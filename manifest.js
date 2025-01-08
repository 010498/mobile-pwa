const baseUrl = "http://localhost/demos/pwa/";
const urlStart = "http://localhost/demos/pwa/home";

const manifest = {
    "background_color": "#04129e",
    "display": "standalone",
    "id": "/?homescreen=1",
    "start_url": urlStart,
    "name": "STAR SEGUIMIENTO Y CONTROL",
    "short_name": "STAR",
    "description": "Aplicación de seguimiento y control de vehículos",
    "lang": "es",
    "orientation": "portrait",
    "theme_color": "#fff",
    "prefer_related_applications": false,
    
    "icons": [
        {
            "src": baseUrl + "Assets/img/icons/icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png",
            "purpose": "any"
        },
        {
            "src": baseUrl + "Assets/img/icons/icon-256x256.png",
            "sizes": "256x256",
            "type": "image/png"
        },
        {
            "src": baseUrl + "Assets/img/icons/icon-384x384.png",
            "sizes": "384x384",
            "type": "image/png"
        },
        {
            "src": baseUrl + "Assets/img/icons/icon-512x512.png",
            "sizes": "512x512",
            "type": "image/png"
        },
        {
            "src": baseUrl+"Assets/img/favicon.ico",
            "sizes": "48x48",
            "type": "image/x-icon"
        },
        
    ],
    "screenshots": [
        {
            "src": baseUrl + "Assets/img/screenshots/mobile-screenshot.png",
            "sizes": "1080x1920",
            "type": "image/png"
        },
        {
            "src": baseUrl + "Assets/img/screenshots/desktop-screenshot.png",
            "sizes": "1920x1080",
            "type": "image/png",
            "form_factor": "wide"
        }
    ]
};

// Crear un elemento <link> para el manifiesto
const link = document.createElement('link');
link.rel = 'manifest';
link.href = 'data:application/json,' + encodeURIComponent(JSON.stringify(manifest));
document.head.appendChild(link);