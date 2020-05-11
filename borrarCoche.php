<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./coche.php");
    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['user_key'];
    $indice = $obj['indice'];

    $db->borrarCoche($user_key, $indice);
    $coches = $db->getCochesUsuario($user_key);
    $exito = json_encode(array("El coche ha sido borrado",$coches));
    echo $exito;
?>