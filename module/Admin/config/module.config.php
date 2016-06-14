<?php
/**
 * Configuration for admin module
 */
return [
    // ROUTING
    'router' => [
        'routes' => [
            // Notice - Automatch is the last-matching route (FILO]
            'automatch' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/[:controller[/:action[/:id]]]',
                    'defaults'    => [
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Dashboard',
                        'action'        => 'index',
                    ],
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[0-9]+',
                    ],
                ],
            ],

            'auth' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/auth',
                    'defaults' => [
                        'controller' => 'Admin\Controller\Auth',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'login' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/login',
                            'defaults' => [
                                'action' => 'login',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/logout',
                            'defaults' => [
                                'action' => 'logout',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            'Admin\Controller\Auth'       => 'Admin\Controller\Factory\AuthControllerFactory',
            'Admin\Controller\Locale'     => 'Admin\Controller\Factory\LocaleControllerFactory',
        ],
        'invokables' => [
            'Admin\Controller\Dashboard'  => 'Admin\Controller\DashboardController',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'Zend\Session\SessionManager'         => 'Zend\Session\Service\SessionManagerFactory',
            'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
        ],
        'aliases' => [
            'session.manager' => 'Zend\Session\SessionManager',
        ],
    ],

    'session_containers' => [
        'user',
        'default',
    ],

    'session_storage' => [
        'type'    => 'SessionArrayStorage',
        'options' => [
        ],
    ],

    'session_config' => [
        'remember_me_seconds' => 2419200,
        'use_cookies'         => true,
        'cookie_httponly'     => true, // Don't editable via JS when true
    ],

    // Forms
    'form_elements'   => [
        'abstract_factories' => [
            'Admin\Form\Factory\AbstractFormFactory'
        ],
    ],

    /**
     * View helper configuration
     */
    'view_helpers' => [
        'invokables' => [
            'pageTitle'        => 'Admin\View\Helper\PageTitle',
            'notification'     => 'Admin\View\Helper\Notification',
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'         => __DIR__ . '/../view/layout/admin-layout.phtml',
            'admin/dashboard/index' => __DIR__ . '/../view/admin/dashboard/index.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
