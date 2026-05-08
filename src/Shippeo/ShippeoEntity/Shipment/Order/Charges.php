<?php

namespace BayWaReLusy\Shippeo\ShippeoEntity\Shipment\Order;

class Charges
{
    protected string $billingAccount;

    /**
     * @return string
     */
    public function getBillingAccount(): string
    {
        return $this->billingAccount;
    }

    /**
     * @param string $billingAccount
     * @return Charges
     */
    public function setBillingAccount(string $billingAccount): Charges
    {
        $this->billingAccount = $billingAccount;
        return $this;
    }
}
