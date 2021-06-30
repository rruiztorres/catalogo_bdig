<?php

// =================================================================================
// Name:       	creaDiccionario
// Purpose:    	Crea un diccionario de objetos geográficos a partir de una base de 
// 				datos postgreSQL e incluye las normas de captura definidas en 
// 				documentos html almacenados de modo independiente. Utiliza funciones 
// 				del archivo main.php

// Author:     	Raúl Ruiz Torres

// Version:		1.4
// 				- Cambios 1.1: Incluidas checkboxes no editables para los campos actu_bdig y vis_bdig.
// 				- Cambios 1.2: Modificada la salida de impresora para poder generar salidas PDF.
// 				- Cambios 1.3: Se incluyen los campos solo_gdb y dif_interna.
//				- Cambios 1.4: Filtramos aquellos objetos que son "solo_gdb = true" para no mostrarlos

// Created:		02/06/2020
// Last.act:	15/07/2020
// Copyright:	(c) rrtorres 2020
// Licence:		CC-BY-NC 4.0
// =================================================================================

function creaDiccionario() {
	$dbconn = onBD();
	$listado_obj = devuelveConsulta("SELECT codigo, nombre, geometria, 
		definicion, nom_corto, actu_bdig, vis_bdig FROM catalogo_btn.objetos_geograficos ORDER BY codigo");
	$counter = 0;

	//Formato para bootstrap
	echo 	"<div class=\"card\">
			<div class=\"card-header\"><h1 class=titulo>Diccionario de Objetos Geográficos</h1></div>
			<div class=\"card-body\">";

	//Comienza bucle objetos geograficos
	while (pg_fetch_array($listado_obj, null, PGSQL_ASSOC)) {
		//obtenemos las variables necesarias del array anterior
		$codigo_obj = pg_fetch_result ($listado_obj, $counter,0);
		$nombre_obj = pg_fetch_result ($listado_obj, $counter,1);
		$geometria_obj = pg_fetch_result ($listado_obj, $counter,2);
		$definicion_obj = pg_fetch_result ($listado_obj, $counter,3);
		$nom_corto = pg_fetch_result ($listado_obj, $counter,4);
		$actu_bdig = pg_fetch_result ($listado_obj, $counter,5);
		$vis_bdig = pg_fetch_result ($listado_obj, $counter,6);

		//Avanzamos un objeto en el array para la siguiente iteracion
		$counter ++; 

			//Cambio de valor campo geometría para incluir tildes (modelo BD no las tiene)
			if ($geometria_obj == "linea") {
				$geometria_obj = "Línea";
				}
				elseif ($geometria_obj == "poligono") {
				$geometria_obj = "Polígono";
				}

			//Cambio de valor campo actu_bdig (la tabla no se actualiza dentro de BDIG)
			if ($actu_bdig== "t")  {
				$actu_bdig = "checked";
				}
				elseif($actu_bdig == "f")  {
				$actu_bdig = " ";
				}

			//Cambio de valor campo vis_bdig (la tabla no se visualiza en BDIG)
			if ($vis_bdig== "t")  {
				$vis_bdig = "checked";
				}
				elseif($vis_bdig == "f")  {
				$vis_bdig = " ";
				}

		//	Cabeceras para cada objeto geográfico. Incluye el codigo y nombre del objeto
		//	Se crean una tabla para ubicar los elementos en el lugar indicado
		//	Se crean unas checkboxes bloqueadas con js para indicar la difusión y la actualización
		//	Se crea el enlace con el menu para cada objeto siendo a=name el codigo de referencia del objeto.

		echo 	"<table><tr><td style=\"width:70%\">

					<a name=$codigo_obj><h1>$codigo_obj $nombre_obj </h1></a>

					</td><td>

			 		<label>
					<input type=\"checkbox\" name=\"actualizacion\" value=\"Check Value\" 
					readonly=\"readonly\" $actu_bdig onclick=\"javascript: return false;\"/>
					Actualiza en entorno BDIG</label>

			 		</td><td>

			 		<label>
					<input type=\"checkbox\" name=\"difusion\" value=\"Check Value\" 
					readonly=\"readonly\" $vis_bdig onclick=\"javascript: return false;\"/>
					Se visualiza en BDIG</label>

					</td></tr></table>
				";


		//Imprime los datos de la cabecera de la tabla (NOM.CORTO, GEOMETRÍA, DEFINICIÓN)
		echo 	"<table class=\"table-bordered\">
					<tr>
						<td style=width:10%;><strong>NOM.CORTO:</strong></td><td style=width:60%;>$nom_corto</td>
						<td style=width:10%;><strong>GEOMETRÍA:</strong></td><td colspan=2 style=width:10%;>$geometria_obj </td>
					</tr>
					<tr><td><strong>DEFINICIÓN:</strong></td><td colspan=4> $definicion_obj</td></tr>
				";


		//Obtenemos el nombre, valor, codigo y definicion de los atributos del objeto.
		$atributos = devuelveConsulta( "SELECT dif_interna, nom_atrib, definicion, tipo_valor, 
			nom_codigo, solo_gdb FROM catalogo_btn.atributos WHERE codigo_obj = '$codigo_obj'ORDER BY orden_atr");

		//Contador para atributos del objeto
		$counter_attrb = 0; 	
		
		//Comprueba que no es atributo vacio
		$total_filas = pg_num_rows($atributos);

		//El objeto no tiene atributos. Cerramos la tabla
		if ($total_filas == 0) {
			echo "</table> </br>";

			//Incluimos las normas de captura para cada objeto
			normaCaptura($codigo_obj, $nom_corto);
		}
			
		//el objeto tiene atributos continuamos con la generación.
		else {
			echo "<tr class=subheader><td class=\"atrib\" colspan=\"4\"><strong>ATRIBUTOS</strong></td></tr>";
		
			//Comienza el bucle de atributos del objeto geografico
			while ($line = pg_fetch_array($atributos, null, PGSQL_ASSOC)) {

				//Almacenamos variables desde el array atributos
				$dif_interna = pg_fetch_result ($atributos, $counter_attrb, 0);
				$nom_atrib = pg_fetch_result ($atributos, $counter_attrb, 1);
				$definicion = pg_fetch_result ($atributos, $counter_attrb, 2);
				$tipo_valor = pg_fetch_result ($atributos, $counter_attrb, 3);
				$nom_codigo = pg_fetch_result ($atributos, $counter_attrb, 4);
				$solo_gdb = pg_fetch_result ($atributos, $counter_attrb, 5);

				//Avanzamos el indice de atributos para la siguiente iteración
				$counter_attrb++; 

					//conversion de tipo para difusion interna 
					if ($dif_interna=="f") {
						$dif_interna = "";
					} else {
						$dif_interna ="<strong>Solo disponible para difusión interna</strong>";
					}

				//Si el objeto geográfico es "solo gdb" no lo mostramos en catálogo.
				if ($solo_gdb=="t") {
				} 

				//Si no es "solo gdb" generamos salida
				else {
							
					// El atributo es tipo codelist y hay que crear una subtabla para el listado de valores.
					if ($tipo_valor == "lista_val") {  
						echo 	"<tr><td><strong>$nom_atrib</strong></td>
								<td colspan=2>
								<span class=\"containter-atributo-left\">$nom_codigo</span> 
								<span class=\"containter-atributo-right\"> $dif_interna</span>
								<br>
								$definicion<br>
								<br>VALORES<br>
								<table class=\"inner-table\">";

						// Almacenamos todos los valores posibles para el atributo que coincide con $nom_codigo
						$valor = devuelveConsulta("SELECT codigo_val, valor, definicion 
							FROM catalogo_btn.valores WHERE nom_cod_atr = '$nom_codigo' ORDER BY orden_val"); 
					
							//Comienza el bucle de valores para el atributo
							while ($line = pg_fetch_array($valor, null, PGSQL_ASSOC)) {
								echo "<tr>";
									foreach ($line as $col_value) {
										echo "<td>$col_value</td>";
									}
								echo "</tr>";
							}

						//Cerramos la subtabla del listado de valores del atributo e imprimimos 
						//el último campo de la tabla de atributos
						echo "</table><td>$tipo_valor</td></tr>";
					}

					// El atributo no es tipo codelist

					else { 
						echo "<tr><td><strong>$nom_atrib</strong></td><td colspan=2>";

							//evita que crear lineas vacías en caso de que no exista el nombre codigo.
							if (empty($nom_codigo)) {

								if (empty($dif_interna)){
									echo "$definicion";
								}
								else {
									echo "<span class=\"containter-atributo-left\"> $dif_interna</span>
										<br>$definicion";	
								}
							}

							else {
									echo "<span class=\"containter-atributo-left\"> $nom_codigo</span>
										<span class=\"containter-atributo-right	\"> $dif_interna</span>
										<br>$definicion";
							}
							
						//cierre linea
						echo "<td>$tipo_valor</td></tr>";
					}
				}
			} 

			// Fin del bucle de atributos del objeto, cierre de tabla.
			echo "</table></br>"; 

			//Incluimos las normas de captura del objeto actual (por codigo_obj)
			normaCaptura($codigo_obj, $nom_corto);
		}

	}
	// cerramos conexión con base de datos
	offBD($dbconn);

// cierre body card bootstrap
echo "</div>"; 
// cierre card bootstrap
echo "</div>"; 
}

?>