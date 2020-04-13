<?php

class CocheEspecificaciones
{
    public $user_key = "";
    public $indice = null;
    public $euros = "";
    public $litros = "";
    public $kilometros_totales = "";
    public $kilometros_inicio = "";
    public $mediaLK = "";
    public $mediaEK = "";
    public $mediaEL = "";


    public $db = "";

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function __destruct()
    {
    }
    public function setAllParameters($user_key, $indice, $euros, $litros, $kilometros_totales,$kilometros_inicio)
    {
        $this->user_key = $user_key;
        $this->indice =$indice;
        $this->euros = $euros;
        $this->litros = $litros;
        $this->kilometros_totales = $kilometros_totales;
        $this->kilometros_inicio = $kilometros_inicio;
    }
    public function setMediaLK(){
    	if($this->kilometros_totales-$this->kilometros_inicio != 0){
    	 $this->mediaLK = $this->litros/($this->kilometros_totales-$this->kilometros_inicio);
    	}
    	else{
    	$this->mediaLK = 0;
    	}return 0;
    }
    public function setMediaEK(){
    	if($this->kilometros_totales-$this->kilometros_inicio != 0){
    	$this->mediaEK =  $this->euros/($this->kilometros_totales-$this->kilometros_inicio);
    	}
    	else{
    	$this->mediaEK = 0;
    	}
    }
    public function setMediaEL(){
    	if($this->litros != 0){
    	$this->mediaEL =  $this->euros/$this->litros;
    	}
    	else{
    	$this->mediaEL = 0;
    	}
    }
}

?>
