<?php

declare(strict_types=1);

namespace BayWaReLusy\Shippeo\Test;

use BayWaReLusy\Shippeo\ShippeoException;
use BayWaReLusy\Shippeo\ShippeoHydrator;
use BayWaReLusy\Shippeo\ShippeoService;
use BayWaReLusy\Shippeo\ShippeoEventType;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

#[CoversMethod(ShippeoService::class, 'parseShippeoEventPayload')]
class ParseShippeoEventPayloadTest extends TestCase
{
    private ShippeoService $service;
    private ClockInterface&MockObject $clock;
    private DateTimeImmutable $frozenNow;

    /** Full valid payload with ETA */
    private const PAYLOAD_WITH_ETA = <<<JSON
        {
          "order": {
            "reference": "DFSU7039395",
            "eta": "2022-06-12T02:00:00+0000"
          },
          "situation": {
            "event": "ETA_EVENT_EXTERNAL",
            "date": "2022-06-02T10:19:39+0000"
          }
        }
        JSON;

    /** Valid payload without an ETA field */
    private const PAYLOAD_WITHOUT_ETA = <<<JSON
        {
          "order": {
            "reference": "DFSU7039395"
          },
          "situation": {
            "event": "CONTAINER_LOADED",
            "date": "2022-06-02T10:19:39+0000"
          }
        }
        JSON;

    protected function setUp(): void
    {
        $this->frozenNow = new DateTimeImmutable('2022-06-02T12:00:00+00:00');

        $this->clock = $this->createMock(ClockInterface::class);
        $this->clock->method('now')->willReturn($this->frozenNow);

        $this->service = new ShippeoService(
            httpClient:         $this->createMock(HttpClient::class),
            requestFactory:     $this->createMock(RequestFactoryInterface::class),
            streamFactory:      $this->createMock(StreamFactoryInterface::class),
            shippeoUsername:    'user',
            shippeoPassword:    'pass',
            shippeoAgency:      'agency_id',
            senderName:         'Sender name',
            hydrator:           $this->createMock(ShippeoHydrator::class),
            shippeoPushLogger:  $this->createMock(LoggerInterface::class),
            clock:              $this->clock,
        );
    }

    #[Test]
    public function parsesContainerIdFromOrderReference(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertSame('DFSU7039395', $event->getContainerId());
    }

    #[Test]
    public function parsesEventTypeFromSituationEvent(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertSame(ShippeoEventType::ExternalEtaUpdate, $event->getType());
    }

    #[Test]
    public function parsesTimestampFromSituationDateInUtc(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertSame('2022-06-02T10:19:39+00:00', $event->getTimestamp()->format(\DateTimeInterface::RFC3339));
        $this->assertSame('UTC', $event->getTimestamp()->getTimezone()->getName());
    }

    #[Test]
    public function setsCreatedFromClock(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertEquals($this->frozenNow, $event->getCreated());
    }

    #[Test]
    public function parsesEtaWhenPresent(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertNotNull($event->getEta());
        $this->assertSame('2022-06-12T02:00:00+00:00', $event->getEta()->format(\DateTimeInterface::RFC3339));
        $this->assertSame('UTC', $event->getEta()->getTimezone()->getName());
    }

