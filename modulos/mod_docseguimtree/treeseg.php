<?php

require_once('../../clases/conexion.php');

//$parent_id = $_GET['node'];
//echo $_GET['node'];

if ($_GET['node'] == 'root') {$parent_id = 0;} else {$parent_id = $_GET['node'];} // added by chiken

if($parent_id !="")
  {
	  if(isset($_GET['enviocodbarr'])!="")
	  {
  $query = "SELECT id, ' Usuario: '||origen_nombres||' Asunto: '||origen_form_asunto as text, ultimonivel as leaf, origen_fecha_creado as fecha,hora_ingreso, respuesta_estado as estado, destino_nombres,destino_cargo,origen_tipo_tramite,origen_tipodoc,respuesta_observacion,respuesta_comentariotxt,fech_tiempo_dias,fecha_tiempo_atencion,resp_comentario_anterior , codigo_documento FROM public.tbli_esq_plant_formunico_docsinternos WHERE codi_barras='".$_GET['enviocodbarr']."' and parent_id='".$parent_id."' order by item_orden ";
	  }
	  else
	  {
  $query = "SELECT id, ' Usuario: '||origen_nombres||' Asunto: '||origen_form_asunto as text, ultimonivel as leaf, origen_fecha_creado as fecha,hora_ingreso, respuesta_estado as estado, destino_nombres,destino_cargo,origen_tipo_tramite,origen_tipodoc,respuesta_observacion,respuesta_comentariotxt,fech_tiempo_dias,fecha_tiempo_atencion,resp_comentario_anterior, codigo_documento  FROM public.tbli_esq_plant_formunico_docsinternos WHERE codi_barras='1000002555' and parent_id='".$parent_id."' order by item_orden ";
	  }
	  
  }
else
{
	 if(isset($_GET['enviocodbarr'])!="")
	  {
  $query = "SELECT id, ' Usuario: '||origen_nombres||' Asunto: '||origen_form_asunto as text, ultimonivel as leaf, origen_fecha_creado as fecha,hora_ingreso, respuesta_estado as estado, destino_nombres,destino_cargo,origen_tipo_tramite,origen_tipodoc,respuesta_observacion,respuesta_comentariotxt,fech_tiempo_dias,fecha_tiempo_atencion,resp_comentario_anterior, codigo_documento  FROM public.tbli_esq_plant_formunico_docsinternos WHERE codi_barras='".$_GET['enviocodbarr']."' and   parent_id is null order by item_orden ";
	  }
	  else
	    {
  $query = "SELECT id, ' Usuario: '||origen_nombres||' Asunto: '||origen_form_asunto as text, ultimonivel as leaf, origen_fecha_creado as fecha,hora_ingreso, respuesta_estado as estado, destino_nombres,destino_cargo,origen_tipo_tramite,origen_tipodoc,respuesta_observacion,respuesta_comentariotxt,fech_tiempo_dias,fecha_tiempo_atencion,resp_comentario_anterior , codigo_documento FROM public.tbli_esq_plant_formunico_docsinternos WHERE codi_barras='1000002555' and   parent_id is null order by item_orden ";
	  }
	  
}
 

//$rs = mysql_query($query);
$rs = pg_query($conn,$query);     
         

$arr = array(); while($obj = pg_fetch_object($rs)) {
    $arr[] = $obj;
}

echo json_encode($arr);

?>
