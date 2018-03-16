<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Common validator
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Wrong\Validation;

/**
 * Profile
 */
class Profile extends \SOLID\a_S\Wrong\ORM\Entity
{
    /**
     * phone
     *
     * @var string
     */
    protected $phone;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    // {{{ Phone validator(s)

    /**
     * validatePhone
     *
     * @param string $phone Phone to validate
     *
     * @return string|void
     */
    public function validatePhone($phone)
    {
        return preg_match('/^[\d\s-\(\)]+$/Si', $phone) ? null : 'Wrong format';
    }

    // }}}

    // {{{ Email validator(s)

    /**
     * validateEmail
     *
     * @param string $email Email to validate
     *
     * @return string|void
     */
    public function validateEmail($email)
    {
        return preg_match('/^[\w\.-]+@[\w\.-]+$/Si', $email) ? null : 'Wrong format';
    }

    // }}}
}
