<?php
$host = "localhost";
$dbname = "weatherapp";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$message = "";

// Procesar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $conn->real_escape_string($_POST['usuario']);
    $pass = $conn->real_escape_string($_POST['password']);

    // Validar si el usuario ya existe
    $checkQuery = "SELECT * FROM registro WHERE usuario = '$user'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $message = "El usuario ya existe.";
    } else {
        $insertQuery = "INSERT INTO registro (usuario, pass) VALUES ('$user', '$pass')";
        if ($conn->query($insertQuery)) {
            $message = "Registro exitoso. Inicia sesión.";
        } else {
            $message = "Error al registrar usuario.";
        }
    }
}

$conn->close();
?>
<?php
