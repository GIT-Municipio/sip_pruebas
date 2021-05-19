<?php

require_once('../../clases/conexion.php');
session_start();

if($_GET["varselecionusuarioenv"]!="")
{
 $sqlmr = "SELECT  usua_cedula, usua_nomb, usua_apellido,usua_cargo, usua_dependencia  FROM public.tblu_migra_usuarios where id='".$_GET["varselecionusuarioenv"]."';";
$resmigra = pg_query($conn, $sqlmr);

$paramemplced=pg_fetch_result($resmigra,$mig,0);
$paramemplnom=pg_fetch_result($resmigra,$mig,1);
$paramemplapel=pg_fetch_result($resmigra,$mig,2);
$paramemplcargo=pg_fetch_result($resmigra,$mig,3);
$paramempldepartament=pg_fetch_result($resmigra,$mig,4);

 $sqlseldocum = "SELECT destino_tipodoc,destino_tipo_tramite,destino_form_asunto  FROM public.tbli_esq_plant_formunico_docsinternos where id='".$_GET["variabtrami"]."' ";
$resseldocum = pg_query($conn, $sqlseldocum);

$paramelorigen_tipodoc=pg_fetch_result($resseldocum,0,0);
$paramelorigen_tipotram=pg_fetch_result($resseldocum,0,1);
$paramelorigen_asunto=pg_fetch_result($resseldocum,0,2);


}

if($_GET["varespuestusu"]==2)
{
	
if($_GET["txtingresdias"]!="")
{
 $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras,  destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,fech_tiempo_dias,origen_id_tipo_tramite,ref_procesoform,codigo_tramite)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['sesusuario_cedula']."','".$_SESSION['sesusuario_nomcompletos']."','".$_SESSION['sesusuario_cargousu']."','".$_SESSION['sesusuario_nomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['sesusuario_cedula']."','REASIGNADO','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png','".$_GET["txtingresdias"]."','".$_GET["varcodtramite"]."','".$_GET["varcodprocesoid"]."','".$_GET["varcodifarchiv"]."' );";
$resfre = pg_query($conn, $sql);
}
else
{
 $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras,  destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,origen_id_tipo_tramite,ref_procesoform,codigo_tramite)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['sesusuario_cedula']."','".$_SESSION['sesusuario_nomcompletos']."','".$_SESSION['sesusuario_cargousu']."','".$_SESSION['sesusuario_nomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['sesusuario_cedula']."','REASIGNADO','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png','".$_GET["varcodtramite"]."','".$_GET["varcodprocesoid"]."','".$_GET["varcodifarchiv"]."' );";
$resfre = pg_query($conn, $sql);
}


 $sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,  est_respuesta_reasignado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['sesusuario_cedula']."',img_respuesta_estado='imgs/btninfo_estado_reasignado.png',respuesta_estado='REASIGNADO'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);


$mensobsre="Se Reasigno a : ".$paramemplnom." ".$paramemplapel." CARGO: ".$paramemplcargo;
////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_reasignado.png', observacion='".$mensobsre."',estadodoc='REASIGNADO' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);
}

echo "<script>window.opener.location.reload(true);window.close();</script>";

?>