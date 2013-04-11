<?php

class Default_AuthenticationController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function loginAction()
    {
        if ( Zend_Auth::getInstance()->hasIdentity() ) {
            $this->_redirect( '/authentication/login' );
        } else {
            // No action
        }
        
        $request = $this->getRequest();
        $form = new Form_Login();
        
        if ( $request->isPost() ) {
            
            if ( $form->isValid( $this->_request->getPost() ) ) {
                $authAdapter = $this->getAuthAdapter();

                $authAdapter
                    ->setIdentity($form->getValue('username'))
                    ->setCredential(sha1($form->getValue('password')));

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                
                if( $result->isValid() ){
                    
//                    $storage = new Zend_Auth_Storage_Session();
//                    $storage->write($authAdapter->getResultRowObject());
                    $identity = $authAdapter->getResultRowObject(); // null, 'password'
                    $auth->getStorage()->write($identity);
                    $this->_redirect('/');
                } else {
//                    $form->username->addErrorMessage('Datos Incorrectos');
                    $this->view->errorMessage = "Nombre de usuario o contrasena incorrecta.";
                }
            } else {
                // No action 
            }
        } else {
            // No action
        }
        
        $this->view->form = $form;
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        
        return $this->_redirect('/');
    }
    
    private function getAuthAdapter() {
        $authAdapter = new Zend_Auth_Adapter_DbTable( Zend_Db_Table::getDefaultAdapter() );
        $authAdapter->setTableName( 'users' )
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');
        
        return $authAdapter;
    }


}