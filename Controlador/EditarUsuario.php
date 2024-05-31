<?php
require_once '../Config/config.php'; // Asegúrate de incluir el archivo de la clase Database

// Verificar si se ha enviado un ID de empleado para editar
if (isset($_GET['id'])) {
    // Obtener el ID del empleado a editar
    $id_empleado = $_GET['id'];

    // Verificar si se ha enviado el formulario de edición
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario de edición
        $nombre = $_POST['Nombre'];
        $cedula = $_POST['Cedula'];
        $contrasena = $_POST['Contrasena'];
        $apellido1 = $_POST['Apellido1'];
        $apellido2 = $_POST['Apellido2'];
        $correo = $_POST['Correo_Electronico'];
        $salario = $_POST['Salario'];
        $estacion_id = $_POST['Estacion_ID'];
        $rol_id = $_POST['Roles'];

        // Crear una instancia de la clase Database
        $database = new Database1();
        // Obtener la conexión a la base de datos
        $conn = $database->getConnection();

        try {
            // Preparar la consulta para actualizar el empleado
            $query = "UPDATE trabajadores SET Nombre = :nombre, Cedula = :cedula, Contrasena = :contrasena, Apellido1 = :apellido1, Apellido2 = :apellido2, Correo_Electronico = :correo, Salario = :salario, Estacion_ID = :estacion_id, Rol_ID = :rol_id WHERE ID = :id";
            $stmt = $conn->prepare($query);
            // Vincular parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':salario', $salario);
            $stmt->bindParam(':estacion_id', $estacion_id);
            $stmt->bindParam(':rol_id', $rol_id);
            $stmt->bindParam(':id', $id_empleado);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Mostrar un mensaje indicando que el empleado fue actualizado
                echo "Empleado actualizado exitosamente.";
                // Recargar la página actual utilizando JavaScript
                echo '<script>setTimeout(function(){ location.reload(); }, 2000);</script>';
                exit;
            } else {
                echo "Error al actualizar el empleado.";
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    } else {
        // Si no se ha enviado el formulario de edición, mostrar el formulario con los datos actuales del empleado
        // Crear una instancia de la clase Database
        $database = new Database1();
        // Obtener la conexión a la base de datos
        $conn = $database->getConnection();

        try {
            // Preparar la consulta para obtener los datos del empleado
            $query = "SELECT * FROM trabajadores WHERE ID = :id";
            $stmt = $conn->prepare($query);
            // Vincular parámetros
            $stmt->bindParam(':id', $id_empleado);
            // Ejecutar la consulta
            $stmt->execute();
            // Obtener los datos del empleado
            $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

            
?>
            <?php
            include_once '../Vista/header.php' ?>
            <br> <br> <br> <br>
            <form method="post">
                <label>Nombre:</label>
                <input type="text" name="Nombre" value="<?php echo isset($empleado['Nombre']) ? $empleado['Nombre'] : ''; ?>">
                <br>
                <label>Cédula:</label>
                <input type="text" name="Cedula" value="<?php echo isset($empleado['Cedula']) ? $empleado['Cedula'] : ''; ?>">
                <br>
                <label>Contraseña:</label>
                <input type="password" name="Contrasena" value="<?php echo isset($empleado['Contrasena']) ? $empleado['Contrasena'] : ''; ?>">
                <br>
                <label>Apellido 1:</label>
                <input type="text" name="Apellido1" value="<?php echo isset($empleado['Apellido1']) ? $empleado['Apellido1'] : ''; ?>">
                <br>
                <label>Apellido 2:</label>
                <input type="text" name="Apellido2" value="<?php echo isset($empleado['Apellido2']) ? $empleado['Apellido2'] : ''; ?>">
                <br>
                <label>Correo Electrónico:</label>
                <input type="text" name="Correo_Electronico" value="<?php echo isset($empleado['Correo_Electronico']) ? $empleado['Correo_Electronico'] : ''; ?>">
                <br>
                <label>Salario:</label>
                <input type="text" name="Salario" value="<?php echo isset($empleado['Salario']) ? $empleado['Salario'] : ''; ?>">
                <br>
                <label>Estación ID:</label>
                <input type="text" name="Estacion_ID" value="<?php echo isset($empleado['Estacion_ID']) ? $empleado['Estacion_ID'] : ''; ?>">
                <br>
                <label>Rol ID:</label>
                <input type="text" name="Roles" value="<?php echo isset($empleado['Rol_ID']) ? $empleado['Rol_ID'] : ''; ?>">
                <br> <br>
                <button type="submit">Actualizar</button>
            </form>
<?php
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
} else {
    // Si no se ha enviado un ID de empleado, redirigir a la página principal
    header("Location: ../Vista/ListaDeEmpleados");
    exit;
}
?>