<?php
/**
 * Admin module
 */
namespace Admin;

use Core\I18n\Locale as Locales;
use Doctrine\Common\EventManager as DoctrineEventManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $locale       = Locales::DEFAULT_LOCALE;
        $session      = new Container('locale');
        $translator   = $e->getApplication()
                          ->getServiceManager()
                          ->get('mvctranslator')
                          ->getTranslator();
                          
        if ($session->offsetExists('locale')) {
            $locale     = $session->locale;
            $translator->setLocale($locale);
            $translator->setFallbackLocale(Locales::DEFAULT_LOCALE);
            \Locale::setDefault($translator->getLocale());
        }

        // Initialize doctrine event manager for translations.
        $this->initTranslations(
            $e->getApplication()->getServiceManager()->get('doctrine.eventmanager.orm_default'),
            $locale
        );

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Intializes doctrine translations, application wide.
     *
     * @param  DoctrineEventManager $doctrineEventManager
     * @return void
     */
    private function initTranslations(DoctrineEventManager $doctrineEventManager, $locale)
    {
        $listener = new \Gedmo\Translatable\TranslatableListener();

        /**
         * IF persist default locale translation is true,
         * translator will also create a record in translations table for that
         * attribute's original value too.
         */
        $listener->setTranslatableLocale($locale)
                 ->setTranslationFallback(true)
                 ->setPersistDefaultLocaleTranslation(false);
        $doctrineEventManager->addEventSubscriber($listener);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
