<?php
class Database
{
    private $host = "localhost:3307";
    private $db_name = "servicio_autobuses";
    private $username = "root";
    private $password = "";
    public $conn;


    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


class Rol
{
    private $conn;
    private $table_name = "roles";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerRoles()
    {
        $query = "SELECT ID, Tipo_De_Rol FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}


class Estacion
{
    private $conn;
    private $table_name = "estaciones";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerEstaciones()
    {
        $query = "SELECT ID, Nombre FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}


class TrabajadoresInfo
{
    private $db;
    private $estacion;
    private $rol;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->estacion = new Estacion($this->db);
        $this->rol = new Rol($this->db);
    }

    public function obtenerEstaciones()
    {
        return $this->estacion->obtenerEstaciones();
    }

    public function obtenerRoles()
    {
        return $this->rol->obtenerRoles();
    }

    public function procesarFormulario($data)
    {
        $sql = "INSERT INTO trabajadores (Cedula, Contrasena, Nombre, Apellido1, Apellido2, Correo_Electronico, Salario, Estacion_ID, Rol_ID) 
                VALUES (:cedula, :contrasena, :nombre, :apellido1, :apellido2, :correo_electronico, :salario, :estacion_id, :Rol_ID)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':cedula', $data['Cedula']);
        $stmt->bindParam(':contrasena', password_hash($data['Contrasena'], PASSWORD_BCRYPT));
        $stmt->bindParam(':nombre', $data['Nombre']);
        $stmt->bindParam(':apellido1', $data['Apellido1']);
        $stmt->bindParam(':apellido2', $data['Apellido2']);
        $stmt->bindParam(':correo_electronico', $data['Correo_Electronico']);
        $stmt->bindParam(':salario', $data['Salario']);
        $stmt->bindParam(':estacion_id', $data['Estacion_ID']);
        $stmt->bindParam(':rol_id', $data['Rol_ID']);

        try {
            if ($stmt->execute()) {
                echo "Registro exitoso!";
            } else {
                echo "Error al registrar.";
            }
        } catch (PDOException $e) {
           
            echo "Error al insertar registro: " . $e->getMessage() . "<br>";
            echo "Detalles del error: " . json_encode($stmt->errorInfo());
        }
    }
}


$trabajadoresInfo = new TrabajadoresInfo();


$resultEstaciones = $trabajadoresInfo->obtenerEstaciones();
$resultRoles = $trabajadoresInfo->obtenerRoles();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trabajadoresInfo->procesarFormulario($_POST);
}
