<?php

namespace BayWaReLusy\Shippeo;

use DateTimeImmutable;

class ShippeoEventEntity
{
    protected string $containerId;
    protected DateTimeImmutable $timestamp;
    protected ShippeoEventType $type;
    protected ?DateTimeImmutable $eta = null;
    protected ?DateTimeImmutable $expectedReceiptDate = null;
    protected DateTimeImmutable $created;

    public function getContainerId(): string
    {
        return $this->containerId;
    }

    public function setContainerId(string $containerId): ShippeoEventEntity
    {
        $this->containerId = $containerId;
        return $this;
    }

    public function getTimestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTimeImmutable $timestamp): ShippeoEventEntity
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getType(): ShippeoEventType
    {
        return $this->type;
    }

    public function setType(ShippeoEventType $type): ShippeoEventEntity
    {
        $this->type = $type;
        return $this;
    }

    public function getEta(): ?DateTimeImmutable
    {
        return $this->eta;
    }

    public function setEta(DateTimeImmutable $eta): ShippeoEventEntity
    {
        $this->eta = $eta;
        return $this;
    }

    public function getExpectedReceiptDate(): ?DateTimeImmutable
    {
        return $this->expectedReceiptDate;
    }

    public function setExpectedReceiptDate(DateTimeImmutable $expectedReceiptDate): ShippeoEventEntity
    {
        $this->expectedReceiptDate = $expectedReceiptDate;
        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): ShippeoEventEntity
    {
        $this->created = $created;
        return $this;
    }
}
