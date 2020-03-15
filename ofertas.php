<?php

class Oferta{

    public $imagen;
    public $titulo;
    public $descripcion;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function __destruct()
    {
        
    }
    public function setAllParameters($imagen, $titulo, $descripcion){
        $this->imagen = $imagen;
        $this->titulo =$titulo;
        $this->descripcion = $descripcion;
    }
   
}