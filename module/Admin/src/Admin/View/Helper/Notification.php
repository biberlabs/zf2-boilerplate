<?php
/**
 * Notification view helper to easily render backend
 * messages utilizing the built-in flashmessenger view helper,
 * the bootstrap way.
 *
 * @since     Oct 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Usage (in views):
 *
 *    echo $this->notification()->error();
 *    echo $this->notification()->success();
 */
class Notification extends AbstractHelper
{
    protected $flash = null;

    public function __invoke()
    {
        $openFormat  = '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>';
        $this->flash = $this->view->flashMessenger();
        $this->flash->setMessageOpenFormat($openFormat)
                    ->setMessageSeparatorString('</li><li>')
                    ->setMessageCloseString('</li></ul></div>');

        return $this;
    }

    public function error()
    {
        echo $this->flash->render('error', array('alert', 'alert-danger'));
        //$this->flash->getPluginFlashMessenger()->clearCurrentMessages('error');
    }

    public function success()
    {
        echo $this->flash->render('success', array('alert', 'alert-success'));
        //$this->flash->getPluginFlashMessenger()->clearCurrentMessages('success');
    }
}
