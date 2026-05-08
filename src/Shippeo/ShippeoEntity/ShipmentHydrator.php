<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity;

use BayWaReLusy\Shippeo\GenericCollectionStrategy;
use BayWaReLusy\Shippeo\GenericStrategy;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\OrderHydrator;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;

class ShipmentHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy(
            'transportServiceBuyer',
            new GenericCollectionStrategy(new ClassMethodsHydrator(false))
        );
        $this->hydrator->addStrategy('carrier', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('transportMean', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('orders', new GenericCollectionStrategy(new OrderHydrator()));
        $this->hydrator->addStrategy(
            'billOfLadingReferences',
            new GenericCollectionStrategy(new ClassMethodsHydrator(false))
        );
        $this->hydrator->addStrategy('container', new GenericStrategy(new ClassMethodsHydrator(false)));
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
