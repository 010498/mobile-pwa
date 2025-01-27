// Nombre del caché
const CACHE_NAME_STATIC = 'static-v2';
const CACHE_NAME_DYNAMIC = 'dynamic-v2';
const CACHE_NAME_INMUTABLE = 'inmutable-v1';

// Archivos a cachear
const APP_SHELL = [
    '/',
    './home',
   

];

// Archivos inmutables (CDN y recursos que no cambian)
const APP_SHELL_INMUTABLE = [
    'https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap',
    'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'
];

// Ciclos de vida
self.addEventListener('install', event => {

	// Descargar Assets
	// Crear Cache
	const cacheStatic = caches.open( CACHE_NAME_STATIC ).then(cache => 
        cache.addAll( APP_SHELL ));

    const cacheInmutable = caches.open( CACHE_NAME_INMUTABLE ).then(cache => 
        cache.addAll( APP_SHELL_INMUTABLE ));

    event.waitUntil( Promise.all([ cacheStatic, cacheInmutable ])  );
    // event.waitUntil(promise(cacheStatic));
});



// Cuando el SW toma el control de la aplicacion
self.addEventListener('activate', event => {
    const respuesta = caches.keys().then(keys => {
        return Promise.all(
            keys.map(key => {
                if (key !== CACHE_NAME_STATIC && key.includes('static')) {
                    return caches.delete(key);
                }

                if (key !== CACHE_NAME_DYNAMIC && key.includes('dynamic')) {
                    return caches.delete(key);
                }
            })
        );
    });

    event.waitUntil(respuesta);
});


// Manejo de cache
// Intercepción de las solicitudes de red
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});



// SYNC: Recuperamos conexion a internet
self.addEventListener('sync', event => {
    if (event.tag === 'sync-data') {
        event.waitUntil(syncData());
    }
});

async function syncData() {
    try {
        const response = await fetch('/path/to/api');
        const data = await response.json();
        // Procesa los datos obtenidos
        console.log('Datos sincronizados:', data);
    } catch (error) {
        console.error('Error al sincronizar datos:', error);
    }
}



// Controlador de Notifcaciones PUSH
self.addEventListener('push', event => {

	const title = 'Nueva notificación';
    const options = {
        body: 'Tienes un nuevo mensaje.',
        icon: '/icon.png',
        badge: '/badge.png'
    };
    event.waitUntil(self.registration.showNotification(title, options));

})