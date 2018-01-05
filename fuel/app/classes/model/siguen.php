<?php 

class Model_Contiene extends Orm\Model
{
    protected static $_table_name = 'siguen';
    protected static $_primary_key = array('id_seguido','id_seguidor');
    protected static $_properties = array(
        'id_seguido' => array(
            'data_type' => 'int'   
        ),
        'id_seguidor' => array(
            'data_type' => 'int'   
        )
    ); 
}
