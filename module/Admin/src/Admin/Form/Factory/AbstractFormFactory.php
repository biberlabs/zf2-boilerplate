<?php
/**
 * Abstract form factory for admin module.
 *
 * @since     Jul 2015
 *
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Form\Factory;

use Admin\Form\LoginForm;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractFormFactory implements AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $fem
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $fem, $name, $requestedName)
    {
        $availableForms = [
            'admin.form.login' => true,
        ];

        return isset($availableForms[$requestedName]);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $fem
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $fem, $name, $requestedName)
    {
        switch ($requestedName) {
            case 'admin.form.login';

                return new LoginForm();
            default:
                break;
        }
    }
}
