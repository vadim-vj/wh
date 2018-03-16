<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Common definitions
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

error_reporting(E_ALL);
ini_set('display_errors', true);

define('DS',           DIRECTORY_SEPARATOR);
define('IS_CLI',       ('cli' === strtolower(PHP_SAPI)));
define('EOL',          IS_CLI ? "\n" : '<br />');
define('BASE_DIR',     rtrim(__DIR__, DS) . DS);
define('RELATIVE_URL', '/' . str_replace(DS, '/', getRelativeDirPath()));
define('LOCAL_URL',    '/' . basename(BASE_DIR) . RELATIVE_URL);
define('GITHUB_URL',   'https://github.com/vadim-vj/common/tree/master' . RELATIVE_URL);

/**
 * getFileByClassName
 * 
 * @param string $class Class name
 * 
 * @return string
 */
function getFileByClassName($class) {
    return str_replace('\\', DS, ltrim($class, '\\')) . '.php';
}

/**
 * getRelativeDirPath
 * 
 * @param string $dir Directory name OPTIONAL
 * 
 * @return string
 */
function getRelativeDirPath($dir = null) {
    return preg_replace('/^' . preg_quote(BASE_DIR, '/') . '/Si', '', $dir ?: getcwd());
}

spl_autoload_register(function ($class) {
    require_once BASE_DIR . getFileByClassName($class);
});
