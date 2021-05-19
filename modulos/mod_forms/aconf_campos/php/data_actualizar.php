<?php
	require_once('config.php');
	require("./connector/db_postgre.php");
	require_once('./connector/form_connector.php');
	
	$form = new FormConnector($conn, "Postgre");	
	
	
	if($_REQUEST[ref_data_padre]=="")
      $_REQUEST[ref_data_padre]=0;
	
	
	$form->render_table("data_departamento_direccion","id","id,nombre, director, email, telf_extension, telf_personal, objetivo, ref_data_padre, ref_institucion");
	
	
	
?>