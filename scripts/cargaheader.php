<?php
// =================================================================================
// Name:        cargaHeader.php
// Purpose:     Incializa el header con las url necesarias para los plugins de 
//              bootstrap o java que se cargan. Carga las dependencias necesarias 
//              las librerias de bootstrap que se utilizan y los scripts de php
//              necesarios.
//
// Author:      Raúl Ruiz Torres
//
// Version:     1.0
// Created:     02/06/2020
// Last Act.    02/06/2020
// Copyright:   (c) rrtorres 2020
// Licence:     CC-BY-NC 4.0
// =================================================================================



//precarga de scripts php
require_once 'scripts/creaIndice.php';
require_once 'scripts/creaDiccionario.php';
require_once 'scripts/creaAttrCom.php';
require_once 'scripts/main.php';
require_once './db_conf.php';


//Activa o desactiva dependencias en header
function activaDependencia($activar,$dependencia) {
    if ($activar==TRUE) {
      echo "$dependencia";
    }
}

//Librerias========================================================================

//Jquery
$jquery="<script src=\"plugins/jquery/jquery.min.js\"></script>";
activaDependencia(TRUE,$jquery);

//Bootstrap 4
$bootstrap4="<script src=\"plugins/bootstrap/js/bootstrap.bundle.min.js\"></script>";
activaDependencia(TRUE, $bootstrap4);

//AdminLTE App
$adminlte="<script src=\"dist/js/adminlte.js\"></script>";
activaDependencia(TRUE, $adminlte);

//Hace al navegador responsive de acuerdo al ancho de pantalla
$viewport="<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
activaDependencia(FALSE,$viewport);

//Permite utilizar fuentes e iconos de font-awesome
$fontAwesome="<link rel=\"stylesheet\" href=\"plugins/fontawesome-free/css/all.min.css\">";
activaDependencia(TRUE,$fontAwesome);

//Permite utilizar Ionicicons
$ionicIcons="<link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\">";
activaDependencia(FALSE,$ionicIcons);

//Selector de fechas para emplear en calendarios
$tempusDominus="<link rel=\"stylesheet\" href=\"plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css\">";
activaDependencia(FALSE,$tempusDominus);

//Checkboxes y Radiobuttons personalizados para bootstrap4
$icheck="<link rel=\"stylesheet\" href=\"plugins/icheck-bootstrap/icheck-bootstrap.min.css\">";
activaDependencia(FALSE,$icheck);

//Mapas clickables en javascript
$jqvMap="<link rel=\"stylesheet\" href=\"plugins/jqvmap/jqvmap.min.css\">";
activaDependencia(FALSE,$jqvMap);

//Hoja de estilo AdminLTE (bootstrap4)
$adminLte="<link rel=\"stylesheet\" href=\"dist/css/adminlte.min.css\">";
activaDependencia(TRUE,$adminLte);

//Esconde las scrollbars nativas y permite utilizar otras personalizadas
$overlayScrollbars="<link rel=\"stylesheet\" href=\"plugins/overlayScrollbars/css/OverlayScrollbars.min.css\">";
activaDependencia(TRUE,$overlayScrollbars);

//Libreria para selectores de tiempo en calendarios
$daterangePicker="<link rel=\"stylesheet\" href=\"plugins/daterangepicker/daterangepicker.css\">";
activaDependencia(FALSE,$daterangePicker);

//Editores de texto en javascript tipo WYSIWYG
$summernote="<link rel=\"stylesheet\" href=\"plugins/summernote/summernote-bs4.css\">";
activaDependencia(FALSE,$summernote);

//Fuentes GoogleFonts - Sans pro
$googleFonts="<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700\" rel=\"stylesheet\">";
activaDependencia(TRUE,$googleFonts);

//Estilos css adicionales fuera de bootstrap - parte de catálogo
$customCss="<link rel=\"stylesheet\" href=\"css/styles.css\">";
activaDependencia(TRUE,$customCss);

//Añade un favicon a la pestaña del navegador
$favicon="<link rel=\"icon\" type=\"image/png\" href=\"imagenes/favicon.png\">";
activaDependencia(TRUE,$favicon);
  

?>