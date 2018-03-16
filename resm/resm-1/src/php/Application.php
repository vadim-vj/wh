<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Application singleton
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com> 
 * @version $id$
 * @link    ____link____
 */

namespace Resm;

/**
 * Application
 */
class Application
{
    /**
     * Block names in resources' structure
     */
    const API_BLOCK_ALLOC   = 'allocated';
    const API_BLOCK_DEALLOC = 'deallocated';

    /**
     * Config var names
     */
    const NAME_SECTION_MAIN = 'Main';
    const NAME_ADDRESS   = 'address';
    const NAME_PORT      = 'port';
    const NAME_RES_COUNT = 'res_count';
    const NAME_RES_PREF  = 'res_prefix';
    const NAME_TEST_MODE = 'test_mode';

    /**
     * Pattern to parse first line of HTTP/1.1 header.
     * See also http://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html#sec5.1
     */
    const PATTERN = '/^\s*GET\s+\/?(allocate\/[\w\.\-]+|deallocate\/\w+\d+|list(?:\/[\w\.\-]+)?|reset)\/?(?:\s+|$)/Si';

    /**
     * Newline
     */
    const EOL = PHP_EOL;

    /**
     * instance
     *
     * @var self
     */
    protected static $instance;

    /**
     * config
     *
     * @var array
     */
    protected $config = array();

    /**
     * server
     *
     * @var resource
     */
    protected $server;

    /**
     * resources
     *
     * @var array
     */
    protected $resources = array();

    /**
     * getInstance
     *
     * @param string $configFile Path to resm.conf
     *
     * @return self
     */
    public static function getInstance($configFile = null)
    {
        if (!isset(static::$instance)) {
            $class = get_called_class();
            static::$instance = new $class();
        }

        if (isset($configFile)) {
            $configFile = realpath($configFile);

            if (!empty($configFile) && is_readable($configFile)) {
                static::$instance->init($configFile);

            } else {
                throw new \Exception('Config file "' . $configFile . '" not exists or not readable');
            }
        }

        return static::$instance;
    }

    /**
     * processRequest
     *
     * @param string  $request     HTTP GET request header
     * @param boolean $addTestInfo For testing
     *
     * @return string
     */
    public function processRequest($request, $addTestInfo = false)
    {
        list($status, $phrase, $body) = $this->forceBadRequest();

        if (!empty($request) && preg_match(static::PATTERN, $request, $matches) && !empty($matches[1])) {
            $args = explode('/', $matches[1]);

            list($status, $phrase, $body)
                = call_user_func_array(array($this, array_shift($args) . 'API'), $args)
                ?: $this->forceBadRequest();
        }

        $result = 'HTTP/1.1 ' . $status . ' ' . $phrase . static::EOL 
            . 'Content-Type: ' . ($addTestInfo ? 'text/plain' : 'application/json') . '; charset=utf-8';

        if (isset($body) || $addTestInfo) {
            $body = isset($body) ? strval(json_encode($body)) : '';

            if ($addTestInfo) {
                $body .= $this->getTestInfoBlock($status, $phrase, $request);
            }

            $result .= static::EOL . static::EOL . $body;
        }

        return $result;
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        while (true) {
            if (false !== ($connection = @stream_socket_accept($this->getServer()))) {
                fwrite(
                    $connection,
                    $this->processRequest(
                        trim(fgets($connection), "\r\n"),
                        !empty($this->config[static::NAME_TEST_MODE])
                    )
                );

                fflush($connection);
                $this->closeResource($connection);
            }
        }
    }

    // {{{ API

    /**
     * Allocate resource
     *
     * @param string $user User name to allocate for
     *
     * @return array
     */
    protected function allocateAPI($user)
    {
        if (empty($this->resources[static::API_BLOCK_DEALLOC])) {
            $result = array(503, 'Service Unavailable', 'Out of resources');

        } else {
            $res = array_shift($this->resources[static::API_BLOCK_DEALLOC]);
            $this->resources[static::API_BLOCK_ALLOC][$res] = $user;

            $result = array(201, 'Created', $res);
        }

        return $result;
    }

