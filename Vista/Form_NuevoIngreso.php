
<?php
require_once '../Modelo/Ingreso_Usuario.php';
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
    <br><br><br><br><br>
    <div class="container">
        <form method="post" action="../Controlador/TrabajadoresInfo.php" class="row g-3 needs-validation" novalidate>
            <div class="col-md-4 position-relative">
                <label for="cedula" class="form-label">Ingrese su Cedula</label>
                <input type="text" class="form-control" id="cedula" name="Cedula" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="contrasena" class="form-label">Ingrese su contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="Contrasena" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="Nombre" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="primer_apellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" id="primer_apellido" name="Apellido1" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" id="segundo_apellido" name="Apellido2" required>
                <div class="valid-tooltip"></div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="email" class="form-label">Correo Electronico</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                    <input type="email" class="form-control" id="email" name="Correo_Electronico" aria-describedby="validationTooltipUsernamePrepend" required>
                    <div class="invalid-tooltip"></div>
                </div>
            </div>
            <div class="col-md-3 position-relative">
                <label for="estacion" class="form-label">Estación a la que pertenece</label>
                <select class="form-select" id="estacion" name="Estacion_ID" required>
                    <option selected disabled value="">Choose...</option>
                    <?php
                    if ($resultEstaciones && $resultEstaciones->rowCount() > 0) {
                        while ($row = $resultEstaciones->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row["ID"] . '">' . $row["Nombre"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>No hay estaciones disponibles</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 position-relative">
                <label for="rol" class="form-label">Rol al que pertenece</label>
                <select class="form-select" id="rol" name="Roles" required>
                    <option selected disabled value="">Choose...</option>
                    <?php
                    if ($resultRoles && $resultRoles->rowCount() > 0) {
                        while ($row = $resultRoles->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row["ID"] . '">' . $row["Tipo_De_Rol"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>No hay roles disponibles</option>';
                    }
                    ?>
                </select>
                <div class="invalid-tooltip"></div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>