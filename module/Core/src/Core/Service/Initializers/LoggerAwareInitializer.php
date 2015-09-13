<?php
/**
 * Logger Aware Interface
 *
 * @since     Sep 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Service\Initializers;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\LoggerAwareInterface;

class LoggerAwareInitializer implements InitializerInterface
{
    /**
     * Initialize method for the logger services.
     * Runs when service manager created a new instance of a service which implements ServiceLocatorAwareInterface.
     *
     * @see config > service_manager > initializer key for details.
     */
    public function initialize($instance, ServiceLocatorInterface $services)
    {
        if ($instance instanceof LoggerAwareInterface) {
            $instance->setLogger($services->get('logger'));
        }
    }
}