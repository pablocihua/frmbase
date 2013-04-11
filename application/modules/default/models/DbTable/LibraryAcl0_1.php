<?php

class Model_LibraryAcl extends Zend_Acl
{
    public function __construct() {
        
        $resource    = new Application_Model_DbTable_Recurso();
        $role        = new Application_Model_DbTable_Role();
        $accion      = new Application_Model_DbTable_Permite();
        
        $row = $resource->getAll();
        foreach( $row as $val ){
            $this->add( new Zend_Acl_Resource( ''. strtolower($val->RECURSO ) .'' ) );
        }
        unset($row);
        
        $i                     = 0;
        $roleCurrent    = '';
        $row                = $role->getAllRoleAsc();

        foreach( $row as $val ){
            if ( $i == 0 ){
                $this->addRole( new Zend_Acl_Role( ''. strtolower($val->ROLE) ) .'' );
//echo strtolower($val->ROLE) .'<br/>';
            } else {
                $this->addRole( new Zend_Acl_Role( strtolower($val->ROLE) ), ''. $roleCurrent .'' );
//echo strtolower($val->ROLE) . ', '. $roleCurrent .'<br/>';
            }

            $roleCurrent = strtolower(''. $val->ROLE .'');
            $i++;
        }
        unset($row);
        
        $row    = $accion->getAllPermissionAllows();
        $this->deny();
        foreach( $row as $val ){
            if ( '' === strtolower($val->ACCION ) ) {
                if ( strtolower($val->RECURSO) != 'error')
                    $this->allow( ''.strtolower($val->ROLE).'', ''.strtolower($val->RECURSO).'' );
            } else {
                $this->allow( ''.strtolower($val->ROLE).'', ''.strtolower($val->RECURSO).'', ''.strtolower($val->ACCION).'' );
            }
//            echo  ''.strtolower($val->ROLE).' ', ' '.strtolower($val->RECURSO).' ', ' '.strtolower($val->ACCION).'<br/>';
        }
        $this->allow('admin', null, 'delete');
    }
    
    
}