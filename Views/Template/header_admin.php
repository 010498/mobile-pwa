<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	  <link rel="icon" href="<?= media() ?>/img/favicon.ico" type="image/ico" />

    <title><?= $data['page_title'] ?></title>
    <!-- <script src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script> -->
    <!-- Bootstrap -->
    <link href="<?= media() ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= media() ?>/vendors/dataTable/css/dataTable.css">
    <!-- Font Awesome -->
    <link href="<?= media() ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Datetimepicker  -->
    <script src="<?= media() ?>/vendors/bootstrap-daterangepicker/daterangepicker.css"></script>
    <script src="<?= media() ?>/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"></script>
    
    <!-- DataTable -->
    <link href="<?= media() ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?= media() ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    
    <!-- bootstrap-daterangepicker -->
    <link href="<?= media() ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- <meta name="viewport" content="width=device-width, initial-scale=no, height=device-height, viewport-fit=cover"> -->
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1 height=device-height, viewport-fit=cover" >
    <meta name="description" content="PWA que permite a los usuarios de STAR SEGUIMIENTO Y CONTROL poder visualizar la información de los vehículos de acuerdo a la última posición generada por el dispositivo GPS.">
    <meta name="keywords" content="PWA, Monitoreo, Seguimiento GPS vehículos">
    <meta name="author" content="STAR SEGUIMIENTO Y CONTROL">
    <meta name="theme-color" content="#04129e">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="STAR SEGUIMIENTO">

    <!-- Recursos iOS -->

    <link rel="apple-touch-icon" sizes="152x152" href="<?= media() ?>/img/icon/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= media() ?>/img/icon/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?= media() ?>/img/icon/icon-152x152.png">

    <link rel="apple-touch-startup-image" href="<?= media() ?>/img/icon/icon-152x152.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1242x2208.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="<?= media() ?>/img/icon-ios/apple-launch-750x1334.png">
    <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1125x2436.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="<?= media() ?>/img/icon-ios/apple-launch-1242x2208.png">

   
 

    <!-- Custom Theme Style -->
    <link href="<?= media() ?>/vendors/custom.min.css" rel="stylesheet">

    <!-- Style local -->
    <link rel="stylesheet" href="<?= media() ?>/css/local/<?= $data['styles'] ?>">
  </head>

  <body class="nav-md ontouchstart">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <!-- <div class="navbar nav_title" style="border: 0;">
              <a href="<?= base_url() ?>monitoreo" class="site_title"><i class="fa fa-paw"></i> <span>STAR S</span></a>
            </div> -->
            <br><br>
            
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?= media() ?>/img/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <!-- Informacion nombre del cliente -->
                <h2><?= $_SESSION['nombre'] ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="<?= base_url() ?>monitoreo"> INICIO </a></li>
                  <li><a href="<?= base_url() ?>historico"> HISTORICO </a></li>
                  <li><a href="<?= base_url() ?>reportes"> REPORTES </a></li>
                  <li><a href="<?= base_url() ?>logout"> CERRAR SESIÓN </a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile" >
                    <!-- Informacion del cliente -->
                    <img src="<?= media() ?>/img/user.png" alt=""><?= $_SESSION['nombre'] ?>
                  </a>
                  
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        
      </div>

   
	