<?php

class Model_DbTable_Permite extends Model_DataDb
{
    protected $_name       = 'permite';
    protected $_primary    = 'id_permite';
    
    public function getAllPermissionAllows( ){
        
        $query = $this->select()
                    ->from( array( 't0'=>'permite' ), array('t0.id_role', 't0.permission'))
                    ->join(array( 't3' =>'role'), 't3.id_role = t0.id_role', array('t3.role') )
                    ->join(array( 't2' =>'recurso'), 't2.id_recurso = t0.id_recurso', array('t2.id_recurso', 't2.recurso') )
                    ->join( array('t4'=>'modulo' ), 't4.id_modulo = t2.id_modulo', array('t4.id_modulo', 't4.modulo'))
                    ->join(array( 't1' =>'accion'), 't1.id_accion = t0.id_accion', 
                            array('id_accion' => 't1.id_accion', 'accion'=>'t1.accion') )
                    #->where('"t0"."ID_ESTATUS" = ?', 1)
                    ->order(array('t3.nivel', 't2.recurso'))
                
                    ->setIntegrityCheck(false);
//die($query);
        return $this->fetchAll( $query );
    }
    
    
}