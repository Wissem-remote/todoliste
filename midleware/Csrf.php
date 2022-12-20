<?php

class Csrf{
    private $token;

    public function __construct(){
        if(empty($_SESSION['token'])){
            $this->token= hash('sha256', random_bytes(32)); 
            session_start();
            $_SESSION['token'] = $this->token;
        }else{
            $this->token = $_SESSION['token'];
        }
    

    }
    public function getToken()
    {
        return $this->token;
    }
    
}