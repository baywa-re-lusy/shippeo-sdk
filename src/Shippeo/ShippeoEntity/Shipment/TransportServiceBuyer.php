<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class TransportServiceBuyer
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
     * @return TransportServiceBuyer
     */
    public function setIdentifier(string $identifier): TransportServiceBuyer
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
     * @return TransportServiceBuyer
     */
    public function setQualifier(string $qualifier): TransportServiceBuyer
    {
        $this->qualifier = $qualifier;
        return $this;
    }
}
