const apiKey = "3782fa8c329f6163cf1c5bce8b501cc1";

// Mostrar/Ocultar menú
function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.classList.toggle("active");
}

// Detectar ubicación automáticamente
window.onload = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                fetchWeatherByCoords(latitude, longitude);
            },
            (error) => {
                alert("No se pudo obtener tu ubicación. Usa el buscador para buscar el clima.");
            }
        );
    } else {
        alert("Geolocalización no soportada por tu navegador.");
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
        .then(response => {
            if (!response.ok) throw new Error("Error al obtener el clima.");
            return response.json();
        })
        .then(data => {
            updateWeatherCard(data);
            updateBackgroundColor(data.weather[0].main);
        })
        .catch(() => alert("Error al obtener el clima. Intenta nuevamente."));
}

// Obtener clima por ciudad
function fetchWeatherByCity(city) {
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=es&appid=${apiKey}`)
        .then(response => {
            if (!response.ok) throw new Error("Ciudad no encontrada.");
            return response.json();
        })
        .then(data => {
            updateWeatherCard(data);
            updateBackgroundColor(data.weather[0].main);
        })
        .catch(() => alert("Ciudad no encontrada. Verifica el nombre e intenta de nuevo."));
}

// Actualizar la tarjeta con los datos del clima
function updateWeatherCard(data) {
    const card = document.getElementById("weather-card");
    const icon = document.getElementById("weather-icon");

    document.getElementById("city-name").textContent = `${data.name}, ${data.sys.country}`;
    document.getElementById("description").textContent = data.weather[0].description;
    document.getElementById("temperature").textContent = `Temperatura: ${data.main.temp}°C`;
    document.getElementById("temp-range").textContent = `Min: ${data.main.temp_min}°C / Max: ${data.main.temp_max}°C`;
    document.getElementById("wind-speed").textContent = `Viento: ${convertWindSpeed(data.wind.speed)} km/h`;
    document.getElementById("humidity").textContent = `Humedad: ${data.main.humidity}%`;
    document.getElementById("rain-chance").textContent = `Probabilidad de lluvia: ${data.rain ? data.rain["1h"] : 0}%`;

    // Mostrar la hora local
    const localTime = new Date((data.dt + data.timezone) * 1000).toLocaleString("es-ES", { timeZone: "UTC" });
    document.getElementById("local-time").textContent = `Hora local: ${localTime}`;

    // Mostrar icono del clima
    icon.src = `http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
    icon.alt = data.weather[0].description;

    // Mostrar la tarjeta del clima
    card.classList.remove("hidden");
}

// Cambiar colores dinámicos del fondo
function updateBackgroundColor(weatherCondition) {
    const body = document.body;

    // Resetear clases dinámicas del fondo
    body.classList.remove("daytime", "nighttime", "cloudy", "rainy", "sunny", "snowy");

    // Cambiar fondo según la condición del clima
    switch (weatherCondition.toLowerCase()) {
        case "clear":
            body.classList.add("sunny");
            break;
        case "clouds":
            body.classList.add("cloudy");
            break;
        case "rain":
        case "drizzle":
            body.classList.add("rainy");
            break;
        case "snow":
            body.classList.add("snowy");
            break;
        default:
            // Día o noche dependiendo de la hora
            const currentHour = new Date().getHours();
            if (currentHour >= 6 && currentHour <= 18) {
                body.classList.add("daytime");
            } else {
                body.classList.add("nighttime");
            }
            break;
    }
}

// Convertir la velocidad del viento de m/s a km/h
function convertWindSpeed(speed) {
    return (speed * 3.6).toFixed(2);
}

// Cerrar sesión (simulado)
function logout() {
    alert("Has cerrado sesión.");
    sessionStorage.removeItem("loggedIn");
    window.location.href = "index.php";
}
