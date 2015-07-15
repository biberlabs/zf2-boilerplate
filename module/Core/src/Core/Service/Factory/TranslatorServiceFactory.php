<?php
/**
 * Translator service factory
 *
 * @since     Oct 2014
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\I18n\Translator as MvcTranslator;
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

        if (APPLICATION_ENV !== 'development') {
            // Use APC cache for translations on production environment
            $translator->setCache($serviceLocator->get('core.cache.translate'));
        }

        $mvcTranslator = new MvcTranslator($translator);
        \Locale::setDefault($translator->getLocale());
        AbstractValidator::setDefaultTranslator($mvcTranslator);

        return $mvcTranslator;
    }
}
