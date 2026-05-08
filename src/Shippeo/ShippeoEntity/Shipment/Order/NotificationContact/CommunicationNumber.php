<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\NotificationContact;

class CommunicationNumber
{
    protected string $qualifier;
    protected ?string $countryCode = null;
    protected string $value;

    /**
     * @return string
     */
    public function getQualifier(): string
    {
        return $this->qualifier;
    }

    /**
     * @param string $qualifier
     * @return CommunicationNumber
     */
    public function setQualifier(string $qualifier): CommunicationNumber
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     * @return CommunicationNumber
     */
    public function setCountryCode(?string $countryCode): CommunicationNumber
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return CommunicationNumber
     */
    public function setValue(string $value): CommunicationNumber
    {
        $this->value = $value;
        return $this;
    }
}
