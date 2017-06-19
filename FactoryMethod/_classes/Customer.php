<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\_classes;

class Customer implements IHeader
{
    public function getText(): string {
        return 'Customer area';
    }
}
