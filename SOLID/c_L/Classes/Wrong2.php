<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Wrong example 2
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\c_L\Classes;

/**
 * Wrong2
 */
class Wrong2 extends Base
{
    /**
     * example
     *
     * @param mixed $arg1 Param 1
     * @param mixed $arg2 Param 2
     * @param mixed $arg3 Param 3
     * @param mixed $arg3 Param 4
     *
     * @throws \Exception
     * @return void
     */
    /* protected */ public function example($arg1, $arg2, $arg3, $arg4)
    {
        throw new \Exception('Some text in "Wrong2" class');
    }
}
