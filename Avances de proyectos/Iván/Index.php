<?php
// login.php

session_start();

// Configuración de conexión a la base de datos
$host = 'localhost';  // Cambia por tu host si es necesario
$dbname = 'weatherapp';
$username = 'root';   // Cambia por tu usuario de MySQL
$password = '';       // Cambia por tu contraseña de MySQL

// Conexión con PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Validación del formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

// Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $error = "Por favor, ingrese usuario y contraseña.";
    } else {
// Consultar el usuario y la contraseña en la base de datos
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :user");
        $stmt->bindParam(':user', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar la contraseña
        if ($user && password_verify($password, $user['pass'])) {
// Iniciar sesión y redirigir
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['user'];
            header("Location: Inicio.html");  // Cambia por la página que deseas mostrar después del login
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar sesión</h2>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar sesión">
    </form>
</div>

</body>
</html>
