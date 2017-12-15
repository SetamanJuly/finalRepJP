<?php 

class Model_List extends Orm\Model
{
    protected static $_table_name = 'list';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'nameList' => array(
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
        'cascade_save' => true,
        'cascade_delete' => false,
        )
    );

    protected static $_many_many = array(
    'list' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_cancion', // column 1 from the table in between, should match a posts.id
        'table_through' => 'list_cancion', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_lista', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Cancion',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
        )
    );
}
