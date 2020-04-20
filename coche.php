<?php

class Coche
{
    public $user_key = "";
    public $indice = null;
    public $nombre = "";
    public $marca = "";
    public $tipo = "";
    public $db = "";

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function __destruct()
    {
    }
    public function setAllParameters($user_key, $indice, $nombre, $marca, $tipo)
    {
        $this->user_key = $user_key;
        $this->indice =$indice;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->tipo = $tipo;
    }
}
?>
