<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\_classes\Database;
use AbstractFactory\_classes as Classes;

interface IDatabase extends Classes\IBase
{
    public function exec(): array;
}
