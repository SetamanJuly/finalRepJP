<?php 
use \Firebase\JWT\JWT;

class Controller_Canciones extends Controller_Base 
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
            if ( ! isset($_POST['nameSong'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name'
                ));

                return $json;
            }

            if ( ! isset($_POST['urlSong'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro url'
                ));

                return $json;
            }

            if ( ! isset($_POST['idsong'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro id'
                ));

                return $json;
            }

            $input = $_POST;
            $song = Model_Cancion::find($input['idsong']);
            $song->nameSong = $input['nameSong'];
            $song->urlSong = $input['urlSong'];
            $song->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'cancion modificada',
                'name' => $song->nameSong
            ));

            return $json;      
    }

    public function get_songs()
    {
        $song = Model_Cancion::find('all', ['select' => 'nameSong']);

        $json = $this->response(array(
            $song
        ));

        return $json;  
    }

    public function post_delete()
    {
        $song = Model_Cancion::find($_POST['id']);
        //$songName = $song->name;
        $song->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $song
        ));

        return $json;
    }
}
