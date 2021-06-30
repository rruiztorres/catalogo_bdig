<?php
// =================================================================================
// Name:       	creaIndice.php
// Purpose:    	Crea un indice en formato bootstrap (LTE admin 2) a partir de una base
// 				de datos PostgreSQL. Agrupa los objetos en temáticas según especifica
// 				ciones BDIG. Genera vistas anidadas.

// Author:     	Raúl Ruiz Torres

// Version:   	1.0
// Created:    	02/06/2020
// Last Act:	02/06/2020
// Copyright:  	(c) rrtorres 2020
// Licence:    	CC-BY-NC 4.0
// =================================================================================



function creaIndice () {
	$dbcon = onBD();
	$listado_ind = devuelveConsulta("SELECT codigo, nombre, geometria, definicion, nom_corto FROM catalogo_btn.objetos_geograficos ORDER BY codigo");


	function treeview ($nombre_seccion, $tema, $icono) {
		$elementos = count($tema);

		echo "<li class=\"nav-item has-treeview\">
            <a href=\"#\" class=\"nav-link\">
              <i class=\"nav-icon $icono\"></i>
              <p>
                $nombre_seccion
                <i class=\"fas fa-angle-left right\"></i>
                <span class=\"badge badge-info right\">$elementos</span>
              </p>
            </a>
            <ul class=\"nav nav-treeview\">";

        //salida pantalla todos elementos de array, link crea un enlace de indice para relacionar con fichas catálogo.
        foreach ($tema as $valor) {
        $link = substr($valor, 0,5);
		echo"<li class=\"nav-item\"><a class=\"nav-link objeto_link\" href\t=#$link\t><p> - $valor</p></a></li>";
		}

		echo "</li></ul>";
	}

	echo "<div class=aside>";
	$ind_counter = 0;

	//indices de array por tema
	$tema1count = $tema2count = $tema3count = $tema4count = $tema5count = $tema7count = 0;

	//bucle que recorre los objetos en la base de datos y crea un enlace siendo href el codigo del objeto
	while (pg_fetch_array($listado_ind, null, PGSQL_ASSOC)) {
		$ind_codigo_obj = pg_fetch_result ($listado_ind, $ind_counter, 0);
		$ind_nombre_obj = pg_fetch_result ($listado_ind, $ind_counter, 1);
		$ind_counter ++;

		//creamos arrays con elementos organizados por tema

		if (strncmp ( $ind_codigo_obj , '01' , 2 ) == 0) {
			$vias[$tema1count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema1count ++;
			}

		elseif (strncmp ( $ind_codigo_obj , '02' , 2 ) == 0) {
			$edif[$tema2count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema2count ++;
			}

		elseif (strncmp ( $ind_codigo_obj , '03' , 2 ) == 0) {
			$serv[$tema3count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema3count ++;
			}

		elseif (strncmp ( $ind_codigo_obj , '04' , 2 ) == 0) {
			$hidro[$tema4count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema4count ++;
			}

		elseif (strncmp ( $ind_codigo_obj , '05' , 2 ) == 0) {
			$elev[$tema5count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema5count ++;
			}

		elseif (strncmp ( $ind_codigo_obj , '07' , 2 ) == 0) {
			$espn[$tema7count] = $ind_codigo_obj.' '.$ind_nombre_obj;
			$tema7count ++;
			}

	}
	//Creamos apertura de menu (1)
	echo "<ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">";
	
		//Especificaciones
		echo "<li class=\"nav-item\">
	            <a href=\"#\" class=\"nav-link \">
	              <i class=\"nav-icon fas fa-globe-europe\"></i>
	              <p>
	                Especificaciones
	              </p></a>
	          </li>";


		//Atributos comunes
		echo "<li class=\"nav-item\">
	            <a href=\"#\" class=\"nav-link \">
	              <i class=\"nav-icon fas fa-globe-europe\"></i>
	              <p>
	                Atributos comunes
	              </p></a>
	          </li>";


	    //Diccionario (la propiedad menu-open determina si el menu aparece abierto (open) o cerrado (close) al cargar la pagina)
	    echo "<li class=\"nav-item has-treeview menu-open\">
	            <a href=\"#\" class=\"nav-link active\">
	              <i class=\"nav-icon fas fa-copy\"></i>
	              <p>
	                Diccionario y normas
	                <i class=\"fas fa-angle-left right\"></i>
	              </p>
	            </a>";

	    //Apertura treeview para generacion automatica        
	    echo "<ul class=\"nav nav-treeview\">";
		    //Generacion automatica        
			treeview("Transporte", $vias, "fas fa-road");
			treeview("Edificios y const.", $edif, "fas fa-city");
			treeview("Servicios e instal.", $serv, "fas fa-industry");
			treeview("Hidrografía", $hidro, "fas fa-water");
			treeview("Orografía y paisaje", $elev, "fas fa-mountain");
			treeview("Zonas admin.", $espn, "fas fa-tree");
			
			//cierre generacion automatica
			echo "</ul>";

	//cierre menu (1)
	echo "</ul></div>"; // cierre indice lateral
	offBD($dbcon);
}

?>