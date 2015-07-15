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
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'MvcTranslator' => 'Core\Service\Factory\TranslatorServiceFactory',
        ),

        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    'translator' => array(
        'locale'                    => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
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
                        'stream' => 'data/logs/application.log',
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

    'translator' => array(
        'locale'                    => 'tr_TR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
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
                    'namespace'  => 'EIQ',
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

        'core.cache.translate' => array(
            'adapter' => array(
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
