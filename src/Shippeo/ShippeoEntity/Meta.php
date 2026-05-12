<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity;

class Meta
{
    protected string $senderID;
    protected string $duplicateReceiverId;
    protected \DateTimeImmutable $messageDate;
    protected string $messageReference;
    protected string $messageType;
    protected string $messageFunction;

    /**
     * @return string
     */
    public function getSenderID(): string
    {
        return $this->senderID;
    }

    /**
     * @param string $senderID
     * @return Meta
     */
    public function setSenderID(string $senderID): Meta
    {
        $this->senderID = $senderID;
        return $this;
    }

    /**
     * @return string
     */
    public function getDuplicateReceiverId(): string
    {
        return $this->duplicateReceiverId;
    }

    /**
     * @param string $duplicateReceiverId
     * @return Meta
     */
    public function setDuplicateReceiverId(string $duplicateReceiverId): Meta
    {
        $this->duplicateReceiverId = $duplicateReceiverId;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getMessageDate(): \DateTimeImmutable
    {
        return $this->messageDate;
    }

    /**
     * @param \DateTimeImmutable $messageDate
     * @return Meta
     */
    public function setMessageDate(\DateTimeImmutable $messageDate): Meta
    {
        $this->messageDate = $messageDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageReference(): string
    {
        return $this->messageReference;
    }

    /**
     * @param string $messageReference
     * @return Meta
     */
    public function setMessageReference(string $messageReference): Meta
    {
        $this->messageReference = $messageReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     * @return Meta
     */
    public function setMessageType(string $messageType): Meta
    {
        $this->messageType = $messageType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessageFunction(): string
    {
        return $this->messageFunction;
    }

    /**
     * @param string $messageFunction
     * @return Meta
     */
    public function setMessageFunction(string $messageFunction): Meta
    {
        $this->messageFunction = $messageFunction;
        return $this;
    }
}
