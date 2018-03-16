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
     * Value separator
     */
    const SEP = '; ';

    /**
     * Prepared select statement
     *
     * @var \PDOStatement
     */
    protected $select;

    /**
     * Save parsed data in DB
     *
     * @param array $data Data to save
     *
     * @return void
     */
    public function saveProduct(array $data)
    {
        $query = 'products SET ' . implode(', ', $this->implodeFields(array_keys($data)));

        if ($product = $this->getProductSelect($data)->fetch()) {
            $query = 'UPDATE ' . $query . ' WHERE id = :id';
            $data['id'] = $product['id'];

            // "Serialize" multiple values
            foreach (array('size', 'color', 'orient') as $field) {
                if (isset($data[$field]) && !empty($product[$field])) {
                    $product[$field] = explode(static::SEP, $product[$field]);
                    $product[$field][] = $data[$field];

                    $product[$field] = array_unique($product[$field]);
                    natsort($product[$field]);
                    $data[$field] = implode(static::SEP, $product[$field]);
                }
            }

        } else {
            $query = 'INSERT ' . $query;
        }

        \Application::getInstance()->getDB()->prepare($query)->execute($data);
    }

    /**
     * Get products list (AJAX request)
     *
     * @param integer $start   Firts arg in LIMIT
     * @param integer $count   Second arg in LIMIT
     * @param integer $catId   Category ID
     * @param string  $sort    Sort field name
     * @param string  $sortDir Sort direction
     *
     * @return array
     */
    public function getProducts($start, $count, $catId, $sort, $sortDir)
    {
        $result = $where = array();

        if (!empty($catId)) {
            $where['p.category_id'] = $catId;
        }
        $sortDir = 'DESC' === strtoupper($sortDir) ? 'DESC' : 'ASC';

        $query = 'FROM products AS p'
            . ' LEFT JOIN categories AS c ON p.category_id = c.id'
            . ' LEFT JOIN brands AS b ON p.brand_id = b.id'
            . (empty($where) ? '' : ' WHERE ' . implode(' AND ', $this->implodeFields(array_keys($where))))
            . ($this->isFieldAllowed($sort) ? ' ORDER BY ' . $sort . ' ' . $sortDir : '');

        if (!empty($where)) {
            $where = array_combine(array_map(array($this, 'sanitizeParam'), array_keys($where)), $where);
        }

        $statement = \Application::getInstance()->getDB()->prepare('SELECT COUNT(p.id) ' . $query);
        $statement->execute($where);

        if (0 < ($result['count'] = intval($statement->fetchColumn()))) {
            $statement = \Application::getInstance()->getDB()->prepare(
                'SELECT p.id, p.name name, p.model, b.name brand, p.article, p.size, p.color, p.orient'
                . ' ' .$query . ' LIMIT ' . $start . ', ' . $count
            );

            $statement->execute($where);
            $result['data'] = $statement->fetchAll();
        }

        return $result;
    }

    /**
     * Delete all products
     *
     * @return void
     */
    public function deleteAllProducts()
    {
        \Application::getInstance()->getDB()->exec('TRUNCATE products');
    }

    /**
     * Get categories list
     *
     * @return array
     */
    public function getCategories()
    {
        return \Application::getInstance()->getDB()->query(
            'SELECT sc.id, CONCAT_WS(" / ", c.name, sc.name) AS name, COUNT(p.id) AS count'
            . ' FROM categories AS sc LEFT JOIN categories AS c ON sc.parent_id = c.id'
            . ' LEFT JOIN products AS p ON sc.id = p.category_id GROUP BY sc.id ORDER BY name'
        )->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_UNIQUE);
    }

    /**
     * Get products total count
     *
     * @return integer
     */
    public function getProductsTotalCount()
    {
        return \Application::getInstance()->getDB()->query('SELECT COUNT(id) FROM products')->fetchColumn();
    }

    // {{{ Helpers

    /**
     * Find product by unique key - return prepared statement
     *
     * @param array $data Data to use for search
     *
     * @return \PDOStatement
     */
    protected function getProductSelect(array $data = null)
    {
        if (!isset($this->select)) {
            $this->select = \Application::getInstance()->getDB()->prepare(
                'SELECT * FROM products WHERE '. implode(' AND ', $this->implodeFields($this->getUniqueKeyFields()))
            );
        }

        if (isset($data)) {
            $this->select->execute($this->getUniqueKeyData($data));
        }

        return $this->select;
    }

    /**
     * Composite unique key
     *
     * @return array
     */
    protected function getUniqueKeyFields()
    {
        return array('name', 'model', 'article', 'category_id');
    }

    /**
     * Prepare data array by unique key fields
     *
     * @param array $data Data to prepare
     *
     * @return array
     */
    protected function getUniqueKeyData(array $data)
    {
        $result = array();

        foreach ($this->getUniqueKeyFields() as $field) {
            $result[$field] = isset($data[$field]) ? $data[$field] : '';
        }

        return $result;
    }

    /**
     * Helper for queries
     *
     * @param array $fields Fields to implode
     *
     * @return array
     */
    protected function implodeFields(array $fields)
    {
        $result = array();

        foreach ($fields as $field) {
            $result[] = $field . ' = :' . $this->sanitizeParam($field);
        }

        return $result;
    }

    /**
     * Check field name
     *
     * @param string $field Field name
     *
     * @return boolean
     */
    protected function isFieldAllowed($field)
    {
        return !empty($field)
            && in_array($field, array('p.id', 'p.name', 'p.model', 'b.name', 'p.article', 'p.size', 'p.color', 'p.orient'));
    }

    /**
     * Sanitize param
     *
     * @param string $param Param name to translate
     *
     * @return string
     */
    protected function sanitizeParam($param)
    {
        return strtr($param, '.', '_');
    }

    // }}}
}
