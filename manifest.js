const url = "http://localhost/";
const baseUrl = "http://localhost/demos/pwa/";
const urlStart = "http://localhost/demos/pwa/home";


const manifest = {
    "background_color": "#04129e",
    "display": "standalone",
    "id": "/?homescreen=1",
    "start_url": urlStart,
    "scope": url,
    "name": "STAR SEGUIMIENTO Y CONTROL",
    "short_name": "STAR",
    "description": "Aplicación de seguimiento y control de vehículos",
    "lang": "es",
    "orientation": "portrait",
    "theme_color": "#04129e",
    "display_override": [
        "window-controls-overlay",
        "standalone",
        "browser"
    ],

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
            "src": baseUrl + "Assets/img/favicon.ico",
            "sizes": "48x48",
            "type": "image/x-icon"
        }
    ],
    "screenshots": [
        {
            "src": baseUrl + "Assets/img/screenshots/desktop-screenshot.png",
            "sizes": "1920x1080",
            "type": "image/png",
            "form_factor": "wide"
        },
        {
            "src": baseUrl + "Assets/img/screenshots/mobile-screenshot.png",
            "sizes": "1080x1920",
            "type": "image/png",
            "form_factor": "narrow"
        }
    ],
    "related_applications": [
        {
            "platform": "webapp",
            "url": baseUrl + "manifest.json"
        }
    ],
    "launch_handler": {
        "client_mode": "navigate-new"
    }
};

// Crear un elemento <link> para el manifiesto
const link = document.createElement('link');
link.rel = 'manifest';
link.href = 'data:application/json,' + encodeURIComponent(JSON.stringify(manifest));
document.head.appendChild(link);

// Configuraciones adicionales para iOS
const metaTags = [
    { name: "apple-mobile-web-app-capable", content: "yes" },
    { name: "apple-mobile-web-app-status-bar-style", content: "black-translucent" },
    { name: "apple-mobile-web-app-title", content: "STAR" },
    { name: "theme-color", content: "#04129e" }
];

metaTags.forEach(tag => {
    const meta = document.createElement('meta');
    meta.name = tag.name;
    meta.content = tag.content;
    document.head.appendChild(meta);
});

// Agregar iconos específicos para iOS
const appleIcons = [
    { rel: "apple-touch-icon", sizes: "180x180", href: baseUrl + "Assets/img/icons/apple-touch-icon-180x180.png" },
    { rel: "apple-touch-icon", sizes: "152x152", href: baseUrl + "Assets/img/icons/apple-touch-icon-152x152.png" },
    { rel: "apple-touch-icon", sizes: "120x120", href: baseUrl + "Assets/img/icons/apple-touch-icon-120x120.png" },
    { rel: "apple-touch-icon", sizes: "76x76", href: baseUrl + "Assets/img/icons/apple-touch-icon-76x76.png" }
];

appleIcons.forEach(icon => {
    const link = document.createElement('link');
    link.rel = icon.rel;
    link.sizes = icon.sizes;
    link.href = icon.href;
    document.head.appendChild(link);
});