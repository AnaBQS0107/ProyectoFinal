<?php
$host = "localhost:3307";
$db_name = "servicio_autobuses";
$username = "root";
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cedula = $_POST['Cedula'];
    $contrasena = $_POST['Contrasena'];
    $nombre = $_POST['Nombre'];
    $apellido1 = $_POST['Apellido1'];
    $apellido2 = $_POST['Apellido2'];
    $email = $_POST['Correo_Electronico'];
    $salario = $_POST['Salario'];
    $estacion_id = $_POST['Estacion_ID'];
    $rol_id = $_POST['Roles']; 

  
    $sql = "INSERT INTO trabajadores (Cedula, Contrasena, Nombre, Apellido1, Apellido2, Correo_Electronico, Salario, Estacion_ID, Rol_ID)
            VALUES (:cedula, :contrasena, :nombre, :apellido1, :apellido2, :email, :salario, :Estacion_ID, :Rol_ID)";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido1', $apellido1);
    $stmt->bindParam(':apellido2', $apellido2);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':Estacion_ID', $estacion_id);
    $stmt->bindParam(':Rol_ID', $rol_id);


    try {
        $stmt->execute();
        echo "Registro exitoso.";
    } catch(PDOException $e) {
        echo "Error al insertar registro: " . $e->getMessage();
    }
}

?>
