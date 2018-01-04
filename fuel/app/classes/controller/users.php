<?php 
use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Base 
{   
    public function post_create()
    {
        try {
            if ( ! isset($_POST['name'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name'
                ));

                return $json;
            }

            if ( ! isset($_POST['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass'
                ));

                return $json;
            }

            $check = Model_Users::find('all', ['where' => ['name' => $_POST['name']]]);
			
			$boolTested;

	        if ($check == null){
	        	$boolTested = false;
	        }else{
	        	$boolTested = true;
	        }

            if ($boolTested == false){
	            $input = $_POST;
	            $user = new Model_Users();
		    //$user -> list = Model_List::find(id)
	            $user->name = $input['name'];
	            $user->pass = $input['pass'];
	            $user->save();

	            $json = $this->response(array(
	                'code' => 201,
	                'message' => 'usuario creado',
	                'name' => $input['name'],
	                'pass' => $input['pass']
	            ));

	            return $json;
            }else{
            	$json = $this->response(array(
	                'code' => 204,
	                'message' => 'el usuario ya existe'
	            ));

	            return $json;
            }

        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        }        
    }

    public function checkUserExist($nameToCheck)
    {
        $users = Model_Users::find('all', ['where' => ['name' => $nameToCheck]]);

        if ($users == null){
        	return false;
        }else{
        	return true;
        }
    }

    public function post_modify()
    {
            if ( ! isset($_POST['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass'
                ));

                return $json;
            }

            $input = $_POST;
            $idUser = self::checkToken();
            $user = Model_Users::find($idUser);
            $user->pass = $_POST['pass'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'contraseña modificada',
                'name' => $user
            ));

            return $json;      
    }

    public function get_login()
    {
        try {
            if ( ! isset($_GET['name'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se name'
                ));

                return $json;
            }

            if ( ! isset($_GET['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass'
                ));

                return $json;
            }

            $users = Model_Users::find('all', ['where' => ['name' => $_GET['name'], 'pass' => $_GET['pass']]]);

            foreach ($users as $key => $value) {
                $id = $value->id;
            }

            if ($users == null){
                $json = $this->response(array(
                    'code' => 401,
                    'message' => 'usuario o contraseña incorrecto'
                ));
                return $json;
            }else{
                $key = "TextKey";
                $token = array(
                    "name" => $_GET['name'],
                    "pass" => $_GET['pass'],
                    "id" => $id,
                    "logged" => true
                );
                
                $jwt = JWT::encode($token, $key);

                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'Logeado',
                    'token' => $jwt                
                ));
                return $json;  
            }

        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        }                       
    }

    public function get_users()
    {
        $users = Model_Users::find('all', ['select' => 'name']);

        foreach ($users as $key => $value) {
                $show[] = $value->name;
                $showID[] = $value->id;
        }
        $test = self::checkToken();
        $json = $this->response(array(
            'name' => $show,
            'id' => $showID,
            'bolean' => $test
        ));

        return $json;  
    }

    public function get_singleuser()
    {
        $users = Model_Users::find('all', ['where' => ['id' => $_GET['id']]]);

        foreach ($users as $key => $value) {
                $show[] = $value->name;
                $showP[] = $value->pass;
        }

        $json = $this->response(array(
            'name' => $show,
            'pass' => $showP
        ));

        return $json;  
    }

    public function post_delete()
    {
    	$idABorrar = self::checkToken();
        $user = Model_Users::find($idABorrar);
        $userName = $user->name;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName
        ));

        return $json;
    }
}
