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

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    $query = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['pass'])) {
            header("Location: Inicio.html");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}

$conn->close();
?>
