<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    const TEMPLATE_INDEX = 'core/index/index';

    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTemplate(self::TEMPLATE_INDEX);

        // Example Service Usage with Cache Storage
        // $exampleService = $this->getServiceLocator()->get('ExampleService');
        // $helloWorldText = $exampleService->helloWorld());

        return new ViewModel();
    }
}
