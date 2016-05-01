<?php
/**
 * Locale controller to switch backoffice language.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Controller;

use Core\I18n\Locale as Locales;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class LocaleController extends AbstractActionController
{
    protected $authService;
    protected $userService;

    public function __construct($authService, $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Change locale.
     *
     * @return void
     */
    public function changeAction()
    {
        $redirect  = $this->getRequest()->getHeader('Referer')->uri()->getPath();
        $newLocale = (string) $this->params()->fromQuery('set');
        $locales   = Locales::getAvailableLocales();
        
        if (array_key_exists($newLocale, $locales)) {
            if ($this->authService->hasIdentity()) {
                $user = $this->authService->getIdentity();
                $this->userService
                     ->changeLocaleByUser($user, $newLocale);
                $user->setLanguage($newLocale);
                $this->authService->getStorage()->write($user);
            }

            $session         = new Container('locale');
            $session->locale = $newLocale;
        }

        return $this->redirect()->toUrl($redirect);
    }
}
