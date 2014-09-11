<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Example of "Entity/Repository" pattern
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

namespace SOLID\a_S\Right\ORM;

/**
 * Repository
 */
class Repository
{
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
     * @param \SOLID\a_S\Right\ORM\Entity $entity Entity to operate
     * 
     * @return integer
     */
    public function insert(\SOLID\a_S\Right\ORM\Entity $entity)
    {
        // ...
    }

    /**
     * update
     *
     * @param \SOLID\a_S\Right\ORM\Entity $entity Entity to operate
     * 
     * @return boolean
     */
    public function update(\SOLID\a_S\Right\ORM\Entity $entity)
    {
        // ...
    }

    /**
     * remove
     * 
     * @param \SOLID\a_S\Right\ORM\Entity $entity Entity to operate
     * 
     * @return boolean
     */
    public function remove(\SOLID\a_S\Right\ORM\Entity $entity)
    {
        // ...
    }
}
