<?php

namespace Fuel\Migrations;

class Users
{

    function up()
    {
        \DBUtil::create_table('users', 
            array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
            'name' => array('type' => 'text'),
            'email' => array('type' => 'text'),
            'pass' => array('type' => 'text'),
            'id_rol' => array('type' => 'int')
            ), 
            array('id'), false, 'InnoDB', 'utf8_general_ci',
            array(
                array(
                    'constraint' => 'foreignkeyUsuariosARoles',
                    'key' => 'id_rol',
                    'reference' => array(
                        'table' => 'roles',
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
       \DBUtil::drop_table('users');
    }
}
