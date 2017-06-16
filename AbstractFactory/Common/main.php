<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace AbstractFactory\Common;
require_once dirname(dirname(__DIR__)) . '/autoload.php';

function main(Factory\IAbstractFactory $factory): void {
    $connection = $factory->createConnection();
    echo 'Connection class: ' . get_class($connection) . EOL;

    $database = $factory->createDatabase();
    echo 'Database class: ' . get_class($database) . EOL;
}

const T_MYSQL = 'MySQL';
const T_POSTGRESQL = 'PostgreSQL';
define('DB_TYPE', mt_rand(0, 1) ? T_MYSQL : T_POSTGRESQL);

switch (DB_TYPE) {
    case T_MYSQL:
        $factory = new Factory\MySQL();
        break;
    case T_POSTGRESQL:
        $factory = new Factory\PostgreSQL();
        break;
    default:
        throw new \Exception();
}

main($factory);
