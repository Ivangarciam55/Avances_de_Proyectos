<?php
// Datos de conexión a la base de datos
$host = "localhost"; // Cambia si el servidor no es local
$dbname = "weatherapp";
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se enviaron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener usuario y contraseña desde el formulario
    $user = $conn->real_escape_string($_POST['usuario']);
    $pass = $conn->real_escape_string($_POST['password']);

    // Consultar la base de datos para validar credenciales
    $query = "SELECT * FROM registro WHERE usuario = '$user' AND pass = '$pass'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso
        header("Location: dashboard.html"); // Redirige si el login es exitoso
        exit();
    } else {
        // Credenciales incorrectas
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Cerrar conexión
$conn->close();
?>
