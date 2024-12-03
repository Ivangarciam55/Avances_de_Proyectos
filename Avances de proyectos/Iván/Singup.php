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
    $password = $_POST['password'];

    // Consulta para insertar al usuario
    $query = "INSERT INTO registro (usuario, pass) VALUES ('$usuario', '$password')";

    if ($conn->query($query)) {
        header("Location: Login.html");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
