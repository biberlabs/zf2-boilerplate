<?php
/**
 * Translator service factory
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service\Factory;

use Zend\I18n\Translator\Translator;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\AbstractValidator;

/**
 * Translator service factory.
 */
class TranslatorServiceFactory implements FactoryInterface
{
    /**
     * @return \Zend\Mvc\I18n\Translator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Configure the translator
        $config     = $serviceLocator->get('Config');
        $translator = Translator::factory($config['translator']);

        $mvcTranslator = new MvcTranslator($translator);

        \Locale::setDefault($translator->getLocale());

        // For translated validation messages
        AbstractValidator::setDefaultTranslator($mvcTranslator, 'forms');

        return $mvcTranslator;
    }
}
