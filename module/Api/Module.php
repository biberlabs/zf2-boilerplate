<?php
namespace Api;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\MvcAuth\MvcAuthEvent;

class Module
{
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

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();

        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            array($this, 'eventAuthenticationPost'),
            900
        );

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $event->getApplication()->getEventManager()->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            array($this, 'dispatchError'),
            9000
        );
    }

    public function eventAuthenticationPost(MvcAuthEvent $event)
    {
        $identity      = $event->getIdentity();
        $oauth2Closure = $event->getMvcEvent()
                               ->getApplication()
                               ->getServiceManager()
                               ->get(\ZF\OAuth2\Service\OAuth2Server::class);

        if (!!$identity) {
            $userData = $oauth2Closure()->getStorage('user_credentials')->getUser($identity->getName());
            
            $identity = new \ZF\MvcAuth\Identity\AuthenticatedIdentity($userData);
            $event->setIdentity($identity);
            //MvcEvent did not understand when manipulated MvcAuthEvent identity
            $event->getMvcEvent()->setParam('ZF\MvcAuth\Identity', $identity);
        }

        return $event;
    }

    public function dispatchError(MvcEvent $event)
    {
        $problem = null;
        if ($event->isError()) {
            $exception = $event->getParam("exception");
            
            // There are some other errors like that :
                // "error-controller-cannot-dispatch",
                // "error-controller-invalid",
                // "error-controller-not-found",
                // "error-router-no-match",
            if ($event->getError() === 'error-controller-not-found') {
                $problem = new ApiProblem(404, "Endpoint controller not found!");
            } elseif ($event->getError() === 'error-router-no-match') {
                $problem = new ApiProblem(404, "Not found!");
            } elseif ($exception instanceof \Exception) {
                $className = explode('\\', get_class($exception));
                $problem   = new ApiProblem($exception->getCode(), end($className) . ' error.');
                $logger    = $event->getTarget()->getServiceManager()->get('logger');
                $logger->err($exception->getMessage(), array(
                    'controller' => $event->getControllerClass(),
                    ));
            }
        } else {
            $problem = new ApiProblem(500, "Unknown Error!");
        }
        
        $response = new ApiProblemResponse($problem);
        $event->stopPropagation();

        return $response;
    }
}
