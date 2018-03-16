<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace AbstractFactory\NameConv;
require_once dirname(dirname(__DIR__)) . '/autoload.php';

const C_CONNECTION = 'Connection';
const C_DATABASE = 'Database';

function main(IAbstractFactory $factory): void {
    $connection = $factory->create(C_CONNECTION);
    echo 'Connection class: ' . get_class($connection) . EOL;

    $database = $factory->create(C_DATABASE);
    echo 'Database class: ' . get_class($database) . EOL;
}

const T_MYSQL = 'MySQL';
const T_POSTGRESQL = 'PostgreSQL';
define('DB_TYPE', mt_rand(0, 1) ? T_MYSQL : T_POSTGRESQL);

main(new Factory(DB_TYPE));
