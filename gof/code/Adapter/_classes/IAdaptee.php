<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter\_classes;

// Vendor class
interface IAdaptee
{
    public function getID(): string;

    public function preAuth(): bool;
    public function sale(): bool;
    public function check3dSecure(): bool;
}
