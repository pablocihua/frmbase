<?php

class Form_Login extends Zend_Form
{
    
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName( 'login' );

        $this->addElement(
            'text', 'username', array(
                'label' => 'Usuario:',
                'required' => true
            )
        );

        $this->addElement(
            'password', 'password', array(
                'label' => 'Contraseña:',
                'required' => true
            )
        );

        $this->addElement(
            'submit', 'Ingresar', array()
        );
        
        
    }

    public function init() {

    }
 
}