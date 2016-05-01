<?php
/**
 * Authentication controller for admin module.
 *
 * @since  Jul 2015
 * @author M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Controller;

use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends BaseAdminController
{
    protected $authService;
    protected $registrationService;
    protected $adminLoginForm;
    protected $logger;
    
    public function __construct($authService, $registrationService, $adminLoginForm, $logger)
    {
        $this->authService = $authService;
        $this->registrationService = $registrationService;
        $this->adminLoginForm = $adminLoginForm;
        $this->logger = $logger;
    }

    /**
     * Login action for backoffice..
     *
     * @return ViewModel
     */
    public function loginAction()
    {
        $view   = new ViewModel();
        $form   = $this->adminLoginForm;
        $failed = null;

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                // Go to service and check credentials
                $data   = $form->getData();
                $result = $this->registrationService->login($data['email'], $data['password']);
                if ($result->isValid()) {
                    $session         = new Container('locale');
                    $session->locale = $result->getIdentity()->getLanguage();

                    $this->logger->info('User '.$result->getIdentity()->getNameSurname().' has been logged in to backoffice');
                    $this->redirect()->toUrl('/');
                } else {
                    $failed = _('Authentication failed. Please check your credentials.');
                    //$this->flashMessenger()->addErrorMessage($failed);
                    $this->logger->info('Login attempt failed.', $data);
                }
            } else {
                $this->formErrors($form->getMessages());
            }
        }

        $view->setVariables(array(
            'loginForm' => $form,
            'failed'    => $failed,
            )
        );

        return $view;
    }

    public function logoutAction()
    {
        if ($this->authService->hasIdentity()) {
            $user = $this->authService->getIdentity();
            $this->authService->clearIdentity();
            $this->logger->info('User '.$user->getNameSurname().' logged out..');
        }

        return $this->redirect()->toUrl('/');
    }
}
