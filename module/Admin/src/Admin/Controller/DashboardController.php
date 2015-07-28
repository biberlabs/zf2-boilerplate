<?php
/**
 * Dashboard controller
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class DashboardController extends BaseAdminController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
