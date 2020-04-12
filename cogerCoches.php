<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./coche.php");
    include_once("./registroCoche.php");
    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['userKey'];

    $coches = array();
    $coches = $db->getCochesUsuario($user_key);

    $exito = json_encode($coches);
    echo $exito;

?>