    #[Test]
    public function etaIsNullWhenNotPresentInPayload(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITHOUT_ETA);
        $this->assertNull($event->getEta());
    }

    #[Test]
    public function returnsEventEntityOnValidPayload(): void
    {
        $event = $this->service->parseShippeoEventPayload(self::PAYLOAD_WITH_ETA);
        $this->assertNotNull($event);
    }

    #[Test]
    public function returnsNullForUnknownEventType(): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395'],
            'situation' => ['event' => 'TOTALLY_UNKNOWN_EVENT', 'date' => '2022-06-02T10:19:39+0000'],
        ]);

        $result = $this->service->parseShippeoEventPayload($payload);
        $this->assertNull($result);
    }

    #[Test]
    public function ignoresInvalidEtaAndStillReturnsEvent(): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395', 'eta' => 'not-a-date'],
            'situation' => ['event' => 'ETA_EVENT', 'date' => '2022-06-02T10:19:39+0000'],
        ]);

        $event = $this->service->parseShippeoEventPayload($payload);
        $this->assertNotNull($event);
        $this->assertNull($event->getEta());
    }

    // -------------------------------------------------------------------------
    // Invalid / missing fields -> ShippeoException
    // -------------------------------------------------------------------------

    #[Test]
    public function throwsOnInvalidJson(): void
    {
        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');

        $this->service->parseShippeoEventPayload('{not valid json}');
    }

    #[Test]
    public function throwsOnNonObjectJson(): void
    {
        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload('"just a string"');
    }

    #[Test]
    public function throwsWhenSituationKeyMissing(): void
    {
        $payload = json_encode([
            'order' => ['reference' => 'DFSU7039395'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload($payload);
    }

    #[Test]
    public function throwsWhenSituationEventKeyMissing(): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395'],
            'situation' => ['date' => '2022-06-02T10:19:39+0000'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload($payload);
    }

    #[Test]
    public function throwsWhenOrderKeyMissing(): void
    {
        $payload = json_encode([
            'situation' => ['event' => 'ETA_EVENT', 'date' => '2022-06-02T10:19:39+0000'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload($payload);
    }

    #[Test]
    public function throwsWhenOrderReferenceKeyMissing(): void
    {
        $payload = json_encode([
            'order'     => ['eta' => '2022-06-12T02:00:00+0000'],
            'situation' => ['event' => 'ETA_EVENT', 'date' => '2022-06-02T10:19:39+0000'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload($payload);
    }

    #[Test]
    public function throwsWhenSituationDateKeyMissing(): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395'],
            'situation' => ['event' => 'ETA_EVENT'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid event data.');
        $this->service->parseShippeoEventPayload($payload);
    }

    #[Test]
    public function throwsWhenSituationDateFormatIsInvalid(): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395'],
            'situation' => ['event' => 'ETA_EVENT', 'date' => '02-06-2022'],
        ]);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Invalid Timestamp');
        $this->service->parseShippeoEventPayload($payload);
    }

    // -------------------------------------------------------------------------
    // All known event types resolve correctly
    // -------------------------------------------------------------------------

    public static function knownShippeoEventProvider(): array
    {
        return [
            'ETA_EVENT'                                                => ['ETA_EVENT',                                                ShippeoEventType::EtaUpdate],
            'ETA_EVENT_EXTERNAL'                                       => ['ETA_EVENT_EXTERNAL',                                       ShippeoEventType::ExternalEtaUpdate],
            'CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE'                 => ['CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE',                 ShippeoEventType::ContainerLeftEmptyPortOfLoading],
            'ORDER_CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE_ESTIMATED' => ['ORDER_CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE_ESTIMATED', ShippeoEventType::ContainerLeftEmptyPortOfLoadingEstimated],
            'CONTAINER_FULL_GATE_IN_AT_LOADING_SITE'                   => ['CONTAINER_FULL_GATE_IN_AT_LOADING_SITE',                   ShippeoEventType::ContainerEntersFullAtThePortOfLoading],
            'ORDER_CONTAINER_FULL_GATE_IN_AT_LOADING_SITE_ESTIMATED'   => ['ORDER_CONTAINER_FULL_GATE_IN_AT_LOADING_SITE_ESTIMATED',   ShippeoEventType::ContainerEntersFullAtThePortOfLoadingEstimated],
            'CONTAINER_LOADED'                                         => ['CONTAINER_LOADED',                                         ShippeoEventType::ContainerLoadedOnTheBoat],
            'ORDER_CONTAINER_LOADED_ESTIMATED'                         => ['ORDER_CONTAINER_LOADED_ESTIMATED',                         ShippeoEventType::ContainerLoadedOnTheBoatEstimated],
            'CONTAINER_LEFT_LOADING_SITE'                              => ['CONTAINER_LEFT_LOADING_SITE',                              ShippeoEventType::VesselLeftThePortOfLoading],
            'ORDER_CONTAINER_LEFT_LOADING_SITE_ESTIMATED'              => ['ORDER_CONTAINER_LEFT_LOADING_SITE_ESTIMATED',              ShippeoEventType::VesselLeftThePortOfLoadingEstimated],
            'ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT'                     => ['ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT',                     ShippeoEventType::VesselArrivedAtTranshipment],
            'ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT_ESTIMATED'           => ['ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT_ESTIMATED',           ShippeoEventType::VesselArrivedAtTranshipmentEstimated],
            'CONTAINER_UNLOADED_TRANSHIPMENT'                          => ['CONTAINER_UNLOADED_TRANSHIPMENT',                          ShippeoEventType::ContainerUnloadedAtTranshipment],
            'ORDER_CONTAINER_UNLOADED_TRANSHIPMENT_ESTIMATED'          => ['ORDER_CONTAINER_UNLOADED_TRANSHIPMENT_ESTIMATED',          ShippeoEventType::ContainerUnloadedAtTranshipmentEstimated],
            'CONTAINER_LOADED_TRANSHIPMENT'                            => ['CONTAINER_LOADED_TRANSHIPMENT',                            ShippeoEventType::ContainerLoadedAtTranshipment],
            'ORDER_CONTAINER_LOADED_TRANSHIPMENT_ESTIMATED'            => ['ORDER_CONTAINER_LOADED_TRANSHIPMENT_ESTIMATED',            ShippeoEventType::ContainerLoadedAtTranshipmentEstimated],
            'ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT'                  => ['ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT',                  ShippeoEventType::VesselDepartedFromTranshipment],
            'ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT_ESTIMATED'        => ['ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT_ESTIMATED',        ShippeoEventType::VesselDepartedFromTranshipmentEstimated],
            'CONTAINER_ON_DELIVERY_SITE'                               => ['CONTAINER_ON_DELIVERY_SITE',                               ShippeoEventType::VesselEntersAtThePortOfDelivery],
            'ORDER_CONTAINER_ON_DELIVERY_SITE_ESTIMATED'               => ['ORDER_CONTAINER_ON_DELIVERY_SITE_ESTIMATED',               ShippeoEventType::VesselEntersAtThePortOfDeliveryEstimated],
            'CONTAINER_UNLOADED'                                       => ['CONTAINER_UNLOADED',                                       ShippeoEventType::ContainerUnloadedFromTheVessel],
            'ORDER_CONTAINER_UNLOADED_ESTIMATED'                       => ['ORDER_CONTAINER_UNLOADED_ESTIMATED',                       ShippeoEventType::ContainerUnloadedFromTheVesselEstimated],
            'CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE'                 => ['CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE',                 ShippeoEventType::ContainerLeftFullThePortOfDelivery],
            'ORDER_CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE_ESTIMATED' => ['ORDER_CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE_ESTIMATED', ShippeoEventType::ContainerLeftFullThePortOfDeliveryEstimated],
            'CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE'                 => ['CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE',                 ShippeoEventType::ContainerReturnsBackEmptyAtThePortOfDelivery],
            'ORDER_CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE_ESTIMATED' => ['ORDER_CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE_ESTIMATED', ShippeoEventType::ContainerReturnsBackEmptyAtThePortOfDeliveryEstimated],
        ];
    }

    #[Test]
    #[DataProvider('knownShippeoEventProvider')]
    public function parsesAllKnownEventTypesCorrectly(string $shippeoEvent, ShippeoEventType $expectedType): void
    {
        $payload = json_encode([
            'order'     => ['reference' => 'DFSU7039395'],
            'situation' => ['event' => $shippeoEvent, 'date' => '2022-06-02T10:19:39+0000'],
        ]);

        $event = $this->service->parseShippeoEventPayload($payload);
        $this->assertNotNull($event);
        $this->assertSame($expectedType, $event->getType());
    }
}
