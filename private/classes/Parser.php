<?php
/**
 * Parser with dictionaries
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

/**
 * Parser
 */
class Parser
{
    /**
     * List of patterns
     *
     * @var array
     */
    protected $patterns;

    /**
     * List of brands
     *
     * @var array
     */
    protected $brands;

    /**
     * List of categories
     *
     * @var array
     */
    protected $categories;

    /**
     * Colors
     *
     * @var array
     */
    protected $colors = array(
        'крас(?:н(?:ый|ая|ое|ые)?)?', 'син(?:ий|яя|ее|ие)?', 'бел(?:ый|ая|ое|ые)?',
        'зел(?:ен(?:ый|ая|ое|ые)?)?', 'сер(?:ый|ая|ое|ые)?', 'чер(?:н(?:ый|ая|ое|ые)?)?',
        'жел(?:т(?:ый|ая|ое|ые)?)?', 'оранж(?:ев(?:ый|ая|ое|ые)?)?', 'золот(?:ой|ая|ое|ые)?',
        'хром',
    );

    /**
     * Sizes
     *
     * @var array
     */
    protected $sizes = array(
        '\d{1,3}(?:(?:,|\.)\d{1,2})?', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL',
    );

    /**
     * Parse line from .csv file
     *
     * @param string $line Line to parse
     *
     * @return array
     */
    public function parseLine($line)
    {
        $result = array('name' => '');

        // Remove enclosing quotes
        $line = preg_replace('/^\s*([\'"])\s*(.+)\s*\1\s*$/Su', '\2', $line);

        // Here we reduce line, one by one pattern, and fulfill the result
        foreach (array_filter($this->getPatterns()) as $name => $patterns) {

            $line = preg_replace_callback(
                $patterns,
                function (array $matches) use ($name, &$result) {

                    // Search for non-empty value with non-numeric key (category/brand ID)
                    // I.e. we search for first matched named group
                    if (in_array($name, array('brand', 'category'))) {
                        $data = array_filter(array_keys(array_filter($matches)), 'is_string');
                        $key  = array_shift($data);

                        // Last value in the "matches" array is a product name
                        if ('category' === $name) {
                            $result['name'] = array_pop($matches);
                            $matches[1] = str_replace($result['name'], '', $matches[$key]);

                        } else {
                            $matches[1] = '';
                        }

                        // Key of the found named group is a brand/category ID, needed to join SQL tables
                        $matches[2] = ltrim($key, '_');
                    }

                    // Assign found value
                    $result[$name] = $matches[2];

                    return $matches[1];
                },
                $line,
                1
            );
        }
        $result['model'] = $line;

        // Remove extra spaces and other non-alphabetical symbols
        $result = preg_replace('/\s+/Su', ' ', array_map(function ($val) { return trim($val, ' .-'); }, $result));

        $result['model'] = $this->ucfirst($result['model']);
        $result['name']  = $this->ucfirst($result['name'], true);

        return $result;
    }

    /**
     * Return patterns list
     *
     * @return array
     */
    protected function getPatterns()
    {
        if (!isset($this->patterns)) {
            // Definition order is important
            $this->patterns = array_fill_keys(
                array('article', 'brand', 'orient', 'size', 'color', 'category'),
                array()
            );

            // Article. Format: " ... (42345677)", "... <brand> H378456699 ...", " .... K45789960" etc.
            $article = '\b([A-Z]?\d{3,9}[A-Z]?)\b';
            $this->patterns['article'][] = '/()\(\s*' . $article . '\s*\)?\s*$/Sui';
            if ($this->getBrands()) {
                $this->patterns['article'][] = '/\b(' . implode('|', $this->getBrands()) . ')\b'
                    . '\s*(?:\(\s*)?' .  $article . '(?:\s*\))?/Sui';
            }

            // Brand. Format: name from the list
            // Here we use named groups ("(?<_ID>name)") to pass ID to the preg_replace_callback()
            if ($this->getBrands()) {
                foreach ($this->getBrands() as $id => $pattern) {
                    $this->patterns['brand'][] = '/\b(?<_' . $id . '>' . $pattern . ')\b/Sui';
                }
            }

            // Stick orientation. Format: {L|R} at the end
            $this->patterns['orient'][] = '/(.*(?:клюшк|ловушк|блокер|блин).*)(?:-\s*|\s+)(L|R)\s*$/Sui';

            // Size. Format: "... - XL", "... - 160", "... - S=120", "... - 6.5 (D)", "... 40"", ..." etc.
            $size = '(?:' . implode('|', $this->sizes) . ')';
            $this->patterns['size'][] = '/(.*коньки.*)(?:-\s*|\s+)(' . $this->sizes[0]
                . '(?:\s*(\()?[A-Z]{1,2}(?(3)\)))?)\s*$/Sui';
            $this->patterns['size'][] = '/(\s)?(?(1)|-\s+)(' . $size . '(?:\s*=\s*' . $size . ')?)\s*$/Sui';
            $this->patterns['size'][] = '/(\s)?(?(1)|-\s+)(\d{1,3}\s*(?:см|"")?)\s*$/Sui';

            // Color. Format (word roots, points, hyphens and slashes): "красн/син", "т.синее", "темно-синяя" etc.
            $this->patterns['color'][] = '/(\(?\s*)?\b([а-я\/\-\.]*\b(?:' . implode('|', $this->colors) . ')\b'
                . '[а-я\/\-\.]*)\b\s*\)?/Sui';

            // Category and name. Format: pattern from the list
            // Here we use named groups ("(?<_ID>name)") to pass ID to the preg_replace_callback()
            foreach ($this->getCategories() as $id => $pattern) {
                $this->patterns['category'][] = '/\b(?<_' . $id . '>' . $pattern . ')\b/Sui';
            }
        }

        return $this->patterns;
    }

    /**
     * Return brands list
     *
     * @return array
     */
    protected function getBrands()
    {
        if (!isset($this->brands)) {
            $this->brands = \Application::getInstance()->getDB()->query(
                'SELECT id, IFNULL(pattern, REPLACE(REPLACE(name, "/", "\/"), "|", "\|")) FROM brands'
            )->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_COLUMN | \PDO::FETCH_UNIQUE);
        }

        return $this->brands;
    }

    /**
     * Return categories list
     *
     * @return array
     */
    protected function getCategories()
    {
        if (!isset($this->categories)) {
            $this->categories = \Application::getInstance()->getDB()->query(
                'SELECT id, pattern FROM categories WHERE pattern IS NOT NULL'
                . ' ORDER BY CASE WHEN parent_id = 0 THEN 0 ELSE 1 END DESC'
            )->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_COLUMN | \PDO::FETCH_UNIQUE);
        }

        return $this->categories;
    }

    /**
     * ucfirst() for Unicode
     *
     * @param string  $string     String to capitalize
     * @param boolean $allToLower Flag; convert all letter to lowercase or not
     *
     * @return string
     */
    protected function ucfirst($string, $allToLower = false)
    {
        $enc = 'UTF-8';

        if ($allToLower) {
            $string = mb_strtolower($string, $enc);
        }

        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc)
            . mb_substr($string, 1, mb_strlen($string, $enc) - 1, $enc);
    }
}
