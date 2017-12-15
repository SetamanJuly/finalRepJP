<?php 
use \Firebase\JWT\JWT;

class Controller_Base extends Controller_Rest 
{   
    protected function checkToken()
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];        
        $tokenDecodificado = JWT::decode($token, "TextKey", array('HS256'));

        return $tokenDecodificado->id;
    }
}
