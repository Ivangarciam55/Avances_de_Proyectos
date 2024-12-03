<?php
// Configuración de la base de datos
$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "weatherapp";

// Conexión a la base de datos
$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $query = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if ($password === $row['pass']) { // Comparación directa (o password_verify si está encriptada)
            header("Location: Inicio.html");
            exit();
        } else {
            header("Location: Login.html?error=Contraseña incorrecta.");
            exit();
        }
    } else {
        header("Location: Login.html?error=Usuario no encontrado.");
        exit();
    }
}
?>
