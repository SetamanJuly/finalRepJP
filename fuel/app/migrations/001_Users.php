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
            ), 
            array('id'), false, 'InnoDB', 'utf8_general_ci');
    }

    function down()
    {
       \DBUtil::drop_table('users');
    }
}
