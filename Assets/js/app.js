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

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./sw.js')
        .then(reg => {
            console.log('Service Worker registrado', reg);
        })
        .catch(err => {
            console.error('Error al registrar el Service Worker', err);
        });

    Notification.requestPermission().then(result => {
        if (result === 'granted') {
            // reg.showNotification('Hola Mundo');
        }
    });
}