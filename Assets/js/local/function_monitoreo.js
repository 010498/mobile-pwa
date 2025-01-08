// Declaración de variables globales
let map;
let markers = [];
let bounds;
const btnToggle = document.getElementById("btn-toggle");
const info = document.getElementById("info");
const btnToggleInicio = document.getElementById("btn-toggle-inicio");

// Evento: Alternar información flotante
btnToggle.addEventListener("click", () => info.classList.toggle("show"));

// Evento: Resetear vista del mapa
btnToggleInicio.addEventListener("click", resetMapView);

// Inicialización del mapa
async function initMap() {
  try {
    // Importar librerías de Google Maps
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    
    bounds = new google.maps.LatLngBounds();
    const ajaxUrl = `${base_url}monitoreo/informacion`;

    // Configuración inicial del mapa
    map = new Map(document.getElementById("map"), {
      zoom: 5,
      center: { lat: 4.3966617, lng: -75.1698283 },
      mapId: "DEMO_MAP_ID",
      disableDefaultUI: true,
    });

    // Obtener datos de la API y crear marcadores
    const data = await fetchData(ajaxUrl);
    createMarkers(data);

    // Ajustar límites del mapa
    map.fitBounds(bounds);
  } catch (error) {
    console.error("Error al inicializar el mapa:", error);
  }
}

// Función: Obtener datos de la API
async function fetchData(url) {
  const response = await fetch(url);
  if (!response.ok) throw new Error("Error en la solicitud");
  return await response.json();
}

// Función: Crear marcadores en el mapa
function createMarkers(data) {
  const infoList = document.getElementById("info-list");
  markers = [];

  data.forEach((item) => {
    const positionData = parsePosition(item.star_posiones_monitoreo);
    if (!isValidCoordinates(positionData.lat, positionData.lng)) return;

    const position = { lat: positionData.lat, lng: positionData.lng };
    const marker = createMarker(position, positionData);

    markers.push(marker);
    bounds.extend(position);

    // Agregar elemento a la lista flotante
    addInfoListItem(infoList, positionData, position);
  });

  // Agrupación de marcadores
  new markerClusterer.MarkerClusterer({ map, markers });
}

// Función: Crear un marcador
function createMarker(position, data) {
  const { placa, ignicion } = data;
  const placaTag = document.createElement("div");
  placaTag.className = "placa-tag";
  placaTag.textContent = placa;

  const infoContent = generateInfoWindowContent(data);
  const infoWindow = new google.maps.InfoWindow({ content: infoContent });

  const marker = new google.maps.marker.AdvancedMarkerElement({
    position,
    map,
    content: placaTag,
  });

  marker.addListener("click", () => {
    infoWindow.open(map, marker);
    map.setZoom(20);
    map.setCenter(marker.position);
  });

  return marker;
}

// Función: Generar contenido dinámico de InfoWindow
function generateInfoWindowContent({ placa, fecha, vel, pos, ignicion }) {
  const statusColor = getStatusColor(ignicion);
  return `
    <div class="custom-info-window">
      <div class="title">${placa}</div>
      <div class="rating">${fecha}</div>
      <div><span class="status" style="color: ${statusColor};">${ignicion}</span></div>
      <div class="rating">${pos}</div>
      <div class="rating">${vel} KM/H</div>
      <br>
    </div>`;
}

// Función: Agregar elemento a la lista flotante
function addInfoListItem(infoList, data, position) {
  const listItem = document.createElement("div");
  listItem.className = "info-item";
  listItem.innerHTML = `
    <p>${data.placa}</p>
    <p>${data.fecha}</p>
    <p>${data.pos}</p>
    <p>Vel: ${data.vel} kph</p>
    <button data-lat="${position.lat}" data-lng="${position.lng}">Zoom</button>
  `;

  listItem.querySelector("button").addEventListener("click", (event) => {
    focusMarker(event.target.dataset.lat, event.target.dataset.lng);
  });

  infoList.appendChild(listItem);
}

// Función: Focar marcador en el mapa
function focusMarker(lat, lng) {
  map.setZoom(20);
  map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
  info.classList.toggle("show");
}

// Función: Restablecer vista del mapa
function resetMapView() {
  map.setCenter({ lat: 4.3966617, lng: -75.1698283 });
  map.setZoom(5);
  map.fitBounds(bounds);
}

// Función: Validar coordenadas
function isValidCoordinates(lat, lng) {
  return (
    typeof lat === "number" &&
    typeof lng === "number" &&
    !isNaN(lat) &&
    !isNaN(lng) &&
    lat >= -90 &&
    lat <= 90 &&
    lng >= -180 &&
    lng <= 180
  );
}

// Función: Analizar datos de posición
function parsePosition(positionString) {
  const cadena = positionString.replace(/[()]/g, "");
  const valores = cadena.split(",");

  return {
    id_movil: valores[0],
    placa: valores[1],
    fecha: valores[2].replace(/"/g, ""),
    lat: parseFloat(valores[3]),
    lng: parseFloat(valores[4]),
    vel: valores[5],
    pos: valores[7].replace(/"/g, ""),
    ignicion: valores[12],
  };
}

// Función: Obtener color de estado
function getStatusColor(ignition) {
  return ignition === "ON" ? "green" : "red";
}

// Inicializar mapa
initMap();
