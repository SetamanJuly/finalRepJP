<?php

namespace Fuel\Migrations;

class Siguen
{

    function up()
    {
        \DBUtil::create_table('siguen', 
            array(
            'id_seguido' => array('type' => 'int'),
            'id_seguidor' => array('type' => 'int'),
            ), 
            array('id_seguido','id_seguidor'), false, 'InnoDB', 'utf8_general_ci',
            array(
		        array(
		            'constraint' => 'foreignkeySeguidorASeguido',
		            'key' => 'id_seguido',
		            'reference' => array(
		                'table' => 'users',
		                'column' => 'id',
		            ),
		            'on_update' => 'RESTRICT',
		            'on_delete' => 'RESTRICT'
		        ),
                array(
                    'constraint' => 'foreignkeySeguidoASeguidor',
                    'key' => 'id_seguidor',
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
       \DBUtil::drop_table('siguen');
    }
}
