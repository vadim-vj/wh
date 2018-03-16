<?php
/**
 * Application singleton
 *
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */

/**
 * Application
 */
final class Application
{
    /**
     * For debug
     */
    const DEV_MODE = true;

    /**
     * Request param names
     */
    const ACTION = 'action';

    /**
     * Application object itself
     *
     * @var \Application
     */
    protected static $instance;

    /**
     * PDO database object
     *
     * @var \PDO
     */
    protected $db;

    /**
     * Get instance
     *
     * @return \Application
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Process request
     *
     * @throws \Exception
     * @return void
     */
    public function run()
    {
        if (isset($_REQUEST[static::ACTION])) {
            $action  = $_REQUEST[static::ACTION];
            // "Camelize" action name, e.g "perform_some" => "PerformSome"
            // It's not allowed to use several underscores, or use it at the start or end of string
            $handler = str_replace(' ', '', ucwords(preg_replace('/([a-z])_([a-z])/', '\1 \2', $action)));

        } else {
            $action  = '';
            $handler = 'Default';
        }

        try {
            if (!method_exists($controller = new \Controller(), $handler = 'doAction' . $handler)) {
                throw new \Exception('Unknown action "' . $action . '"');
            }

            $controller->$handler();

        } catch (\Exception $exception) {
            if (static::DEV_MODE) {
                throw $exception;

            } else {
                echo $exception->getMessage();
            }
        }
    }

    /**
     * Return PDO database object
     *
     * @throws \PDOException
     * @return \PDO
     */
    public function getDB()
    {
        if (!isset($this->db)) {
            $config = require_once DIR_PRIVATE . DS . 'database' . DS . 'config.php';
            $dsn = 'mysql:dbname=' . $config['dbname'];

            foreach (array('host', 'port', 'unix_socket') as $param) {
                if (!empty($config[$param])) {
                    $dsn .= ';' . $param . '=' . $config[$param];
                }
            }

            $this->db = new \PDO(
                $dsn . ';charset=utf8',
                $config['user'],
                $config['pass'],
                array(
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_AUTOCOMMIT         => false,
                )
            );
            $this->db->exec('SET NAMES "utf8"');
        }

        return $this->db;
    }

    /**
     * It's not possible to instantiate this class using "new" operator, only via ::getInstance() method
     *
     * @return void
     */
    protected function __construct()
    {
    }

    /**
     * Cloning is forbidden too
     *
     * @return void
     */
    protected function __clone()
    {
    }
}
