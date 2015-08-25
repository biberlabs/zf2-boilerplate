<?php
/**
 * Object manager initializer
 *
 * @since     Aug 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */

namespace Core\Service\Initializers;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ObjectManagerAwareInitializer implements InitializerInterface
{
    /**
     * Initialize method for the objectmanager-aware services.
     * Runs when a service which implements ServiceLocatorAwareInterface pulled from service manager.
     *
     * @see config > service_manager > initializer key for details.
     */
    public function initialize($service, ServiceLocatorInterface $sl)
    {
        // Inject doctrine entity manager instance to services which implements ObjectManagerAwareInterface
        if ($service instanceof ObjectManagerAwareInterface) {
            if ($sl instanceof AbstractPluginManager) {
                $service->setObjectManager($sl->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
            } else {
                $service->setObjectManager($sl->get('doctrine.entitymanager.orm_default'));
            }
        }
    }
}
