<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Amount;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Attribute;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Charges;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\ClientIdentification;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Consignee;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\DangerousGood;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\HandlingUnit;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Packing;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\PickUp;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Quantity;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Reference;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\ReturnablePackaging;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\NotificationContact;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order\Tag;

class Order
{
    /** @var string */
    protected string $goodsDescription;
    /** @var Reference[] */
    protected array $references = [];
    /** @var Packing[] */
    protected array $packing = [];
    /** @var ReturnablePackaging[] */
    protected array $returnablePackaging = [];
    /** @var PickUp|null */
    protected ?PickUp $pickUp = null;
    /** @var Consignee  */
    protected Consignee $consignee;
    /** @var ClientIdentification|null */
    protected ?ClientIdentification $clientIdentification = null;
    /** @var NotificationContact[] */
    protected array $notificationContacts = [];
    /** @var Tag[] */
    protected array $tags = [];
    /** @var Quantity|null */
    protected ?Quantity $quantity = null;
    /** @var Amount[] */
    protected array $amounts = [];
    /** @var HandlingUnit[] */
    protected array $handlingUnits = [];
    /** @var Attribute[] */
    protected array $attributes = [];
    /** @var DangerousGood[] */
    protected array $dangerousGoods = [];
    /** @var Charges|null */
    protected ?Charges $charges = null;

    /**
     * @return string
     */
    public function getGoodsDescription(): string
    {
        return $this->goodsDescription;
    }

    /**
     * @param string $goodsDescription
     * @return Order
     */
    public function setGoodsDescription(string $goodsDescription): Order
    {
        $this->goodsDescription = $goodsDescription;
        return $this;
    }

    /**
     * @return Reference[]
     */
    public function getReferences(): array
    {
        return $this->references;
    }

    /**
     * @param Reference[] $references
     * @return Order
     */
    public function setReferences(array $references): Order
    {
        $this->references = $references;
        return $this;
    }

    /**
     * @return Packing[]
     */
    public function getPacking(): array
    {
        return $this->packing;
    }

    /**
     * @param Packing[] $packing
     * @return Order
     */
    public function setPacking(array $packing): Order
    {
        $this->packing = $packing;
        return $this;
    }

    /**
     * @return ReturnablePackaging[]
     */
    public function getReturnablePackaging(): array
    {
        return $this->returnablePackaging;
    }

    /**
     * @param ReturnablePackaging[] $returnablePackaging
     * @return Order
     */
    public function setReturnablePackaging(array $returnablePackaging): Order
    {
        $this->returnablePackaging = $returnablePackaging;
        return $this;
    }

    /**
     * @return PickUp|null
     */
    public function getPickUp(): ?PickUp
    {
        return $this->pickUp;
    }

    /**
     * @param PickUp $pickUp
     * @return Order
     */
    public function setPickUp(PickUp $pickUp): Order
    {
        $this->pickUp = $pickUp;
        return $this;
    }

    /**
     * @return Consignee
     */
    public function getConsignee(): Consignee
    {
        return $this->consignee;
    }

    /**
     * @param Consignee $consignee
     * @return Order
     */
    public function setConsignee(Consignee $consignee): Order
    {
        $this->consignee = $consignee;
        return $this;
    }

    /**
     * @return ClientIdentification|null
     */
    public function getClientIdentification(): ?ClientIdentification
    {
        return $this->clientIdentification;
    }

    /**
     * @param ClientIdentification $clientIdentification
     * @return Order
     */
    public function setClientIdentification(ClientIdentification $clientIdentification): Order
    {
        $this->clientIdentification = $clientIdentification;
        return $this;
    }

    /**
     * @return NotificationContact[]
     */
    public function getNotificationContacts(): array
    {
        return $this->notificationContacts;
    }

    /**
     * @param NotificationContact[] $notificationContacts
     * @return Order
     */
    public function setNotificationContacts(array $notificationContacts): Order
    {
        $this->notificationContacts = $notificationContacts;
        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     * @return Order
     */
    public function setTags(array $tags): Order
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return Quantity|null
     */
    public function getQuantity(): ?Quantity
    {
        return $this->quantity;
    }

    /**
     * @param Quantity $quantity
     * @return Order
     */
    public function setQuantity(Quantity $quantity): Order
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Amount[]
     */
    public function getAmounts(): array
    {
        return $this->amounts;
    }

    /**
     * @param Amount[] $amounts
     * @return Order
     */
    public function setAmounts(array $amounts): Order
    {
        $this->amounts = $amounts;
        return $this;
    }

    /**
     * @return HandlingUnit[]
     */
    public function getHandlingUnits(): array
    {
        return $this->handlingUnits;
    }

    /**
     * @param HandlingUnit[] $handlingUnits
     * @return Order
     */
    public function setHandlingUnits(array $handlingUnits): Order
    {
        $this->handlingUnits = $handlingUnits;
        return $this;
    }

    /**
     * @return Attribute[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param Attribute[] $attributes
     * @return Order
     */
    public function setAttributes(array $attributes): Order
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return DangerousGood[]
     */
    public function getDangerousGoods(): array
    {
        return $this->dangerousGoods;
    }

    /**
     * @param DangerousGood[] $dangerousGoods
     * @return Order
     */
    public function setDangerousGoods(array $dangerousGoods): Order
    {
        $this->dangerousGoods = $dangerousGoods;
        return $this;
    }

    /**
     * @return Charges|null
     */
    public function getCharges(): ?Charges
    {
        return $this->charges;
    }

    /**
     * @param Charges|null $charges
     * @return Order
     */
    public function setCharges(?Charges $charges): Order
    {
        $this->charges = $charges;
        return $this;
    }
}
