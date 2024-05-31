<?php
require_once '../Config/config.php';

if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    $database = new Database1();
    $conn = $database->getConnection();

    try {
        $query = "DELETE FROM trabajadores WHERE ID = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_empleado);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error al eliminar el empleado.";
        }
    } catch (PDOException $exception) {
        echo "Error: " . $exception->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
