<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class TransportMean
{
    protected ?string $code = null;
    protected string $qualifier;
    protected string $identifier;
    protected string $identificationPlate;
    protected bool $isTrackable;
    protected ?string $text = null;

    public const TYPE_TRUCK   = 'truck';
    public const TYPE_TRAILER = 'trailer';
    public const TYPE_DRIVER  = 'driver';

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return TransportMean
     */
    public function setCode(?string $code): TransportMean
    {
        $this->code = $code;
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
     * @return TransportMean
     */
    public function setQualifier(string $qualifier): TransportMean
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return TransportMean
     */
    public function setIdentifier(string $identifier): TransportMean
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentificationPlate(): string
    {
        return $this->identificationPlate;
    }

    /**
     * @param string $identificationPlate
     * @return TransportMean
     */
    public function setIdentificationPlate(string $identificationPlate): TransportMean
    {
        $this->identificationPlate = $identificationPlate;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTrackable(): bool
    {
        return $this->isTrackable;
    }

    /**
     * @param bool $isTrackable
     * @return TransportMean
     */
    public function setIsTrackable(bool $isTrackable): TransportMean
    {
        $this->isTrackable = $isTrackable;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return TransportMean
     */
    public function setText(?string $text): TransportMean
    {
        $this->text = $text;
        return $this;
    }
}
