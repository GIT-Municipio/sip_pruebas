<?php
	require_once('config.php');
	require("./connector/db_postgre.php");
	require_once('./connector/form_connector.php');
	
	$form = new FormConnector($conn, "Postgre");	
	
	
	
	$form->render_table("tblb_org_institucion","cedula_ruc","cedula_ruc,nombre,autoridad_nombre,autoridad_cargo,autoridad_cedula,autoridad_represlegal,autoridad_cedula_represlegal,autoridad_foto");
	
	
?>