<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="<?= media() ?>/img/favicon.ico" type="image/ico" />

    <!-- Manifest JSON -->
    <link rel="manifest" href="<?= base_url() ?>/manifest.json">

    <title><?= $data['page_title'] ?></title>
    <script src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script>
    <!-- Bootstrap -->
    <link href="<?= media() ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= media() ?>/vendors/dataTable/css/dataTable.css">
    <!-- Font Awesome -->
    <link href="<?= media() ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Datetimepicker  -->
    <script src="<?= media() ?>/vendors/bootstrap-daterangepicker/daterangepicker.css"></script>
    <script src="<?= media() ?>/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"></script>
    <!-- NProgress -->
    <link href="<?= media() ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- DataTable -->
    <link href="<?= media() ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?= media() ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= media() ?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?= media() ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
 

    <!-- Custom Theme Style -->
    <link href="<?= media() ?>/vendors/custom.min.css" rel="stylesheet">

<!-- Style local -->
    <link rel="stylesheet" href="<?= media() ?>/css/local/<?= $data['styles'] ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?= base_url() ?>monitoreo" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
            </div>

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
                  <li><a href="<?= base_url() ?>monitoreo"><i class="fa fa-home"></i> INICIO <span class="label label-success pull-right"></span></a></li>
                  <li><a href="<?= base_url() ?>historico"><i class="fa fa-home"></i> HISTORICO <span class="label label-danger pull-right"></span></a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
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
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <!-- Informacion del cliente -->
                    <img src="<?= media() ?>/img/user.png" alt=""><?= $_SESSION['nombre'] ?>
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    
                    <a class="dropdown-item"  href="<?= base_url() ?>logout"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        
      </div>

   
	