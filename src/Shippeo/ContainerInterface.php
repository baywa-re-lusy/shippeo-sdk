<?php

namespace BayWaReLusy\Shippeo;

interface ContainerInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     * @return static
     */
    public function setId(string $id): static;

    /**
     * @return string
     */
    public function getUnLoCodeLoadingPort(): string;

    /**
     * @param string $unLoCodeLoadingPort
     * @return static
     */
    public function setUnLoCodeLoadingPort(string $unLoCodeLoadingPort): static;

    /**
     * @return string
     */
    public function getUnLoCodeDestinationPort(): string;

    /**
     * @param string $unLoCodeDestinationPort
     * @return static
     */
    public function setUnLoCodeDestinationPort(string $unLoCodeDestinationPort): static;

    /**
     * @return string
     */
    public function getMasterBillOfLadingReference(): string;

    /**
     * @param string $masterBillOfLadingReference
     * @return static
     */
    public function setMasterBillOfLadingReference(string $masterBillOfLadingReference): static;

    /**
     * @return string
     */
    public function getOceanCarrierCode(): string;

    /**
     * @param string $oceanCarrierCode
     * @return static
     */
    public function setOceanCarrierCode(string $oceanCarrierCode): static;

    /**
     * @return \DateTime|null
     */
    public function getLastPushToShippeo(): ?\DateTime;

    /**
     * @param \DateTime|null $lastPushToShippeo
     * @return static
     */
    public function setLastPushToShippeo(?\DateTime $lastPushToShippeo): static;
}
