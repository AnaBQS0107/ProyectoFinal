<?php
session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<?php
require_once '../Config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    $codigo = $_POST["codigo"];
    $insert = isset($_POST["insert"]) ? $_POST["insert"] : false;

    try {
        $database = new Database1();
        $conn = $database->getConnection();

        $query_peaje = "SELECT * FROM tarifas WHERE codigo = :codigo";
        $stmt_peaje = $conn->prepare($query_peaje);
        $stmt_peaje->bindParam(':codigo', $codigo);
        $stmt_peaje->execute();

        if ($stmt_peaje->rowCount() > 0) {
            $datos_peaje = $stmt_peaje->fetch(PDO::FETCH_ASSOC);

            $query_estacion_nombre = "SELECT e.Nombre AS Nombre_Estacion
            FROM trabajadores t
            LEFT JOIN estaciones e ON t.Estacion_ID = e.ID
            WHERE t.nombre = :nombre";
            $stmt_estacion_nombre = $conn->prepare($query_estacion_nombre);
            $stmt_estacion_nombre->bindParam(':nombre', $user['nombre']);
            $stmt_estacion_nombre->execute();

            $estacion_row = $stmt_estacion_nombre->fetch(PDO::FETCH_ASSOC);
            if ($estacion_row) { 
                $estacion_nombre = $estacion_row['Nombre_Estacion'];

                if ($insert) {
                    // Insertar los datos en la tabla cobros
                    $query_insert_cobro = "INSERT INTO cobros (Tipo_De_Vehiculo, Codigo, Monto, Tramitador, Estacion) VALUES (:tipo_de_vehiculo, :codigo, :monto, :tramitador, :estacion)";
                    $stmt_insert_cobro = $conn->prepare($query_insert_cobro);
                    $stmt_insert_cobro->bindParam(':tipo_de_vehiculo', $datos_peaje['Tipo_De_Vehiculo']);
                    $stmt_insert_cobro->bindParam(':codigo', $datos_peaje['Codigo']);
                    $stmt_insert_cobro->bindParam(':monto', $datos_peaje['Monto']);
                    $stmt_insert_cobro->bindParam(':tramitador', $user['nombre']);
                    $stmt_insert_cobro->bindParam(':estacion', $estacion_nombre);
                    $stmt_insert_cobro->execute();
                }

                echo "<tr><td>1</td><td>" . $datos_peaje['Tipo_De_Vehiculo'] . "</td><td>" . $datos_peaje['Codigo'] . "</td><td>" . $datos_peaje['Monto'] . "</td><td>" . $user['nombre'] . "</td><td>" . $estacion_nombre . "</td></tr>";
            } else {
                echo "<tr><td colspan='6'>No se encontró la estación para el usuario actual</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No se encontraron datos para el código proporcionado</td></tr>";
        }
    } catch (PDOException $exception) {
        echo "<tr><td colspan='6'>Error en la conexión a la base de datos: " . $exception->getMessage() . "</td></tr>";
    }
    exit;
}
?>
