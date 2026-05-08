<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\HandlingUnit;

class ContentReference
{
    protected string $reference;
    protected string $qualifier;

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return ContentReference
     */
    public function setReference(string $reference): ContentReference
    {
        $this->reference = $reference;
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
     * @return ContentReference
     */
    public function setQualifier(string $qualifier): ContentReference
    {
        $this->qualifier = $qualifier;
        return $this;
    }
}
