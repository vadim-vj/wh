<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\_classes;

class Admin implements IHeader
{
    public function getText(): string {
        return 'Admin area';
    }
}
