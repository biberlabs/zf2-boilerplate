<?php
return [
    'service_manager' => [
        'factories' => [
            'search.client.elastic' => 'Search\Client\Factory\ElasticClientFactory',
            'search.index.user'     => 'Search\Index\Service\Factory\UserIndexServiceFactory',
            'search.query.user'     => 'Search\Query\Service\Factory\UserQueryServiceFactory',
        ],
    ],
];
