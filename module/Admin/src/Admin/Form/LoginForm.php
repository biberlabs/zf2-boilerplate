<?php
/**
 * Login form for administration module.
 *
 * @since     Jul 2015
 *
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
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
            'type'    => Email::class,
            'options' => array(
                'label'            => _('Email address'),
                'placeholder'      => 'Your email address',
                //'help-block'       => 'Demo user: admin@boilerplate.local',
            ),
            'attributes' => array(
                'id'    => 'email',
                'class' => 'form-control',
            ),
        ));
 
        $this->add(array(
            'name'    => 'password',
            'type'    => Password::class,
            'options' => array(
                'label'  => _('Password'),
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
       ));
       
        $this->add(array(
            'name'    => 'csrf',
            'type'    => Csrf::class,
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
 
        //add captcha element...
        $this->add(array(
            'name'    => 'captcha',
            'type'    => Captcha::class,
            'options' => array(
                'label'            => _('I am not a robot'),
                'captcha'          => array(
                    'class'      => 'Figlet',
                    'wordLen'    => 6,
                    'expiration' => 600,
                    ),
                ),
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => _('Please type the word above'),
                ),
            )
        );
        
        $this->add(array(
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => array(
                'value' => 'Login',
                'type'  => 'submit',
                'class' => 'btn btn-primary btn-block'
            ),
            'options' => array(
                'label'       => _('Login'),
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
