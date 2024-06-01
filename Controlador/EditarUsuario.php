<?php
require_once '../Config/config.php';


if (isset($_GET['id'])) {

    $id_empleado = $_GET['id'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = $_POST['Nombre'];
        $cedula = $_POST['Cedula'];
        $contrasena = $_POST['Contrasena'];
        $apellido1 = $_POST['Apellido1'];
        $apellido2 = $_POST['Apellido2'];
        $correo = $_POST['Correo_Electronico'];
        $estacion_id = $_POST['Estacion_ID'];
        $rol_id = $_POST['Roles'];


        $database = new Database1();

        $conn = $database->getConnection();


        try {

            $query = "UPDATE trabajadores SET Nombre = :nombre, Cedula = :cedula, Contrasena = :contrasena, Apellido1 = :apellido1, Apellido2 = :apellido2, Correo_Electronico = :correo,  Estacion_ID = :estacion_id, Rol_ID = :rol_id WHERE ID = :id";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':correo', $correo);

            $stmt->bindParam(':estacion_id', $estacion_id);
            $stmt->bindParam(':rol_id', $rol_id);
            $stmt->bindParam(':id', $id_empleado);

            if ($stmt->execute()) {

                echo "Empleado actualizado exitosamente.";

                echo '<script>setTimeout(function(){ location.reload(); }, 2000);</script>';
                exit;
            } else {
                echo "Error al actualizar el empleado.";
            }
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    } else {

        $database = new Database1();

        $conn = $database->getConnection();

        try {

            $query = "SELECT * FROM trabajadores WHERE ID = :id";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id_empleado);

            $stmt->execute();

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
                <label>Estación ID:</label>
                <input type="text" name="Estacion_ID" value="<?php echo isset($empleado['Estacion_ID']) ? $empleado['Estacion_ID'] : ''; ?>">
                <br>
                <label>Rol ID:</label>
                <input type="text" name="Roles" value="<?php echo isset($empleado['Rol_ID']) ? $empleado['Rol_ID'] : ''; ?>">
                <br> <br>
                <button type="button" id="updateButton">Actualizar</button>
            </form>
<?php
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
} else {

    header("Location: ../Vista/ListaDeEmpleados");
    exit;
}
?>


<script>
    document.getElementById('updateButton').addEventListener('click', function() {
        swal({
            title: "¡Usuario actualizado con éxito!",
            text: "Por favor presiona el botón",
            icon: "success",
            button: "Volver a la tabla",
        }).then((willUpdate) => {
            if (willUpdate) {
                window.location.href = '../Vista/ListaDeEmpleados.php';
            } else {
                swal("La información del empleado no se ha actualizado.");
            }
        });
    });
</script>
