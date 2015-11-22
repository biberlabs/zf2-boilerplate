<?php
/**
 * Core module configuration
 */
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory', // Zend Built-in cache factory
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        
        'factories' => array(
            'MvcTranslator'             => 'Core\Service\Factory\TranslatorServiceFactory',
            'core.service.auth'         => 'Core\Service\Factory\AuthenticationServiceFactory',
            'core.service.registration' => 'Core\Service\Factory\RegistrationServiceFactory',
            'core.service.user'         => 'Core\Service\Factory\UserServiceFactory',
        ),

        'aliases' => array(
            'translator' => 'MvcTranslator',
            // Aliasing the Zend\Authentication\AuthenticationService will allow it to be
            // recognised by the ZF2 view helper.
            'Zend\Authentication\AuthenticationService' => 'core.service.auth',
        ),

        'initializers' => array(
            'Core\Service\Initializers\CacheAwareInitializer',
            'Core\Service\Initializers\LoggerAwareInitializer',
            'Core\Service\Initializers\ObjectManagerAwareInitializer',
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
            'processors' => array(
                array(
                    'name'     => 'Core\Log\Processor\EventType',
                    'priority' => 1000,
                    'options'  => array(),
                ),
            ),
        ),
    ),

    // // Placeholder for console routes
    // 'console' => array(
    //     'router' => array(
    //         'routes' => array(
    //         ),
    //     ),
    // ),

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
                'name'    => 'redis',
                'options' => array(
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
