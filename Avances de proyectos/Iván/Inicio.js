// Función para alternar el menú responsivo
function toggleMenu() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

// Función para ocultar la pantalla de bienvenida y mostrar la aplicación
window.addEventListener("load", () => {
    const welcomeScreen = document.getElementById("welcome-screen");
    const pageWrapper = document.querySelector(".page-wrapper");

    setTimeout(() => {
        welcomeScreen.style.display = "none";
        pageWrapper.classList.add("loaded");
    }, 5000); // 3 segundos
});

// Función para buscar el clima
function searchWeather() {
    const locationInput = document.getElementById("location");
    const location = locationInput.value.trim();

    if (!location) {
        alert("Por favor, ingresa el nombre de una ciudad.");
        return;
    }

    fetchWeather(location);
}

// Función para obtener datos del clima
async function fetchWeather(location) {
    const apiKey = "3782fa8c329f6163cf1c5bce8b501cc1"; // Reemplaza con tu API Key
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${location}&units=metric&lang=es&appid=${apiKey}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error("Ciudad no encontrada");
        }

        const weatherData = await response.json();
        displayWeather(weatherData);
    } catch (error) {
        alert(error.message);
    }
}

// Función para capitalizar la primera letra de cada palabra
function capitalizeFirstLetter(str) {
    return str
        .split(' ') // Divide la cadena por los espacios
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitaliza la primera letra de cada palabra
        .join(' '); // Vuelve a unir las palabras
}

// Función para mostrar la información del clima
function displayWeather(data) {
    const weatherContainer = document.getElementById("weather");

    const {
        name,
        sys: { country },
        weather: [{ description, icon }],
        main: { temp, temp_min, temp_max },
        wind: { speed },
    } = data;

    // Capitalizamos el description
    const capitalizedDescription = capitalizeFirstLetter(description);

    // Convertimos la velocidad del viento de m/s a km/h
    const windSpeedKmH = (speed * 3.6).toFixed(1); // Redondeamos a un decimal

    const weatherHTML = `
        <div class="weather-card">
            <h2>${name}, ${country}</h2>
            <img class="weather-icon" src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="${description}">
            <p class="description">${capitalizedDescription}</p>
            <p class="temperature">${temp}°C</p>
            <p>Máx: ${temp_max}°C / Mín: ${temp_min}°C</p>
            <p>Viento: ${windSpeedKmH} km/h</p> <!-- Aquí mostramos la velocidad en km/h -->
        </div>
    `;

    weatherContainer.innerHTML = weatherHTML;

    // Cambiar el fondo dependiendo del clima
    changeBackground(capitalizedDescription);
}

// Función para cambiar el fondo de la aplicación
function changeBackground(description) {
    const body = document.body;
    body.className = ""; // Eliminar todas las clases previas

    if (description.includes("nieve")) {
        body.classList.add("snowy");
    } else if (description.includes("lluvia") || description.includes("chubasco")) {
        body.classList.add("rainy");
    } else if (description.includes("nubes")) {
        body.classList.add("cloudy");
    } else if (description.includes("cielo claro")) {
        body.classList.add("sunny");
    } else {
        body.classList.add("clear");
    }
}

// Función para obtener la ubicación en tiempo real
function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Usamos las coordenadas para obtener el clima
            fetchWeatherByCoordinates(latitude, longitude);
        }, function() {
            alert("No se pudo obtener la ubicación.");
        });
    } else {
        alert("La geolocalización no es compatible con este navegador.");
    }
}

// Función para obtener los datos del clima usando las coordenadas
async function fetchWeatherByCoordinates(lat, lon) {
    const apiKey = "3782fa8c329f6163cf1c5bce8b501cc1"; // Reemplaza con tu API Key
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&lang=es&appid=${apiKey}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error("No se pudo obtener el clima.");
        }

        const weatherData = await response.json();
        displayWeather(weatherData);
    } catch (error) {
        alert(error.message);
    }
}

// Llamamos a la función para obtener la ubicación cuando se carga la página
window.addEventListener("load", getUserLocation);
