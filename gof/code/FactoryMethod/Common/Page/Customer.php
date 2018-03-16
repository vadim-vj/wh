<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\Common\Page;
use FactoryMethod\_classes as Classes;

class Customer implements IPage
{
    public function getHeader(): Classes\IHeader {
        return new Classes\Customer();
    }
}
