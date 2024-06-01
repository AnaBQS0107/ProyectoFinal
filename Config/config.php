<?php
define('DB_HOST', 'localhost:3307');
define('DB_NAME', 'servicio_autobuses');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

class Database1 {
    private static $instance = null;
    private $conn;
    private $host = "localhost:3307";
    private $db_name = "servicio_autobuses";
    private $username = "root";
    private $password = "";

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
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
?>
