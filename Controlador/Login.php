<?php
session_start(); // Iniciar la sesión

require_once '../Modelo/Validar_Credenciales.php';

class AuthController {
    private $ValidarCredenciales;

    public function __construct() {
        $this->ValidarCredenciales = new ValidarCredenciales();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cedula'], $_POST['contrasena'])) {
            $cedula = $_POST['cedula'];
            $contrasena = $_POST['contrasena'];

            $user = $this->ValidarCredenciales->login($cedula, $contrasena);

            if ($user) {
                $nombre = $user['Nombre'];
                $rol = $user['Rol_ID'];
                $nombre_rol = $this->ValidarCredenciales->getRoleName($rol);

                // Guardar la información del usuario en la sesión
                $_SESSION['user'] = [
                    'nombre' => $nombre,
                    'rol_id' => $rol,
                    'nombre_rol' => $nombre_rol
                ];

                // Redirigir al formulario index.php
                header("Location: ../Vista/Inicio.php");
                exit(); // Asegurarse de que se detenga la ejecución del script
            } else {
                echo "Credenciales inválidas. Acceso denegado.";
            }
        } else {
            echo "Error: No se recibieron los datos del formulario.";
        }
    }

    public function logout() {
        // Destruir la sesión
        session_unset();
        session_destroy();
        echo "Sesión cerrada.";
    }

    public function checkSession() {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            echo "Usuario: " . $user['nombre'] . "<br>";
            echo "Rol: " . $user['nombre_rol'] . "<br>";
        } else {
            echo "No hay usuario conectado.";
        }
    }
}

$controller = new AuthController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'check':
            $controller->checkSession();
            break;
        default:
            echo "Acción no válida.";
            break;
    }
}
?>
