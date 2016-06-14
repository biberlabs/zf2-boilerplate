<?php
/**
 * API specific configuration
 */
return [
    'service_manager' => [
        'factories' => [
            Api\V1\User\UserResource::class        => Api\V1\User\UserResourceFactory::class,
            Api\OAuth\Storage\Adapter\Redis::class => Api\OAuth\Storage\Adapter\RedisFactory::class,
            Api\OAuth\Storage\Adapter\Pdo::class   => Api\OAuth\Storage\Adapter\PdoFactory::class,
            ZF\OAuth2\Service\OAuth2Server::class  => ZF\MvcAuth\Factory\NamedOAuth2ServerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'api.rest.user' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/user[/:user_id]',
                    'defaults' => [
                        'controller' => 'Api\V1\User\Controller',
                    ],
                ],
            ], // end of api.rest.user
            'oauth' => [
                'options' => [
                    'route'    => '/oauth',
                ],
                'type'         => 'Segment', // regex type will be remove.
                'child_routes' => [
                    'token' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => '/token',
                            'defaults' => [
                                'action' => 'token',
                            ],
                        ],
                    ],
                    'resource' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route' => '',
                        ],
                    ],
                    'code' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route' => '',
                        ],
                    ],
                ]
            ], // end of oauth
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'api.rest.user',
        ],
    ],
    'zf-rest' => [
        'Api\V1\User\Controller' => [
            'listener'              => Api\V1\User\UserResource::class,
            'route_name'            => 'api.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name'       => 'user',
            'entity_http_methods'   => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size'                  => 25,
            'page_size_param'            => null,
            'entity_class'               => Api\V1\User\UserEntity::class,
            'collection_class'           => Api\V1\User\UserCollection::class,
            'service_name'               => 'User',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Api\V1\User\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Api\V1\User\Controller' => [
                0 => 'application/vnd.example.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Api\V1\User\Controller' => [
                0 => 'application/vnd.example.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            'Api\V1\User\UserEntity' => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.user',
                'route_identifier_name'  => 'user_id',
                'hydrator'               => Zend\Stdlib\Hydrator\ObjectProperty::class,
            ],
            'Api\V1\User\UserCollection' => [
                'entity_identifier_name' => 'id',
                'route_name'             => 'api.rest.user',
                'route_identifier_name'  => 'user_id',
                'is_collection'          => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'Api\V1\User\Controller' => [
            'input_filter' => 'Api\V1\User\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Api\V1\User\Validator' => [

        ],
    ],
    'zf-mvc-auth' => [
        'authorization'  => [
            'deny_by_default'              => true,
            'ZF\OAuth2\Controller\Auth'    => [
                'actions' => [
                    'token' => [
                        'POST' => false,
                    ],
                    'authorize' => [
                        'GET'  => false,
                        'POST' => false,
                    ],
                ],
            ],
        ],
        'authentication' => [
            'adapters' => [
                'api-auth' => [
                    'adapter' => ZF\MvcAuth\Authentication\OAuth2Adapter::class,
                    'storage' => []
                ],
            ],
            'map' => [
                'Api\V1' => 'api-auth',
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
        'options'        => [
            'always_issue_new_refresh_token' => true,
        ],
        'access_lifetime' => 7200,
    ],
];
