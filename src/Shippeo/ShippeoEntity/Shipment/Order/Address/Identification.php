<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address;

class Identification
{
    protected string $identifier;
    protected string $qualifier;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return Identification
     */
    public function setIdentifier(string $identifier): Identification
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getQualifier(): string
    {
        return $this->qualifier;
    }

    /**
     * @param string $qualifier
     * @return Identification
     */
    public function setQualifier(string $qualifier): Identification
    {
        $this->qualifier = $qualifier;
        return $this;
    }
}
