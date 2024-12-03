<?php
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "weatherapp";

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $conn->real_escape_string($_POST['password']);

    // Consulta para verificar si el usuario ya existe
    $query_check = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($query_check);

    if ($result->num_rows > 0) {
        header("Location: registro.php?error=El usuario ya existe.");
        exit();
    }

    // Insertar nuevo usuario
    $query = "INSERT INTO registro (usuario, pass) VALUES ('$usuario', '$password')";
    if ($conn->query($query)) {
        header("Location: index.php?error=Registro exitoso. Inicia sesión.");
    } else {
        header("Location: registro.php?error=Error al registrar usuario.");
    }
}
?>
