<?php
/**
 * Authentication service factory
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Authentication service factory
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Simply returns doctrine authentication service factory.
     *
     * @see https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function createService(ServiceLocatorInterface $services)
    {
        return $services->get('doctrine.authenticationservice.orm_default');
    }
}
