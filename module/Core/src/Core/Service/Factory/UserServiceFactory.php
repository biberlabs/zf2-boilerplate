<?php
/**
 * User service factory
 *
 * @since     Nov 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Core\Service\UserService;

/**
 * User service factory
 */
class UserServiceFactory implements FactoryInterface
{
    /**
     * Simply returns doctrine authentication service factory.
     *
     * @see https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
     *
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $userRepo = $sm->get('doctrine.entitymanager.orm_default')->getRepository('Core\Entity\User');

        return new UserService($userRepo);
    }
}
