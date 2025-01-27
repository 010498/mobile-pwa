// Declaración de variables globales
let map;
let trafficLayer;
let terrainLayer;
let satelliteLayer;
let markers = [];
let bounds;
const btnToggle = document.getElementById("btn-toggle");
const info = document.getElementById("info");
const btnToggleInicio = document.getElementById("btn-toggle-inicio");

// Obtener el ID del elemento que permite mostrar que se esta cargando la informacion 
const spinner = document.querySelector('#spinner');

// Funciones que permite mostrar y ocultar el elemento 
function hideSpinner(){ spinner.style.display = 'none'; }
function showSpinner(){ spinner.style.display = 'block'; }

// Evento: Alternar información flotante
btnToggle.addEventListener("click", () => info.classList.toggle("show"));

// Evento: Resetear vista del mapa
btnToggleInicio.addEventListener("click", resetMapView);

// Inicialización del mapa
async function initMap() {
  showSpinner(); // Mostramos spinner que nos indica que se esta cargando la informacion
  try {
    // Importar librerías de Google Maps
    const { Map, InfoWindow, TrafficLayer, TileLayer } = await google.maps.importLibrary("maps");
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

    // deactivateLayers();
    // trafficLayer = new google.maps.TrafficLayer();
   
    // Crear capa de relieve
    terrainLayer = new google.maps.ImageMapType({
      getTileUrl: (coord, zoom) =>
        `https://stamen-tiles.a.ssl.fastly.net/terrain/${zoom}/${coord.x}/${coord.y}.png`,
      tileSize: new google.maps.Size(256, 256),
      name: "Terrain",
      maxZoom: 18,
      minZoom: 0,
    });

    // Crear capa satelital personalizada
    satelliteLayer = new google.maps.ImageMapType({
      getTileUrl: (coord, zoom) =>
        `https://mts0.google.com/vt/lyrs=y&x=${coord.x}&y=${coord.y}&z=${zoom}`,
      tileSize: new google.maps.Size(256, 256),
      name: "Satellite",
      maxZoom: 18,
      minZoom: 0,
    });

    // Configurar capas
    setupLayerSwitcher();

    // Obtener datos de la API y crear marcadores
    const data = await fetchData(ajaxUrl);
    createMarkers(data);

    // Ajustar límites del mapa
    map.fitBounds(bounds);
    
  } catch (error) {
    console.error("Error al inicializar el mapa:", error);
  } finally {
    hideSpinner(); // Permite ocultar el elemento cuando se termine de cargar la informacion 
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
    const positionData = {
        lat: parseFloat(item.latitud),
        lng: parseFloat(item.longitud),
        placa: item.placa,
        fecha: item.fecha,
        posicion: item.posicion,
        velocidad: item.velocidad,
        ignicion: item.ignicion,
        odometro: item.odometro,
        velmax: item.velmax

    };
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
function generateInfoWindowContent({ placa, fecha, velocidad, posicion, ignicion, lat, lng }) {
  const statusColor = getStatusColor(ignicion);
  const content = document.createElement('div');
  content.className = 'custom-info-window';
  content.innerHTML = `
    <div class="title">${placa}</div>
    <div class="rating">${fecha}</div>
    <div><span class="status" style="color: ${statusColor};">${ignicion}</span></div>
    <div class="rating">${posicion}</div>
    <div class="rating">${velocidad} KM/H</div>
    <br>

    <button class="btn-detalle" data-lat="${lat}" data-lng="${lng}">Ver detalle</button>
    <button class="btn-llegar">Como llegar</button>
  `;

  content.querySelector('.btn-detalle').addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-detalle')) {
      const latitud = parseFloat(e.target.getAttribute('data-lat'));
      const longitud = parseFloat(e.target.getAttribute('data-lng'));

      openmodal(latitud, longitud);
    }
  });

  content.querySelector('.btn-llegar').addEventListener('click', function (e) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          console.log(pos);
        },
        (error) => {
          console.error("Error obteniendo ubicación:", error);
          alert("No se pudo obtener la ubicación del dispositivo.");
        }
      );
    } else {
      alert("La geolocalización no está soportada por este navegador.");
    }
  });
  

  return content;
}

// Funcion que permite abrir el modal con la informacion del streetView
function openmodal(latitud, longitud) {
  $('#mapStreet').html(''); // Limpia el contenedor del mapa
  $('#pano').html(''); // Limpia el contenedor de Street View
  $('#streetViewModal').modal('show');
  initialize(latitud, longitud); // Llama a la función con las coordenadas dinámicas
}

// Funcion que permite generar la ruta desde el punto del usuario hasta el punto donde se encuentr el vehiculo
// function comoLlegar(){
//   console.log("Creacion de funcion");
// }

// Función: Agregar elemento a la lista flotante
function addInfoListItem(infoList, data, position) {
  
  const listItem = document.createElement("div");
  listItem.className = "info-item";
  listItem.innerHTML = `
    <p>Pla: ${data.placa}</p>
    <p>Fec: ${data.fecha}</p>
    <p>Pos: ${data.posicion}</p>
    <p>Vel: ${data.velocidad} kph</p>
    <p>Km:  ${data.odometro} KM</p>
    <p>Vel Max: ${data.velmax} kph</p>
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



// Función: Obtener color de estado
function getStatusColor(ignition) {
  return ignition === "ON" ? "green" : "red";
}

// Alternador de capas
function setupLayerSwitcher() {
  // Obtener información del select
  const layerSelect = document.querySelector('#layer-switcher');
  layerSelect.addEventListener('change', (event) => {
    const selectedLayer = event.target.value;

    deactivateLayers();

    switch (selectedLayer) {
      case "traffic":
        trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
        break;
      case "terrain":
        map.overlayMapTypes.insertAt(0, terrainLayer);
        break;
      case "satellite":
        map.overlayMapTypes.insertAt(0, satelliteLayer);
        break;
      default:
        console.log("Capa no soportada");
    }
    // switchLayer(selectedLayer);
  });
}

// Desactivar todas las capas
function deactivateLayers() {
  if (trafficLayer) trafficLayer.setMap(null);
  map.overlayMapTypes.clear();
}

// Inicializar mapa
initMap();
window.initialize = initialize;

