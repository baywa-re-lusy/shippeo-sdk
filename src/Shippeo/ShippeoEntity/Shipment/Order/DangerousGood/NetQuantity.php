<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood;

class NetQuantity
{
    public const MEASURE_UNIT_CODE_PIECE       = 'PCE';
    public const MEASURE_UNIT_CODE_KILOGRAM    = 'KGM';
    public const MEASURE_UNIT_CODE_LITER       = 'LTR';
    public const MEASURE_UNIT_CODE_CUBIQ_METER = 'MTQ';

    public const MEASURE_UNIT_CODES =
        [
            self::MEASURE_UNIT_CODE_PIECE,
            self::MEASURE_UNIT_CODE_KILOGRAM,
            self::MEASURE_UNIT_CODE_LITER,
            self::MEASURE_UNIT_CODE_CUBIQ_METER,
        ];

    protected float $value;
    protected string $measureUnitCode;

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return NetQuantity
     */
    public function setValue(float $value): NetQuantity
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeasureUnitCode(): string
    {
        return $this->measureUnitCode;
    }

    /**
     * @param string $measureUnitCode
     * @return NetQuantity
     */
    public function setMeasureUnitCode(string $measureUnitCode): NetQuantity
    {
        if (!in_array($measureUnitCode, self::MEASURE_UNIT_CODES)) {
            throw new \InvalidArgumentException('Invalid');
        }

        $this->measureUnitCode = $measureUnitCode;
        return $this;
    }
}
