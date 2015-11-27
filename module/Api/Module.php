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
            1
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
        $identity = $event->getIdentity();

        if (!!$identity) {
            // Manipulate the identity here... Switch it with or add your own model etc.
            $event->setIdentity($identity);
        }

        return true;
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
                $logger    = $event->getTarget()->getServiceLocator()->get('logger');
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