    /**
     * deallocate
     *
     * @param string $res Resource name
     *
     * @return array
     */
    protected function deallocateAPI($res)
    {
        if (empty($this->resources[static::API_BLOCK_ALLOC][$res])) {
            $result = array(404, 'Not Found', 'Not allocated');

        } else {
            unset($this->resources[static::API_BLOCK_ALLOC][$res]);
            array_push($this->resources[static::API_BLOCK_DEALLOC], $res);
            sort($this->resources[static::API_BLOCK_DEALLOC], SORT_NATURAL);

            $result = array(204, 'No Content', null);
        }

        return $result;
    }

    /**
     * list
     *
     * @return array
     */
    protected function listAPI($user = null)
    {
        return array(
            200,
            'OK',
            empty($user) ? $this->resources : array_keys($this->resources[static::API_BLOCK_ALLOC], $user)
        );
    }

    /**
     * reset
     *
     * @return array
     */
    protected function resetAPI()
    {
        $this->resources[static::API_BLOCK_DEALLOC] = array_merge(
            $this->resources[static::API_BLOCK_DEALLOC],
            array_keys($this->resources[static::API_BLOCK_ALLOC])
        );
        sort($this->resources[static::API_BLOCK_DEALLOC], SORT_NATURAL);

        $this->resources[static::API_BLOCK_ALLOC] = array();

        return array(204, 'No Content', null);
    }

    // }}}

    /**
     * getTestInfoBlock
     *
     * @param integer $status  HTTP response code
     * @param string  $phrase  HTTP response message
     * @param string  $request HTTP request params from URI
     *
     * @return string
     */
    protected function getTestInfoBlock($status, $phrase, $request)
    {
        $result  = static::EOL . static::EOL . '=============== Test info ===============' . static::EOL;
        $result .= $status . ': ' . $phrase . static::EOL . static::EOL;
        $result .= 'Request:   "' . ltrim($request, '/') . '"' . static::EOL;
        $result .= 'Resources: "' . json_encode($this->resources) . '"' . static::EOL;

        return $result;
    }

    /**
     * getServer
     *
     * @return resource
     */
    protected function getServer()
    {
        if (!isset($this->server)) {
            $this->server = @stream_socket_server(
                $this->config[static::NAME_ADDRESS] . ':' . $this->config[static::NAME_PORT],
                $errno,
                $errstr
            );

            if (false === $this->server) {
                throw new \Exception($errstr, $errno);
            }
        }

        return $this->server;
    }

    /**
     * closeResource
     *
     * @param resource $resource Socket or connection to close
     *
     * @return void
     */
    protected function closeResource($resource)
    {
        stream_socket_shutdown($resource, STREAM_SHUT_RDWR);
        fclose($resource);
    }

    /**
     * forceBadRequest
     *
     * @return array
     */
    protected function forceBadRequest()
    {
        return array(400, 'Bad Request', 'Bad Request');
    }

    /**
     * init
     *
     * @param string $configFile Path to resm.conf
     *
     * @return void
     */
    protected function init($configFile)
    {
        if (!is_readable($configFile)) {
            throw new \Exception('Wrong path to config file: "' . $configFile . '"');
        }

        if (!is_array($tmp = parse_ini_file($configFile, true)) || empty($tmp[static::NAME_SECTION_MAIN])) {
            throw new \Exception('Wrong config file format');
        }

        $this->config = $tmp[static::NAME_SECTION_MAIN];
        $this->config[static::NAME_RES_COUNT] = intval($this->config[static::NAME_RES_COUNT]);
        $prefix = $this->config[static::NAME_RES_PREF];

        $this->resources[static::API_BLOCK_ALLOC] = array();
        $this->resources[static::API_BLOCK_DEALLOC] = array_map(
            function ($x) use ($prefix) { return $prefix . $x; },
            range(1, $this->config[static::NAME_RES_COUNT])
        );
    }

    /**
     * __construct
     *
     * @return void
     */
    protected function __construct()
    {
        // ...
    }

    /**
     * __clone
     *
     * @return void
     */
    protected function __clone()
    {
        // ...
    }

    /**
     * __destruct
     *
     * @return void
     */
    public function __destruct()
    {
        if (is_resource($this->server)) {
            $this->closeResource($this->server);
        }
    }
}
