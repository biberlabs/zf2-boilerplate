<?php
/**
 * Base Form class for all derived administraive area child forms.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm as TwbForm;
use Zend\Form\Form;
 
class BaseForm extends Form
{
    const LAYOUT_HORIZONTAL = TwbForm::LAYOUT_HORIZONTAL;
    const LAYOUT_INLINE     = TwbForm::LAYOUT_INLINE;

    public function __construct($name = null, $options = array())
    {
        return parent::__construct($name, $options);
    }
}
