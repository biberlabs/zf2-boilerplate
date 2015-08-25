<?php
/**
 * Core module configuration
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Core\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'automatch' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory', // Zend Built-in cache factory
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'MvcTranslator' => 'Core\Service\Factory\TranslatorServiceFactory',
            'core.service.auth' => 'Core\Service\Factory\AuthenticationServiceFactory',
            'core.service.registration' => 'Core\Service\Factory\RegistrationServiceFactory',
            'Example'       => 'Core\Service\Factory\ExampleServiceFactory',
        ),

        'aliases' => array(
            'translator' => 'MvcTranslator',
            // Aliasing the Zend\Authentication\AuthenticationService will allow it to be 
            // recognised by the ZF2 view helper.
            'Zend\Authentication\AuthenticationService' => 'core.service.auth',
            'ExampleService' => 'Example',
        ),

        'initializers' => array(
            'Core\Service\Initializers\CacheAwareInitializer',
        ),
    ),

    'translator' => array(
        'locale'                    => ['en_US', 'en_US'], // ['current', 'fallback']

        'translation_file_patterns' => array(
            // Core module, default domain
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
            
            // Zend captcha
            array(
                'type'        => 'phpArray',
                'base_dir'    => 'vendor/zendframework/zend-i18n-resources/languages',
                'pattern'     => '%s/Zend_Captcha.php',
                'text_domain' => 'forms',
            ),
            // Form validations
            array(
                'type'        => 'phpArray',
                'base_dir'    => 'vendor/zendframework/zend-i18n-resources/languages',
                'pattern'     => '%s/Zend_Validate.php',
                'text_domain' => 'forms',
            ),
        ),

        'cache' => array(
            'adapter' => array(
                // Use APC cache on production
                'name'    => 'apc',
                'options' => array(
                    'namespace' => 'translations',
                ),
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false
                    )
                )
            ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Core\Controller\Index' => 'Core\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    // DOCTRINE - PERSISTENCY
    'doctrine' => array(
        // Data fixtures for user module
        'fixture' => array(
            'Core_fixture' => __DIR__ . '/../src/Core/Fixture',
        ),

        'driver' => array(
            'translatable' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'vendor/gedmo/doctrine-extensions/lib/Gedmo/Translatable/Entity',
                    ),
                ),
            'annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__.'/../src/Core/Entity',
                ),
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Core\Entity'               => 'annotation_driver',
                    'Gedmo\Translatable\Entity' => 'translatable',
                    )
            ),
        ),
    ),

    /**
     * Logger is available by $serviceLocator->get('logger');
     *
     * Usage:
     *
     *   $logger->warn('Warning message..');
     *   $logger->crit('Warning message..', array('data' => 'foo'));
     *
     * See Zend\Log\LoggerInterface for alvailable methods.
     */
    'log' => array(
        'logger' => array(
            'writers' => array(
                array(
                    'name'     => 'stream',
                    'priority' => 1000,
                    'options'  => array(
                        'stream' => 'data/logs/application.'.date('Y.m.d').'.log',
                    ),
                ),
            ),
        ),
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'caches' => array(
        // Can be called directly via SM in the name of 'core.cache.memcached'
        'core.cache.memcached' => array(
            'adapter' => array(
                'name'     => 'memcached',
                'lifetime' => 7200,
                'options'  => array(
                    'servers'   => array(
                        array(
                            '127.0.0.1',11211
                        )
                    ),
                    'namespace'  => 'zf2_boilerplate',
                    'liboptions' => array(
                        'COMPRESSION'     => true,
                        'binary_protocol' => true,
                        'no_block'        => true,
                        'connect_timeout' => 100
                    )
                )
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false
                ),
            ),
        ),

        'core.cache.apc' => array(
            'adapter' => array(
                'name' => 'apc'
                ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false
                    ),
                ),
            ),
        'core.cache.redis' => array(
            'adapter' => array(
                'name' => 'redis',
                'options' => array (
                    'server' => [
                            'host' => '127.0.0.1',
                            'port' => 6379,
                    ]
                ),
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false
                ),
            ),
        ),

        'core.cache.session' => array(
            'adapter' => array(
                'name'    => 'filesystem',
                'options' => array(
                    'cache_dir' => __DIR__ . '/../../../data/cache/session'
                    ),
            ),
        ),
    ),
);
