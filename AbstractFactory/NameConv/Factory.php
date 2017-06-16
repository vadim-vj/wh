<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\NameConv;
use AbstractFactory\_classes as Classes;

class Factory implements IAbstractFactory
{
    protected $type;

    public function __construct(string $type) {
        $this->type = $type;
    }

    public function create(string $name): Classes\IBase {
        $class = 'AbstractFactory\_classes\\' . $name . '\\' . $this->type;

        return new $class();
    }
}
