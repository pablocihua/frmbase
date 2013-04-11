<?php

class Posts_Form_Posts extends Zend_Form
{
    public function init() {
        $this->addElement( 'hidden', 'id' );
        
        $this->addElement(
                'text', 'title', array(
                    'label' => 'Titulo',
                    'required' => true,
                    'class' => 'input-small'
                )
        );
        
        $this->addElement(
                'textarea', 'full_text', array(
                    'label' => 'Contenido',
                    'required' => true,
                    'class' => 'input-large', // uneditable-input
                    'rows' => '5',
                    'cols' => ''
                )
        );
        
//        $this->setElementDecorators(array('Label', 'ViewHelper', 'HtmlTag'));
//        
//        $this->getElement('title')->addDecorator('HtmlTag', array('class' => 'row', 'openOnly' => true));
//        $this->getElement('full_text')->addDecorator('HtmlTag', array('closeOnly' => false));
        
        $this->addElement( 'submit', 'Guardar', array('class' => 'btn', 'ignore' => true) );
        
    }
}