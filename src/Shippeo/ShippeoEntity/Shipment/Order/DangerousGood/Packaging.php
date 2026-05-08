<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood;

class Packaging
{
    protected int $number;
    protected ?string $code = null;
    protected ?string $description = null;

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Packaging
     */
    public function setNumber(int $number): Packaging
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return Packaging
     */
    public function setCode(?string $code): Packaging
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Packaging
     */
    public function setDescription(?string $description): Packaging
    {
        $this->description = $description;
        return $this;
    }
}
