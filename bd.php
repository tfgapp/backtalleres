<?php
include_once("./usuario.php");
include_once("./ofertas.php");

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
        $query = "INSERT INTO users(nombre, apellido, correo, nom_usuario, pass) VALUES
         ( '$usuario->nombre','$usuario->apellido','$usuario->correo','$usuario->user_name','$usuario->pass')";
        return $this->executeQuery($query);
    }
    public function getUsuario($name){
        $query = "SELECT nombre, apellido, correo, nom_usuario, pass FROM users WHERE nom_usuario = '$name'";
        $users = $this->executeQuery($query);
        $pre= mysqli_fetch_array($users);
        $usuario = new Usuario($this->db);
        if($pre != NULL){$usuario->setAllParameters($pre["nom_usuario"],$pre["pass"],$pre["nombre"],$pre["apellido"],$pre["correo"]);}
        else{@$usuario->setAllParameters("sin usuario",$pre["pass"],$pre["nombre"],$pre["apellido"],$pre["correo"]);}
        return $usuario;
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
}
?>
