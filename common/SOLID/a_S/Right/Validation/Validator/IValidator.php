<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Validators interface
 * 
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Right\Validation\Validator;

/**
 * AValidator
 */
interface IValidator
{
    /**
     * validate
     * 
     * @param mixed $value Value to validate
     * 
     * @return string|void
     */
    public function validate($value);
}
