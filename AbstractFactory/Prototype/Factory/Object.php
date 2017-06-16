<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\Prototype\Factory;
use AbstractFactory\_classes as Classes;
use AbstractFactory\Prototype as Main;

class Object implements IAbstractFactory
{
    protected $dict = [];

    public function __construct(string $type) {
        switch ($type) {
            case Main\T_MYSQL:
                $this->register(Main\C_CONNECTION, new Classes\Connection\MySQL());
                $this->register(Main\C_DATABASE, new Classes\Database\MySQL());
                break;
            case Main\T_POSTGRESQL:
                $this->register(Main\C_CONNECTION, new Classes\Connection\PostgreSQL());
                $this->register(Main\C_DATABASE, new Classes\Database\PostgreSQL());
                break;
        }
    }

    public function register(string $id, Classes\IBase $object): void {
        $this->dict[$id] = $object;
    }

    public function create(string $id): Classes\IBase {
        return clone $this->dict[$id];
    }
}
