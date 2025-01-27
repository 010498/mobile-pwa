const form = document.querySelector('#form-reportes');
const spinner = document.getElementById('spinner');


// Funciones para mostrar y ocultar el spinner
function showSpinner() { spinner.style.display = 'block'; }
function hideSpinner() { spinner.style.display = 'none'; }

var map = null;
var InforObj = [];
if (!form) {
    console.error('No se encontró el formulario con el ID #form-reportes');
}
const tipoReporteSelect = document.querySelector('#select-soporte');

function configureDatePickers() {
    ['#fechaInicial', '#fechaFinal'].forEach(id => {
        $(id).datetimepicker({ format: 'YYYY-MM-DD', defaultDate: moment() });
    });
}

async function cargarPlacas() {
  
    try {
        const ajaxUrl = `${base_url}reportes/ver_placas`;
        const response = await fetch(ajaxUrl);
        if (!response.ok) throw new Error("Error al cargar placas");
        const data = await response.text();
        const selectPlaca = document.querySelector('#select-placa');
        if (data.trim() === '') {
            selectPlaca.innerHTML = '<option value="0">Sin opciones disponibles</option>';
        } else {
            selectPlaca.innerHTML = data;
            selectPlaca.value = 0;
        }
    } catch (error) {
        console.error("Error al cargar placas:", error);
    } 
}

// Inicializar la funcion del mapa con el fin de poder mostar la informacion de los exc de velocidad
function initMap(data) {
    const bounds = new google.maps.LatLngBounds();

    // Inicializar mapa
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 3,
        center: { lat: 4.4039698, lng: -75.164008 },
        mapTypeId: "terrain",
        // Ocultar los controles de mapa
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false,
        zoomControl: false,

    });

    // Crear marcadores y extender límites
    data.forEach(pos => {
        const { fecha_gps, latitud, longitud, posicion, velocidad } = pos;
        const latLng = {
            lat: parseFloat(pos.latitud),
            lng: parseFloat(pos.longitud),
        };

        const marker = new google.maps.Marker({
            position: latLng,
            map,
        });

       

        let infoWindow = new google.maps.InfoWindow({
            content: generateInfoWindowContent({ fecha_gps, posicion, velocidad }),
        }); // Una única instancia

      
        // Permite mostrar la informacion de la ventana de informacion
        marker.addListener("click", () => {
            closeOtherInfo(); // Cerrar la ventana de información
            infoWindow.open(marker.get('map'), marker);
            InforObj[0] = infoWindow;
            map.setZoom(18);
            map.setCenter(marker.position);
        });

        bounds.extend(latLng);
    });

    // Ajustar límites del mapa
    map.fitBounds(bounds);
    window.centerZoom = centerZoom;
}



document.addEventListener('DOMContentLoaded', () => {
    const dtVelocidad = document.querySelector('#dtVelocidad');
    if (dtVelocidad) dtVelocidad.style.display = 'none';

    if (tipoReporteSelect) {
        tipoReporteSelect.addEventListener('change', function () {
            if (this.value == "1") {
                $('#dtVelocidad').show();
            } else {
                $('#dtVelocidad').hide();
            }
        });
    }
});

