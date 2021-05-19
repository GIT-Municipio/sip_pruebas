<?php

	require_once("connector/dataview_connector.php");
	require_once('config.php');
	require("connector/db_postgre.php");
	
	require_once('../../../clases/conexion.php');
	
	//$data = new FormConnector($conn, "Postgre");	
	
	
	
	$data = new DataViewConnector($conn, "Postgre");	
	
	//$data->filter("usuario_sys", "0");
	
	$data->dynamic_loading(50);
	
	
	$data->render_sql("Select * from tbli_esq_plantilla where  fuente='Municipal'","id","nombre_plantilla,fecha_pub,refer_procesoid,total_iteracion");
		
	//$data->render_table("data_proyectos","id","nombre_proyecto,versio,fecha,usuario_sys");
	
	
	
	
?>