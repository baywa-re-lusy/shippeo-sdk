<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

class Packing
{
    protected int $handlingUnitNumber;
    protected string $type;
    protected string $customType;
    protected int $grossWeight;

    /**
     * @return int
     */
    public function getHandlingUnitNumber(): int
    {
        return $this->handlingUnitNumber;
    }

    /**
     * @param int $handlingUnitNumber
     * @return Packing
     */
    public function setHandlingUnitNumber(int $handlingUnitNumber): Packing
    {
        $this->handlingUnitNumber = $handlingUnitNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Packing
     */
    public function setType(string $type): Packing
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomType(): string
    {
        return $this->customType;
    }

    /**
     * @param string $customType
     * @return Packing
     */
    public function setCustomType(string $customType): Packing
    {
        $this->customType = $customType;
        return $this;
    }

    /**
     * @return int
     */
    public function getGrossWeight(): int
    {
        return $this->grossWeight;
    }

    /**
     * @param int $grossWeight
     * @return Packing
     */
    public function setGrossWeight(int $grossWeight): Packing
    {
        $this->grossWeight = $grossWeight;
        return $this;
    }
}
