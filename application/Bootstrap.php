<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    private $_acl = null;


    #stores a copy of all the database adapters in the Registry for future references
    protected function _initDatabases() {        
        /* # Para una sola base de datos*/
       $this->bootstrap('db');
        $db = $this->getResource('db');
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Registry::set('db', $db);
        Zend_Db_Table_Abstract::setDefaultAdapter( Zend_Registry::get('db') );
    }

    
    protected function _initAutoload() {
        $modelLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'    => APPLICATION_PATH . '/modules/default'
        ));
//var_dump(Zend_Auth::getInstance()->hasIdentity()); exit;
        if ( Zend_Auth::getInstance()->hasIdentity() ) {
            
            $role = new Model_DbTable_Role();
            $rol = $role->getRoleById( Zend_Auth::getInstance()->getStorage()->read()->id_role );
            foreach( $rol as $val ){
                Zend_Registry::set( 'role', strtolower($val->role) );
            }
            #Zend_Registry::set( 'role', Zend_Auth::getInstance()->getStorage()->read()->role );
        } else {
            Zend_Registry::set( 'role', 'invitado');
        }
        
        $this->_acl = new Model_DbTable_LibraryAcl;
        
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin( new Plugin_AccessCheck( $this->_acl) );
        
        Zend_Registry::set('acl', $this->_acl);
        return $modelLoader;
    }
    
    function _initViewHelpers() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        
        $view->setHelperPath( APPLICATION_PATH . '/helpers', '');
        
        $view->doctype('HTML4_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-type', 'text/html')
            ->appendName('description', 'Desarrollo');
        
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('Framework frmbase');
    }
    
    protected function _initNavigation() {
        // read in the array menu
        $nav = new Zend_Config(require(APPLICATION_PATH . '/configs/main-top.php'));

        // initialize the navigation object with the array
        $container = new Zend_Navigation($nav);

        // Set the navigation object to the view
        Zend_Layout::startMvc(); // This is missing from every other tutorial I have seen
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->navigation($container);
        #$view->navigation($container)->setAcl( $this->_acl )->setRole( Zend_Registry::get('role') );
    }
}

