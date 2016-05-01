<?php
/**
 * AuthController factory
 *
 * @since     May 2016
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Admin\Controller\Factory;

use Admin\Controller\AuthController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     *
     * @return \Admin\Controller\AuthController
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        return new AuthController(
            $sm->getServiceLocator()->get('core.service.auth'),
            $sm->getServiceLocator()->get('core.service.registration'),
            $sm->getServiceLocator()->get('FormElementManager')->get('admin.form.login'),
            $sm->getServiceLocator()->get('logger')
        );
    }
}
