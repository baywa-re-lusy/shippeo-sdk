<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity;

use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\BillOfLadingReference;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Carrier;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Container;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\TransportMean;
use BayWaReLusy\Shippeo\ShippeoEntity\Shipment\TransportServiceBuyer;

class Shipment
{
    protected string $technicalReference;
    protected ?string $reference = null;
    protected string $type;
    protected string $transportMode;
    protected ?string $serviceLine = null;
    /** @var BillOfLadingReference[] */
    protected ?array $billOfLadingReferences = null;
    protected ?Container $container = null;
    /** @var TransportServiceBuyer[] */
    protected array $transportServiceBuyer = [];
    /** @var Carrier[] */
    protected array $carrier = [];
    /** @var string[] */
    protected ?array $nextShipments = null;
    /** @var TransportMean[] */
    protected array $transportMean = [];
    /** @var Order[] */
    protected array $orders = [];
    protected bool $isDangerousGoods = false;

    /**
     * @return string
     */
    public function getTechnicalReference(): string
    {
        return $this->technicalReference;
    }

    /**
     * @param string $technicalReference
     * @return Shipment
     */
    public function setTechnicalReference(string $technicalReference): Shipment
    {
        $this->technicalReference = $technicalReference;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Shipment
     */
    public function setReference(string $reference): Shipment
    {
        $this->reference = $reference;
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
     * @return Shipment
     */
    public function setType(string $type): Shipment
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransportMode(): string
    {
        return $this->transportMode;
    }

    /**
     * @param string $transportMode
     * @return Shipment
     */
    public function setTransportMode(string $transportMode): Shipment
    {
        $this->transportMode = $transportMode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getServiceLine(): ?string
    {
        return $this->serviceLine;
    }

    /**
     * @param string|null $serviceLine
     * @return Shipment
     */
    public function setServiceLine(?string $serviceLine): Shipment
    {
        $this->serviceLine = $serviceLine;
        return $this;
    }

    /**
     * @return Container|null
     */
    public function getContainer(): ?Container
    {
        return $this->container;
    }

    /**
     * @param Container|null $container
     * @return Shipment
     */
    public function setContainer(?Container $container): Shipment
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return TransportServiceBuyer[]
     */
    public function getTransportServiceBuyer(): array
    {
        return $this->transportServiceBuyer;
    }

    /**
     * @param TransportServiceBuyer[] $transportServiceBuyers
     * @return Shipment
     */
    public function setTransportServiceBuyer(array $transportServiceBuyers): Shipment
    {
        $this->transportServiceBuyer = $transportServiceBuyers;
        return $this;
    }

    /**
     * @return Carrier[]
     */
    public function getCarrier(): array
    {
        return $this->carrier;
    }

    /**
     * @param Carrier[] $carriers
     * @return Shipment
     */
    public function setCarrier(array $carriers): Shipment
    {
        $this->carrier = $carriers;
        return $this;
    }

    /**
     * @return BillOfLadingReference[]|null
     */
    public function getBillOfLadingReferences(): ?array
    {
        return $this->billOfLadingReferences;
    }

    /**
     * @param BillOfLadingReference[] $billOfLadingReferences
     * @return Shipment
     */
    public function setBillOfLadingReferences(array $billOfLadingReferences): Shipment
    {
        $this->billOfLadingReferences = $billOfLadingReferences;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getNextShipments(): ?array
    {
        return $this->nextShipments;
    }

    /**
     * @param string[] $nextShipments
     * @return Shipment
     */
    public function setNextShipments(array $nextShipments): Shipment
    {
        $this->nextShipments = $nextShipments;
        return $this;
    }

    /**
     * @return TransportMean[]
     */
    public function getTransportMean(): array
    {
        return $this->transportMean;
    }

    /**
     * @param TransportMean[] $transportMean
     * @return Shipment
     */
    public function setTransportMean(array $transportMean): Shipment
    {
        $this->transportMean = $transportMean;
        return $this;
    }

    /**
     * @return Order[]
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param Order[] $orders
     * @return Shipment
     */
    public function setOrders(array $orders): Shipment
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDangerousGoods(): bool
    {
        return $this->isDangerousGoods;
    }

    /**
     * @param bool $isDangerousGoods
     * @return Shipment
     */
    public function setIsDangerousGoods(bool $isDangerousGoods): Shipment
    {
        $this->isDangerousGoods = $isDangerousGoods;
        return $this;
    }
}
