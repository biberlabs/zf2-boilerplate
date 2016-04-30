<?php
/**
 * Base admin controller for all derived child controllers in admin module.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class BaseAdminController extends AbstractActionController
{
    /**
     * On dispatch event.
     *
     * @param  MvcEvent $event
     *
     * @return mixed|\Zend\Http\Response
     */
    public function onDispatch(MvcEvent $event)
    {
        $whitelist = array(
            'auth/logout',
            'auth/login'
            );
        
        $route = $event->getRouteMatch()->getMatchedRouteName();
        
        if (!in_array($route, $whitelist) && $this->identity() === null) {
            // Route is not whitelisted and user is unauthenticated.
            // Redirect to the login page.
            return $this->redirect()->toRoute('auth/login');
        }

        return parent::onDispatch($event);
    }

    /**
     * Converts form validation error messages to simple
     * text messages to use with flashMessenger view helper
     *
     * @param  array  $errors Output of the form->getMessages()
     * @return void
     */
    protected function formErrors(array $errors)
    {
        $messenger = $this->flashMessenger();
        array_walk_recursive($errors, function ($item, $key) use (&$messenger) {
            if (is_string($item)) {
                $messenger->addErrorMessage($item);
            }
        });
    }
}
