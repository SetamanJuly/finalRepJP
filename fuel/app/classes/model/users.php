<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'users';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'name' => array(
            'data_type' => 'varchar'   
        ),
        'pass' => array(
            'data_type' => 'varchar'   
        )
    );

    protected static $_has_many = array(
    'list' => array(
        'key_from' => 'id',
        'model_to' => 'Model_List',
        'key_to' => 'id_user',
        'cascade_save' => true,
        'cascade_delete' => false,
    	)
    );
}
