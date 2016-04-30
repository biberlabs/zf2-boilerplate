<?php
/**
 * LocaleController factory
 *
 * @since     May 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Admin\Controller\Factory;

use Admin\Controller\LocaleController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LocaleControllerFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     *
     * @return \Admin\Controller\AuthController
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        return new LocaleController(
            $sm->getServiceLocator()->get('core.service.auth'),
            $sm->getServiceLocator()->get('core.service.user')
        );
    }
}
