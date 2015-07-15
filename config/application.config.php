<?php
$modules = array(
        'Core',
        'DoctrineModule',
        'DoctrineORMModule',
        'TwbBundle',
    );

$devModules = array(
    'Zf2Whoops',
    'ZendDeveloperTools',
    'DoctrineDataFixtureModule',
    'SanSessionToolbar',
    'ZfSnapEventDebugger',
    );

$configCache = true;
$moduleCache = true;

$backoffices = array('admin.boilerplate.local');

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'cli'; // Cli?

if ($host == 'cli') {
    // Disable configuration caching for cli requests!
    $configCache = false;
    $moduleCache = false;
}

if (in_array($host, $backoffices)) {
    // Load Admin specific modules only..
    $modules = array_merge($modules, ['Admin']);
}

if (APPLICATION_ENV == 'development') {
    // Load extra modules on development environment
    $modules = array_merge($devModules, $modules);
    // Disable configuration and module caching
    $configCache = false;
    $moduleCache = false;
}

// and return the result
return array(
    'modules'                 => $modules,
    'module_listener_options' => array(
        'module_paths'             => array(
            './module',
            './vendor'
        ),
        'config_glob_paths'        => array(
            'config/autoload/{,*.}{global,local}.php'
        ),
        'config_cache_enabled'     => $configCache,
        'module_map_cache_enabled' => $moduleCache,
        'cache_dir'                => './data/cache',

        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        'check_dependencies'       => false,
    )
);
