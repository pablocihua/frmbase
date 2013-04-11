<?php

class Posts_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{
    protected $_name = 'posts';
    protected $_primary = 'id';
    
    public function getAll(){
        return $this->fetchAll();
    }
    
    public function save( $bind ){
        $row = $this->createRow();
        $row->setFromArray( $bind );
        
        return $row->save();
    }
}