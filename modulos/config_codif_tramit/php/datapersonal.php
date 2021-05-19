<?php
	require_once('config.php');
	require("./connector/db_postgre.php");
	require_once('./connector/form_connector.php');
	
	$form = new FormConnector($conn, "Postgre");	
	
	
	if($_REQUEST[data_tipo_activusuarios]=="true")
	  $_REQUEST[data_tipo_activusuarios]=1;
	  else
      $_REQUEST[data_tipo_activusuarios]=2;
	  
	  $_REQUEST[tipo_usuario]=0;
	  $_REQUEST[ref_departamento]=0;
	
	
	$form->render_table("data_modusuarios","id","id,cedula, nombres, apellidos, cargo, titulo, email, telefono, usuario, clave, biografia, tipo_usuario, ref_departamento, data_tipo_activusuarios");
	
	
	
?>