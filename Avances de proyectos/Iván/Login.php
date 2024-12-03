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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Weather App</title>
    <link rel="stylesheet" href="Inicio.css">
</head>

<body>
<!-- Menú de navegación -->
<nav id="sidebar" class="nav-menu">
    <ul>
        <li><a href="about.html">Acerca de</a></li>
        <li><a href="Explicacion.html">Explicacion del clima</a></li>
        <li><a href="Contact.html">Contactos</a></li>
    </ul>
</nav>

<!-- Contenedor de la animación de bienvenida -->
<div id="welcome-screen">
    <h2>Bienvenido a la Weather App</h2>
</div>

<div class="page-wrapper">
    <!-- Header -->
    <header>
        <div class="header-content">
            <h1>Weather App</h1>
            <!-- Botón del menú responsivo -->
            <button class="menu-btn" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="weather-app">
        <!-- Información del clima -->
        <section id="weather-info">
            <div id="weather">
                <p>Esperando información del clima...</p>
            </div>
        </section>

        <!-- Barra de búsqueda -->
        <section id="location-input">
            <label for="location">Busca tu ciudad:</label>
            <div class="search-wrapper">
                <input type="text" id="location" placeholder="Ingresa el nombre de la ciudad">
                <button onclick="searchWeather()">Obtener el clima</button>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Ivan García - Todos los derechos reservados</p>
        </div>
    </footer>
</div>

<script src="Inicio.js"></script>
</body>

</html>
