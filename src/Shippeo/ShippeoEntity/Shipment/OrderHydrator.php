<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

use BayWaReLusy\Shippeo\GenericCollectionStrategy;
use BayWaReLusy\Shippeo\GenericStrategy;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGoodHydrator;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\HandlingUnitHydrator;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\NotificationContactHydrator;
use Laminas\Hydrator\ClassMethodsHydrator;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\AddressHydrator;
use Laminas\Hydrator\HydratorInterface;

class OrderHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy('references', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('packing', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy(
            'returnablePackaging',
            new GenericCollectionStrategy(new ClassMethodsHydrator(false))
        );
        $this->hydrator->addStrategy('pickUp', new GenericStrategy(new AddressHydrator()));
        $this->hydrator->addStrategy('consignee', new GenericStrategy(new AddressHydrator()));
        $this->hydrator->addStrategy('clientIdentification', new GenericStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy(
            'notificationContacts',
            new GenericCollectionStrategy(new NotificationContactHydrator())
        );
        $this->hydrator->addStrategy('tags', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('quantity', new GenericStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('amounts', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('handlingUnits', new GenericCollectionStrategy(new HandlingUnitHydrator()));
        $this->hydrator->addStrategy('attributes', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('dangerousGoods', new GenericCollectionStrategy(new DangerousGoodHydrator()));
        $this->hydrator->addStrategy('charges', new GenericStrategy(new ClassMethodsHydrator(false)));
    }

    public function hydrate(array $data, object $object): object
    {
        return $this->hydrator->hydrate($data, $object);
    }

    public function extract(object $object): array
    {
        return $this->hydrator->extract($object);
    }
}
