<?php

declare(strict_types=1);

namespace BayWaReLusy\Shippeo\Tests;

use BayWaReLusy\Shippeo\ShippeoService;
use BayWaReLusy\Shippeo\ShippeoException;
use BayWaReLusy\Shippeo\ShippeoHydrator;
use BayWaReLusy\Shippeo\ContainerInterface;
use BayWaReLusy\Shippeo\ShippeoEntity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

#[CoversClass(ShippeoService::class)]
class ShippeoServiceTest extends TestCase
{
    private HttpClient $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private ShippeoHydrator $hydrator;
    private LoggerInterface $logger;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        $this->httpClient     = $this->createMock(HttpClient::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->streamFactory  = $this->createMock(StreamFactoryInterface::class);
        $this->hydrator       = $this->createMock(ShippeoHydrator::class);
        $this->logger         = $this->createMock(LoggerInterface::class);
        $this->clock          = $this->createMock(ClockInterface::class);
    }

    private function createService(): ShippeoService
    {
        return new ShippeoService(
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            'user',
            'pass',
            'AGENCY',
            'SENDER',
            $this->hydrator,
            $this->logger,
            $this->clock
        );
    }

    private function createContainerMock(bool $lastPush = false): ContainerInterface
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('getId')->willReturn('CONT123');
        $container->method('getOceanCarrierCode')->willReturn('OC123');
        $container->method('getMasterBillOfLadingReference')->willReturn('MBL123');
        $container->method('getUnLoCodeLoadingPort')->willReturn('LOAD123');
        $container->method('getUnLoCodeDestinationPort')->willReturn('DEST123');
        $container->method('getLastPushToShippeo')->willReturn($lastPush ? new \DateTime() : null);

