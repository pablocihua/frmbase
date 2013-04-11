<?php

class Model_DbTable_Recurso extends Model_DataDb
{
    protected $_name = 'recurso';
    protected $_primary = 'id_recurso';
    
    
    public function getAllResource(){
        $query = $this->select()
                ->from(array('t0' => 'recurso'), array('t0.id_recurso', 't0.recurso' ))
                ->join(array('t1'=>'modulo'), 't1.id_modulo = t0.id_modulo', array('t1.id_modulo', 't1.modulo'))
                ->order('t0.id_modulo Asc')
                ->setIntegrityCheck(false);
//die($query);
        return $this->fetchAll( $query );
    }
    
    public function getAllResourceAllows( $id ) {
        
        $query = $this->select()
                    ->from( array( 't0'=>'recurso' ), array('t0.id_recurso', 't0.recurso', 'son' => new Zend_Db_Expr('count("t0"."id_recurso")')))
                    ->join( array( 't2'=>'modulo' ), '"t2"."id_modulo" = "t0"."id_modulo"', array('t2.id_modulo', 't2.modulo'))
                    ->join( array( 't1' =>'permite'), '"t1"."id_recurso" = "t0"."id_recurso"', array() )
                    ->where( '"t1"."id_role"  In (Select id_role From users Where id_user = ?)', $id)
                    ->group( array('t0.id_recurso', 't0.recurso'))

                    ->setIntegrityCheck(false);

        return $this->fetchAll( $query );
    }
}