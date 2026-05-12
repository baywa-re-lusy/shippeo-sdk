<?php

namespace BayWaReLusy\Shippeo;

use DateTimeImmutable;

interface ShippeoEventInterface
{
    public function getTimestamp(): DateTimeImmutable;
    public function setTimestamp(DateTimeImmutable $timestamp): static;

    public function getType(): ShippeoEventType;
    public function setType(ShippeoEventType $type): static;

    public function getEta(): ?DateTimeImmutable;
    public function setEta(?DateTimeImmutable $eta): static;

    public function getExpectedReceiptDate(): ?DateTimeImmutable;
    public function setExpectedReceiptDate(?DateTimeImmutable $expectedReceiptDate): static;

    public function getCreated(): ?DateTimeImmutable;
    public function setCreated(?DateTimeImmutable $created): static;
}
