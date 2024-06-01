<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icono.png"> 
    <title>Login</title>
</head>
<body>
    <form method="post" action="../Controlador/Login.php?action=login">
        <label for="cedula">Cedula:</label>
        <input type="text" id="cedula" name="cedula" required><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>