<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\NameConvParam;
use FactoryMethod\_classes as Classes;

interface IPage
{
    public function __construct(string $type);
    public function getHeader(): Classes\IHeader;
}
