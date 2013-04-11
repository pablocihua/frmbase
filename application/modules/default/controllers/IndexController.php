<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
//        $storage = new Zend_Auth_Storage_Session();
//        $data = $storage->read();
//        $this->view->username = $data->username;
        
        $this->view->headTitle('Inicio', 'PREPEND');
        
        $this->view->titulo = 'Framework &nbsp;&nbsp; f r m B a s e';
//        $postsModel = new Application_Model_Posts();
//        $this->view->titulares = $postsModel->getAllNew();
    }


}

