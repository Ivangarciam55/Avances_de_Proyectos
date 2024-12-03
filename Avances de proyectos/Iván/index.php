<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ecf0f1;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        .login-container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .login-container button:hover {
            background-color: #e67e22;
        }

        .login-container a {
            display: block;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Inicia Sesión</h1>
    <?php if (isset($_GET['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
</div>
</body>
</html>
