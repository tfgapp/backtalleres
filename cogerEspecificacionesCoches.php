<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./cocheEspecificaciones.php");

    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['user_key'];
    $indice = $obj['indice'];

    $coche = $db->getEspecificacionesCoche($user_key, $indice);

    if($coche == "No se encuentra el coche")
    {	
		$exito = json_encode(array("No existe el coche"));
		echo $exito;
    }
   else
   {
		$exito = json_encode(array("El coche existe",$coche));
		echo $exito;
	}

?>