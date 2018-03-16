<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Base class
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\c_L\Classes;

/**
 * Base
 */
abstract class Base
{
    /**
     * example
     *
     * @param mixed $arg1 Param 1
     * @param mixed $arg2 Param 2
     * @param mixed $arg3 Param 3
     *
     * @throws \LogicException
     * @return void
     */
    public function example($arg1, $arg2, $arg3)
    {
        throw new \LogicException('Some text');
    }
}
