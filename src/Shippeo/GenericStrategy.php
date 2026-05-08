<?php

namespace BayWaReLusy\Shippeo;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;

class GenericStrategy implements StrategyInterface
{
    protected HydratorInterface $hydrator;

    /**
     * GenericCollectionStrategy constructor.
     * @param HydratorInterface $hydrator
     */
    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function extract($value, ?object $object = null)
    {
        return is_null($value) ? null : $this->hydrator->extract($value);
    }

    /**
     * @param $value
     * @param array<string, mixed>|null $data
     * @return void
     */
    public function hydrate($value, ?array $data)
    {
        // TODO: Implement hydrate() method.
    }
}
