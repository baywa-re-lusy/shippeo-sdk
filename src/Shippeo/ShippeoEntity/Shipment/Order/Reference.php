<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

class Reference
{
    protected string $qualifier;
    protected string $reference;

    /**
     * @return string
     */
    public function getQualifier(): string
    {
        return $this->qualifier;
    }

    /**
     * @param string $qualifier
     * @return Reference
     */
    public function setQualifier(string $qualifier): Reference
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Reference
     */
    public function setReference(string $reference): Reference
    {
        $this->reference = $reference;
        return $this;
    }
}
