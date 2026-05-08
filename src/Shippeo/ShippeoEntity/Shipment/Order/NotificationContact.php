<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\NotificationContact\CommunicationNumber;

class NotificationContact
{
    protected ?string $name = null;
    protected ?string $email = null;
    protected ?CommunicationNumber $communicationNumber = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return NotificationContact
     */
    public function setName(string $name): NotificationContact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return NotificationContact
     */
    public function setEmail(string $email): NotificationContact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return CommunicationNumber|null
     */
    public function getCommunicationNumber(): ?CommunicationNumber
    {
        return $this->communicationNumber;
    }

    /**
     * @param CommunicationNumber|null $communicationNumber
     * @return NotificationContact
     */
    public function setCommunicationNumber(?CommunicationNumber $communicationNumber): NotificationContact
    {
        $this->communicationNumber = $communicationNumber;
        return $this;
    }
}
