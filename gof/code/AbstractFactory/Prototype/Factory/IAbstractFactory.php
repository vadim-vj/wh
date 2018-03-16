<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\Prototype\Factory;
use AbstractFactory\_classes as Classes;

interface IAbstractFactory
{
    public function __construct(string $type);
    public function create(string $id): Classes\IBase;
}
