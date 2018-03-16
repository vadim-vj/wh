<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Email validator
 * 
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Right\Validation\Validator;

/**
 * Email
 */
class Email implements \SOLID\a_S\Right\Validation\Validator\IValidator
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
        return preg_match('/^[\w\.-]+@[\w\.-]+$/Si', $value) ? null : 'Wrong format';
    }
}
