<?php
/**
 * Configuration for admin module
 */
return array(
    // ROUTING
    'router' => array(
        'routes' => array(
            // Notice - Automatch is the last-matching route (FILO)
            'automatch' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/[:controller[/:action[/:id]]]',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Dashboard',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'         => '[0-9]+',
                    ),
                ),
            ),

            'auth' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Auth',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'login' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/logout',
                            'defaults' => array(
                                'action' => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Dashboard'  => 'Admin\Controller\DashboardController',
            'Admin\Controller\Auth'       => 'Admin\Controller\AuthController',
            'Admin\Controller\Locale'     => 'Admin\Controller\LocaleController',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Session\SessionManager'         => 'Zend\Session\Service\SessionManagerFactory',
            'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
        ),
        'aliases' => array(
            'session.manager' => 'Zend\Session\SessionManager',
        ),
    ),

    'session_containers' => array(
        'user',
        'default',
    ),

    'session_storage' => array(
        'type'    => 'SessionArrayStorage',
        'options' => array(
        ),
    ),

    'session_config' => array(
        'remember_me_seconds' => 2419200,
        'use_cookies'         => true,
        'cookie_httponly'     => true, // Don't editable via JS when true
    ),

    // Forms
    'form_elements'   => array(
        'abstract_factories' => array(
            'Admin\Form\Factory\AbstractFormFactory'
        ),
    ),

    /**
     * View helper configuration
     */
    'view_helpers' => array(
        'invokables' => array(
            'pageTitle'        => 'Admin\View\Helper\PageTitle',
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/layout'         => __DIR__ . '/../view/layout/admin-layout.phtml',
            'admin/dashboard/index' => __DIR__ . '/../view/admin/dashboard/index.phtml',
            'error/404'             => __DIR__ . '/../view/error/404.phtml',
            'error/index'           => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
