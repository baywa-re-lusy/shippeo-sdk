<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class Carrier
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
     * @return Carrier
     */
    public function setIdentifier(string $identifier): Carrier
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
     * @return Carrier
     */
    public function setQualifier(string $qualifier): Carrier
    {
        $this->qualifier = $qualifier;
        return $this;
    }
}
