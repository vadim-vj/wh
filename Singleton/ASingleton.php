<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Singleton;

abstract class ASingleton implements ISingleton
{
    protected static $instances = [];

    protected function __construct() {
        // ...
    }

    protected function __clone() {
        throw new \Exception();
    }

    protected function __sleep() {
        throw new \Exception();
    }

    protected function __wakeup() {
        throw new \Exception();
    }

    public static function getInstance(string $id = self::DEFAULT): ISingleton {
        if (!isset(static::$instances[static::class])) {
            static::$instances[static::class] = [];
        }

        if (!isset(static::$instances[static::class][$id])) {
            static::$instances[static::class][$id] = new static();
        }

        return static::$instances[static::class][$id];
    }
}
