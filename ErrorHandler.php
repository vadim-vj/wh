<?php
/**
 * PHP version 7.1
 *
 * Error handling (debug)
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
declare(strict_types=1);
// Report all PHP errors (from v5.4)
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * ErrorHandler
 */
abstract class ErrorHandler
{
    /**
     * Error handler
     *
     * @param string $errno      Level of the error raised
     * @param string $errstr     Error message
     * @param string $errfile    (Optional) Filename that the error was raised in
     * @param int    $errline    (Optional) Line number the error was raised at
     * @param array  $errcontext (Optional) Aray of every variable in the scope the error was triggered in
     *
     * @return bool If the function returns FALSE then the normal error handler continues
     */
    public static function handleError(
        string $errno,
        string $errstr,
        string $errfile = '',
        int $errline = 0,
        array $errcontext = []
    ): bool {
        $result = error_reporting() & $errno;

        // This error code is included in error_reporting
        if ($result) {
            switch ($errno) {
            case E_USER_ERROR:
                break;

            case E_USER_WARNING:
                break;

            case E_USER_NOTICE:
                break;

            default:
                break;
            }
        }

        return $result;
    }

    /**
     * Handle exception
     *
     * @param \Exception|\Throwable $exception (Optional) Exception object (\Throwable since PHP7.0)
     *
     * @return void
     */
    public static function handleException(\Exception $exception = null): void
    {
        echo 'Uncaught exception: ' . $exception->getMessage();
    }
}

/**
 * Returns a string containing the previously defined error handler (if any).
 * If the built-in error handler is used NULL is returned.
 * NULL is also returned in case of an error such as an invalid callback.
 * If the previous error handler was a class method,
 * this function will return an indexed array with the class and the method name
 */
set_error_handler(['\ErrorHandler', 'handleError']);

/**
 * Always returns TRUE
 */
restore_error_handler();

/**
 * Returns the name of the previously defined exception handler, or NULL on error.
 * If no previous handler was defined, NULL is also returned
 */
set_exception_handler(['\ErrorHandler', 'handleException']);

/**
 * Always returns TRUE
 */
restore_exception_handler();

/**
 * NULL or Array
 * (
 *  [type] => 8
 *  [message] => Undefined variable: a
 *  [file] => C:\WWW\index.php
 *  [line] => 2
 * )
 */
var_dump(error_get_last());
