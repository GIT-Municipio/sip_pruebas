<?php

	require_once("connector/dataview_connector.php");
	//require_once('config.php');
	require("connector/db_postgre.php");
	
	require_once('../../../clases/conexion.php');
	
	//$data = new FormConnector($conn, "Postgre");	
	
	
	
	$data = new DataViewConnector($conn, "Postgre");	
	
	//$data->filter("usuario_sys", "0");
	
	$data->dynamic_loading(50);
	
	$_GET['envcampobus']='gparam_contenido';
	
	$data->render_sql("Select * from tbl_archivos_scanimgs where  upper(".$_GET['envcampobus'].") like upper('%".$_GET['envinfobus']."%')","id","fecha,gparam_nom_categoria,gparam_tipo_documento");
		
	//$data->render_table("data_proyectos","id","nombre_proyecto,versio,fecha,usuario_sys");
	
	
	
	
?>