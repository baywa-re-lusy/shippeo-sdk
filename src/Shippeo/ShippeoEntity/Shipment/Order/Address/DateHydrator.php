<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address;

use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;

class DateHydrator implements HydratorInterface
{
    private ClassMethodsHydrator $hydrator;

    public function __construct()
    {
        $this->hydrator = new ClassMethodsHydrator(false);

        $this->hydrator->addStrategy('dateTime', new DateTimeFormatterStrategy(\DateTimeInterface::RFC3339));
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
