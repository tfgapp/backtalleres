<?php
    include_once("./bd.php");
    include_once("./iniciarbd.php");
    include_once("./cocheEspecificaciones.php");
    global $db;

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $user_key = $obj['user_key'];
    $indice = $obj['indice'];
    $euros = $obj['euros'];
    $litros = $obj['litros'];
    $kilometros_totales = $obj['kilometros_totales'];

    $especificaciones = new CocheEspecificaciones($db);
    $especificaciones->setAllParameters($user_key, $indice, $euros, $litros, $kilometros_totales,0);
    $db->updateEspecificacionesCoche($especificaciones);
    $especificaciones->setMediaLK();
    $especificaciones->setMediaEK();
    $especificaciones->setMediaEL();

    $exito = json_encode(array("Correcto",$especificaciones));
    echo $exito;
?>
