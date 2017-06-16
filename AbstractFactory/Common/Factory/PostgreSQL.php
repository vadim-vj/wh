<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\Common\Factory;
use AbstractFactory\_classes\{Connection, Database};

class PostgreSQL implements IAbstractFactory
{
    public function createConnection(): Connection\IConnection {
        return new Connection\PostgreSQL();
    }

    public function createDatabase(): Database\IDatabase{
        return new Database\PostgreSQL();
    }
}
