<?php
include_once("./bd.php");
include_once("./usuario.php");
include_once("./ofertas.php");
include_once("./iniciarbd.php");
global $db;


$json = file_get_contents('php://input');
$obj = json_decode($json,true);

 $userName = $obj['nombre'];
 $pass = $obj['pass'];



 if(empty($userName) || empty($pass)) 
 {
    $mensaje= array("Usuario o contraseña vacios");
            $mensajeJson = json_encode($mensaje);
            echo $mensajeJson; 
}
else{
    $usuario = $db->getUsuario($userName);
    $coches = $db->getCochesUsuario($usuario->user_key);
    if($usuario->user_name != "sin usuario"){
        if($usuario->pass == $pass){
            $mensaje= array("Login", $usuario->user_key,$coches);
            $mensajeJson = json_encode($mensaje);
            echo $mensajeJson; 
        }
    }
}
?>