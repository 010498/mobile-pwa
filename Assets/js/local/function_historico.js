// Configurar datetimepickers de forma unificada
var tabla_datos;
var map = null;
const spinner = document.getElementById('spinner');

// Crear funciones para ocultar o mostrar el spinner mientras carga 
// Funciones para mostrar y ocultar el spinner
function showSpinner() { spinner.style.display = 'block'; }
function hideSpinner() { spinner.style.display = 'none'; }

function configureDatePickers() {
    ['#fechaInicial', '#fechaFinal'].forEach(id => {
        $(id).datetimepicker({ format: 'YYYY-MM-DD', defaultDate: moment() });
    });
}

// Cargar placas de manera asíncrona
async function cargarPlacas() {
    try {
        const ajaxUrl = `${base_url}historico/ver_placas`;
        const response = await fetch(ajaxUrl);
        if (!response.ok) throw new Error("Error al cargar placas");
        const data = await response.text();
        const selectPlaca = document.querySelector('#select-placa');
        selectPlaca.innerHTML = data;
        selectPlaca.value = 0;
    } catch (error) {
        console.error("Error al cargar placas:", error);
    }
}



// Trazar recorrido
function initMap(data) {
    const directionAngles = { 'N': 0, 'NE': 45, 'E': 90, 'SE': 135, 'S': 180, 'SO': 225, 'O': 270, 'NO': 315 };
    const bounds = new google.maps.LatLngBounds();
    
    // Inicializar el mapa
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 3,
        center: { lat: 4.4039698, lng: -75.164008 },
        mapTypeId: "terrain",
    });

    const flightPlanCoordinates = data.map(pos => ({
        lat: parseFloat(pos.latitud),
        lng: parseFloat(pos.longitud),
    }));

    const flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2,
    });

    data.forEach(pos => {
        const { latitud, longitud, direccion,  fecha_gps, ignicion, posicion, velocidad } = pos;
        const lat = parseFloat(latitud);
        const lng = parseFloat(longitud);
        const angle = directionAngles[direccion] || 0;

        const marker = new google.maps.Marker({
            position: { lat, lng },
            map,
            icon: {
                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                scale: 2.5,
                rotation: angle,
                fillColor: "#0000FF",
                fillOpacity: 0.8,
                strokeWeight: 1.4,
            },
        });

        const infoWindow = new google.maps.InfoWindow({
            content: generateInfoWindowContent({ fecha_gps, ignicion, posicion, velocidad }),
        });

        marker.addListener("click", () => {
            infoWindow.open(map, marker);
            map.setZoom(18);
            map.setCenter(marker.position);
        });

        bounds.extend({ lat, lng });
    });

    map.fitBounds(bounds);
    flightPath.setMap(map);
    window.centerZoom = centerZoom;

}

// Generar contenido de la ventana de información
function generateInfoWindowContent({ fecha_gps, ignicion, posicion, velocidad }) {
    const statusColor = ignicion === "ON" ? "green" : "red";
    return `
        <div class="custom-info-window">
            <div class="rating">${fecha_gps}</div>
            <div class="rating">${posicion}</div>
            <div><span class="status" style="color: ${statusColor};">${ignicion}</span></div>
            <div class="rating">${velocidad} KM/H</div>
            <br>
        </div>`;
}

// Manejo del formulario
async function handleFormSubmit(e) {
    e.preventDefault();

    const ajaxUrl = `${base_url}historico/cargar_recorrido`;
    const ajaxUrlResumen = `${base_url}historico/cargar_resumen`;
    const movil = document.querySelector('#select-placa').value;

    if (movil == 0) {
        alert("FAVOR SELECCIONAR UN VEHICULO");
        return;
    }

    showSpinner();

    try {
        
        const formData = new FormData(form);
        const [response, responseResumen] = await Promise.all([
            fetch(ajaxUrl, { method: 'POST', body: formData }),
            fetch(ajaxUrlResumen, { method: 'POST', body: formData })
        ]);

        if (!response.ok) throw new Error("Error en la respuesta del servidor para cargar recorrido");
        if (!responseResumen.ok) throw new Error("Error en la respuesta del servidor para cargar resumen");

        const jsData = await response.json();
        const jsDataResumen = await responseResumen.json();

        if (jsData.status && jsDataResumen.status) {
            initMap(jsData.data); // Cargar informacion del mapa cuando se ejecuta la accion
            cargar_tabla(jsData.data);
            mostrar_resumen_desplazamiento(jsDataResumen.data)
            $('#x_map').show();
            $('#x_tb').show();
           
        } else {
            alert("No se encontraron datos para mostrar el recorrido o el resumen");
        }
    } catch (error) {
        console.error("Error al procesar la solicitud:", error);
        alert("Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo.");
    } finally {
        // Cerrar el Spinner cuando se termina de ejecutar la funcion
        hideSpinner();
    }
    
}

// Inicializar eventos al cargar la página
function init() {
    configureDatePickers();
    cargarPlacas();

    form.onsubmit = handleFormSubmit;
}

// Funcion que permite cargar la informacion en la tabla mostrando el resumen del desplazamiento
function mostrar_resumen_desplazamiento(data)
{
    
    let tableBody = document.getElementById('tbody-resumenDesplazamiento');
    let rows = '';
    

    if( !data || data.length == 0){
        tableBody.innerHTML = rows;
        return;
    }

    rows += `<tr>
        <td>${data.desplazamiento} KM</td>
        <td>${data.operacion}</td>
        <td>${data.ralenti}</td>
    </tr>`;

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Funcion que permite cargar la informacion en la tabla
function cargar_tabla(data) {
    let tableBody = document.getElementById('tbody');
    let rows = '';

    for (let i = 0; i < data.length; i++) {
        rows += `<tr class="custom-info-window">
            <td>${data[i].fecha_gps}</td>
            <td onclick="centerZoom(${data[i].latitud}, ${data[i].longitud})">${data[i].posicion}</td>
            <td>${data[i].ignicion}</td>
            <td>${data[i].velocidad} KM/H</td>
            <td>${data[i].evento}</td>
        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Funcion que permite centrar y hacer zoom en el mapa
function centerZoom(lat, lng) {
    if(map){
        map.setCenter(new google.maps.LatLng(lat,lng)); 
        map.setZoom(18);
    }
}

// Variables y eventos globales
const form = document.querySelector('#form-historico');
window.addEventListener('load', init);

