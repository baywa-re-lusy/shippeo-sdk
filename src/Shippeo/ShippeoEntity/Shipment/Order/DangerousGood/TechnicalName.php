<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood;

class TechnicalName
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
     * @return TechnicalName
     */
    public function setText(string $text): TechnicalName
    {
        $this->text = $text;
        return $this;
    }
}
