<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
namespace Adapter;
use Adapter\_classes as Classes;
require_once dirname(__DIR__) . '/autoload.php';

function main(Classes\ITarget $pm): void {
    echo 'Payment method class: ' . $pm->getID() . EOL;
}

main(new Classes\PaymentTarget());
main(new PaymentAdapter(new Classes\PaymentAdaptee()));
