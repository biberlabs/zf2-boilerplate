<?php
/**
 * Example Service Factory
 *
 * @since     Jul 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Core\Service\Example as ExampleService;

/**
 * Example service factory.
 */
class ExampleServiceFactory implements FactoryInterface
{
    /**
     * @return ExampleService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ExampleService();
    }
}
