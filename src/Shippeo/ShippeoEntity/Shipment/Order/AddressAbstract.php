<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address\Date;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Address\Identification;

abstract class AddressAbstract
{
    /** @var Identification[] */
    protected array $identifications = [];
    protected ?string $name = null;
    protected ?string $address1 = null;
    protected ?string $address2 = null;
    protected ?string $country = null;
    protected ?string $postalCode = null;
    protected ?string $city = null;
    protected ?string $latitude = null;
    protected ?string $longitude = null;
    protected ?string $ownership = null;
    protected ?int $activityTime = null;
    protected ?string $instructions = null;
    protected bool $appointment = false;
    /** @var Date[] */
    protected array $dates = [];

    /**
     * @return Identification[]
     */
    public function getIdentifications(): array
    {
        return $this->identifications;
    }

    /**
     * @param Identification[] $identifications
     * @return AddressAbstract
     */
    public function setIdentifications(array $identifications): AddressAbstract
    {
        $this->identifications = $identifications;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return AddressAbstract
     */
    public function setName(?string $name): AddressAbstract
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param string|null $address1
     * @return AddressAbstract
     */
    public function setAddress1(?string $address1): AddressAbstract
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param string|null $address2
     * @return AddressAbstract
     */
    public function setAddress2(?string $address2): AddressAbstract
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return AddressAbstract
     */
    public function setCountry(?string $country): AddressAbstract
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return AddressAbstract
     */
    public function setPostalCode(string $postalCode): AddressAbstract
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return AddressAbstract
     */
    public function setCity(?string $city): AddressAbstract
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return AddressAbstract
     */
    public function setLatitude(string $latitude): AddressAbstract
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return AddressAbstract
     */
    public function setLongitude(string $longitude): AddressAbstract
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOwnership(): ?string
    {
        return $this->ownership;
    }

    /**
     * @param string $ownership
     * @return AddressAbstract
     */
    public function setOwnership(string $ownership): AddressAbstract
    {
        $this->ownership = $ownership;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getActivityTime(): ?int
    {
        return $this->activityTime;
    }

    /**
     * @param int $activityTime
     * @return AddressAbstract
     */
    public function setActivityTime(int $activityTime): AddressAbstract
    {
        $this->activityTime = $activityTime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    /**
     * @param string|null $instructions
     * @return AddressAbstract
     */
    public function setInstructions(?string $instructions): AddressAbstract
    {
        $this->instructions = $instructions;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAppointment(): bool
    {
        return $this->appointment;
    }

    /**
     * @param bool $appointment
     * @return AddressAbstract
     */
    public function setAppointment(bool $appointment): AddressAbstract
    {
        $this->appointment = $appointment;
        return $this;
    }

    /**
     * @return Date[]
     */
    public function getDates(): array
    {
        return $this->dates;
    }

    /**
     * @param Date[] $dates
     * @return AddressAbstract
     */
    public function setDates(array $dates): AddressAbstract
    {
        $this->dates = $dates;
        return $this;
    }
}
