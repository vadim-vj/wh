<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter\_classes;

// Our base class for payment methods
class PaymentTarget implements ITarget
{
    public function getID(): string {
        return get_class($this);
    }

    public function commit(): bool {
        return false;
    }

    public function refund(): bool {
        return false;
    }
}
