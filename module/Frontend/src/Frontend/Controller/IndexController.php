<?php
namespace Frontend\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    const TEMPLATE_INDEX = 'frontend/index/index';

    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTemplate(self::TEMPLATE_INDEX);

        return $view;
    }
}
