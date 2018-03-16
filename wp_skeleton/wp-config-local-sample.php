<?php

/**
 * Config for local development
 * 
 * @author Vadim Sannikov <vsj.vadim@gmail.com> 
 */

error_reporting(E_ALL);
ini_set('display_errors', true);

define('DB_NAME',     'database_name_here');
define('DB_USER',     'username_here');
define('DB_PASSWORD', 'password_here');
define('DB_HOST',     'localhost');

define('WP_DEBUG', true);
