<?php

declare(strict_types=1);

namespace BayWaReLusy\Shippeo\Test;

use BayWaReLusy\Shippeo\ShippeoEntity;
use BayWaReLusy\Shippeo\ShippeoEntity\Meta;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\BillOfLadingReference;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Carrier;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Container;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address\Identification;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Consignee;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\PickUp;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Reference;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\TransportServiceBuyer;
use BayWaReLusy\Shippeo\ShippeoHydrator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippeoHydrator::class)]
class ShippeoHydratorTest extends TestCase
{
    private ShippeoHydrator $hydrator;

    /** Expected data matching container_push.json exactly */
    private array $expectedData;

    protected function setUp(): void
    {
        $this->hydrator    = new ShippeoHydrator();
        $this->expectedData = json_decode(
            file_get_contents(__DIR__ . '/files/container_push.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Build a fully-populated ShippeoEntity that mirrors container_push.json.
     */
    private function buildEntity(): ShippeoEntity
    {
        $meta = (new Meta())
            ->setSenderID('Sender ID')
            ->setDuplicateReceiverId('shippeo')
            ->setMessageDate(new \DateTimeImmutable('2021-03-29T13:53:36+00:00'))
            ->setMessageReference('ABCD1234567')
            ->setMessageType('GTF511')
            ->setMessageFunction('9');

        $container = (new Container())
            ->setReference('ABCD1234567');

        $transportServiceBuyer = (new TransportServiceBuyer())
            ->setIdentifier('agency_id')
            ->setQualifier('ZZ');

        $carrier = (new Carrier())
            ->setIdentifier('EGLV')
            ->setQualifier('ZZ');

        $billOfLading = (new BillOfLadingReference())
            ->setReference('OOLU0123456789')
            ->setQualifier('MBL');

        $pickUpIdentification = (new Identification())
            ->setIdentifier('CNSHA')
            ->setQualifier('UNLOCODE');

        $pickUp = (new PickUp())
            ->setIdentifications([$pickUpIdentification])
            ->setDates([(new Order\Address\Date())->setQualifier('398')]);

        $consigneeIdentification = (new Identification())
            ->setIdentifier('BEANR')
            ->setQualifier('UNLOCODE');

        $consignee = (new Consignee())
            ->setIdentifications([$consigneeIdentification])
            ->setDates([(new Order\Address\Date())->setQualifier('2')]);

        $reference = (new Reference())
            ->setQualifier('DQ')
            ->setReference('ABCD1234567');

        $order = (new Order())
            ->setGoodsDescription('General goods')
            ->setReferences([$reference])
            ->setPickUp($pickUp)
            ->setConsignee($consignee);

        $shipment = (new Shipment())
            ->setTechnicalReference('ABCD1234567')
            ->setReference('ABCD1234567')
            ->setType('630')
            ->setTransportMode('maritime')
            ->setServiceLine('EGLV')
            ->setContainer($container)
            ->setTransportServiceBuyer([$transportServiceBuyer])
            ->setCarrier([$carrier])
            ->setBillOfLadingReferences([$billOfLading])
            ->setOrders([$order])
            ->setIsDangerousGoods(false);

        return (new ShippeoEntity())
            ->setMeta($meta)
            ->setShipment($shipment);
    }

    // -------------------------------------------------------------------------
    // extract() – meta block
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesMetaSenderID(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['senderID'],
            $result['meta']['senderID']
        );
    }

    #[Test]
    public function extractProducesMetaDuplicateReceiverId(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['duplicateReceiverId'],
            $result['meta']['duplicateReceiverId']
        );
    }

    #[Test]
    public function extractProducesMetaMessageDateInRfc3339Format(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['messageDate'],
            $result['meta']['messageDate'],
            'messageDate must be serialised as RFC 3339'
        );
    }

