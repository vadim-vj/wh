<?php
/**
 * Controller class
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

/**
 * Controller
 */
class Controller
{
    /**
     * Number of lines in .csv file processed per one iteration
     */
    const LINES_PER_ITERATION = 800;

    /**
     * Import paths
     *
     * @var array
     */
    protected $importPaths = array();

    // {{{ Action handlers

    /**
     * Display page
     *
     * @return void
     */
    public function doActionDefault()
    {
        require_once DIR_PRIVATE . DS . 'template.php';
    }

    /**
     * Import products
     *
     * @throws \Exception
     * @throws \RuntimeException
     * @throws \LogicException
     * @return void
     */
    public function doActionImport()
    {
        // Number of current iteration
        $page = isset($_REQUEST['page']) ? max(0, intval($_REQUEST['page'])) : 0;

        $file = new \SplFileObject($this->importPaths['csv'], 'r');
        $file->setFlags(\SplFileObject::DROP_NEW_LINE | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);
        $file->seek(static::LINES_PER_ITERATION * $page);

        if (false === ($log = @fopen($this->importPaths['log'], 'a'))) {
            throw new \Exception('Failed to open import log file for writing');
        }
        $count = 0;

        try {
            $parser = new \Parser();
            $model  = new \Model();

            $transaction = \Application::getInstance()->getDB()->beginTransaction();

            while ($file->valid() && static::LINES_PER_ITERATION >= ++$count) {
                $data = $parser->parseLine($line = $file->current());

                if (empty($data['name']) || empty($data['category'])) {
                    fwrite($log, '[' . ($file->key() + 1) . ']: ' . $line . PHP_EOL);

                } else {
                    $model->saveProduct($data);
                }

                $file->next();
            }

            fclose($log);

            if (!empty($transaction)) {
                \Application::getInstance()->getDB()->commit();
            }

        } catch (\Exception $exception) {
            @fclose($log);

            if (!empty($transaction)) {
                \Application::getInstance()->getDB()->rollback();
            }

            throw $exception;
        }

        if ($file->valid()) {
            $this->redirect(array(\Application::ACTION => 'import', 'page' => $page + 1));

        } else {
            header('Content-Type: text/html; charset=utf-8');

            if ($text = file_get_contents($this->importPaths['log'])) {
                echo '<b>Not recognized name or category</b>: <br />';
                echo str_replace(PHP_EOL, '<br />', $text) . '<br />';
            }

            echo 'Done. Processed: ' . $file->key() . ' records.<br />';

            // It's not possible to remove file before the \SplFileObject::__destruct() is called
            // See http://php.net/manual/en/class.splfileobject.php#113149
            unset($file);
            @unlink($this->importPaths['csv']);

            $this->redirect(null, false, 'Return');
        }
    }

    /**
     * Upload text/csv file
     *
     * @throws \Exception
     * @return void
     */
    public function doActionUploadFile()
    {
        if (empty($_FILES['inputfile'])) {
            throw new \Exception('Unable to upload file');

        } elseif (!empty($_FILES['inputfile']['error'])) {
            throw new \Exception('Upload error; code ' . $_FILES['inputfile']['error']);

        } elseif (!in_array($_FILES['inputfile']['type'], $this->getAllowedFileTypes())) {
            throw new \Exception('Wrong file type ("' . $_FILES['inputfile']['type'] . '")');

        } elseif (!is_writable($this->importPaths['dir'])) {
            throw new \Exception('Import directory ("private/import") is not writable for web server');

        } elseif (!move_uploaded_file($_FILES['inputfile']['tmp_name'], $this->importPaths['csv'])) {
            throw new \Exception('Unable to save temporary .csv file');

        } elseif (false === ($log = @fopen($this->importPaths['log'], 'w'))) {
            throw new \Exception('Failed to truncate import log file');
        }

        fclose($log);
        $this->redirect(array(\Application::ACTION => 'import'));
    }

    /**
     * Get products list
     *
     * @return void
     */
    public function doActionGetProducts()
    {
        $params = array(
            'start' => 10 * (isset($_REQUEST['page']) ? max(0, intval($_REQUEST['page'])) : 0),
            'count' => 10,
        );

        foreach (array('category', 'sort', 'sort_dir') as $name) {
            $params[$name] = isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
        }

        header('Content-Type: application/json;');
        echo json_encode(call_user_func_array(array(new \Model(), 'getProducts'), $params));
    }

    /**
     * Delete all products
     *
     * @return void
     */
    public function doActionDeleteAllProducts()
    {
        $model = new \Model();
        $model->deleteAllProducts();

        $this->redirect();
    }

    // }}}

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->importPaths['dir'] = DIR_PRIVATE . DS . 'import';
        $this->importPaths['csv'] = $this->importPaths['dir'] . DS . 'current.csv';
        $this->importPaths['log'] = $this->importPaths['dir'] . DS . 'log.txt';
    }

    /**
     * Redirect
     *
     * @param array   $params  Query params
     * @param boolean $auto    Flag to auto-redirect
     * @param mixed   $message Message to print
     *
     * @return void
     */
    protected function redirect(array $params = null, $auto = true, $message = null)
    {
        $url = 'index.php' . ($params ? '?' . http_build_query($params) : '');

        if ($auto) {
            header('Location: ' . $url);

        } else {
            echo '<a href="' . $url . '">' . ($message ?: 'Next') . ' &gt;&gt;&gt;</a>';
        }
    }

    /**
     * List of allowed file types
     *
     * @return array
     */
    protected function getAllowedFileTypes()
    {
        return array('text/plain', 'text/csv');
    }
}
