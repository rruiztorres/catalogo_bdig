<?php

//Crea una conexion con una base de datos postgresql
function onBD () {
	// desde db_conf
	$connect = setBD();
	// Conexion a la base de datos
 	$dbconn = pg_connect($connect)
  			or die('No ha podido crearse la conexión compruebe host, base de datos, usuario y contraseña: ' . pg_last_error());
  	return $dbconn;
}
//================================================================================================================================================
//================================================================================================================================================

//Desconecta la base de datos conectada en conectaBD
function offBD($dbconn) {
	pg_close($dbconn);
	$date = date('d-m-Y');
	return ("BD desconectada el $date");
}
//================================================================================================================================================
//================================================================================================================================================


//Devuelve un array de resultados a partir de una consulta SQL ($query)
function devuelveConsulta ($query) {
	$consulta = pg_query($query)
		or die('La consulta de atributos falló: ' . pg_last_error()); 
	return $consulta;
}

//================================================================================================================================================
//================================================================================================================================================


// Incrusta la norma de captura para cada objeto geográfico
function normaCaptura ($codigo_obj, $nom_corto) {
	$ruta = '\\'.'\sapignmad092\00_documentos\01_especificaciones_btn\HTML_METODOS_CAPTURA'.'\\';
	$archivo = $codigo_obj.'_'.$nom_corto;

	$path = $ruta.$archivo.".html";
	echo "<br>";
	include $path;
	echo "<br><hr></hr></br>";
}
//================================================================================================================================================
//================================================================================================================================================


?>
