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

    // Consulta para verificar usuario y contraseña
    $query = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['pass']) { // Comparación sin encriptación
            header("Location: Inicio.html");
            exit();
        } else {
            header("Location: index.php?error=Contraseña incorrecta.");
        }
    } else {
        header("Location: index.php?error=Usuario no encontrado.");
    }
}
?>
