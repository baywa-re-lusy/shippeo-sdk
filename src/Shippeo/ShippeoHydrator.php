<?php

namespace BayWaReLusy\Shippeo;

use BayWaReLusy\Shippeo\ShippeoEntity\MetaHydrator;
use BayWaReLusy\Shippeo\ShippeoEntity\ShipmentHydrator;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;

class ShippeoHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy('meta', new GenericStrategy(new MetaHydrator()));
        $this->hydrator->addStrategy('shipment', new GenericStrategy(new ShipmentHydrator()));
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
