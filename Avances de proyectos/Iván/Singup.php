<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "weatherapp";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO registro (usuario, pass) VALUES ('$usuario', '$password')";

    if ($conn->query($query) === TRUE) {
        echo "Registro exitoso. <a href='Index.html'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
