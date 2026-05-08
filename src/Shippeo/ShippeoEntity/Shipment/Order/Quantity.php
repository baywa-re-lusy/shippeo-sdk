<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

class Quantity
{
    protected ?int $grossWeight = null;
    protected ?int $grossVolume = null;
    protected float $loadingMeters;
    protected ?int $palletGround = null;
    protected ?bool $fullLoad = null;

    /**
     * @return int|null
     */
    public function getGrossWeight(): ?int
    {
        return $this->grossWeight;
    }

    /**
     * @param int|null $grossWeight
     * @return Quantity
     */
    public function setGrossWeight(?int $grossWeight): Quantity
    {
        $this->grossWeight = $grossWeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGrossVolume(): ?int
    {
        return $this->grossVolume;
    }

    /**
     * @param int|null $grossVolume
     * @return Quantity
     */
    public function setGrossVolume(?int $grossVolume): Quantity
    {
        $this->grossVolume = $grossVolume;
        return $this;
    }

    /**
     * @return float
     */
    public function getLoadingMeters(): float
    {
        return $this->loadingMeters;
    }

    /**
     * @param float $loadingMeters
     * @return Quantity
     */
    public function setLoadingMeters(float $loadingMeters): Quantity
    {
        $this->loadingMeters = $loadingMeters;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPalletGround(): ?int
    {
        return $this->palletGround;
    }

    /**
     * @param int|null $palletGround
     * @return Quantity
     */
    public function setPalletGround(?int $palletGround): Quantity
    {
        $this->palletGround = $palletGround;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getFullLoad(): ?bool
    {
        return $this->fullLoad;
    }

    /**
     * @param bool|null $fullLoad
     * @return Quantity
     */
    public function setFullLoad(?bool $fullLoad): Quantity
    {
        $this->fullLoad = $fullLoad;
        return $this;
    }
}