    #[Test]
    public function extractProducesMetaMessageReference(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['messageReference'],
            $result['meta']['messageReference']
        );
    }

    #[Test]
    public function extractProducesMetaMessageType(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['messageType'],
            $result['meta']['messageType']
        );
    }

    #[Test]
    public function extractProducesMetaMessageFunction(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['meta']['messageFunction'],
            $result['meta']['messageFunction']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – shipment root fields
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesShipmentTechnicalReference(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['technicalReference'],
            $result['shipment']['technicalReference']
        );
    }

    #[Test]
    public function extractProducesShipmentReference(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['reference'],
            $result['shipment']['reference']
        );
    }

    #[Test]
    public function extractProducesShipmentType(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame($this->expectedData['shipment']['type'], $result['shipment']['type']);
    }

    #[Test]
    public function extractProducesShipmentTransportMode(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['transportMode'],
            $result['shipment']['transportMode']
        );
    }

    #[Test]
    public function extractProducesShipmentServiceLine(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['serviceLine'],
            $result['shipment']['serviceLine']
        );
    }

    #[Test]
    public function extractProducesNullServiceLineWhenNotSet(): void
    {
        $entity = $this->buildEntity();
        $entity->getShipment()->setServiceLine(null);

        $result = $this->hydrator->extract($entity);

        $this->assertNull($result['shipment']['serviceLine']);
    }

    #[Test]
    public function extractProducesIsDangerousGoodsAsBool(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['isDangerousGoods'],
            $result['shipment']['isDangerousGoods']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – container
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesContainerReference(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['container']['reference'],
            $result['shipment']['container']['reference']
        );
    }

    #[Test]
    public function extractProducesNullContainerWhenNotSet(): void
    {
        $entity = $this->buildEntity();
        $entity->getShipment()->setContainer(null);

        $result = $this->hydrator->extract($entity);

        $this->assertNull($result['shipment']['container']);
    }

    // -------------------------------------------------------------------------
    // extract() – transportServiceBuyer
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesTransportServiceBuyerAsArray(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertIsArray($result['shipment']['transportServiceBuyer']);
        $this->assertCount(1, $result['shipment']['transportServiceBuyer']);
    }

    #[Test]
    public function extractProducesTransportServiceBuyerIdentifier(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['transportServiceBuyer'][0]['identifier'],
            $result['shipment']['transportServiceBuyer'][0]['identifier']
        );
    }

    #[Test]
    public function extractProducesTransportServiceBuyerQualifier(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['transportServiceBuyer'][0]['qualifier'],
            $result['shipment']['transportServiceBuyer'][0]['qualifier']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – carrier
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesCarrierAsArray(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertIsArray($result['shipment']['carrier']);
        $this->assertCount(1, $result['shipment']['carrier']);
    }

    #[Test]
    public function extractProducesCarrierIdentifier(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['carrier'][0]['identifier'],
            $result['shipment']['carrier'][0]['identifier']
        );
    }

    #[Test]
    public function extractProducesCarrierQualifier(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['carrier'][0]['qualifier'],
            $result['shipment']['carrier'][0]['qualifier']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – billOfLadingReferences
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesBillOfLadingReferencesAsArray(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertIsArray($result['shipment']['billOfLadingReferences']);
        $this->assertCount(1, $result['shipment']['billOfLadingReferences']);
    }

    #[Test]
    public function extractProducesBillOfLadingReference(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['billOfLadingReferences'][0]['reference'],
            $result['shipment']['billOfLadingReferences'][0]['reference']
        );
    }

    #[Test]
    public function extractProducesBillOfLadingReferenceQualifier(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['billOfLadingReferences'][0]['qualifier'],
            $result['shipment']['billOfLadingReferences'][0]['qualifier']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – orders
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesOrdersAsArray(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertIsArray($result['shipment']['orders']);
        $this->assertCount(1, $result['shipment']['orders']);
    }

    #[Test]
    public function extractProducesOrderGoodsDescription(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['goodsDescription'],
            $result['shipment']['orders'][0]['goodsDescription']
        );
    }

    #[Test]
    public function extractProducesOrderReferences(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertIsArray($result['shipment']['orders'][0]['references']);
        $this->assertCount(1, $result['shipment']['orders'][0]['references']);
        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['references'][0]['qualifier'],
            $result['shipment']['orders'][0]['references'][0]['qualifier']
        );
        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['references'][0]['reference'],
            $result['shipment']['orders'][0]['references'][0]['reference']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – pickUp
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesPickUpIdentification(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $pickUp = $result['shipment']['orders'][0]['pickUp'];

        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['pickUp']['identifications'][0]['identifier'],
            $pickUp['identifications'][0]['identifier']
        );
        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['pickUp']['identifications'][0]['qualifier'],
            $pickUp['identifications'][0]['qualifier']
        );
    }

    #[Test]
    public function extractProducesPickUpNullableFieldsAsNull(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $pickUp = $result['shipment']['orders'][0]['pickUp'];

        foreach (['name', 'address1', 'address2', 'country', 'postalCode', 'city',
                     'latitude', 'longitude', 'ownership', 'activityTime', 'instructions'] as $field) {
            $this->assertNull($pickUp[$field], "Expected null for pickUp.$field");
        }
    }

    #[Test]
    public function extractProducesPickUpAppointmentAsFalse(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertFalse($result['shipment']['orders'][0]['pickUp']['appointment']);
    }

    #[Test]
    public function extractProducesPickUpDates(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            [
                [
                    'qualifier' => '398',
                    'dateTime'  => null,
                ]
            ],
            $result['shipment']['orders'][0]['pickUp']['dates']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – consignee
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesConsigneeIdentification(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $consignee = $result['shipment']['orders'][0]['consignee'];

        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['consignee']['identifications'][0]['identifier'],
            $consignee['identifications'][0]['identifier']
        );
        $this->assertSame(
            $this->expectedData['shipment']['orders'][0]['consignee']['identifications'][0]['qualifier'],
            $consignee['identifications'][0]['qualifier']
        );
    }

    #[Test]
    public function extractProducesConsigneeNullableFieldsAsNull(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $consignee = $result['shipment']['orders'][0]['consignee'];

        foreach (['name', 'address1', 'address2', 'country', 'postalCode', 'city',
                     'latitude', 'longitude', 'ownership', 'activityTime', 'instructions'] as $field) {
            $this->assertNull($consignee[$field], "Expected null for consignee.$field");
        }
    }

    #[Test]
    public function extractProducesConsigneeDates(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $this->assertSame(
            [
                [
                    'qualifier' => '2',
                    'dateTime'  => null,
                ]
            ],
            $result['shipment']['orders'][0]['consignee']['dates']
        );
    }

    // -------------------------------------------------------------------------
    // extract() – optional order fields (nulls / empty arrays)
    // -------------------------------------------------------------------------

    #[Test]
    public function extractProducesEmptyArraysForUnsetOrderCollections(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $order = $result['shipment']['orders'][0];

        foreach (['packing', 'returnablePackaging', 'notificationContacts',
                     'tags', 'amounts', 'handlingUnits', 'attributes', 'dangerousGoods'] as $field) {
            $this->assertSame([], $order[$field], "Expected empty array for order.$field");
        }
    }

    #[Test]
    public function extractProducesNullForOptionalOrderObjects(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        $order = $result['shipment']['orders'][0];

        foreach (['clientIdentification', 'quantity', 'charges'] as $field) {
            $this->assertNull($order[$field], "Expected null for order.$field");
        }
    }

    // -------------------------------------------------------------------------
    // extract() – full structural comparison against container_push.json
    // -------------------------------------------------------------------------

    #[Test]
    public function extractMatchesContainerPushJsonStructureCompletely(): void
    {
        $result = $this->hydrator->extract($this->buildEntity());

        // Recursively assert structure and values match the fixture
        $this->assertSameJsonStructure($this->expectedData, $result);
    }

    // -------------------------------------------------------------------------
    // hydrate() – not implemented
    // -------------------------------------------------------------------------

    /**
     * GenericStrategy::hydrate() is not yet implemented (contains a TODO stub
     * that returns null).  Calling ShippeoHydrator::hydrate() therefore causes
     * ClassMethodsHydrator to pass null into typed setters such as setMeta(),
     * which raises a TypeError.  This test documents that known limitation so
     * that a future implementation of GenericStrategy::hydrate() will be caught
     * by the test suite turning green rather than silently broken.
     */
    #[Test]
    public function hydrateThrowsTypeErrorBecauseGenericStrategyIsNotImplemented(): void
    {
        $this->expectException(\TypeError::class);

        $this->hydrator->hydrate($this->expectedData, new ShippeoEntity());
    }

    // -------------------------------------------------------------------------
    // Data providers – messageFunction codes
    // -------------------------------------------------------------------------

    public static function messageFunctionProvider(): array
    {
        return [
            'create (9)' => ['9'],
            'update (4)' => ['4'],
            'delete (1)' => ['1'],
        ];
    }

    #[Test]
    #[DataProvider('messageFunctionProvider')]
    public function extractSerializesAllMessageFunctionValues(string $functionCode): void
    {
        $entity = $this->buildEntity();
        $entity->getMeta()->setMessageFunction($functionCode);

        $result = $this->hydrator->extract($entity);

        $this->assertSame($functionCode, $result['meta']['messageFunction']);
    }

    // -------------------------------------------------------------------------
    // Private helper
    // -------------------------------------------------------------------------

    /**
     * Recursively checks that every key in $expected exists in $actual and that
     * scalar values are strictly equal.  Null values in $expected are asserted
     * as null; arrays are recursed into.
     */
    private function assertSameJsonStructure(array $expected, array $actual, string $path = ''): void
    {
        foreach ($expected as $key => $expectedValue) {
            $currentPath = $path ? "$path.$key" : (string)$key;

            $this->assertArrayHasKey($key, $actual, "Missing key [$currentPath] in extracted output");

            $actualValue = $actual[$key];

            if (is_array($expectedValue)) {
                $this->assertIsArray($actualValue, "Expected array at [$currentPath]");
                $this->assertSameJsonStructure($expectedValue, $actualValue, $currentPath);
            } elseif (is_null($expectedValue)) {
                $this->assertNull($actualValue, "Expected null at [$currentPath]");
            } else {
                $this->assertSame(
                    $expectedValue,
                    $actualValue,
                    "Value mismatch at [$currentPath]"
                );
            }
        }
    }
}
