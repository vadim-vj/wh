<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Wrong example 1
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\c_L\Classes;

/**
 * Wrong1
 */
class Wrong1 extends Base
{
    /**
     * example
     *
     * @param mixed $arg1 Param 1
     * @param mixed $arg2 Param 2
     *
     * @throws \Exception
     * @return void
     */
    public function example($arg1, $arg2)
    {
        throw new \Exception('Some text in "Wrong1" class');
    }
}
