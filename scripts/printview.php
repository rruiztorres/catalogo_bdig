<!-- -->

<page> 
    <page_header> 
         <img class="header" src="imagenes/header.jpg">
    </page_header> 
    <page_footer> 
         
    </page_footer> 


<!-- generación automática para el catálogo --> 
<?php
	//los estilos no se pueden incluir como css hay que incluirlos como estilos en linea.
	include_once "css/pdfstyles.html";
	include_once "main.php";

	$dbconn = onBD();
	$listado_obj = devuelveConsulta("SELECT codigo, nombre, geometria, 
		definicion, nom_corto FROM catalogo_btn.objetos_geograficos ORDER BY codigo");
	$counter = 0;

	while (pg_fetch_array($listado_obj, null, PGSQL_ASSOC)) {
		//obtenemos las variables necesarias del array anterior
		$codigo_obj = pg_fetch_result ($listado_obj, $counter,0);
		$nombre_obj = pg_fetch_result ($listado_obj, $counter,1);
		$geometria_obj = pg_fetch_result ($listado_obj, $counter,2);
		$definicion_obj = pg_fetch_result ($listado_obj, $counter,3);
		$nom_corto = pg_fetch_result ($listado_obj, $counter,4);

		//Avanzamos un objeto en el array para la siguiente iteracion
		$counter ++; 

		//Obtenemos el nombre, valor, codigo y definicion de los atributos del objeto.
		$atributos = devuelveConsulta("SELECT nom_atrib, definicion, tipo_valor, 
			nom_codigo FROM catalogo_btn.atributos WHERE codigo_obj = '$codigo_obj'ORDER BY orden_atr");

		$counter_attrb = 0; //Contador para atributos del objeto	
		$counter_array = 1;	//Contador para


		//Cabecera para cada tabla de cada objeto geográfico se crea un enlace 
		//siendo a=name el codigo de referencia del objeto.

		echo "<a name=$codigo_obj><h1>$codigo_obj $nombre_obj </h1></a>";

		//Imprime los datos del objeto en html (codigo, nombre, geometria y definición) antes de la tabla
		echo "	<table style: border=1px solid black;>
				<tr><td class=cabecera1>FENÓMENO</td><td class=cabecera2>$nombre_obj</td><td class=cabecera3>$codigo_obj</td></tr>
				<tr><td class=cabecera1>GEOMETRÍA</td><td class=cabecera2 colspan=2>$geometria_obj</td></tr>
				<tr><td class=cabecera1>DEFINICIÓN:</td><td class=cabecera2 colspan=2>$definicion_obj</td></tr>
				";


		//Obtenemos el nombre, valor, codigo y definicion de los atributos del objeto.
		$atributos = devuelveConsulta( "SELECT nom_atrib, definicion, tipo_valor, 
			nom_codigo FROM catalogo_btn.atributos WHERE codigo_obj = '$codigo_obj'ORDER BY orden_atr");

		$counter_attrb = 0; //Contador para atributos del objeto	
		$counter_array = 1;	//Contador para


		//Comprueba que no es atributo vacio
		$total_filas = pg_num_rows($atributos);

		if ($total_filas == 0) {
			//El objeto no tiene atributos. Cerramos la tabla
			echo "</table>";

			//normas captura
			$ruta = '\\'.'\sapignmad092\00_documentos\01_especificaciones_btn\HTML_METODOS_CAPTURA'.'\\';
			$archivo = "dummy";

			include utf8_encode($ruta.$archivo.".txt");
			}

		else {
			echo "	<tr><td class=subheader colspan=3>ATRIBUTOS";

					//hago cosas

			echo "	</td></tr>";
			echo "</table>";

			//normas captura
			$ruta = '\\'.'\sapignmad092\00_documentos\01_especificaciones_btn\HTML_METODOS_CAPTURA'.'\\';
			$archivo = "dummy";

			include $ruta.$archivo.".txt";



		}
		










	}


echo "<h1>fin</h1>";




?>
<!-- fin generación automatica contenido catalogo --> 

</page> 
