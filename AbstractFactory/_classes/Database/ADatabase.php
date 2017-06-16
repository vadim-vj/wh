<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\_classes\Database;

abstract class ADatabase implements IDatabase
{
    public function exec(): array {
        // ...
    }
}
