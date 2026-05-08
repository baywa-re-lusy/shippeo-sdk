<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\GenericStrategy;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;

class NotificationContactHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy('communicationNumber', new GenericStrategy(new ClassMethodsHydrator(false)));
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
