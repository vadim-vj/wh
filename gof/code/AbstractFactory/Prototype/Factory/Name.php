<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace AbstractFactory\Prototype\Factory;
use AbstractFactory\_classes as Classes;
use AbstractFactory\Prototype as Main;

class Name implements IAbstractFactory
{
    protected $dict = [];

    public function __construct(string $type) {
        switch ($type) {
            case Main\T_MYSQL:
                $this->register(Main\C_CONNECTION, 'AbstractFactory\_classes\Connection\MySQL');
                $this->register(Main\C_DATABASE, 'AbstractFactory\_classes\Database\MySQL');
                break;
            case Main\T_POSTGRESQL:
                $this->register(Main\C_CONNECTION, 'AbstractFactory\_classes\Connection\PostgreSQL');
                $this->register(Main\C_DATABASE, 'AbstractFactory\_classes\Database\PostgreSQL');
                break;
        }
    }

    public function register(string $id, string $name): void {
        $this->dict[$id] = $name;
    }

    public function create(string $id): Classes\IBase {
        return new $this->dict[$id]();
    }
}
