<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace FactoryMethod\NameConvParam;
require_once dirname(dirname(__DIR__)) . '/autoload.php';

function main(IPage $page): void {
    echo 'Header class: ' . get_class($page->getHeader()) . EOL;
    echo 'Header: ' . $page->getHeader()->getText() . EOL;
}

const T_ADMIN = 'Admin';
const T_CUSTOMER = 'Customer';
define('AREA_TYPE', mt_rand(0, 1) ? T_ADMIN : T_CUSTOMER);

main(new Page(AREA_TYPE));
