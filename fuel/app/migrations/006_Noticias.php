<?php

namespace Fuel\Migrations;

class Noticias
{

    function up()
    {
        \DBUtil::create_table('noticias', 
            array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'tituloNoticia' => array('type' => 'text'),
            'descripcion' => array('type' => 'text'),
            'id_user' => array('type' => 'int'),
            ), 
            array('id'), false, 'InnoDB', 'utf8_general_ci',
            array(
		        array(
		            'constraint' => 'foreignkeyNoticiasAUsuarios',
		            'key' => 'id_user',
		            'reference' => array(
		                'table' => 'users',
		                'column' => 'id',
		            ),
		            'on_update' => 'RESTRICT',
		            'on_delete' => 'RESTRICT'
		        )
			)
        );
    }

    function down()
    {
       \DBUtil::drop_table('noticias');
    }
}
