<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager'      => 'Doctrine\ORM\EntityManager',
                'identity_class'      => 'Core\Entity\User',
                'identity_property'   => 'email',
                'credential_property' => 'password',
                'credential_callable' => 'Core\Service\RegistrationService::verifyPassword',
            ],
        ],
        
        // Entity Manager instantiation settings
        'entitymanager' => [
            'orm_default' => [
                'connection'    => 'orm_default',
                'configuration' => 'orm_default',
            ],
        ],
    ],
];
