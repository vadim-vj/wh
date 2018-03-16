<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace FactoryMethod\NameConvParam;
use FactoryMethod\_classes as Classes;

class Page implements IPage
{
    protected $type;

    public function __construct(string $type) {
        $this->type = $type;
    }

    public function getHeader(): Classes\IHeader {
        $class = 'FactoryMethod\_classes\\' . $this->type;

        return new $class();
    }
}
