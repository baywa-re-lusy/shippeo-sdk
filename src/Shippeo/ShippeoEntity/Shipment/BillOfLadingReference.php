<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class BillOfLadingReference
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
     * @return BillOfLadingReference
     */
    public function setReference(string $reference): BillOfLadingReference
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
     * @return BillOfLadingReference
     */
    public function setQualifier(string $qualifier): BillOfLadingReference
    {
        $this->qualifier = $qualifier;
        return $this;
    }
}
