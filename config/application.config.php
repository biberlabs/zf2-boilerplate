<?php
$env = getenv('APPLICATION_ENV');
if (empty($env)) {
    $env = 'production'; // Set environment as production if it's not available
}

// Define as global CONSTANT
define('APPLICATION_ENV', $env);

/**
 * Domain names for different application behaviours.
 * While FRONTEND URI serving public face of your application to end users,
 * API Uri handles restful requests and ADMIN only exists for
 * you, administrators and staff.
 */
define('APP_URI_FRONTEND', 'www.boilerplate.local');
define('APP_URI_API', 'api.boilerplate.local');
define('APP_URI_ADMIN', 'admin.boilerplate.local');

/**
 * You need to define three virtual hosts for the domains above in your
 * HTTP server respectively and each request should be handled by correct
 * virtual server, not randomly.
 *
 * Setting correct/separate server names in HTTP level and getting ready to run same
 * application on multiple pyshical nodes is a good approach from many aspects,
 * also probably it will be a MUST when your application is growing & need scaling.
 *
 * You also will need to alter this hardcoded domain names in this file
 * on production/testing/staging environments utilizing sed/awk on build-time.
 */
define('APP_SERVER_NAME',  (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'cli'));

$modules = [
    // Common modules to load everytime.
    'common' => [
        'Core',
        'DoctrineModule',
        'DoctrineORMModule',
        'Search',
        ],
    // Load only on www.* requests
    APP_URI_FRONTEND => [
        'Frontend',
        ],
    // Load only on api.* requests
    APP_URI_API => [
        'ZF\ApiProblem',
        'ZF\ContentNegotiation',
        'ZF\Hal',
        'ZF\Rest',
        'ZF\OAuth2',
        'ZF\MvcAuth',
        'Api',
        ],
    // Load only on admin.* requests
    APP_URI_ADMIN => [
        'Admin',
        ],
    // Development purposes only
    'development' => [
        'Zf2Whoops',
        'ZendDeveloperTools',
        'DoctrineDataFixtureModule',
        'SanSessionToolbar',
        'ZfSnapEventDebugger',
        'ZFTool',
        ],
    ];

$configCache   = true;
$moduleCache   = true;
$modulesToLoad = $modules['common'];
$cacheDir      = './data/cache';

if (PHP_SAPI === 'cli') {
    // Disable configuration caching on CLI requests!
    $configCache = false;
    $moduleCache = false;
} else {
    /**
     * This is important:
     * Save merged configuration files in separate folders since
     * application generates different merged configs on different domains.
     */
    $cacheDir      = $cacheDir.'/'.explode('.', APP_SERVER_NAME)[0]; // www, api or admin
    $modulesToLoad = array_merge($modulesToLoad, $modules[APP_SERVER_NAME]);
}

if (APPLICATION_ENV === 'development') {
    // Load extra modules on development environment
    if (APP_SERVER_NAME !== APP_URI_API) {
        $modulesToLoad = array_merge($modulesToLoad, $modules['development']);
    }
    // Disable configuration and module caching
    $configCache = false;
    $moduleCache = false;
}

// and return the result
return [
    'modules'                 => $modulesToLoad,
    'module_listener_options' => [
        'module_paths'             => [
            './module',
            './vendor'
        ],
        'config_glob_paths'        => [
            'config/autoload/{,*.}{global,local}.php'
        ],
        'config_cache_enabled'     => $configCache,
        'module_map_cache_enabled' => $moduleCache,
        'cache_dir'                => $cacheDir,

        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        'check_dependencies'       => false,
    ]
];
