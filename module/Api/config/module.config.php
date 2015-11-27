<?php
return [
    'service_manager' => [
        'factories' => [
            Api\V1\User\UserResource::class        => Api\V1\User\UserResourceFactory::class,
            Api\OAuth\Storage\Adapter\Redis::class => Api\OAuth\Storage\Adapter\RedisFactory::class,
            Api\OAuth\Storage\Adapter\Pdo::class   => Api\OAuth\Storage\Adapter\PdoFactory::class,
            ZF\OAuth2\Service\OAuth2Server::class  => ZF\MvcAuth\Factory\NamedOAuth2ServerFactory::class,
        ],
    ],
    'router' => array(
        'routes' => array(
            'api.rest.user' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Api\V1\User\Controller',
                    ),
                ),
            ), // end of api.rest.user
            'oauth' => array(
                'options' => array(
                    'spec'  => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ),
                'type'         => 'regex', // regex type will be remove.
                'child_routes' => array(
                    'token' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/token',
                            'defaults' => array(
                                'action' => 'token',
                            ),
                        ),
                    ),
                    'resource' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '',
                        ),
                    ),
                    'code' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '',
                        ),
                    ),
                )
            ), // end of oauth
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rest.user',
        ),
    ),
    'zf-rest' => array(
        'Api\V1\User\Controller' => array(
            'listener'              => Api\V1\User\UserResource::class,
            'route_name'            => 'api.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name'       => 'user',
            'entity_http_methods'   => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size'                  => 25,
            'page_size_param'            => null,
            'entity_class'               => Api\V1\User\UserEntity::class,
            'collection_class'           => Api\V1\User\UserCollection::class,
            'service_name'               => 'User',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Api\V1\User\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Api\V1\User\Controller' => array(
                0 => 'application/vnd.example.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\V1\User\Controller' => array(
                0 => 'application/vnd.example.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Api\V1\User\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.user',
                'route_identifier_name'  => 'user_id',
                'hydrator'               => Zend\Stdlib\Hydrator\ObjectProperty::class,
            ),
            'Api\V1\User\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.user',
                'route_identifier_name'  => 'user_id',
                'is_collection'          => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Api\V1\User\Controller' => array(
            'input_filter' => 'Api\V1\User\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Api\V1\User\Validator' => array(

        ),
    ),
    'zf-mvc-auth' => [
        'authorization'  => [
            'deny_by_default'              => true,
            'ZF\OAuth2\Controller\Auth'    => [
                'actions' => [
                    'token' => [
                        'POST' => false,
                    ],
                ],
            ],
        ],
        'authentication' => [
            'adapters' => [
                'zingatOAuth2' => [
                    'adapter' => ZF\MvcAuth\Authentication\OAuth2Adapter::class,
                    'storage' => []
                ],
            ],
            'map' => [
                'Api\V1' => 'zingatOAuth2',
            ],
            'access_lifetime' => 7200,
        ],
    ],
    'zf-oauth2' => [
        'storage' => [
            'client_credentials' => \Api\OAuth\Storage\Adapter\Pdo::class,
            'user_credentials'   => \Api\OAuth\Storage\Adapter\Pdo::class,
            'access_token'       => \Api\OAuth\Storage\Adapter\Redis::class,
            'scope'              => \Api\OAuth\Storage\Adapter\Pdo::class,
            'authorization_code' => \Api\OAuth\Storage\Adapter\Redis::class,
            'refresh_token'      => \Api\OAuth\Storage\Adapter\Redis::class,
        ],
        'grant_types' => [
            'client_credentials' => true, // Default Value
            'authorization_code' => true, // Default Value
            'password'           => true, // Default Value
            'refresh_token'      => true, // Default Value
            'jwt'                => false,
        ],
        'allow_implicit' => false,
        'options'        => array(
            'always_issue_new_refresh_token' => true,
        ),
        'access_lifetime' => 7200,
    ],
];
