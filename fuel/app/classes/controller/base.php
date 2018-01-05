<?php 
use \Firebase\JWT\JWT;

class Controller_Base extends Controller_Rest 
{   
    protected function keyName(){
        $_key = "TextKey";
        return $_key;
    }

    protected function checkToken()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];    
        $key = self::keyName();    
        $tokenDecodificado = JWT::decode($token, $key, array('HS256'));

        return $tokenDecodificado->id;
    }

    protected function createToken($name, $pass, $id)
    {
        $token = array(
            "name" => $name,
            "pass" => $pass,
            "id" => $id,
            "logged" => true
        );
        
        $key = self::keyName(); 
        $jwt = JWT::encode($token, $key);

        return $jwt;  
    }

    public function post_create()
    {
        try {
            if ( ! isset($_POST['descripcion'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro que describa el rol',
                    'data' => null
                ));

                return $json;
            }

            $input = $_POST;
            $rol = new Model_Roles();
            $rol->descripcion = $input['descripcion'];
            $rol->save();

            $json = $this->response(array(
                'code' => 201,
                'message' => 'rol creado',
                'data' => $rol
            ));

            return $json;
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
}
