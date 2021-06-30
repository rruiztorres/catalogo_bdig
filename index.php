<!--
=================================================================================
Name:       Catalogo BDIG
Purpose:    Genera una salida html del catalogo y diccionario de objetos de BDIG

Author:     Raúl Ruiz Torres

Version:    3.0.8

Created:    14/07/2020
Last Act:   15/07/2020
Copyright:  (c) rrtorres 2020
Licence:    CC-BY-NC 4.0
=================================================================================
-->


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="rrtorres@mitma.es">
  
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">

  <title>BDIG | Catálogo y Diccionario de datos</title>
    <?php 
      //Cargamos dependencias y header
      include 'scripts/cargaheader.php';
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


  <div class="wrapper">


      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light fondo-header">
        <div class="navbar_logo"><img src="imagenes/IGN-Header-Tittle.png"></div>
      </nav>


      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- navbar izquierda links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="mailto:rrtorres@mitma.es" class="nav-link">Contacto</a>
          </li>
        </ul>


        <!-- FORMULARIO DE BÚSQUEDA (pendiente)
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" id="formulario" type="search" placeholder="Buscar" aria-label="search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit" id="boton-buscar">
                <i class="fas fa-search"></i>
              </button>
              <script type="text/javascript"></script>
          
            </div>
          </div>
        </form>-->


        <!-- navbar derecha links -->
        <ul class="navbar-nav ml-auto">
          <!-- Menu impresión -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-print"></i>
              <!--incluye un numero en superindice al lado del icono
              <span class="badge badge-warning navbar-badge">3</span>  -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">Opciones de impresión</span>
              <div class="dropdown-divider">
            </div>
            <a class="dropdown-item">
              <i class="fas fa-print"></i> Imprimir
              <span class="float-right text-muted text-sm"><!-- incluir un tip para el boton o similar--></span>
              </a>
            <a href="print_pdf.php" target="blank" class="dropdown-item">
              <i class="fas fa-file-pdf"></i> Guardar PDF
              <span class="float-right text-muted text-sm"><!-- incluir un tip para el boton o similar--></span>
            </a>
          </li>


          <!-- Menu notificaciones desplegable -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">1</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">1 Notificiación</span>
              <div class="dropdown-divider">
              <!-- no se utiliza -->
              </div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> Última actualización
                <span class="float-right text-muted text-sm"><?php $date = date('d-m-Y'); echo "$date";?></span>
              </a>
              <div class="dropdown-divider">
              <!-- no se utiliza -->
              </div>
              <a href="#" class="dropdown-item dropdown-footer">Catálogo BDIG - <b>Version</b> 3.0.8</a>
            </div>
          </li>


          <li class="nav-item">
            <!--Activa el panel lateral con más opciones -->
            <!--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
              <i class="fas fa-th-large"></i>
            </a>-->
          </li>
        </ul>
      </nav>
      <!-- FIN navbar izquierda -->


      <!-- Sidebar principal (opciones) -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Logo corporativo -->
        <a href="index.php" class="brand-link">
          <img class="logo" src="imagenes/logo.jpg">
          <span class="logo-text"><h3>CATÁLOGO BDIG</h3>
        </a>


        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <?php
              creaIndice();
            ?>
          </nav>
          <!-- FIN sidebar-menu -->
        </div>
        <!-- FIN sidebar -->
      </aside>


      <!-- Content Wrapper. Contenido de la pagina -->
      <div class="content-wrapper">
        <!-- Content Header (header pagina) -->

        <div class="container-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-12">
              <!-- FIN col-sm-12-->
              </div>
            <!-- FIN row mb-2-->
            </div>
          <!-- FIN container fluid-->
          </div>
        <!-- FIN container header -->
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class ="row">
              <section class="col-md-11">
                <!--llamada a las funciones de contenido principal-->
                <?php
                  creaAttrCom();
                  creaDiccionario();
                ?>
              </section>

              <section class="col-md-1">
                <span class="ir-arriba icon-arrow-up2"><i class="fas fa-arrow-up"></i></span>
              </section>
            <!--FIN row -->
            </div>
          <!--fin container fluid -->
          </div>
        </section>
      <!-- FIN content-wrapper -->
      </div>

      <footer class="main-footer">
        <!-- pie de página --> 
        <span>
            <img class="logo-footer" src="imagenes/logo.jpg"> <strong>&copy; <a href="https://ign.es"target="blank">
            Instituto Geográfico Nacional</a> </strong> C/ General Ibáñez de Íbero 3, 28003 Madrid - España
        </span>

        <div class="float-right d-none d-sm-inline-block">
        <!-- espacio de control no utilizado, queda oculto por el boton de volver arriba -->
        </div>
      </footer>

      <!-- Control de Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar iria aquí (no utilizado de momento) -->
      </aside>


  </div>
  <!-- FIN wrapper -->

  <div class="data">
    <!-- boton ir arriba -->   
    <script src="scripts/funciones.js"></script>;
  </div>

</body>

</html>
