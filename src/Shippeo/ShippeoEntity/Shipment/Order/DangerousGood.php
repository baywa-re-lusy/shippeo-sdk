<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood\AdditionalInformation;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood\NetQuantity;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood\Packaging;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood\TechnicalName;

class DangerousGood
{
    protected string $ADR;
    protected string $class;
    protected string $classificationCode;
    protected int $UNDG;
    protected ?NetQuantity $netQuantity = null;
    protected float $grossWeight;
    protected ?float $limitedQuantity = null;
    protected ?float $exceptedQuantity = null;
    protected ?AdditionalInformation $additionalInformation = null;
    protected ?TechnicalName $technicalName = null;
    protected ?Packaging $packaging = null;

    /**
     * @return string
     */
    public function getADR(): string
    {
        return $this->ADR;
    }

    /**
     * @param string $ADR
     * @return DangerousGood
     */
    public function setADR(string $ADR): DangerousGood
    {
        $this->ADR = $ADR;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return DangerousGood
     */
    public function setClass(string $class): DangerousGood
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassificationCode(): string
    {
        return $this->classificationCode;
    }

    /**
     * @param string $classificationCode
     * @return DangerousGood
     */
    public function setClassificationCode(string $classificationCode): DangerousGood
    {
        $this->classificationCode = $classificationCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getUNDG(): int
    {
        return $this->UNDG;
    }

    /**
     * @param int $UNDG
     * @return DangerousGood
     */
    public function setUNDG(int $UNDG): DangerousGood
    {
        $this->UNDG = $UNDG;
        return $this;
    }

    /**
     * @return NetQuantity|null
     */
    public function getNetQuantity(): ?NetQuantity
    {
        return $this->netQuantity;
    }

    /**
     * @param NetQuantity|null $netQuantity
     * @return DangerousGood
     */
    public function setNetQuantity(?NetQuantity $netQuantity): DangerousGood
    {
        $this->netQuantity = $netQuantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getGrossWeight(): float
    {
        return $this->grossWeight;
    }

    /**
     * @param float $grossWeight
     * @return DangerousGood
     */
    public function setGrossWeight(float $grossWeight): DangerousGood
    {
        $this->grossWeight = $grossWeight;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLimitedQuantity(): ?float
    {
        return $this->limitedQuantity;
    }

    /**
     * @param float|null $limitedQuantity
     * @return DangerousGood
     */
    public function setLimitedQuantity(?float $limitedQuantity): DangerousGood
    {
        $this->limitedQuantity = $limitedQuantity;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getExceptedQuantity(): ?float
    {
        return $this->exceptedQuantity;
    }

    /**
     * @param float|null $exceptedQuantity
     * @return DangerousGood
     */
    public function setExceptedQuantity(?float $exceptedQuantity): DangerousGood
    {
        $this->exceptedQuantity = $exceptedQuantity;
        return $this;
    }

    /**
     * @return AdditionalInformation|null
     */
    public function getAdditionalInformation(): ?AdditionalInformation
    {
        return $this->additionalInformation;
    }

    /**
     * @param AdditionalInformation|null $additionalInformation
     * @return DangerousGood
     */
    public function setAdditionalInformation(?AdditionalInformation $additionalInformation): DangerousGood
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }

    /**
     * @return TechnicalName|null
     */
    public function getTechnicalName(): ?TechnicalName
    {
        return $this->technicalName;
    }

    /**
     * @param TechnicalName|null $technicalName
     * @return DangerousGood
     */
    public function setTechnicalName(?TechnicalName $technicalName): DangerousGood
    {
        $this->technicalName = $technicalName;
        return $this;
    }

    /**
     * @return Packaging|null
     */
    public function getPackaging(): ?Packaging
    {
        return $this->packaging;
    }

    /**
     * @param Packaging|null $packaging
     * @return DangerousGood
     */
    public function setPackaging(?Packaging $packaging): DangerousGood
    {
        $this->packaging = $packaging;
        return $this;
    }
}
