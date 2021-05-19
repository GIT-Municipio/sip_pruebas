<?php
	require_once('config.php');
	require("./connector/db_postgre.php");
	require_once('./connector/form_connector.php');
	
	$form = new FormConnector($conn, "Postgre");	
	
	
	
	$form->render_table("tblb_org_institucion","cedula_ruc","cedula_ruc,nombre,delegado_cedula,delegado_nombre,delegado_cargo,delegado_nrodocumento_delegacion,delegado_fecha_resolucion,delegado_foto");
	
	
?>