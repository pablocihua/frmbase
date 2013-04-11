<?php

class Model_DbTable_Role extends Model_DataDb
{
    protected $_name       = 'role';
    protected $_primary    = 'id_role';
    
    public function getRoleById( $id ){
        $id = (int) $id;
        $query = $this->select()
                    ->from( array( 't0'=>  $this->_name ), array('t0.*'))
                    ->where('t0.id_role = ?', $id)
                
                    ->setIntegrityCheck(false);

        return $this->fetchAll( $query );
    }
    
    public function getAllRoleAsc(){
        $query = $this->select()
                    ->from( array( 't0'=>  $this->_name ), array('t0.*'))
                    ->order(array('t0.nivel ASC'))
                
                    ->setIntegrityCheck(false);

        return $this->fetchAll( $query );
    }
    
    public function getAsKeyValue() {
        $rowset = $this->fetchAll();
        $data = array();
        
        foreach( $rowset as $row ){
            $data[$row->id_role] = $row->role;
        }

        return $data;
    }
    
    
}