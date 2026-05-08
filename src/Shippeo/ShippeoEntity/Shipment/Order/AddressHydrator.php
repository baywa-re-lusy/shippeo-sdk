<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\GenericCollectionStrategy;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address\DateHydrator;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;

class AddressHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy('identifications', new GenericCollectionStrategy(new ClassMethodsHydrator(false)));
        $this->hydrator->addStrategy('dates', new GenericCollectionStrategy(new DateHydrator()));
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
