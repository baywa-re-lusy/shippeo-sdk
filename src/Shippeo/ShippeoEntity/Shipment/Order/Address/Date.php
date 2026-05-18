<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address;

use DateTime;

class Date
{
    protected string $qualifier;
    protected ?DateTime $dateTime = null;

    /**
     * @return string
     */
    public function getQualifier(): string
    {
        return $this->qualifier;
    }

    /**
     * @param string $qualifier
     * @return Date
     */
    public function setQualifier(string $qualifier): Date
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param ?DateTime $dateTime
     * @return Date
     */
    public function setDateTime(?DateTime $dateTime): Date
    {
        $this->dateTime = $dateTime;
        return $this;
    }
}
