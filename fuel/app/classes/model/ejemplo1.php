<?php

namespace Model;

class Model_Ejemplo1 extends \Model {

    public static function get_results()
    {
    	$usuarios = DB::query('SELECT * FROM users');
    	return usuarios;
    }

    public static function create_user($name)
    {
    	DB::query('INSERT INTO users (name) VALUES $name');
    	return "ok";
    }

    public static function delete_user($id)
    {
    	DB::query('DELETE FROM users (id) WHERE id = $id');
    	return "ok2";
    }
}