// inicializar procesosr del SW

var urlApp = window.location.href;
var swLocation = './sw.js';


if ( navigator.serviceWorker ) {
    
    if ( urlApp.includes('localhost') ) {
        swLocation = './sw.js';
    }

    Notification.requestPermission().then(result => {
        if (result === 'granted') {
            // reg.showNotification('Hola Mundo');
        }
    });

    // navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
    if( navigator.geolocation ){
        navigator.geolocation.getCurrentPosition( pos => {
            console.log("Posicion", pos);
        })
    }else{
        console.log(" Posiciones, Error! ");
    }
}


function geoSuccess(position) {
    console.log('Geolocation success:', position);
    // Puedes agregar lógica adicional aquí
}

function geoError(error) {
    let errorMessage = '';
    switch (error.code) {
        case error.PERMISSION_DENIED:
            errorMessage = 'User denied the request for Geolocation.';
            break;
        case error.POSITION_UNAVAILABLE:
            errorMessage = 'Location information is unavailable.';
            break;
        case error.TIMEOUT:
            errorMessage = 'The request to get user location timed out.';
            break;
        case error.UNKNOWN_ERROR:
            errorMessage = 'An unknown error occurred.';
            break;
    }
    console.error('Geolocation error:', errorMessage);
}

// var url = window.location.href;
// var swLocation = './sw.js';
// if (navigator.serviceWorker) {
//     console.log('El navegador soporta Service Workers.');

//     navigator.serviceWorker.register(swLocation)
//         .then(reg => {
//             console.log('Service Worker registrado correctamente:', reg);

//             if ('sync' in reg) {
//                 console.log('El registro soporta sincronización en segundo plano.');

//                 return reg.sync.register('sync-data');
//             } else {
//                 console.error('El registro no soporta sincronización en segundo plano.');
//             }
//         })
//         .then(() => {
//             console.log('Sincronización en segundo plano registrada.');
//         })
//         .catch(err => {
//             console.error('Error en el proceso:', err);
//         });
// }


// var url = window.location.href;
// var swLocation = './sw.js';


// if ( navigator.serviceWorker ) {
    
//     if ( url.includes('localhost') ) {
//         swLocation = './sw.js';
//     }

//     Notification.requestPermission().then(result => {
//         if (result === 'granted') {
//             // reg.showNotification('Hola Mundo');
//         }
//     });

//     navigator.serviceWorker.register( swLocation );
// }

// if ('serviceWorker' in navigator) {
//     navigator.serviceWorker.register('./sw.js')
//         .then(reg => {
//             console.log('Service Worker registrado', reg);
//         })
//         .catch(err => {
//             console.error('Error al registrar el Service Worker', err);
//         });

//     Notification.requestPermission().then(result => {
//         if (result === 'granted') {
//             // reg.showNotification('Hola Mundo');
//         }
//     });
// }

// if ('serviceWorker' in navigator && 'SyncManager' in window) {
//     navigator.serviceWorker.register('./sw.js')
//         .then(registration => {
//             console.log('Service Worker registrado', registration);

//             // Solicitar permisos de notificación
//             return Notification.requestPermission().then(permission => {
//                 if (permission === 'granted') {
//                     return registration.sync.register('sync-data');
//                 } else {
//                     throw new Error('Permiso de notificación denegado');
//                 }
//             });
//         })
//         .then(() => {
//             console.log('Sincronización en segundo plano registrada');
//         })
//         .catch(err => {
//             console.error('Error al registrar el Service Worker o la sincronización en segundo plano', err);
//         });
// } else {
//     console.error('Service Worker o SyncManager no soportados en este navegador');
// }

