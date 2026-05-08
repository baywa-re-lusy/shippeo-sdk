<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class Container
{
    protected string $reference;

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Container
     */
    public function setReference(string $reference): Container
    {
        $this->reference = $reference;
        return $this;
    }
}
