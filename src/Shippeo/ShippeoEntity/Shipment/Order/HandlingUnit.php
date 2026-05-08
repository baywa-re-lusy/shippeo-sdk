<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\HandlingUnit\ContentReference;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\HandlingUnit\Attribute;

class HandlingUnit
{
    protected int $serialNumber;
    protected ?string $consignorReference = null;
    protected string $consolidationId;
    /** @var ContentReference[] */
    protected array $contentReferences = [];
    protected ?string $trackingCode = null;
    protected ?string $barcode = null;
    protected ?string $packagingQualifier = null;
    protected ?string $customPackagingQualifier = null;
    protected float $grossWeight;
    protected float $grossVolume;
    protected float $width;
    protected float $length;
    protected float $height;

    /**
     * @return int
     */
    public function getSerialNumber(): int
    {
        return $this->serialNumber;
    }

    /**
     * @param int $serialNumber
     * @return HandlingUnit
     */
    public function setSerialNumber(int $serialNumber): HandlingUnit
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConsignorReference(): ?string
    {
        return $this->consignorReference;
    }

    /**
     * @param string $consignorReference
     * @return HandlingUnit
     */
    public function setConsignorReference(string $consignorReference): HandlingUnit
    {
        $this->consignorReference = $consignorReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsolidationId(): string
    {
        return $this->consolidationId;
    }

    /**
     * @param string $consolidationId
     * @return HandlingUnit
     */
    public function setConsolidationId(string $consolidationId): HandlingUnit
    {
        $this->consolidationId = $consolidationId;
        return $this;
    }

    /**
     * @return ContentReference[]
     */
    public function getContentReferences(): array
    {
        return $this->contentReferences;
    }

    /**
     * @param ContentReference[] $contentReferences
     * @return HandlingUnit
     */
    public function setContentReferences(array $contentReferences): HandlingUnit
    {
        $this->contentReferences = $contentReferences;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrackingCode(): ?string
    {
        return $this->trackingCode;
    }

    /**
     * @param string $trackingCode
     * @return HandlingUnit
     */
    public function setTrackingCode(string $trackingCode): HandlingUnit
    {
        $this->trackingCode = $trackingCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     * @return HandlingUnit
     */
    public function setBarcode(string $barcode): HandlingUnit
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPackagingQualifier(): ?string
    {
        return $this->packagingQualifier;
    }

    /**
     * @param string $packagingQualifier
     * @return HandlingUnit
     */
    public function setPackagingQualifier(string $packagingQualifier): HandlingUnit
    {
        $this->packagingQualifier = $packagingQualifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomPackagingQualifier(): ?string
    {
        return $this->customPackagingQualifier;
    }

    /**
     * @param string $customPackagingQualifier
     * @return HandlingUnit
     */
    public function setCustomPackagingQualifier(string $customPackagingQualifier): HandlingUnit
    {
        $this->customPackagingQualifier = $customPackagingQualifier;
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
     * @return HandlingUnit
     */
    public function setGrossWeight(float $grossWeight): HandlingUnit
    {
        $this->grossWeight = $grossWeight;
        return $this;
    }

    /**
     * @return float
     */
    public function getGrossVolume(): float
    {
        return $this->grossVolume;
    }

    /**
     * @param float $grossVolume
     * @return HandlingUnit
     */
    public function setGrossVolume(float $grossVolume): HandlingUnit
    {
        $this->grossVolume = $grossVolume;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @param float $width
     * @return HandlingUnit
     */
    public function setWidth(float $width): HandlingUnit
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float
     */
    public function getLength(): float
    {
        return $this->length;
    }

    /**
     * @param float $length
     * @return HandlingUnit
     */
    public function setLength(float $length): HandlingUnit
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     * @return HandlingUnit
     */
    public function setHeight(float $height): HandlingUnit
    {
        $this->height = $height;
        return $this;
    }
}
