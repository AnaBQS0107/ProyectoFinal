<?php
require_once '../Modelo/Ingreso_Usuario.php';
require_once '../Controlador/TrabajadoresInfo.php'; 

class EmpleadoController1 {
    public $resultTrabajadores; 

    public function mostrarEmpleados() {
        $trabajadoresTabla = new TrabajadoresTabla();
        $this->resultTrabajadores = $trabajadoresTabla->obtenerTodosLosTrabajadores();
    }
}

$controller = new EmpleadoController1();
$controller->mostrarEmpleados();
?>


