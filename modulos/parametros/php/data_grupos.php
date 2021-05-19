<?php

	require_once("connector/dataview_connector.php");
	
	require("connector/db_postgre.php");
	
     require_once('../../../conexion.php');
	
	//$data = new FormConnector($conn, "Postgre");	
	
	
	
	$data = new DataViewConnector($conn, "Postgre");	
	
	//$data->filter("usuario_sys", "0");
	
	$data->dynamic_loading(50);
	
	//if($_GET['envcampobus']=='doc_texto_contenido')
	//$_GET['envcampobus']='doc_texto_contenido';
	
	$data->render_sql("Select * from vista_archivos_busquedas where  upper(".$_GET['envcampobus'].") like upper('%".$_GET['envinfobus']."%')","id","fecha_registro, grupo_codbarras_tramite, grup_nombre, form_cod_barras, fecha_modificacion, doc_fecha_conserv_emision, doc_param_vigencia_anios,  doc_fecha_conserv_final, doc_fecha_conserv_alerta_1, doc_fecha_conserv_alerta_2,   doc_numfolio, doc_titulo, doc_texto_contenido, doc_responsable_emision,  doc_url_info, doc_tipo_info, doc_novedades, doc_observacion,   doc_anexo, doc_estado, nombre_departamento, nombre, param_categoria,  param_tipo_documento, bodega, estanteria, nivel, revisado_por,  aprobado_por, est_novedades, est_conmetadatos, est_conservacion,  usu_respons_edit, img_verdocumento, img_configdocum, img_estado,   est_oficina, est_general, est_pasivo, est_historico, est_digital,  param_cod_tipo_docum");
		
	//$data->render_table("data_proyectos","id","nombre_proyecto,versio,fecha,usuario_sys");
	
	
	
	
?>