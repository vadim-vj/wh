<?php
/**
 * Endpoint
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

define('DS', DIRECTORY_SEPARATOR);
define('DIR_PUBLIC',   __DIR__ . DS . 'public');
define('DIR_PRIVATE',  __DIR__ . DS . 'private');

spl_autoload_register(function ($class) {
    require_once DIR_PRIVATE . DS . 'classes' . DS . str_replace('\\', DS, ltrim($class, '\\')) . '.php';
});

\Application::getInstance()->run();
