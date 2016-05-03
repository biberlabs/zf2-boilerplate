<?php
namespace Api;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
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
        $oauth2Closure = $event->getApplication()->getServiceManager()
                             ->get(\ZF\OAuth2\Service\OAuth2Server::class);
        $logger = $event->getApplication()->getServiceManager()->get('logger');


        $eventManager->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            function (MvcAuthEvent $event) use ($oauth2Closure) {
                // Manipulating Identity Data
                $identity      = $event->getIdentity();

                if (!!$identity) {
                    if ($identity instanceof AuthenticatedIdentity) {
                        $userData = $oauth2Closure()->getStorage('user_credentials')->getUser($identity->getName());
                        if (is_array($identity->getAuthenticationIdentity())) {
                            $userData = array_merge($userData, $identity->getAuthenticationIdentity());
                        }
                        $identity = new AuthenticatedIdentity($userData);
                        $event->setIdentity($identity);
                    }
                    //MvcEvent did not understand when manipulated MvcAuthEvent identity
                    $event->getMvcEvent()->setParam('ZF\MvcAuth\Identity', $identity);
                }

                return $event;
            },
            900
        );

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $event->getApplication()->getEventManager()->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            function (MvcEvent $event) use ($logger) {
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
            },
            9000
        );
    }

    public function dispatchError(MvcEvent $event)
    {

    }
}
