</html>
<!doctype html>
<html lang="en">
  <head>

    <!-- Favicon icon -->
    <link rel="icon" href="<?= media() ?>/img/favicon.ico" type="image/x-icon">

    


    
    <title><?= $data['page_tag'] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="PWA que permite a los usuarios de STAR SEGUIMIENTO Y CONTROL poder visualizar la información de los vehiculos de acuerdo a la última posición generada por el dispositivo GPS." />
    <meta name="keywords" content="PWA, Monitoreo, Seguimiento GPS vehículos">
    <meta name="author" content="STAR SEGUIMEINTO Y CONTROL" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Configuracion para android -->
     <meta name="theme-color" content="#04129e">


    <!-- Style Theme -->
    <link rel="stylesheet" href="<?= media() ?>/css/theme/style.css ">

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
                <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Guardar Credenciales.</label>
                </div>
                <button class="btn btn-block btn-primary mb-4">Iniciar Sesión</button>
                <span id="info-mensaje"></span>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
   
  <script>
    const base_url = "<?= base_url(); ?>";
  </script>

  <!-- Espacio para agregar los Script -->
  <script src="<?= media() ?>/js/theme/vendor-all.min.js"></script>
  <!-- Script Theme -->
  <script src="<?= media() ?>/js/theme/plugins/bootstrap.min.js"></script>
  <script src="<?= media() ?>/js/theme/plugins/sweetalert.min.js"></script>
  <!-- Script STAR -->
  <script src="<?= media() ?>/js/local/<?= $data['data_functions_js'] ?>"></script>
  <script src="<?= media() ?>/js/<?= $data['app'] ?>"></script>

  <script src="<?= base_url() ?>manifest.js"></script>

  </body>
</html>

