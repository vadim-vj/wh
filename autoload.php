<?
/*
 * autoload.php
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);

spl_autoload_register(function (string $name): void {
  require_once __DIR__ . '/' . str_replace('\\', '/', ltrim($name, '\\')) . '.php';
});
