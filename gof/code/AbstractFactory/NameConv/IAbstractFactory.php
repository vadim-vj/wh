<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\NameConv;
use AbstractFactory\_classes as Classes;

interface IAbstractFactory
{
    public function __construct(string $type);
    public function create(string $name): Classes\IBase;
}
