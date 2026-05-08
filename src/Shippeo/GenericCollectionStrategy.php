<?php

namespace BayWaReLusy\Shippeo;

use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;

class GenericCollectionStrategy implements StrategyInterface
{
    /**
     * @param HydratorInterface $hydrator
     * @param string|null $className
     */
    public function __construct(
        protected HydratorInterface $hydrator,
        protected ?string $className = null
    ) {
    }

    public function extract($value, ?object $object = null)
    {
        if (is_null($value)) {
            return null;
        }

        $result = [];

        foreach ($value as $val) {
            $result[] = $this->hydrator->extract($val);
        }

        return $result;
    }

    /**
     * @param $value
     * @param array<string, mixed>|null $data
     * @throws \Exception
     */
    public function hydrate($value, ?array $data)
    {
        if (is_null($this->className)) {
            throw new \Exception('No class name specified');
        }

        $hydrated = [];

        foreach ($value as $element) {
            $hydrated[] = $this->hydrator->hydrate($element, new $this->className());
        }

        return $hydrated;
    }
}
