<?php 

class Model_Notiticas extends Orm\Model
{
    protected static $_table_name = 'noticias';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', 
        'tituloNoticia' => array(
            'data_type' => 'varchar'   
        ),
        'descripcion' => array(
            'data_type' => 'varchar'   
        ),
        'id_user' => array(
            'data_type' => 'int'   
        )
    );
   
    protected static $_belongs_to = array(
    'user' => array(
        'key_from' => 'id_user',
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
        )
    );
}
