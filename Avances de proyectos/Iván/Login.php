<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Configuración de conexión a la base de datos
    $host = "localhost";
    $dbname = "weatherapp";
    $username = "root";
    $password = "";

    // Crear conexión
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    // Consultar en la base de datos
    $query = "SELECT * FROM registro WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['pass'])) {
            header("Location: Inicio.html");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    // Cerrar conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }
        .container button {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container button:hover {
            background-color: #e67e22;
        }
        .container a {
            color: #f39c12;
            text-decoration: none;
        }
        .container a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Iniciar Sesión</h1>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="Singup.php">Regístrate</a></p>
</div>
</body>
</html>
