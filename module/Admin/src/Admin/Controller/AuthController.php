<?php
/**
 * Authentication controller for admin module.
 *
 * @since  Jul 2015
 * @author M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    /**
     * Login action for backoffice..
     *
     * @return ViewModel
     */
    public function loginAction()
    {
        $view   = new ViewModel();
        $form   = $this->getServiceLocator()->get('FormElementManager')->get('admin.form.login');
        $failed = null;

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            $logger = $this->getServiceLocator()->get('logger');
            if ($form->isValid()) {
                // Go to service and check credentials
                $data   = $form->getData();
                $result = $this->getServiceLocator()->get('core.service.registration')->login($data['email'], $data['password']);
                if ($result->isValid()) {
                    $session         = new Container('locale');
                    $session->locale = $result->getIdentity()->getLanguage();
                    
                    $logger->info('User '.$result->getIdentity()->getNameSurname().' has been logged in to backoffice');
                    $this->redirect()->toUrl('/');
                } else {
                    $failed = _('Authentication failed. Please check your credentials.');
                    $logger->info('Login attempt failed: '.json_encode($data));
                }
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
        $auth = $this->getServiceLocator()->get('core.service.auth');

        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $auth->clearIdentity();
            $this->getServiceLocator()->get('logger')->info('User '.$user->getNameSurname().' logged out..');
        }

        return $this->redirect()->toUrl('/');
    }
}
