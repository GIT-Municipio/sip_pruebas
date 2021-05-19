<?php
	require_once('config.php');
	require("./connector/db_postgre.php");
	require_once('./connector/form_connector.php');
	
	$form = new FormConnector($conn, "Postgre");	
	
	//if($_REQUEST[actualizociusbddw])
	//$_REQUEST[actualizociusbdd]=true;
	///else
	//$_REQUEST[actualizociusbdd]='FALSE';
	
	$form->render_table("tblb_org_institucion","cedula_ruc","cedula_ruc,nombre,imglogo,provincia,canton,parroquia,calle_principal,calle_interseccion, referencia_cercana,autoridad_nombre,autoridad_cargo,autoridad_cedula,autoridad_represlegal,autoridad_cedula_represlegal,delegado_cedula,delegado_nombre,delegado_cargo,delegado_nrodocumento_delegacion,delegado_fecha_resolucion,actualizociusbdd,mision");
	
	
?>