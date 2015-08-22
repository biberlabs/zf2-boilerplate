<?php
/**
 * Registration service factory
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service\Factory;

use Core\Service\RegistrationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Registration service factory.
 */
class RegistrationServiceFactory implements FactoryInterface
{
    /**
     * @return RegistrationService
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        return new RegistrationService($sm->get('core.service.auth'));
    }
}
