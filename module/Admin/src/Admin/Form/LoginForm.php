<?php
/**
 * Login form for administration module.
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Form;

use Zend\Form\Element\Captcha;
use Zend\Form\Element\Csrf;
use Zend\InputFilter\InputFilterProviderInterface;
 
class LoginForm extends BaseForm implements InputFilterProviderInterface
{
    protected $captchaUrl = null;

    public function __construct($name = 'login-form')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
    }

    public function init()
    {
        $this->add(array(
            'name'    => 'email',
            'type'    => 'Email',
            'options' => array(
                'label'            => _('Email address'),
                'id'               => 'email',
                'placeholder'      => 'Your email address',
                'twb-layout'       => self::LAYOUT_HORIZONTAL,
                'column-size'      => 'sm-6',
                'help-block'       => 'Demo user: admin@boilerplate.local',
                'label_attributes' => array(
                    'class' => 'col-sm-2',
                ),
            )
        ));
 
        $this->add(array(
            'name'    => 'password',
            'type'    => 'password',
            'options' => array(
                'label'            => _('Password'),
                'twb-layout'       => self::LAYOUT_HORIZONTAL,
                'column-size'      => 'sm-6',
                'help-block'       => 'Demo pass: TestPass!',
                'label_attributes' => array(
                    'class' => 'col-sm-2',
                ),
            )
       ));
       
        $this->add(array(
            'type'    => 'Csrf',
            'name'    => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
 
        //add captcha element...
        $this->add(array(
            'type'    => 'Captcha',
            'name'    => 'captcha',
            'options' => array(
                'label'            => _('I am not a robot'),
                'captcha'          => array(
                    'class'      => 'Figlet',
                    'wordLen'    => 6,
                    'expiration' => 600,
                    ),
                'twb-layout'       => self::LAYOUT_HORIZONTAL,
                'label_attributes' => array(
                    'class' => 'col-sm-2',
                ),
                'column-size'      => 'sm-6',
                ),
            'attributes' => array(
                'placeholder' => _('Please type the word above'),
                ),
            )
        );
        
        $this->add(array(
            'name'       => 'submit',
            'type'       => 'button',
            'attributes' => array(
                'value' => 'Login',
                'type'  => 'submit',
                'class' => 'btn btn-primary btn-block'
            ),
            'options' => array(
                'label'       => _('Login'),
                'twb-layout'  => self::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-2 col-sm-offset-2'
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        // The email input already have validators attached by default.
        return array(
            'password' => array(
                'required'    => true,
                'allow_empty' => false,
                'filters'     => array(
                    array('name' => 'ToNull'),
                    ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 100,
                            'message'  => _('Minimum password length is 6 characters!'),
                            ),
                        ),
                    ),
                ),
            );
    }
}
