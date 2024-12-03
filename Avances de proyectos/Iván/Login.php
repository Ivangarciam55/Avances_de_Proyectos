<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "weatherapp";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = "";

// Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $conn->real_escape_string($_POST['usuario']);
    $pass = $conn->real_escape_string($_POST['password']);

    // Consultar en la base de datos
    $query = "SELECT * FROM registro WHERE usuario = '$user' AND pass = '$pass'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        header("Location: dashboard.html");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Cerrar conexión
$conn->close();
?>
