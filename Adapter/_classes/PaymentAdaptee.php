<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter\_classes;

// Vendor class
class PaymentAdaptee implements IAdaptee
{
    public function getID(): string {
        return get_class($this);
    }

    public function preAuth(): bool {
        // ...
        return true;
    }

    public function sale(): bool {
        // ...
        return true;
    }

    // Not used in adapter
    public function check3dSecure(): bool {
        // ...
        return true;
    }
}
