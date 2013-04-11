<?php

class Model_DbTable_LibraryAcl extends Zend_Acl
{
    public function __construct() {
        
        $role           = new Model_DbTable_Role();
        $module         = new Model_DbTable_Module();
        $resource       = new Model_DbTable_Recurso();
        $permission     = new Model_DbTable_Permite();

        $i              = 0;
        $roleCurrent    = '';
        $row            = $role->getAllRoleAsc();
        foreach( $row as $val ){
            if ( $i == 0 ){
                $this->addRole( new Zend_Acl_Role( strtolower($val->role) ) );
            } else {
                $this->addRole( new Zend_Acl_Role( strtolower($val->role) ), $roleCurrent );
            }

            $roleCurrent = strtolower( $val->role );
            $i++;
        }
        unset($row);

        $row           = $resource->getAllResource();
        $rowModules    = $module->getAllModuleAsc();
        foreach( $rowModules as $value ){
            $this->add( new Zend_Acl_Resource( strtolower($value->modulo) ) );
            foreach( $row as $val ){
                if( $val->modulo == $value->modulo ){
                    $this->add( new Zend_Acl_Resource( strtolower($value->modulo ) . ':'. strtolower($val->recurso ) ), strtolower($value->modulo));
                } else {
                    // No action
                }
            }
        }
        unset($row);

        $row    = $permission->getAllPermissionAllows();
        $this->deny();
        foreach( $row as $val ){
            if( $val->permission ){
                $this->allow( strtolower($val->role), strtolower($val->modulo) . ':' . strtolower($val->recurso), strtolower($val->accion) );
//                echo 'allow: ' . strtolower($val->role) .', '. strtolower($val->modulo) . ':'. strtolower($val->recurso) .', '. strtolower($val->accion) . '<br/>';
            } else {
                $this->deny( strtolower($val->role), strtolower($val->modulo) . ':' . strtolower($val->recurso), strtolower($val->accion) );
//                echo 'deny: ' . strtolower($val->role) .', '. strtolower($val->modulo) . ':'. strtolower($val->recurso) .', '. strtolower($val->accion) . '<br/>';
            }
        }
    }
}