<?php


include_once("./bd.php");
include_once("./usuario.php");
include_once("./ofertas.php");
include_once("./iniciarbd.php");
$json = file_get_contents('php://input');
 
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);
 $userName = $obj['user'];
 $pass = $obj['password'];
 $email = $obj['email'];
 global $db;
 
$usuario = $db->getUsuario($userName);

/*email: email,
user:user,
password:password*/
$checkUsuario = mysqli_fetch_array($usuario);
if(isset($userName)&&isset($pass)&&isset($email)){
    $usuario = $db->getUsuario($userName);

    
    $checkUsuario = mysqli_fetch_array($usuario);
    if(!isset($checkUsuario)){
        
        $objUsuario = new Usuario($db);
        $objUsuario->setAllParameters($userName,$pass," "," ",$email);
        
        $MensajeDeOk = 'El usuario ha sido creado';
        $SuccessOkJson = json_encode($MensajeDeOk);
        echo $SuccessOkJson; 
        
    }
    else{
        $mensajeDeFallo = 'Nombre de usuario existente';
        $failJson = json_encode($mensajeDeFallo);
        echo $failJson; 
    
    }
}
else{

    $mensajeDeFallo = 'Parametros requeridos  completados';
    $failJson = json_encode($mensajeDeFallo);
    echo $failJson; 

}

 
?>


?>