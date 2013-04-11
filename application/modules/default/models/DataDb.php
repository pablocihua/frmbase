<?php

class Model_DataDb extends Zend_Db_Table_Abstract
{


    /* con esta función es donde especificas con que base de datos trabajar en este DbTable */
    /*protected function _setupDatabaseAdapter() {
        $this->_db = Zend_Registry::get( 'Pdo_Mysql' ); //esto indica el nombre que se le puso a la conexion
        $this->_db->setFetchMode(Zend_Db::FETCH_OBJ);
        parent::_setupDatabaseAdapter();
    }*/

    public function getAll(){
        return $this->fetchAll();
    }
    
    public function save( $data, $id = null ){
        $result = false;

        if( is_null( $id ) ){
            $result = $this->dbInsert( $data );

            if( $result ){
                $result = $this->dbLastInsert( $this->_name );
            } else {
                // No action
            }
        } else {
            $id          = (int) $id;
            $result    = $this->dbUpdate( $data, $this->_primary . ' = ' . $id );

            if( $result ){
                $result = $id;
            } else {
                // No action
            }
        }

        return $result;
    }
    
    public function del( $id = null ){

        $id        = (int) $id;
        $return    = false;
        if( !is_null( $id ) ){

                $row    = $this->getRow( $id );
                if( $row ){

                    $return    = $row->delete();
                } else {
                    // No action
                }
        } else {
            // No action
        }
        
        return $return;
    }

    public function getRow( $id ){
        $id = (int) $id;
        $row = $this->find( $id )->current();
        
        return $row;
    }
    
    public function getRowForeingKey( $id, $foreykey ){
        $query = $this->select()
                    ->from( array('t0' => $this->_name ), array('t0.*'))
                    ->where('"t0"."' . strtoupper($foreykey ) . '" = ?', $id)
                
                    ->setIntegrityCheck(false);
        $rowset = $this->_fetch( $query );

        $data = array();
        if ( is_array( $rowset ) && count( $rowset ) ){
            foreach( $rowset[0] as $key => $row ){
                $data[$key] = $row;
            }
        } else {
            // No action
        }

        return $data;
    }
    
    public function getEntityById( $id ){
        $query = $this->select()
                    ->from( array( 't0'=>  $this->_name ), array('t0.*'))
                    ->where('t0.' . $this->_primary . ' = ?', $id)
                
                    ->setIntegrityCheck(false);

        return $this->fetchAll( $query );
    }
    
    public function getResultQuery( $query ){

        return $this->_db->fetchAll( $query );
    }
    
    
    
    public function dbInsert( $data ){
        return $this->_db->insert( $this->_name, $data );
    }
    
    public function dbUpdate( $data, $where ){
        return $this->_db->update( $this->_name, $data, $where );
    }
    
    public function dbDelete( $where ){
        return $this->_db->delete( $this->_name, $where );
    }
    
    public function dbLastInsert( ){
        # die("Select GEN_ID(GEN_{$this->_name}_ID, 0) ID FROM rdb\$database");
        $rowset = $this->_db->fetchAll( "Select GEN_ID(GEN_{$this->_name}_ID, 0) LAST_ID From rdb\$database" );
        $data = 0;
        foreach( $rowset as $row ){
            $data = $row->LAST_ID;
        }

        return (int) $data;
    }
    
    public function getJSon( $data, $criterion ){

        $contador    = 0;
        $jSon           = '[{ "label" : "", "value" : { "criterion" : "", "id" :  "", "id2" :  ""} },';
        foreach ($data as $id => $valor) {
                if( strpos( strtolower($valor['criterion']), strtolower($criterion) ) !== false ){
                        // agregamos esta linea porque cada elemento debe estar separado por una coma
                        if ($contador++ > 0) $jSon .= ", ";
                        $jSon .= "{
                                 \"label\" : \"{$valor['criterion']}\", 
                                        \"value\" : { \"criterion\" : \"{$valor['criterion']}\", \"id\" : {$valor['id']}, \"id2\" : {$valor['id2']} } }";
                } else {
                    // No action
                }
        } // siguiente item
        $jSon .= ']';

        return $jSon;
    }
    

}