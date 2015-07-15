<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
define('REQUEST_STARTED', microtime(true));
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

$env = getenv('APPLICATION_ENV');
if (empty($env)) {
    $env = 'production'; // Set environment as production if not provided
}

// Define as global CONSTANT
define('APPLICATION_ENV', $env);

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
