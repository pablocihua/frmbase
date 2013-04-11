<?php

class Posts_PostsController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // 
    }

    public function listAction() {
        $auth = Zend_Auth::getInstance();
        $acl   = new Model_DbTable_LibraryAcl();
        
        if ( !$auth->hasIdentity() ){
            return $this->_redirect('/authentication/login');
        } else {
            // No action
        }
//echo $auth->getIdentity()->role .' / '. $this->getRequest()->module . ':' . $this->getRequest()->controller .' / '. $this->getRequest()->action . ' '; //exit;
//echo $acl->isAllowed( $auth->getIdentity()->role, $this->getRequest()->module . ':' . $this->getRequest()->controller, $this->getRequest()->action ) ? 'si' : 'no'; exit;
        if( !$acl->isAllowed( $auth->getIdentity()->role, $this->getRequest()->module . ':' . $this->getRequest()->controller, $this->getRequest()->action ) ){
            return $this->_redirect( '/' );
        } else {
            // No action
        }
        
        if ( !$auth->hasIdentity() ){
            return $this->_redirect('/authentication/login');
        } else {
            // No action
        }
        
        $model = new Posts_Model_DbTable_Posts();
        $posts = $model->getAll();
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($posts);
        
        if ( $this->_hasParam('page') ){
            $paginator->setCurrentPageNumber( $this->_getParam('page'));
        } else {
            // No action
        }
        
        $this->view->paginator = $paginator;
    }

    public function addAction() {
        $auth = Zend_Auth::getInstance();
        
        if ( !$auth->hasIdentity() ){
            return $this->_redirect('/authentication/login');
        } else {
            // No action
        }
        
        $form = new Posts_Form_Posts();
        
        if ( $this->getRequest()->isPost() ) {
            if ( $form->isValid( $this->_getAllParams() ) ) {
                $model = new Posts_Model_DbTable_Posts();
                $model->save( $form->getValues() );
                
                return $this->_redirect('/');
            }
        }
        
        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $auth = Zend_Auth::getInstance();
        
        if ( !$auth->hasIdentity() ){
            return $this->_redirect('/authentication/login');
        } else {
            // No action
        }
    }

    public function deleteAction() {
        // action body
        $auth = Zend_Auth::getInstance();
        
        if ( !$auth->hasIdentity() ){
            return $this->_redirect('/authentication/login');
        } else {
            // No action
        }
    }


}









