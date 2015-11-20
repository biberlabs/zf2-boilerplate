<?php
return [
    'service_manager' => [
        'factories' => [
            'Api\V1\User\UserResource' => 'Api\V1\User\UserResourceFactory',
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
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rest.user',
        ),
    ),
    'zf-rest' => array(
        'Api\V1\User\Controller' => array(
            'listener'              => 'Api\V1\User\UserResource',
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
            'entity_class'               => 'Api\V1\User\UserEntity',
            'collection_class'           => 'Api\V1\User\UserCollection',
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
                'hydrator'               => 'Zend\Stdlib\Hydrator\ObjectProperty',
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
    'zf-mvc-auth' => array(
        'authorization' => array(
        ),
    ),
];
