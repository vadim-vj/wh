<?php
/**
 * Pseudo-model (wrapper to work with DB)
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

/**
 * Model
 */
class Model
{
    /**
     * Save parsed data in DB
     *
     * @param array $data Data to save
     *
     * @return void
     */
    public function saveProduct(array $data)
    {
    }

    /**
     * Get products list (AJAX request)
     *
     * @param integer $start    Firts arg in LIMIT
     * @param integer $count    Second arg in LIMIT
     * @param string  $category Category and subcategory names
     * @param string  $sort     Sort field name
     * @param string  $sortDir  Sort direction
     *
     * @return array
     */
    public function getProducts($start, $count, $category, $sort, $sortDir)
    {
    }

    /**
     * Delete all products
     *
     * @return void
     */
    public function deleteAll()
    {
        \Application::getInstance()->getDB()->exec('TRUNCATE products');
    }
}
