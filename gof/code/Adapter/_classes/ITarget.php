<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter\_classes;

// Our base class for payment methods
interface ITarget
{
    public function getID(): string;

    public function commit(): bool;
    public function refund(): bool;
}
