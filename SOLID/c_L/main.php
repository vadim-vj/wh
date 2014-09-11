<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Usage example
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

require_once '../../top.inc.php';

/**
 * getExceptionMessage
 *
 * @param \Exception $ex Exception object
 *
 * @return string
 */
function getExceptionMessage(\Exception $ex)
{
    return 'Exception of "' . get_class($ex) . '" catched (message: "' . $ex->getMessage() . '")' . EOL;
}

/**
 * test
 *
 * @param \SOLID\c_L\Classes\Base $obj Class instance
 *
 * @return void
 */
function test(\SOLID\c_L\Classes\Base $obj)
{
    try {
        $obj->example(rand(), rand(), rand());

    } catch (\LogicException $ex) {
        echo ('RIGHT: ' . getExceptionMessage($ex));
    }
}

foreach (array('Wrong1', 'Wrong2', 'Right') as $class) {
    $class = '\SOLID\c_L\Classes\\' . $class;

    try {
        test(new $class());

    } catch (\Exception $ex) {
        echo ('WRONG: ' . getExceptionMessage($ex));
    }
}

require_once BASE_DIR . 'footer.php';
