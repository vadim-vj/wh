<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace Builder;
require_once dirname(__DIR__) . '/autoload.php';

// Director
function main(Builder\IBuilder $builder): void {
    $builder->build();

    foreach ((new Database())->getData() as $row) {
        $builder->processRow($row);
    }
}

const T_SQL = 'SQL';
const T_EXCEL = 'Excel';
define('DB_TYPE', mt_rand(0, 1) ? T_SQL : T_EXCEL);

$class = 'Builder\Builder\\' . DB_TYPE;
main($builder = new $class());

switch (DB_TYPE) {
    case T_SQL:
        var_dump($builder->getDump());
        break;
    case T_EXCEL:
        var_dump($builder->getDocument());
        break;
}
