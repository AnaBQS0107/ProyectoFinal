<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Controlador/Empleados.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWize - Registro</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">ID Primaria</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido 1</th>
                    <th scope="col">Apellido 2</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Salario</th>
                    <th scope="col">Estación ID</th>
                    <th scope="col">Rol ID</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($controller->resultTrabajadores)): ?>
                    <?php foreach ($controller->resultTrabajadores as $usuario) : ?>
                        <tr>
                            <th scope="row"><?php echo $usuario['ID']; ?></th>
                            <td><?php echo $usuario['Cedula']; ?></td>
                            <td><?php echo $usuario['Contrasena']; ?></td>
                            <td><?php echo $usuario['Nombre']; ?></td>
                            <td><?php echo $usuario['Apellido1']; ?></td>
                            <td><?php echo $usuario['Apellido2']; ?></td>
                            <td><?php echo $usuario['Correo_Electronico']; ?></td>
                            <td><?php echo $usuario['Salario']; ?></td>
                            <td><?php echo $usuario['Estacion_ID']; ?></td>
                            <td><?php echo $usuario['Rol_ID']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No hay datos disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
