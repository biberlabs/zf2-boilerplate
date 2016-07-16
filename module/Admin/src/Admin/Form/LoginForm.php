<?php
/**
 * Login form for administration module.
 *
 * @since     Jul 2015
 *
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Admin\Form;

use Zend\Filter\ToNull;
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
        $this->add([
            'name'    => 'email',
            'type'    => Email::class,
            'options' => [
                'label'        => _('Email address'),
                'placeholder'  => 'Your email address',
                //'help-block' => 'Demo user: admin@boilerplate.local',
            ],
            'attributes' => [
                'id'    => 'email',
                'class' => 'form-control',
            ],
        ]);
 
        $this->add([
            'name'    => 'password',
            'type'    => Password::class,
            'options' => [
                'label'  => _('Password'),
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
       ]);
       
        $this->add([
            'name'    => 'csrf',
            'type'    => Csrf::class,
            'options' => [
                'csrf_options' => [
                    'timeout' => 3600
                ]
            ]
        ]);
 
        //add captcha element...
        $this->add([
            'name'    => 'captcha',
            'type'    => Captcha::class,
            'options' => [
                'label'            => _('I am not a robot'),
                'captcha'          => [
                    'class'      => 'Figlet',
                    'wordLen'    => 6,
                    'expiration' => 600,
                    ],
                ],
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => _('Please type the word above'),
                ],
            ]
        );
        
        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'value' => 'Login',
                'type'  => 'submit',
                'class' => 'btn btn-primary btn-block'
            ],
            'options' => [
                'label'       => _('Login'),
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        // The email input already have validators attached by default.
        return [
            'password' => [
                'required'    => true,
                'allow_empty' => false,
                'filters'     => [
                    [ 'name' => ToNull::class ],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 100,
                            'message'  => _('Minimum password length is 6 characters!'),
                            ],
                        ],
                    ],
                ],
            ];
    }
}
