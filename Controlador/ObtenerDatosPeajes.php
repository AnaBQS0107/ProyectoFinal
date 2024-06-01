<?php
require_once '../Config/config.php'; // Asegúrate de incluir el archivo que define Database1

// Verifica si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    // Obtén el código del vehículo seleccionado
    $codigo = $_POST["codigo"];

    // Intenta establecer una conexión a la base de datos
    try {
        $database = new Database1();
        $conn = $database->getConnection();

        // Utiliza una consulta preparada para prevenir ataques de inyección SQL
        $query = "SELECT * FROM tarifas WHERE codigo = :codigo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();

        // Verifica si se encontraron resultados
        if ($stmt->rowCount() > 0) {
            // Si hay resultados, imprime los datos directamente en formato HTML
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<tr><td>1</td><td>" . $datos['Tipo_De_Vehiculo'] . "</td><td>" . $datos['Codigo'] . "</td><td>" . $datos['Monto'] . "</td></tr>";
        } else {
            // Si no se encuentran resultados, muestra un mensaje de error
            echo "<tr><td colspan='4'>No se encontraron datos para el código proporcionado</td></tr>";
        }
    } catch (PDOException $exception) {
        // Si ocurre un error en la conexión o la consulta, muestra un mensaje de error
        echo "<tr><td colspan='4'>Error en la conexión a la base de datos: " . $exception->getMessage() . "</td></tr>";
    }
    exit; // Agrega esta línea para asegurarte de que el script PHP no continúe con el HTML
}
?>
