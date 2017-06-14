<?
/*
 * autoload.php
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

spl_autoload_register(function ($name) {
  require_once __DIR__ . '/' . str_replace('\\', '/', ltrim($name, '\\')) . '.php';
});