async function handleFormSubmit(event) {
    event.preventDefault();

    const tipoReporte = tipoReporteSelect.value;
    const placa = document.querySelector('#select-placa');

    if (placa.value === '0' || tipoReporte === '0') {
        alert('Seleccione una opción válida');
        return;
    }

    // showSpinner();

    try {
        
        if( tipoReporte == 1){
            
            // URL's
            let ajaxUrlResumen = `${base_url}reportes/resumen_excesos`;
            let ajaxUrl = `${base_url}reportes/consultar_velocidad`;
            let formData = new FormData(form);

            showSpinner();

            // Peticion al servicio para el resumen de informacion
            const fetchResumen = fetch( ajaxUrlResumen, {
                method: 'POST',
                body: formData
            })
            .then( response => {
                if(!response.ok){ throw new Error('Error al enviar los datos resumen')}
                return response.json();
            })

            // Peticion al servicio para el llenado del historico de velocidad
            const fetchVelocidad = fetch( ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then( response => {
                if( !response.ok ){ throw new Error('Error al enviar la datos de velocidad')}
                return response.json();
            })

            // Solucion a ambas peticiones 
            Promise.all([ fetchResumen, fetchVelocidad ])
                .then( ([ resumenData, velocidadData ]) => {
                    if( resumenData.status && velocidadData.status ){
                        initMap(velocidadData.data); // Inicializar el mapa
                        $('#x_tb').show(); // Mostrar tabla de exceso de velocidad
                        $('#x_tb_operacion').hide(); // Ocultar la informacion de la tabla de operacion
                        $('#x_tb_temperatura').hide(); // Oculatar la informacion de la tabla de temperatura
                        $('#x_tb_combustible').hide(); // Ocultar la informacion de la tabla de combustible

                        cargar_resumen_excesos( resumenData.data );
                        cargar_tabla( velocidadData.data );
                    }else{
                        alert('No se encontraron datos');
                        cargar_resumen_excesos();
                        cargar_tabla();
                    }
                })
            .catch(error => {
                console.error("Ocurrió un error en las peticiones:", error.message);
            })
            .finally(() => {
                hideSpinner();
            })

        }else if (tipoReporte == 2) {
            // Permite realizar la logica para obtener la informacion sobre horas de operacion
            let ajaxUrl = `${base_url}reportes/consultar_horas_operacion`;
            let formData = new FormData(form);

            showSpinner();

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al enviar los datos');
                }
                return response.json();
            })
            .then(jsData => {
                if(jsData.status){
                    $('#x_tb').hide();  // Ocultar tabla de exceso de velocidad
                    $('#x_tb_operacion').show(); // Mostrar la informacion de la tabla de horas de operacion
                    $('#x_tb_temperatura').hide(); // Oculatar la informacion de la tabla de temperatura
                    $('#x_tb_combustible').hide(); // Oculatar la informacion de la tabla de combustible
                    cargar_tabla_horas(jsData.data);
                }else{
                    alert(jsData.msg);
                    // Limpiar tabla si no hay datos
                    cargar_tabla_horas();
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error.message);
            })
            .finally(() => {
                hideSpinner(); // Asegúrate de que el spinner se oculte al final
            });
        } else if (tipoReporte == 3) {
            // URL's
            let ajaxUrlResumen = `${base_url}reportes/resumen_temperatura`;
            let ajaxUrl = `${base_url}reportes/historico_temperatura`;

            // Crear instancias separadas de FormData
            let formDataResumen = new FormData(form);
            let formDataTemperatura = new FormData(form);

            // Petición al servicio para el resumen de información
            const fetchResumen = fetch(ajaxUrlResumen, {
                method: 'POST',
                body: formDataResumen,
            }).then(response => {
                if (!response.ok) throw new Error('Error al enviar los datos resumen');
                return response.json();
            });

            // Petición al servicio para el llenado del histórico de temperatura
            const fetchTemperatura = fetch(ajaxUrl, {
                method: 'POST',
                body: formDataTemperatura,
            }).then(response => {
                if (!response.ok) throw new Error('Error al enviar los datos de temperatura');
                return response.json();
            });

            // Solución a ambas peticiones
            Promise.all([fetchResumen, fetchTemperatura])
                .then(([resumenData, temperaturaData]) => {
                    if (resumenData && resumenData.status && temperaturaData && temperaturaData.status) {
                        $('#x_tb_temperatura').show(); // Mostrar tabla de temperatura
                        $('#x_tb_operacion').hide(); // Ocultar tabla de horas de operación
                        $('#x_tb').hide(); // Ocultar tabla de exceso de velocidad
                        $('#x_tb_combustible').hide(); // Ocultar informacion de combustible

                        // Cargar informacion de las tablas de temperaruta
                        cargar_resumen_temperatura(resumenData.data);
                        cargar_tabla_temperatura(temperaturaData.data);
                    } else {
                        cargar_resumen_temperatura();
                        cargar_tabla_temperatura();
                    }
                })
                .catch(error => {
                    console.error("Ocurrió un error en las peticiones:", error.message);
                })
                .finally( () => {
                    hideSpinner();
                })

        } else if (tipoReporte == 4) {
            // Lógica para el tipo de reporte 4 ( Combustible )
            let ajaxUrlCargue = `${base_url}reportes/consultar_cargue_combustible`;
            let ajaxUrlConsumo = `${base_url}reportes/consultar_consumo_combustible`;
            let ajaxUrlDescargue = `${base_url}reportes/consultar_descargue_combustible`;

            let formData = new FormData(form);

            
            // Petición al servicio para el cargue de combustible
            // ================ Funciona este bloque ==============
            // const fetchCargue = fetch( ajaxUrlCargue, {
            //     method: 'POST',
            //     body: formData
            // })
            // .then( response => {
            //     if( !response.ok ) { throw new Error('Error al enviar los datos de cargue') }
            //     return response.json();
            // })
            // .then( jsData => {
            //     if( jsData.status ){

            //         $('#x_tb_combustible').show(); // Mostrar tabla de combustibles
            //             $('#x_tb_temperatura').hide(); // Ocultar tabla de temperatura
            //             $('#x_tb_operacion').hide(); // Ocultar tabla de horas de operación
            //             $('#x_tb').hide(); // Ocultar tabla de exceso de velocidad
            //         cargar_tabla_cargue_combustible( jsData.data );
            //     }
            // })
            // =================== Fin bloque funcional ====================.

            const fetchConsumo = fetch( ajaxUrlConsumo, {
                method: 'POST',
                body: formData
            })
            .then( response => {
                if( !response.ok ){ throw new Error(' Error no se pudo enviar la informacion de consumo')}
                return response.json();
            })
            .then( jsData => {
                if( jsData.status ){
                    console.log( jsData.data );
                }
            })

            // Petición al servicio para el consumo de combustible
            // const fetchConsumo = fetch( ajaxUrlConsumo, {
            //     method: 'POST',
            //     body: formData
            // })
            // .then( response => {
            //     if( !response.ok ) { throw new Error('Error al enviar los datos de consumo') }
            //     return response.json();
            // })

            // Petición al servicio para el descargue de combustible
            // const fetchDescargue = fetch ( ajaxUrlDescargue, {
            //     method: 'POST',
            //     body: formData
            // })
            // .then( response => {
            //     if( !response.ok ) { throw new Error('Error al enviar los datos de descargue') }
            //     return response.json();
            // })

            // Solución a las peticiones
            // Promise.all([ fetchCargue, fetchConsumo])
            //     .then( ([ cargueData, consumoData ]) => {
            //         if( cargueData.status && consumoData.status  ){
            //         // Mostrar panel con las tablas de combustible
            //             $('#x_tb_combustible').show(); // Mostrar tabla de combustibles
            //             $('#x_tb_temperatura').hide(); // Ocultar tabla de temperatura
            //             $('#x_tb_operacion').hide(); // Ocultar tabla de horas de operación
            //             $('#x_tb').hide(); // Ocultar tabla de exceso de velocidad

            //             //cargar informacion de la tabla de llenado
            //             cargar_tabla_cargue_combustible(cargueData.data);
            //             // cargar_tabla_consumo_promedio(consumoData.data);
            //             // console.log(consumoData.data);

            //         }else{
            //             // Si no hay informacion en la tablas limpiarlas
            //             cargar_tabla_cargue_combustible();
            //             // cargar_tabla_consumo_promedio();
            //         }
            //     })


        }

    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al enviar el formulario');

    } 
}

