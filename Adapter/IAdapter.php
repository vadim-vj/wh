<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Adapter;
use Adapter\_classes as Classes;

// Adapted payment method class
interface IAdapter extends Classes\ITarget
{
    public function __construct(Classes\IAdaptee $adaptee);
}
