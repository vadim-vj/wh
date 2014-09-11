<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Example of "ActiveRecord" pattern
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Wrong\ORM;

/**
 * Entity
 */
class Entity
{
    /**
     * Prefixes for getter/setter methods
     */
    const GET = 'get';
    const SET = 'set';

    // {{{ Properties

    /**
     * id
     *
     * @var integer
     */
    protected $id;

    /**
     * propertyA
     *
     * @var string
     */
    protected $propertyA = 'Test value';

    /**
     * propertyB
     *
     * @var integer
     */
    protected $propertyB = 123;

    // }}}

    // {{{ Constructor and getter/setter

    /**
     * __construct
     *
     * @param integer $id DB record primary key
     *
     * @return void
     */
    public function __construct($id = null)
    {
        if (!empty($id)) {
            // ...
        }
    }

    /**
     * Getters/setters
     *
     * @param string $name Called method name
     * @param array  $args Passed parameters
     *
     * @throws \BadMethodCallException
     * @return mixed
     */
    public function __call($name, array $args = array())
    {
        $result = null;

        if (preg_match('/^(' . static::GET . '|' . static::SET . ')(\w+)$/Si', $name, $matches)) {
            $name = lcfirst($matches[2]);

            if (property_exists($this, $name)) {
                if (static::GET === $matches[1]) {
                    $result = $this->$name;

                } elseif (!empty($args)) {
                    $this->$name = array_shift($args);
                    $resul = $this;

                } else {
                    throw new \BadMethodCallException('Argument not passed');
                }
            } else {
                throw new \BadMethodCallException('Property "' . $name . '" doesn\'t exist');
            }
        } else {
            throw new \BadMethodCallException('Invalid method name: "' . get_class($this) . '::' . $name . '"');
        }

        return $result;
    }

    /**
     * map
     *
     * @param array $data Values array
     *
     * @return void
     */
    public function map(array $data)
    {
        foreach ($data as $name => $value) {
            $this->{'set' . ucfirst($name)}($value);
        }
    }

    // }}}

    // {{{ Database routines

    /**
     * find
     *
     * @param integer $id DB record primary key
     *
     * @return self|void
     */
    public function find($id)
    {
        // ...
    }

    /**
     * findAll
     *
     * @return array
     */
    public function findAll()
    {
        // ...
    }

    /**
     * insert
     *
     * @return integer
     */
    public function insert()
    {
        // ...
    }

    /**
     * update
     *
     * @return boolean
     */
    public function update()
    {
        // ...
    }

    /**
     * remove
     *
     * @return boolean
     */
    public function remove()
    {
        // ...
    }

    // }}}
}
