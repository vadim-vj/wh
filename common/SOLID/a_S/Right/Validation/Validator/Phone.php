<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Phone validator
 * 
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Right\Validation\Validator;

/**
 * Phone
 */
class Phone implements \SOLID\a_S\Right\Validation\Validator\IValidator
{
    /**
     * validate
     * 
     * @param string $value Value to validate
     * 
     * @return string|void
     */
    public function validate($value)
    {
        return preg_match('/^[\d\s-\(\)]+$/Si', $value) ? null : 'Wrong format';
    }
}
