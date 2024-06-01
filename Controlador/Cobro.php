<?php
class Database {
    private $host = "localhost:3307";
    private $db_name = "servicio_autobuses";
    private $username = "root";
    private $password = "";

    public function getConnection() {
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    try {
        $query = "SELECT Tipo_De_Vehiculo, Codigo, Monto, Tramitador, Estacion FROM cobros";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $cobros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error al obtener datos: " . $e->getMessage();
    }
} else {
    echo "No se pudo establecer la conexión.";
}
?>
