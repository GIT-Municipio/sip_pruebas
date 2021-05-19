<?php

	require_once("connector/dataview_connector.php");
	require_once('config.php');
	require("connector/db_postgre.php");
	
	require_once('../../../clases/conexion.php');
	
	//$data = new FormConnector($conn, "Postgre");	
	
	
	
	$data = new DataViewConnector($conn, "Postgre");	
	
	//$data->filter("usuario_sys", "0");
	
	$data->dynamic_loading(50);
	
	
	$data->render_sql("Select * from data_proyectos where  usuario_sys='".$_GET[misuario]."'","id","nombre_proyecto,versio,fecha,usuario_sys,descripcion,imagenicon,num_aplicaciones");
		
	//$data->render_table("data_proyectos","id","nombre_proyecto,versio,fecha,usuario_sys");
	
	
	
	
?>