<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Right example
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\c_L\Classes;

/**
 * Right
 */
class Right extends Base
{
    /**
     * example
     *
     * @param mixed $arg1 Param 1
     * @param mixed $arg2 Param 2
     * @param mixed $arg3 Param 3
     * @param array $arg3 Param 4 OPTIONAL
     *
     * @throws \BadMethodCallException
     * @return void
     */
    public function example($arg1, $arg2, $arg3, $arg4 = array())
    {
        throw new \BadMethodCallException('Some text');
    }
}
