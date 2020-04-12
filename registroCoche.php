<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./coche.php");
    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['userKey'];
    $nombre = $obj['nombre'];
    $marca = $obj['marca'];
    $tipo = $obj['tipo'];

    $coches = array();
    $coches = $db->getCochesUsuario($user_key);

    $db->crearCocheUsuario($user_key, $nombre, $marca, $tipo);
    $exito = json_encode(array("El coche ha sido creado",$coches));
    echo $exito;

?>