<?php 
use \Firebase\JWT\JWT;

class Controller_Canciones extends Controller_Rest 
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

            if ( ! isset($_POST['urlS'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro url'
                ));

                return $json;
            }

            $input = $_POST;
            $song = new Model_Cancion();
            $song->nameSong = $input['name'];
            $song->urlSong = $input['urlS'];
            $song->save();

            $json = $this->response(array(
                'code' => 201,
                'message' => 'Cancion creada',
                'name' => $input['name'],
                'url' => $input['urlS']
            ));

            return $json;

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

    public function post_modify()
    {
        //try {
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

            if ( ! isset($_POST['iduser'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
                ));

                return $json;
            }

            $input = $_POST;
            $user = Model_Users::find($input['iduser']);
            $user->name = $_POST['name'];
            $user->pass = $_POST['pass'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario modificado',
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
            'pass' => $showP
        ));

        return $json;  
    }

    public function post_delete()
    {
        $user = Model_Users::find($_POST['id']);
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
