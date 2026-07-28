<?php

namespace BayWaReLusy\Shippeo;

use DateTime;

interface ContainerInterface
{
    public function getId(): ?string;
    public function setId(?string $id): static;

    public function getUnLoCodeLoadingPort(): ?string;
    public function setUnLoCodeLoadingPort(?string $unLoCodeLoadingPort): static;

    public function getUnLoCodeDestinationPort(): ?string;
    public function setUnLoCodeDestinationPort(?string $unLoCodeDestinationPort): static;

    public function getMasterBillOfLadingReference(): ?string;
    public function setMasterBillOfLadingReference(?string $masterBillOfLadingReference): static;

    public function getOceanCarrierCode(): ?string;
    public function setOceanCarrierCode(?string $oceanCarrierCode): static;

    public function getLastPushToShippeo(): ?DateTime;
    public function setLastPushToShippeo(?DateTime $lastPushToShippeo): static;
}
