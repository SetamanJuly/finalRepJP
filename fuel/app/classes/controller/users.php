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
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name',
                    'data' => null
                ));

                return $json;
            }

            if ( ! isset($_POST['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass',
                    'data' => null
                ));

                return $json;
            }

            if ( ! isset($_POST['email'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro email',
                    'data' => null
                ));

                return $json;
            }

            if ( ! isset($_POST['rol'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro rol',
                    'data' => null
                ));

                return $json;
            }

            $checkUsername = Model_Users::find('all', ['where' => ['name' => $_POST['name']]]);
			
            $checkEmail = Model_Users::find('all', ['where' => ['email' => $_POST['email']]]);

			$boolTested;

	        if ($checkUsername == null && $checkEmail == null){
	        	$boolTested = false;
	        }else{
	        	$boolTested = true;
	        }

            if ($boolTested == false){
	            $input = $_POST;
	            $user = new Model_Users();
	            $user->name = $input['name'];
	            $user->pass = $input['pass'];
	            $user->email = $input['email'];
                $user->id_rol = $input['rol'];
	            $user->save();

	            $json = $this->response(array(
	                'code' => 201,
	                'message' => 'usuario creado',
	                'data' => $user
	            ));

	            return $json;
            }else{
            	$json = $this->response(array(
	                'code' => 204,
	                'message' => 'el usuario ya existe',
                    'data' => null
	            ));
	            return $json;
            }

        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
                'data' => null
            ));

            return $json;
        }        
    }

    public function post_modify()
    {
            if ( ! isset($_POST['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass',
                    'data' => null
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
                'data' => $user
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
                    'message' => 'parametro incorrecto, se necesita que el parametro se name',
                    'data' => null
                ));

                return $json;
            }

            if ( ! isset($_GET['pass'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame pass',
                    'data' => null
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
                    'message' => 'usuario o contraseña incorrecto',
                    'data' => null
                ));
                return $json;
            }else{
            	$token = self::createToken($_GET['name'],$_GET['pass'],$id);  
                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'Logeado',
                    'token' => $token           
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
        $json = $this->response(array(
            'name' => $show,
            'id' => $showID
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
            'pass' => $showP,
            'data' => null
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
            'data' => $userName
        ));

        return $json;
    }
}
