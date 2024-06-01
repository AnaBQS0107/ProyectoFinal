<?php
require_once '../Config/config.php';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
            exit();
        }
    }


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}


class Cobro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerCobros() {
        try {
            $query = "SELECT Tipo_De_Vehiculo, Codigo, Monto, Tramitador, Estacion FROM cobros";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error en la consulta SQL: " . $exception->getMessage();
            return [];
        }
    } 
}

class TrabajadoresTabla {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function obtenerTodosLosTrabajadores() {
        $query = "SELECT t.*, r.Tipo_De_Rol, e.Nombre AS Nombre_Estacion 
                  FROM trabajadores t
                  LEFT JOIN roles r ON t.Rol_ID = r.ID
                  LEFT JOIN estaciones e ON t.Estacion_ID = e.ID";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNombreEstacion($estacionID) {
        $estacion = new Estacion($this->db);
        $result = $estacion->obtenerEstacionPorID($estacionID);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['Nombre'];
    }

    public function obtenerTipoDeRol($rolID) {
        $rol = new Rol($this->db);
        $result = $rol->obtenerRolPorID($rolID);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['Tipo_De_Rol'];
    }
}

class Rol {
    private $conn;
    private $table_name = "roles";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerRoles() {
        $query = "SELECT ID, Tipo_De_Rol FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function obtenerRolPorID($rolID) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $rolID);
        $stmt->execute();
        return $stmt;
    }
}

class Estacion {
    private $conn;
    private $table_name = "estaciones";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerEstaciones() {
        $query = "SELECT ID, Nombre FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerEstacionPorID($estacionID) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $estacionID);
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
        $database = Database::getInstance();
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
        $sql = "INSERT INTO trabajadores (Cedula, Contrasena, Nombre, Apellido1, Apellido2, Correo_Electronico,  Estacion_ID, Rol_ID) 
                VALUES (:cedula, :contrasena, :nombre, :apellido1, :apellido2, :correo_electronico, :estacion_id, :Rol_ID)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':cedula', $data['Cedula']);
        $stmt->bindParam(':contrasena', password_hash($data['Contrasena'], PASSWORD_BCRYPT));
        $stmt->bindParam(':nombre', $data['Nombre']);
        $stmt->bindParam(':apellido1', $data['Apellido1']);
        $stmt->bindParam(':apellido2', $data['Apellido2']);
        $stmt->bindParam(':correo_electronico', $data['Correo_Electronico']);
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

   

