<?php
include_once("./usuario.php");
include_once("./ofertas.php");
include_once("./coche.php");


class Database{
 
    protected $url;
    protected $user;
    protected $password;
    protected $db;
    protected $connection = null;

    public function __construct($url, $user, $password, $db)
    {
        $this->url = $url;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }
    public function __destruct()
    {
        if($this->connection != null){
            $this->closeConnection();
        }
    }
    public function makeConnection(){
        $this->connection = new mysqli($this->url, $this->user, $this->password, $this->db);
        if($this->connection->connect_error){
            echo "Fail" . $this->connection->connect_error;
        }
    }
    protected function closeConnection(){
        if($this->connection != null){
            $this->connection->close();
            $this->connection = null;
        }
    }
    public function executeQuery($query, $params = null){
        // Is there a DB connection?
        $this->makeConnection();
        // Adjust query with params if available
        if($params != null){
            // Change ? to values from parameter array
            $queryParts = preg_split("/\?/", $query);
            // if amount of ? is not equal to amount of values => error
            if(count($queryParts) != count($params) + 1){
                return false;
            }
            // Add first part
            $finalQuery = $queryParts[0];
            // Loop over all parameters
            for($i = 0; $i < count($params); $i++){
                // Add clean parameter to query
                $finalQuery = $finalQuery . $this->cleanParameters($params[$i]) . $queryParts[$i + 1];
            }
            $query = $finalQuery;
        }
        // Check for SQL injection

        $result = $this->connection->query($query);
        return $result;
    }
    protected function cleanParameters($parameters){
        // prevent SQL injection
        $result = $this->connection->real_escape_string($parameters);
        return $result;
    }
    public function insertUsuario($usuario){
        $query = "INSERT INTO users(user_key, nombre, apellido, correo, nom_usuario, pass) VALUES
         ( '$usuario->user_key', '$usuario->nombre','$usuario->apellido','$usuario->correo','$usuario->user_name','$usuario->pass')";
        return $this->executeQuery($query);
    }
    public function getUsuario($name){
        $query = "SELECT user_key, nombre, apellido, correo, nom_usuario, pass FROM users WHERE nom_usuario = '$name'";
        $users = $this->executeQuery($query);
        $pre= mysqli_fetch_array($users);
        $usuario = new Usuario($this->db);
        if($pre != NULL){$usuario->setAllParameters($pre["user_key"],$pre["nom_usuario"],$pre["pass"],$pre["nombre"],$pre["apellido"],$pre["correo"]);}
        else{@$usuario->setAllParameters($pre["user_key"], "sin usuario",$pre["pass"],$pre["nombre"],$pre["apellido"],$pre["correo"]);}
        return $usuario;
    }
   
    public function getCochesUsuario($user_key)
    {
        $query = "SELECT user_key,indice, nombre, marca, tipo FROM coches WHERE user_key ='$user_key'";
        $pre = $this->executeQuery($query);
        if($pre->num_rows > 0)
        {
            $coches = array();
            while($row = mysqli_fetch_array($pre))
            { 
                $userkey2 = $row['user_key'];
                $indice = $row['indice'];
                $nombre = $row['nombre'];
                $marca = $row['marca'];
                $tipo = $row['tipo'];
                $coche = new Coche($this->db);
                $coche->setAllParameters($userkey2, $indice, $nombre, $marca, $tipo);
                array_push($coches, $coche);
            }
            return $coches;  
        }
        else
        {
            return("No hay coches que mostrar");
        } 
    }
    public function crearCocheUsuario($user_key, $nombre, $marca, $tipo)
    {
        $query = "INSERT INTO coches(user_key, nombre, marca, tipo) VALUES ( '$user_key', '$nombre','$marca','$tipo')";
        $pre = $this->executeQuery($query);
    }
    public function deleteUsuario($name){
        $query = "DELETE FROM users WHERE nom_usuario == ". $name;
        $this->executeQuery($query); 
    }
    public function getOferta($oferta){
        $query = "SELECT titulo, imagen, descripcion FROM ofertas WHERE titulo =". $oferta;
        $pre = mysqli_fetch_array($this->executeQuery($query), MYSQL_BOTH);
        $oferta = new Oferta($this->db);
        $oferta->setAllParameters(base64_decode($pre["imagen"]),$pre["titulo"],$pre["descripcion"]);
        return $oferta;
    }
     public function updateEspecificacionesCoche($especificaciones)
    {
    	if($this->getEspecificacionesCoche($especificaciones->user_key, $especificaciones->indice) != "No hay coches que mostrar")
    	{
        $query = "UPDATE especificaciones SET euros = '$especificaciones->euros', litros = '$especificaciones->litros', 'kilometros_totales' = $especificaciones->kilometros_totales  WHERE indice = $especificaciones->indice";
        $pre = $this->executeQuery($query);
		}
        else
        {
        	$query = "INSERT INTO especificaciones (indice, euros, litros, kilometros_totales, kilometros_inicio) VALUES ('$especificaciones->indice','$especificaciones->euros','$especificaciones->litros','$especificaciones->kilometros_totales','$especificaciones->kilometros_totales')";
            $pre = $this->executeQuery($query);
        }
    }
     public function getEspecificacionesCoche($user_key, $indice)
    {
        $query = "SELECT euros, litros, kilometros_totales, kilometros_inicio FROM especificaciones WHERE indice ='$indice'";
        $p = $this->executeQuery($query);
        if(@$p->num_rows > 0)
        {   
            $pre= mysqli_fetch_array($p);
            $coche = new CocheEspecificaciones($this->db);
            $coche->setAllParameters($user_key, $indice, $pre['euros'], $pre['litros'], $pre['kilometros_totales'], $pre['kilometros_inicio']);
            $coche->setMediaLK();
            $coche->setMediaEK();
            $coche->setMediaEL();
            return $coche;  
        }
        else
        {
            return("No se encuentra el coche");
        } 
    } 

}
?>
