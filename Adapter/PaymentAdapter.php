<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter;
use Adapter\_classes as Classes;

// Adapted payment method class
class PaymentAdapter extends Classes\PaymentTarget implements IAdapter
{
    protected $adaptee;

    public function __construct(Classes\IAdaptee $adaptee) {
        $this->adaptee = $adaptee;
    }

    // Direct forwarding
    public function getID(): string {
        return $this->adaptee->getID();
    }

    // Adapt
    public function commit(): bool {
        return $this->adaptee->preAuth() && $this->adaptee->sale();
    }

    // Not supported by adaptee
    public function refund(): bool {
        return parent::refund();
    }
}
