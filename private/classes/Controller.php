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
        @unlink($this->importPaths['csv']);
        $this->redirect();
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

        } elseif (false === ($file = @fopen($this->importPaths['log'], 'w'))) {
            throw new \Exception('Failed to truncate import log file');
        }

        fclose($file);
        $this->redirect(array(\Application::ACTION => 'import'));
    }

    /**
     * Get products list
     *
     * @return void
     */
    public function doActionGetProducts()
    {
    }

    /**
     * Delete all products
     *
     * @return void
     */
    public function doActionDeleteAllProducts()
    {
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
