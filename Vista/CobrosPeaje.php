<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobros -- PassWize</title>
    <link rel="icon" type="image/png" href="../img/icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br><br><br><br>
    <center>
        <h5>¿Cuál tipo de vehiculo pasará por la estación?</h5>
    </center>
    <br>
    <div class="d-flex justify-content-center flex-wrap gap-3">
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Código: L</div>
            <div class="card-body text-success">
                <h5 class="card-title">Automoviles livianos</h5>
                <p class="card-text">Monto: 340</p>
                <center><button type="button" class="btn btn-success" onclick="seleccionar('L')">Seleccionar</button></center>
            </div>
        </div>
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Código: A</div>
            <div class="card-body text-success">
                <h5 class="card-title">Autobuses</h5>
                <p class="card-text">Monto: 680</p>
                <center><button type="button" class="btn btn-success" onclick="seleccionar('A')">Seleccionar</button></center>
            </div>
        </div>
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Código: O</div>
            <div class="card-body text-success">
                <h5 class="card-title">Otros</h5>
                <p class="card-text">Monto: 850</p>
                <center><button type="button" class="btn btn-success" onclick="seleccionar('O')">Seleccionar</button></center>
            </div>
        </div>
    </div>

    <!-- Resultado de la selección -->
    <table id="tabla" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipo de Vehiculo</th>
                <th scope="col">Código</th>
                <th scope="col">Monto</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        </tbody>
    </table>

    <script>
        function seleccionar(codigo) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controlador/ObtenerDatosPeajes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector("#tabla tbody").innerHTML = xhr.responseText;
                }
            };
            xhr.send("codigo=" + codigo);
        }
    </script>
</body>
</html>