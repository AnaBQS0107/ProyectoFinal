<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controlador/Empleados.php';
require_once '../Modelo/Ingreso_Usuario.php';

$controller = new EmpleadoController1();

$controller->mostrarEmpleados();
$trabajadoresTabla = new TrabajadoresTabla();

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
                    <th scope="col">Estación ID</th>
                    <th scope="col">Rol ID</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($controller->resultTrabajadores)) : ?>
                    <?php foreach ($controller->resultTrabajadores as $usuario) : ?>
                        <tr>
                            <th scope="row"><?php echo $usuario['ID']; ?></th>
                            <td><?php echo $usuario['Cedula']; ?></td>
                            <td><?php echo $usuario['Contrasena']; ?></td>
                            <td><?php echo $usuario['Nombre']; ?></td>
                            <td><?php echo $usuario['Apellido1']; ?></td>
                            <td><?php echo $usuario['Apellido2']; ?></td>
                            <td><?php echo $usuario['Correo_Electronico']; ?></td>
                            <td><?php echo $trabajadoresTabla->obtenerNombreEstacion($usuario['Estacion_ID']); ?></td>
                            <td><?php echo $trabajadoresTabla->obtenerTipoDeRol($usuario['Rol_ID']); ?></td>
                            <td>
                                <a href="../Controlador/EditarUsuario.php?id=<?php echo $usuario['ID']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <br><br>
                                <a href="#" data-id="<?php echo $usuario['ID']; ?>" class="btn btn-danger btn-sm delete-link">Eliminar</a>
                            </td>

                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <script>
                                document.querySelectorAll('.delete-link').forEach(link => {
                                    link.addEventListener('click', function(event) {
                                        event.preventDefault(); 
                                        const employeeId = this.getAttribute('data-id');

                                        swal({
                                            title: "¿Seguro que deseas borrar este usuario?",
                                            text: "Una vez eliminado no podrás recuperarlo",
                                            icon: "warning",
                                            buttons: true,
                                            dangerMode: true,
                                        }).then((willDelete) => {
                                            if (willDelete) {
                                                fetch(`../Controlador/EliminarEmpleado.php?id=${employeeId}`, {
                                                        method: 'GET'
                                                    })
                                                    .then(response => response.text())
                                                    .then(data => {
                                                        if (data.trim() === 'success') {
                                                            swal("Usuario eliminado con exito", {
                                                                icon: "success",
                                                            }).then(() => {
                                                             
                                                                location.reload();
                                                            });
                                                        } else {
                                                            swal("No se pudo eliminar este usuario", {
                                                                icon: "error",
                                                            });
                                                        }
                                                    })
                                                    .catch(error => {
                                                        swal("Error: " + error, {
                                                            icon: "error",
                                                        });
                                                    });
                                            } else {
                                                swal("El usuario permanecerá en la base de datos");
                                            }
                                        });
                                    });
                                });
                            </script>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">No hay datos disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <center><a href="../Vista/Form_NuevoIngreso.php" class="btn btn-info" role="button">Crear Nuevo Usuario</a></center>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>