function init() {
    configureDatePickers();
    cargarPlacas();

    form.addEventListener('submit', handleFormSubmit);
    // hideSpinner(); // Hide spinner initially
}
// Permite llenar la tabla con el resumen de los exc de velocidad
function cargar_resumen_excesos(data)
{
    let tableBody = document.getElementById('tbody-resumen');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows;
        return;
    }

    for (let i = 0; i < data.length; i++) {
        rows += `<tr>
            <td>${data[i].placa}</td>
            <td>${data[i].excesos}</td>
            <td>${data[i].distancia} KM</td>
            <td>${parseInt(data[i].velocidad)} KM/H</td>
            <td>${parseInt(data[i].promedio)} KM/H</td>
  
        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla

}

// Permite llenar la tabla con la informacion de los exc de velocidad
function cargar_tabla(data) {

    let tableBody = document.getElementById('tbody');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows; // Limpia la tabla
        return;
    }
    
    for (let i = 0; i < data.length; i++) {
        rows += `<tr>
            <td>${data[i].fecha_gps}</td>
            <td onclick="centerZoom(${data[i].latitud}, ${data[i].longitud})">${data[i].posicion}</td>
            <td>${data[i].velocidad} KM/H</td>
            <td>EXC VELOCIDAD</td>
        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Permite llenar la tabla con la informacion de las horas de operacion
function cargar_tabla_horas(data) {
    let tableBody = document.getElementById('tbody-operacion');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows; // Limpia la tabla
        return;
    }

    for(let i = 0; i < data.length; i++){
        rows += `<tr>
            <td>${data[i].fecha}</td>
            <td>${data[i].tiempo} </td>
            <td>${data[i].odometro} KM </td>
            <td>${parseInt(data[i].avg)} KM/H </td>
            <td>${parseInt(data[i].max)} KM/H </td>

        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
    
}

// Permite llenar la tabla con la informacion del resumen de temperaturas
function cargar_resumen_temperatura(data)
{
    // Obtener el id de la tabla body
    let tableBody = document.getElementById('tbody-resumen-temp');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows;
        return;
    }

    for (let i = 0; i < data.length; i++) {
        rows += `<tr>
            <td>${data[i].placa}</td>
            <td>${parseInt(data[i].maxima)} °C</td>
            <td>${parseInt(data[i].minima)} °C</td>
            <td>${parseInt(data[i].promedio)} °C</td>
        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Permite llenar la tabla con la informacion de la temperatura
function cargar_tabla_temperatura(data) {
    let tableBody = document.getElementById('tbody-temp');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows; // Limpia la tabla
        return;
    }

    for (let i = 0; i < data.length; i++) {
        rows += `<tr>
            <td>${data[i].fecha}</td>
            <td>${data[i].posicion}</td>
            <td>${parseInt(data[i].temperatura)} °C</td>
        </tr>`;
    }

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Permite llenar la tabla con la informacion del cargue de combustible
function cargar_tabla_cargue_combustible(data)
{
    let tableBody = document.getElementById('tbody-cargue');
    let rows = '';

    if(!data || data.length == 0){
        tableBody.innerHTML = rows;
        return
    }

    // Llenar tabla
    for(let i = 0; i < data.length; i++){
        rows += `<tr>
            <td>${data[i].fechaInicio}</td>
            <td>${data[i].fechaFin}</td>
            <td>${parseInt(data[i].cantidad)} Gal</td>
        </tr>`
    }   

    tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}

// Permite llenar la tabla con la informacion del consumo promedio de combustible 
function cargar_tabla_consumo_promedio(data)
{
    let tableBody = document.getElementById('tbody-consumo');
    let rows = '';

    if(!data || data.length == 0){
        tableBody = rows;
        return;
    }

    // Ciclo que permite llenar la tabla
    for(let i = 0; i < data.length; i++){
        rows += `<tr>
            <td>${data[i].fechaInicio}</td>
            <td>${data[i].fechaFin}</td>
            <td>${parseInt(data[i].cantidad)} Gal</td>
        </tr>`
    }   

        tableBody.innerHTML = rows; // Actualiza todo el contenido de la tabla
}
// Generar contenido de la ventana de información
function generateInfoWindowContent({ fecha_gps, posicion, velocidad }) {
    return `
        <div class="custom-info-window">
            <div class="rating">${fecha_gps }</div>
            <div class="rating">${posicion}</div>
            <div class="rating">${velocidad} KM/H</div>
            <br>
        </div>`;
}

// Funcion que permite centrar y hacer zoom en el mapa
function centerZoom(lat, lng) {
    if(map){
        map.setCenter(new google.maps.LatLng(lat,lng)); 
        map.setZoom(18);
    }
}

// Funcion que permite cerrar la ventana de informacion
function closeOtherInfo() {
    if (InforObj.length > 0) {
      InforObj[0].set("marker", null);  /* detach the info-window from the marker ... undocumented in the API docs */
      InforObj[0].close();              /* and close it */
      InforObj.length = 0;              /* blank the array */
    }
}



window.addEventListener('load', init);
