const apiKey = "3782fa8c329f6163cf1c5bce8b501cc1";

// Mostrar/Ocultar menú
function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.classList.toggle("hidden");
}

// Detectar ubicación automáticamente
window.onload = () => {
    if (!sessionStorage.getItem("loggedIn")) {
        alert("Debes iniciar sesión primero.");
        window.location.href = "login.html";
    } else {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                fetchWeatherByCoords(latitude, longitude);
            },
            () => alert("No se pudo obtener tu ubicación. Usa el buscador.")
        );
    }
};

// Buscar clima por ciudad
function searchWeather() {
    const location = document.getElementById("location").value.trim();
    if (!location) return alert("Por favor, escribe una ciudad.");
    fetchWeatherByCity(location);
}

// Obtener clima por coordenadas
function fetchWeatherByCoords(lat, lon) {
    fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`)
        .then(response => response.json())
        .then(data => updateWeatherCard(data))
        .catch(() => alert("Error al obtener el clima. Intenta nuevamente."));
}

// Obtener clima por ciudad
function fetchWeatherByCity(city) {
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=es&appid=${apiKey}`)
        .then(response => response.json())
        .then(data => updateWeatherCard(data))
        .catch(() => alert("Ciudad no encontrada. Verifica el nombre e intenta de nuevo."));
}

// Actualizar la tarjeta con los datos del clima
function updateWeatherCard(data) {
    const card = document.getElementById("weather-card");
    const icon = document.getElementById("weather-icon");

    document.getElementById("city-name").textContent = `${data.name}, ${data.sys.country}`;
    document.getElementById("local-time").textContent = `Hora local: ${getLocalTime(data.timezone)}`;
    document.getElementById("description").textContent = data.weather[0].description;
    document.getElementById("temperature").textContent = `Temperatura: ${data.main.temp}°C`;
    document.getElementById("temp-range").textContent = `Min: ${data.main.temp_min}°C / Max: ${data.main.temp_max}°C`;
    document.getElementById("wind-speed").textContent = `Viento: ${data.wind.speed} m/s`;

    icon.src = `https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
    icon.classList.remove("hidden");
    card.classList.remove("hidden");

    // Cambiar colores según el clima
    const weather = data.weather[0].main.toLowerCase();
    changeBackgroundColor(weather);
}

// Obtener la hora local basada en la zona horaria
function getLocalTime(timezoneOffset) {
    const localTime = new Date(new Date().getTime() + timezoneOffset * 1000);
    return localTime.toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" });
}

// Cambiar fondo dinámicamente según el clima
function changeBackgroundColor(weather) {
    const body = document.body;
    body.className = ""; // Reinicia las clases de fondo

    if (weather.includes("cloud")) body.classList.add("cloudy");
    else if (weather.includes("rain")) body.classList.add("rainy");
    else if (weather.includes("snow")) body.classList.add("snowy");
    else if (weather.includes("clear")) body.classList.add("clear");
    else if (weather.includes("sun")) body.classList.add("sunny");
    else body.classList.add("day");
}

// Función de logout
function logout() {
    sessionStorage.removeItem("loggedIn");
    window.location.href = "index.php";
}