        return $container;
    }

    public function testPushContainerSuccess(): void
    {
        $service   = $this->createService();
        $container = $this->createContainerMock();

        // Hydrator returns an array that will be json_encoded as body
        $extracted = ['shipment' => ['id' => 'CONT123']];

        $this->hydrator
            ->expects($this->once())
            ->method('extract')
            ->with($this->isInstanceOf(ShippeoEntity::class))
            ->willReturn($extracted);

        $expectedBody = (string)json_encode($extracted, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Prepare request mocks (login request and shipment request)
        $loginRequest = $this->createMock(RequestInterface::class);
        $loginRequest
            ->method('withHeader')
            ->willReturnCallback(function ($name, $value) use ($loginRequest) {
                if ($name === 'Authorization') {
                    TestCase::assertSame('Basic ' . base64_encode('user:pass'), $value);
                } elseif ($name === 'Content-Type') {
                    TestCase::assertSame('application/json', $value);
                } else {
                    TestCase::fail('Unexpected header on login request: ' . $name);
                }

                return $loginRequest;
            });

        $shipmentRequest = $this->createMock(RequestInterface::class);
        $shipmentRequest
            ->method('withHeader')
            ->willReturnCallback(function ($name, $value) use ($shipmentRequest) {
                if ($name === 'Authorization') {
                    TestCase::assertSame('Bearer TOKEN123', $value);
                } elseif ($name === 'Content-Type') {
                    TestCase::assertSame('application/json', $value);
                } else {
                    TestCase::fail('Unexpected header on shipment request: ' . $name);
                }
                return $shipmentRequest;
            });

        $shipmentRequest
            ->method('withBody')
            ->willReturnSelf();

        // requestFactory should return loginRequest for /api/tokens and shipmentRequest for /api/edi/shipment
        $this->requestFactory
            ->expects($this->exactly(2))
            ->method('createRequest')
            ->willReturnCallback(function ($method, $uri) use ($loginRequest, $shipmentRequest) {
                if ($uri === '/api/tokens') {
                    return $loginRequest;
                }
                if ($uri === '/api/edi/shipment') {
                    return $shipmentRequest;
                }
                TestCase::fail('Unexpected URI passed to createRequest: ' . $uri);
            });

        // login response
        $loginResponse   = $this->createMock(ResponseInterface::class);
        $loginBodyStream = $this->createMock(StreamInterface::class);

        $loginBodyStream
            ->method('getContents')
            ->willReturn(json_encode(['data' => ['token' => 'TOKEN123']]));
        $loginResponse
            ->method('getStatusCode')
            ->willReturn(200);
        $loginResponse
            ->method('getBody')
            ->willReturn($loginBodyStream);

        // shipment response (success)
        $shipmentResponse = $this->createMock(ResponseInterface::class);
        $shipmentResponse
            ->method('getStatusCode')
            ->willReturn(200);

        // httpClient sendRequest called twice
        $this->httpClient
            ->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls($loginResponse, $shipmentResponse);

        // streamFactory should be called with the expected body
        $stream = $this->createMock(StreamInterface::class);
        $this->streamFactory
            ->expects($this->once())
            ->method('createStream')
            ->with($this->equalTo($expectedBody))
            ->willReturn($stream);

        // Logger info should be called with the body
        $this->logger
            ->expects($this->once())
            ->method('info')
            ->with($this->equalTo($expectedBody));

        // Execute - should not throw
        $service->pushContainer($container);
        $this->addToAssertionCount(1);
    }

    public function testPushContainerClientErrorThrowsShippeoException(): void
    {
        $service   = $this->createService();
        $container = $this->createContainerMock();

        $this->hydrator
            ->method('extract')
            ->willReturn(['x' => 'y']);

        $loginRequest = $this->createMock(RequestInterface::class);
        $loginRequest
            ->method('withHeader')
            ->willReturnSelf();

        $shipmentRequest = $this
            ->createMock(RequestInterface::class);
        $shipmentRequest
            ->method('withHeader')
            ->willReturnSelf();
        $shipmentRequest
            ->method('withBody')
            ->willReturnSelf();

        $this->requestFactory
            ->expects($this->exactly(2))
            ->method('createRequest')
            ->willReturnCallback(function ($method, $uri) use ($loginRequest, $shipmentRequest) {
                return $uri === '/api/tokens' ? $loginRequest : $shipmentRequest;
            });

        $loginResponse   = $this->createMock(ResponseInterface::class);
        $loginBodyStream = $this->createMock(StreamInterface::class);

        $loginBodyStream
            ->method('getContents')
            ->willReturn(json_encode(['data' => ['token' => 'TOKEN123']]));
        $loginResponse
            ->method('getStatusCode')
            ->willReturn(200);
        $loginResponse
            ->method('getBody')
            ->willReturn($loginBodyStream);

        $shipmentResponse = $this->createMock(ResponseInterface::class);
        $shipmentResponse
            ->method('getStatusCode')
            ->willReturn(400);

        $shipmentBodyStream = $this->createMock(StreamInterface::class);
        $shipmentBodyStream
            ->method('getContents')
            ->willReturn(json_encode(['errors' => [['detail' => 'Bad request']]]));

        $shipmentResponse
            ->method('getBody')
            ->willReturn($shipmentBodyStream);

        $this->httpClient
            ->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls($loginResponse, $shipmentResponse);

        $this->streamFactory
            ->method('createStream')
            ->willReturn($this->createMock(StreamInterface::class));

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Bad request');

        $service->pushContainer($container);
    }

    public function testPushContainerServerErrorThrowsShippeoExceptionWrapped(): void
    {
        $service   = $this->createService();
        $container = $this->createContainerMock();

        $this->hydrator
            ->method('extract')
            ->willReturn(['x' => 'y']);

        $loginRequest = $this->createMock(RequestInterface::class);
        $loginRequest
            ->method('withHeader')
            ->willReturnSelf();

        $shipmentRequest = $this->createMock(RequestInterface::class);

        $shipmentRequest
            ->method('withHeader')
            ->willReturnSelf();
        $shipmentRequest
            ->method('withBody')
            ->willReturnSelf();

        $this->requestFactory
            ->expects($this->exactly(2))
            ->method('createRequest')
            ->willReturnCallback(function ($method, $uri) use ($loginRequest, $shipmentRequest) {
                return $uri === '/api/tokens' ? $loginRequest : $shipmentRequest;
            });

        $loginResponse   = $this->createMock(ResponseInterface::class);
        $loginBodyStream = $this->createMock(StreamInterface::class);

        $loginBodyStream
            ->method('getContents')
            ->willReturn(json_encode(['data' => ['token' => 'TOKEN123']]));
        $loginResponse
            ->method('getStatusCode')
            ->willReturn(200);
        $loginResponse
            ->method('getBody')
            ->willReturn($loginBodyStream);

        $shipmentResponse = $this->createMock(ResponseInterface::class);
        $shipmentResponse
            ->method('getStatusCode')
            ->willReturn(500);
        $shipmentResponse
            ->method('getBody')
            ->willReturn($this->createMock(StreamInterface::class));

        $this->httpClient
            ->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls($loginResponse, $shipmentResponse);

        $this->streamFactory
            ->method('createStream')
            ->willReturn($this->createMock(StreamInterface::class));

        // The service wraps internal RuntimeException into a ShippeoException with message 'Internal Server Error.'
        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage('Internal Server Error.');

        $service->pushContainer($container);
    }

    public function testLoginFailureThrowsShippeoException(): void
    {
        $service   = $this->createService();
        $container = $this->createContainerMock();

        // Simulate login failure (401)
        $loginRequest = $this->createMock(RequestInterface::class);
        $loginRequest
            ->method('withHeader')
            ->willReturnCallback(function ($name, $value) use ($loginRequest) {
                if ($name === 'Authorization') {
                    TestCase::assertStringStartsWith('Basic ', $value);
                } elseif ($name === 'Content-Type') {
                    TestCase::assertSame('application/json', $value);
                }
                return $loginRequest;
            });

        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', '/api/tokens')
            ->willReturn($loginRequest);

        $loginResponse = $this->createMock(ResponseInterface::class);

        $loginResponse
            ->method('getStatusCode')
            ->willReturn(401);
        $loginResponse
            ->method('getBody')
            ->willReturn($this->createMock(StreamInterface::class));

        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with($loginRequest)
            ->willReturn($loginResponse);

        $this->expectException(ShippeoException::class);
        $this->expectExceptionMessage("Couldn't login to Shippeo.");

        $service->pushContainer($container);
    }

    public function testUpdateVsCreateMessageFunction(): void
    {
        $service = $this->createService();
        // Create container that indicates it was previously pushed
        $container = $this->createContainerMock(true);

        // We want to assert that the ShippeoEntity passed to hydrator has messageFunction = '4'
        $this->hydrator
            ->expects($this->once())
            ->method('extract')
            ->with($this->callback(function ($entity) {
                if (! $entity instanceof ShippeoEntity) {
                    return false;
                }
                $meta = $entity->getMeta();
                if ($meta === null) {
                    return false;
                }
                return $meta->getMessageFunction() === '4';
            }))
            ->willReturn(['dummy' => 'value']);

        // Prepare request mocks
        $loginRequest = $this->createMock(RequestInterface::class);
        $loginRequest
            ->method('withHeader')->willReturnSelf();

        $shipmentRequest = $this->createMock(RequestInterface::class);

        // Expect Authorization header to contain the token returned by login
        $shipmentRequest
            ->method('withHeader')
            ->willReturnCallback(function ($name, $value) use ($shipmentRequest) {
                if ($name === 'Authorization') {
                    TestCase::assertSame('Bearer TOKEN123', $value);
                } elseif ($name === 'Content-Type') {
                    TestCase::assertSame('application/json', $value);
                }
                return $shipmentRequest;
            });

        $shipmentRequest
            ->method('withBody')
            ->willReturnSelf();

        $this->requestFactory
            ->expects($this->exactly(2))
            ->method('createRequest')
            ->willReturnCallback(function ($method, $uri) use ($loginRequest, $shipmentRequest) {
                return $uri === '/api/tokens' ? $loginRequest : $shipmentRequest;
            });

        $loginResponse   = $this->createMock(ResponseInterface::class);
        $loginBodyStream = $this->createMock(StreamInterface::class);

        $loginBodyStream
            ->method('getContents')
            ->willReturn(json_encode(['data' => ['token' => 'TOKEN123']]));
        $loginResponse
            ->method('getStatusCode')
            ->willReturn(200);
        $loginResponse
            ->method('getBody')
            ->willReturn($loginBodyStream);

        $shipmentResponse = $this->createMock(ResponseInterface::class);
        $shipmentResponse
            ->method('getStatusCode')
            ->willReturn(200);

        $this->httpClient
            ->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls($loginResponse, $shipmentResponse);

        $this->streamFactory
            ->method('createStream')
            ->willReturn($this->createMock(StreamInterface::class));

        // Execute - should not throw and hydrator callback will assert messageFunction
        $service->pushContainer($container);
        $this->addToAssertionCount(1);
    }
}
