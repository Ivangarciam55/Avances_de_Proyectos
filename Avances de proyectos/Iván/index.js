const apiKey = '3782fa8c329f6163cf1c5bce8b501cc1'; // Tu clave de API de OpenWeatherMap

function getWeather() {
    const location = document.getElementById('location').value;

    if (location) {
        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${location}&appid=${apiKey}&units=metric&lang=es`)
            .then(response => response.json())
            .then(data => displayWeather(data))
            .catch(error => console.error('Error al obtener clima por la ubicación:', error));
    } else {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const { latitude, longitude } = position.coords;
                fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric&lang=es`)
                    .then(response => response.json())
                    .then(data => displayWeather(data))
                    .catch(error => console.error('Error al obtener el clima por geolocalización:', error));
            }, error => {
                console.error('Error al obtener la geolocalización:', error);
                alert('No se pudo obtener tu ubicación. Por favor, ingresa una ciudad manualmente.');
            });
        } else {
            alert('La geolocalización no es soportada por este navegador.');
        }
    }
}

function displayWeather(data) {
    const weatherDiv = document.getElementById('weather');
    const body = document.body;

    if (data && data.weather && data.weather.length > 0) {
        const temperatura = data.main.temp.toFixed(1);
        const descripcion = data.weather[0].description.charAt(0).toUpperCase() + data.weather[0].description.slice(1);
        const mainWeather = data.weather[0].main.toLowerCase();

        let iconClass = '';
        if (mainWeather.includes('clear')) {
            iconClass = 'wi-day-sunny';
        } else if (mainWeather.includes('clouds')) {
            iconClass = 'wi-cloudy';
        } else if (mainWeather.includes('rain') || mainWeather.includes('drizzle')) {
            iconClass = 'wi-rain';
        } else if (mainWeather.includes('thunderstorm')) {
            iconClass = 'wi-thunderstorm';
        } else if (mainWeather.includes('snow')) {
            iconClass = 'wi-snow';
        } else {
            iconClass = 'wi-na';
        }

        weatherDiv.innerHTML = `
            <i class="wi ${iconClass} weather-icon"></i>
            <h2>${data.name}</h2>
            <p>Temperatura: ${temperatura} °C</p>
            <p>Clima: ${descripcion}</p>
        `;

        if (mainWeather.includes('clear')) {
            body.style.background = 'linear-gradient(to bottom, #ffcc00, #ff6600)';
        } else if (mainWeather.includes('clouds')) {
            body.style.background = 'linear-gradient(to bottom, #d3d3d3, #a9a9a9)';
        } else if (mainWeather.includes('rain') || mainWeather.includes('drizzle')) {
            body.style.background = 'linear-gradient(to bottom, #3a7bd5, #3a6073)';
        } else if (mainWeather.includes('thunderstorm')) {
            body.style.background = 'linear-gradient(to bottom, #1e3c72, #2a5298)';
        } else if (mainWeather.includes('snow')) {
            body.style.background = 'linear-gradient(to bottom, #e0eafc, #cfdef3)';
        } else {
            body.style.background = 'linear-gradient(to bottom, #3b4d61, #1c2431)';
        }
    } else {
        weatherDiv.innerHTML = '<p>No se pudo obtener la información del clima.</p>';
    }
}

// Obtener el clima al cargar la página
document.addEventListener('DOMContentLoaded', getWeather);
