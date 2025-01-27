<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Favicon -->
    <link rel="icon" href="<?= media() ?>/img/favicon.ico" type="image/x-icon">

    <title><?= $data['page_tag'] ?></title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=no, height=device-height, viewport-fit=cover"> -->
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1 height=device-height, viewport-fit=cover" >
    <meta name="description" content="PWA que permite a los usuarios de STAR SEGUIMIENTO Y CONTROL poder visualizar la información de los vehículos de acuerdo a la última posición generada por el dispositivo GPS.">
    <meta name="keywords" content="PWA, Monitoreo, Seguimiento GPS vehículos">
    <meta name="author" content="STAR SEGUIMIENTO Y CONTROL">
    <meta name="theme-color" content="#04129e">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="STAR SEGUIMIENTO">

    <!-- Recursos iOS -->
    <link rel="apple-touch-startup-image" href="<?= media() ?>/img/icon/icon-152x152.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1242x2208.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="<?= media() ?>/img/icon-ios/apple-launch-750x1334.png">
    <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1125x2436.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1242x2208.png">

    <!-- CSS -->
   <link rel="stylesheet" href="<?= media() ?>/css/theme/style.css">
   <link rel="stylesheet" href="<?= media() ?>/vendors/custom.min.css">
</head>

  <body>
    <div class="auth-wrapper">
      <div class="auth-content text-center">
        <img src="assets/img/logo-letras negras.png" alt="" class="img-fluid mb-4">
      <div class="card borderless">
        <div class="row align-items-center ">
          <div class="col-md-12">
            <form name="form-login" id="form-login">
              <div class="card-body">
                <h4 class="mb-3 f-w-400">Iniciar Sesión</h4>
                <hr>
                <div class="form-group mb-3">
                  <input type="text" class="form-control" id="user-info" name="user-info" autofocus autocomplete="off" placeholder="Usuario">
                </div>
                <div class="form-group mb-4 position-relative">
                  <input type="password" class="form-control" id="pass-info" name="pass-info" autocomplete="off" placeholder="Contraseña">
                  <button type="button" class="btn-eye" onclick="togglePasswordVisibility()" aria-label="Mostrar/Ocultar Contraseña">
                    <i id="eye-icon" class="fa fa-eye"></i>
                  </button>
                </div>
                <button class="btn btn-primary">Iniciar Sesión</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
   
  <script>
    const base_url = "<?= base_url(); ?>";
  </script>

  <!-- Script STAR -->
  <script src="<?= media() ?>/js/local/<?= $data['data_functions_js'] ?>"></script>
  <script src="<?= media() ?>/js/<?= $data['app'] ?>"></script>

  <script src="<?= base_url() ?>manifest.js"></script>

  <script type="module">
      // Import the functions you need from the SDKs you need
      import { initializeApp } from "https://www.gstatic.com/firebasejs/11.2.0/firebase-app.js";
      import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.2.0/firebase-analytics.js";
      // TODO: Add SDKs for Firebase products that you want to use
      // https://firebase.google.com/docs/web/setup#available-libraries

      // Your web app's Firebase configuration
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      const firebaseConfig = {
        apiKey: "AIzaSyCSXyD2IwOtLWSgIXxhlDNpznUcuJ3334Q",
        authDomain: "pwa-starseguimiento.firebaseapp.com",
        projectId: "pwa-starseguimiento",
        storageBucket: "pwa-starseguimiento.firebasestorage.app",
        messagingSenderId: "1059923768921",
        appId: "1:1059923768921:web:9cc30cbc9dced8ee542348",
        measurementId: "G-Z12DG9QE1Z"
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);
      const analytics = getAnalytics(app);
    </script>
  </body>
</html>

