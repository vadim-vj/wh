<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace FactoryMethod\Common;
require_once dirname(dirname(__DIR__)) . '/autoload.php';

function main(Page\IPage $page): void {
    echo 'Page class: ' . get_class($page) . EOL;
    echo 'Header class: ' . get_class($page->getHeader()) . EOL;
    echo 'Header: ' . $page->getHeader()->getText() . EOL;
}

const T_ADMIN = 'Admin';
const T_CUSTOMER = 'Customer';
define('AREA_TYPE', mt_rand(0, 1) ? T_ADMIN : T_CUSTOMER);

switch (AREA_TYPE) {
    case T_ADMIN:
        $page = new Page\Admin();
        break;
    case T_CUSTOMER:
        $page = new Page\Customer();
        break;
    default:
        throw new \Exception();
}

main($page);
