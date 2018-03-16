<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\_classes\Connection;

abstract class AConnection implements IConnection
{
    public function connect(): \resource {
        // ...
    }
}
