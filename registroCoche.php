<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./coche.php");
    include_once("./cocheEspecificaciones.php");
    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['userKey'];
    $nombre = $obj['nombre'];
    $marca = $obj['marca'];
    $tipo = $obj['tipo'];

    $coches = array();
    $db->crearCocheUsuario($user_key, $nombre, $marca, $tipo);
    $coches = $db->getCochesUsuario($user_key);

	$indice = "";
    foreach ($coches as $coche) 
    {
       if ($coche->nombre == $nombre && $coche->marca == $marca && $coche->tipo == $tipo) 
           $indice = $coche->indice;
   	}


    $especificaciones = new CocheEspecificaciones($db);
    $especificaciones->setAllParameters($user_key, $indice, 0, 0, 0, 0);
    $db->updateEspecificacionesCoche($especificaciones);


    
    $exito = json_encode(array("El coche ha sido creado",$coches));
    echo $exito;

?>