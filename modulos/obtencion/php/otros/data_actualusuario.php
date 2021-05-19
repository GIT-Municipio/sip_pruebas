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
	
	
	$form->render_table("data_modusuarios","id","id, tipo_usuario, imagenicon, iniciales_nombres, cedula, apellidos, nombres, sexo, estado_civil, email, nacionalidad, direccion, coord_direccion, telf_celular, usuario, clave, estado");
	
	
	
?>