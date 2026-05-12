<?php

namespace BayWaReLusy\Shippeo;

use BayWaReLusy\Shippeo\ShippeoEntity\Meta;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment;
use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ShippeoService
{
    protected ?string $token = null;

    protected const SHIPPEO_LOGIN_URI    = '/api/tokens';
    protected const SHIPPEO_SHIPMENT_URI = '/api/edi/shipment';

    protected const SHIPPEO_CREATE_TRANSPORT = '9';
    protected const SHIPPEO_UPDATE_TRANSPORT = '4';
    protected const SHIPPEO_DELETE_TRANSPORT = '1';

    public function __construct(
        protected HttpClient $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
        protected string $shippeoUsername,
        protected string $shippeoPassword,
        protected string $shippeoAgency,
        protected string $senderName,
        protected ShippeoHydrator $hydrator,
        protected LoggerInterface $shippeoPushLogger,
        protected ClockInterface $clock,
    ) {
    }

    /**
     * Push the given container to Shippeo.
     * @throws ShippeoException
     */
    public function pushContainer(ContainerInterface $container): void
    {
        try {
            $this->login();
            $shippeoContainer = $this->buildContainer($container);

            $body = (string)json_encode(
                $this->hydrator->extract($shippeoContainer),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

            $this->shippeoPushLogger->info($body);

            $request = $this->requestFactory->createRequest('POST', self::SHIPPEO_SHIPMENT_URI)
                ->withHeader('Authorization', 'Bearer ' . $this->token)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->streamFactory->createStream($body));

            $response = $this->httpClient->sendRequest($request);

            if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
                throw new ShippeoException(
                    $this->handleShippeoErrorResponse($response)
                );
            }

            if ($response->getStatusCode() >= 500) {
                throw new \RuntimeException(
                    sprintf('Shippeo API returned server error %d.', $response->getStatusCode())
                );
            }
        } catch (ShippeoException $e) {
            throw $e;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            throw new ShippeoException('Internal Server Error.');
        }
    }

    /**
     * Parse the Shippeo Webhook payload into a Shippeo event entity.
     * @param string $jsonBody
     * @return ShippeoEventEntity
     * @throws ShippeoException
     */
    public function parseShippeoEventPayload(string $jsonBody): ShippeoEventEntity
    {
        $data = json_decode($jsonBody, true);

        if (
            !is_array($data) ||
            !array_key_exists('situation', $data) ||
            !array_key_exists('event', $data['situation']) ||
            !array_key_exists('order', $data) ||
            !array_key_exists('reference', $data['order']) ||
            !array_key_exists('date', $data['situation'])
        ) {
            throw new ShippeoException('Invalid event data.');
        }

        if (!$date = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:sO', $data['situation']['date'])) {
            throw new ShippeoException('Invalid Timestamp');
        }

        $event = new ShippeoEventEntity();
        $event
            ->setContainerId($data['order']['reference'])
            ->setCreated($this->clock->now())
            ->setTimestamp($date->setTimezone(new DateTimeZone('UTC')))
            ->setType(ShippeoEventType::fromShippeoEvent($data['situation']['event']));

        if (
            array_key_exists('eta', $data['order']) &&
            $eta = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:sO', $data['order']['eta'])
        ) {
            $event->setEta($eta->setTimezone(new DateTimeZone('UTC')));
        }

        return $event;
    }

    /**
     * Login to Shippeo Services.
     * @throws ShippeoException If the login fails.
     */
    protected function login(): void
    {
        try {
            $loginEncoded = base64_encode($this->shippeoUsername . ':' . $this->shippeoPassword);

            $request = $this->requestFactory->createRequest('POST', self::SHIPPEO_LOGIN_URI)
                ->withHeader('Authorization', 'Basic ' . $loginEncoded)
                ->withHeader('Content-Type', 'application/json');

            $result = $this->httpClient->sendRequest($request);

            if ($result->getStatusCode() >= 400) {
                throw new \RuntimeException(
                    sprintf("Shippeo login failed with status %d.", $result->getStatusCode())
                );
            }

            $response = json_decode($result->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException("Couldn't decode response from Shippeo.");
            }

            $this->token = $response['data']['token'];
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->shippeoPushLogger->critical($e->getMessage());
            throw new ShippeoException("Couldn't login to Shippeo.");
        }
    }

    /**
     * Build the Shippeo entity from the container.
     * @param ContainerInterface $container
     * @return ShippeoEntity
     */
    protected function buildContainer(ContainerInterface $container): ShippeoEntity
    {
        $shipment = new Shipment();
        $shipment
            ->setType('630')
            ->setTransportMode('maritime')
            ->setTechnicalReference($container->getId())
            ->setReference($container->getId())
            ->setServiceLine($container->getOceanCarrierCode())
            ->setContainer((new Shipment\Container())->setReference($container->getId()))
            ->setTransportServiceBuyer([
                (new Shipment\TransportServiceBuyer())
                    ->setIdentifier($this->shippeoAgency)
                    ->setQualifier('ZZ')
            ])
            ->setCarrier([
                (new Shipment\Carrier())
                    ->setIdentifier($container->getOceanCarrierCode())
                    ->setQualifier('ZZ')
            ])
            ->setBillOfLadingReferences([
                (new Shipment\BillOfLadingReference())
                    ->setReference($container->getMasterBillOfLadingReference())
                    ->setQualifier('MBL')
            ]);

        $pickUp = new Shipment\Order\PickUp();
        $pickUp
            ->setIdentifications([
                (new Shipment\Order\Address\Identification())
                    ->setQualifier('UNLOCODE')
                    ->setIdentifier($container->getUnLoCodeLoadingPort())
            ]);

        $consignee = new Shipment\Order\Consignee();
        $consignee
            ->setIdentifications([
                (new Shipment\Order\Address\Identification())
                    ->setQualifier('UNLOCODE')
                    ->setIdentifier($container->getUnLoCodeDestinationPort())
            ]);

        $order = new Shipment\Order();
        $order
            ->setGoodsDescription('General goods')
            ->setPickUp($pickUp)
            ->setConsignee($consignee)
            ->setReferences([
                (new Shipment\Order\Reference())
                    ->setReference($container->getId())
                    ->setQualifier('DQ')
            ]);

        $shipment->setOrders([$order]);

        $shippeoEntity = new ShippeoEntity();
        $shippeoEntity
            ->setMeta(
                (new Meta())
                    ->setSenderID($this->senderName)
                    ->setDuplicateReceiverId('shippeo')
                    ->setMessageDate($this->clock->now())
                    ->setMessageReference($container->getId())
                    ->setMessageType('GTF511')
                    ->setMessageFunction(
                        $container->getLastPushToShippeo() ?
                            self::SHIPPEO_UPDATE_TRANSPORT :
                            self::SHIPPEO_CREATE_TRANSPORT
                    )
            )
            ->setShipment($shipment);

        return $shippeoEntity;
    }

    /**
     * Handle Shippeo API error responses.
     * @param ResponseInterface $response
     * @return string
     */
    protected function handleShippeoErrorResponse(ResponseInterface $response): string
    {
        $bodyContents = $response->getBody()->getContents();
        $this->shippeoPushLogger->critical($bodyContents);

        $errorMessage = 'Shippeo API returned an error.';
        $responseBody = json_decode($bodyContents, true);

        if (
            $responseBody &&
            array_key_exists('errors', $responseBody) &&
            is_array($responseBody['errors']) &&
            count($responseBody['errors']) > 0
        ) {
            $errorMessage = $responseBody['errors'][0]['detail'];
        }

        return $errorMessage;
    }
}
