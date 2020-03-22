<?php
include_once("./bd.php");
include_once("./usuario.php");
include_once("./ofertas.php");
include_once("./iniciarbd.php");

 $userName = $_POST['nombre'];
 $pass = $_POST['pass'];
 global $db;
 if(!empty($userName) && !empty($pass)) {
    throw new Exception ('Usuario o contraseñas vacio');
}
else{
    if()
}
?>


?>