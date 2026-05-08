<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood;

class AdditionalInformation
{
    protected string $text;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return AdditionalInformation
     */
    public function setText(string $text): AdditionalInformation
    {
        $this->text = $text;
        return $this;
    }
}
