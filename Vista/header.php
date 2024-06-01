<?php
session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../Vista/Inicio.php">
                <img src="../img/icono.png" alt="IconoPassWize" width="85" height="55">
            </a>
            <a class="navbar-brand" href="#">Servicio de Peajes PassWize</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">PassWize</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php if ($user) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($user['nombre']); ?> (<?php echo htmlspecialchars($user['nombre_rol']); ?>)
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                                    <li><a class="dropdown-item" href="../Vista/Index.php">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../Vista/Inicio.php">Página Principal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../Vista/Form_NuevoIngreso.php">Ingresar usuario</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../Vista/ListaDeEmpleados.php">Lista de Empleados</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../Vista/CobrosPeaje.php">Cobrar Peajes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../Vista/Filtros.php">Conteo de Peajes</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>