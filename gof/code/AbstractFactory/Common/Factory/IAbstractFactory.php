<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\Common\Factory;
use AbstractFactory\_classes\{Connection, Database};

interface IAbstractFactory
{
    public function createConnection(): Connection\IConnection;
    public function createDatabase(): Database\IDatabase;
}
