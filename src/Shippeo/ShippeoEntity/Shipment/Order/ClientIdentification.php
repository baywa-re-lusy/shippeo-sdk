<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

class ClientIdentification
{
    protected ?string $organization = null;
    protected ?string $agency = null;

    /**
     * @return string|null
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param string|null $organization
     * @return ClientIdentification
     */
    public function setOrganization(?string $organization): ClientIdentification
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAgency(): ?string
    {
        return $this->agency;
    }

    /**
     * @param string|null $agency
     * @return ClientIdentification
     */
    public function setAgency(?string $agency): ClientIdentification
    {
        $this->agency = $agency;
        return $this;
    }
}
