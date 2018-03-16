<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\_classes\Connection;
use AbstractFactory\_classes as Classes;

interface IConnection extends Classes\IBase
{
    public function connect(): \resource;
}
