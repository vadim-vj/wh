<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace Singleton;
require_once dirname(__DIR__) . '/autoload.php';

function main(): void {
    echo 'Singleton class: ' . get_class(Session::getInstance()) . EOL;
    echo 'Singleton class: ' . get_class(Session::getInstance('#test')) . EOL;
}

main();
