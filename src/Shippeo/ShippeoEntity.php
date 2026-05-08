<?php

namespace BayWaReLusy\Shippeo;

use BayWaReLusy\Shippeo\ShippeoEntity\Meta;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

class ShippeoEntity
{
    protected Meta $meta;
    protected Shipment $shipment;

    /**
     * @return Meta
     */
    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @param Meta $meta
     * @return ShippeoEntity
     */
    public function setMeta(Meta $meta): ShippeoEntity
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return Shipment
     */
    public function getShipment(): Shipment
    {
        return $this->shipment;
    }

    /**
     * @param Shipment $shipment
     * @return ShippeoEntity
     */
    public function setShipment(Shipment $shipment): ShippeoEntity
    {
        $this->shipment = $shipment;
        return $this;
    }
}
