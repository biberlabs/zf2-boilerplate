<?php
/**
 * Very simple view helper for easily rendering page titles
 * in administration related views.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Pagetitle view helper renders page titles in admin interfaces
 * while keeping the html meta TITLE value in sync with the rendered content.
 *
 * Usage (in a view) :
 *     echo $this->pageTitle('Reports');
 *     echo $this->pageTitle('User list', '4 users found');
 */
class PageTitle extends AbstractHelper
{
    /**
     * Invokable.
     *
     * @param  string $title    Page title to render
     * @param  string $subtitle Sub-title (optional)
     *
     * @return string
     */
    public function __invoke($title, $subtitle = null)
    {
        $subtitle = $subtitle === null ? '' : ' <small>'.$subtitle.'</small>';
        $this->view->headTitle($title);
        
        return '<h1>'.$title.$subtitle.'</h1><hr />'.PHP_EOL;
    }
}
