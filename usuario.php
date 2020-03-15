<?php

class Usuario{

    public $nombre;
    public $apellido;
    public $user_name;
    public $pass;
    public $correo;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function __destruct()
    {
    
    }
    public function setAllParameters($user_name, $pass, $nombre,$apellido,$correo){
        $this->nombre = $nombre;
        $this->apellido =$apellido;
        $this->user_name = $user_name;
        $this->pass = $pass;
        $this->correo = $correo;
    }
   
}