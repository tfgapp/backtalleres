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



 if(empty($userName) || empty($pass)) {
    $mensaje= "Usuario o contraseña vacios";
            $mensajeJson = json_encode($mensaje);
            echo $mensajeJson; 
}
else{
    $usuario = $db->getUsuario($userName);
    if($usuario->user_name != "sin usuario"){
        if($usuario->pass == $pass){
            $mensaje= "Login" ;
            $mensajeJson = json_encode($mensaje);
            echo $mensajeJson; 
        }
    }
}



?>