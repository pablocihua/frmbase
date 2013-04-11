<?php

class Model_DbTable_Module extends Model_DataDb
{
    protected $_name       = 'modulo';
    protected $_primary    = 'id_modulo';
    
    public function getModuleById( $id ){
        $id = (int) $id;
        $query = $this->select()
                    ->from( array( 't0'=>  $this->_name ), array('t0.*'))
                    ->where('"t0"."' . $this->_primary . '" = ?', $id)
                
                    ->setIntegrityCheck(false);

        return $this->fetchAll( $query );
    }
    
    public function getAllModuleAsc(){
        $query = $this->select()
                    ->from( array( 't0'=>  $this->_name ), array('t0.*'))
                    ->order(array('t0.id_modulo ASC'))
                
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