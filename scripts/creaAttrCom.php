<?php

// =================================================================================
// Name:       	creaAttrCom
// Purpose:   	Crea la entrada de atributos comunes en el catálogo a partir de una 
// 				base de datos postgreSQL. Utiliza funciones del archivo main.php

// Author:     	Raúl Ruiz Torres

// Version:		1.1
// 				-Cambios 1.1: Se diferencian los atributos según el tipo de difusión

// Created:		02/05/2020
// Last Act:	13/07/2020
// Copyright:	(c) rrtorres 2020
// Licence:		CC-BY-NC 4.0
// =================================================================================

function creaAttrCom () {
	$dbconn = onBD();
	$listado_obj = devuelveConsulta("SELECT nom_atrib, tipo_valor, definicion, dif_interna 
		FROM catalogo_btn.atributos_comunes ORDER BY orden_atr");

	$counter = 0;

	//Generamos la salida para el inicio de la tarjeta bootstrap, cabecera e inicio de la tabla de atributos
	echo 	"<div class=\"card\">
		 	<div class=\"card-header\"><a name=\"atributoscomunes\"><h1 class=titulo>Atributos comunes</h1></div></a>
			<div class=\"card-body\">
		 	<table class=\"table-bordered\">
		 	<tr class=subheader style=\"font-weight:bolder\";><td>NOMBRE ATRIBUTO</td><td>DEFINICIÓN</td>
		 	<td>TIPO VALOR</td><td>DIFUSIÓN</strong></td><tr>
		 	</div>";

	//Inicio bucle atributos comunes	 	
	while (pg_fetch_array($listado_obj, null, PGSQL_ASSOC)) {
		$nom_atrib = pg_fetch_result ($listado_obj, $counter,0);
		$tipo_valor = pg_fetch_result ($listado_obj, $counter,1);
		$definicion = pg_fetch_result ($listado_obj, $counter,2);
		$dif_interna = pg_fetch_result ($listado_obj, $counter,3);

			//Conversor de tipo para dif_interna
			if ($dif_interna == 't') {
				$dif_interna = '<strong>Solo disponible para difusión interna.</strong>';
			} else {
				$dif_interna = 'En difusión';
			}

		//Avanzamos un atributo
		$counter++;

		echo"<tr><td>$nom_atrib</td><td>$definicion</td><td>$tipo_valor</td><td>$dif_interna</td></tr>";
	}
	//Cierre de elementos
	echo "</table>
		<br><br>
		</div> 
		</div>";

//Desconectamos BD
offBD($dbconn);
}

?>