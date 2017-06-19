<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\Common\Page;
use FactoryMethod\_classes as Classes;

interface IPage
{
    public function getHeader(): Classes\IHeader;
}
