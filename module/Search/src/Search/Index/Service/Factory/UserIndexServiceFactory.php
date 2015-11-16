<?php
/**
 * Abstract Index Service Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Index\Service\Factory;

use Search\Index\Service\UserIndexService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserIndexServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserIndexService
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $userIndexService = new UserIndexService($sm->get('search.client.elastic'));

        return $userIndexService;
    }
}
