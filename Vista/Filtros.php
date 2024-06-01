<?php

require_once '../Controlador/Cobro.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cobros</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br>
    <div class="container mt-5">
        <center><h1>Lista de Cobros</h1></center>
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">Tipo de Vehiculo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Persona que tramita</th>
                    <th scope="col">Estación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cobros as $cobro): ?>
                    <tr>
                        <td><?php echo $cobro['Tipo_De_Vehiculo']; ?></td>
                        <td><?php echo $cobro['Codigo']; ?></td>
                        <td><?php echo $cobro['Monto']; ?></td>
                        <td><?php echo $cobro['Tramitador']; ?></td>
                        <td><?php echo $cobro['Estacion']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>