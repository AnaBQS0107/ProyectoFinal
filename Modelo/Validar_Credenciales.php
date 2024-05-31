<?php
require_once '../Config/config.php';

class ValidarCredenciales {
    private $db;

    public function __construct() {
        $database = new Database1();
        $this->db = $database->getConnection();
    }


    public function login($cedula, $contrasena) {
        try {
            $stmt = $this->db->prepare("SELECT Nombre, Rol_ID FROM trabajadores WHERE Cedula = :cedula AND Contrasena = :contrasena");
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getRoleName($roleId) {
        try {
            $stmt = $this->db->prepare("SELECT Tipo_De_Rol FROM roles WHERE ID = :roleId");
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC)['Tipo_De_Rol'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
?>
