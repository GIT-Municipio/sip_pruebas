<?php

//echo $_GET["radioopcstado"];


require_once('../../clases/conexion.php');
session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

	//Calculamos tiempo de vida inactivo.
	$vida_session = time() - $_SESSION['tiempo'];

	//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
	if ($vida_session > $inactivo) {
		//Removemos sesión.
		session_unset();
		//Destruimos sesión.
		session_destroy();
		//Redirigimos pagina.
		header("location: http://localhost/sip_pruebas/404/404.html");
		exit();
	}
}
$_SESSION['tiempo'] = time();
//---------------------

/////////////////documento seleccionado
$vartipodocid = "";
$vartipodocodigounic = "";
$vartipodocdetalle = "";
$variddepartamactual="";
	
if(isset($_GET["myidtipodocum"])!="")
{
	$sqltipdoc = "SELECT id, codigo_doc, codigo_doc||': '|| tipo as descriptipo   FROM tbli_esq_plant_formunico_tipodoc where id='".$_GET["myidtipodocum"]."';";
	$restipdoc = pg_query($conn, $sqltipdoc);
	$vartipodocid = pg_fetch_result($restipdoc,0,'id');
	$vartipodocodigounic = pg_fetch_result($restipdoc,0,'codigo_doc');
	$vartipodocdetalle = pg_fetch_result($restipdoc,0,'descriptipo');
}


if(isset($_GET["varusulocalactiv"])!="")
{
	$sqltipdoc = "SELECT cod_depenid   FROM tblu_migra_usuarios where usua_cedula='".$_GET["varusulocalactiv"]."';";
	$restipdoc = pg_query($conn, $sqltipdoc);
	$variddepartamactual = pg_fetch_result($restipdoc,0,'cod_depenid');
}

////////SELECCIONAR AÑO ACTUAL
 $sqlalt = "select date_part('year', now())  ;";
$resmalt = pg_query($conn, $sqlalt);
$paramanioactual=pg_fetch_result($resmalt,0,0);

////////////////////SECUENCIA O CADENA DE CODIFICACION
 $sqltipdoc = "SELECT id, cod_instit, cod_depart, cod_jefatura, anio_actual, cod_tipo_doc, numer_actual,  cod_tipo_nomdoc, ref_id_departam, cod_instit||'-'||cod_depart||'-'||cod_jefatura||'-'||anio_actual||'-'||cod_tipo_doc||'-'||numer_actual as codificaciondocnum, cod_instit||'-'||cod_depart||'-'||cod_jefatura||'-'||anio_actual||'-'||cod_tipo_doc||'-' as codificaciondoctext  FROM public.tbli_esq_plant_formato_numeracion where ref_id_departam=".$variddepartamactual." and cod_tipo_doc='".$vartipodocodigounic."' and anio_actual='".$paramanioactual."'; ";
	$restipdoc = pg_query($conn, $sqltipdoc);
	$varcodificnumerinicial = pg_fetch_result($restipdoc,0,'numer_actual');
	$varcodificacionfintxt = pg_fetch_result($restipdoc,0,'codificaciondoctext');
	$varcodificacionfinun = pg_fetch_result($restipdoc,0,'codificaciondocnum');



if($_GET["varselecionusuarioenv"]!="")
{
 $sqlmr = "SELECT  usua_cedula, usua_nomb, usua_apellido,usua_cargo, usua_dependencia  FROM public.tblu_migra_usuarios where id='".$_GET["varselecionusuarioenv"]."';";
$resmigra = pg_query($conn, $sqlmr);

$paramemplced=pg_fetch_result($resmigra,$mig,0);
$paramemplnom=pg_fetch_result($resmigra,$mig,1);
$paramemplapel=pg_fetch_result($resmigra,$mig,2);
$paramemplcargo=pg_fetch_result($resmigra,$mig,3);
$paramempldepartament=pg_fetch_result($resmigra,$mig,4);



/*
 $sqlseldocum = "SELECT destino_tipodoc,destino_tipo_tramite,destino_form_asunto  FROM public.tbli_esq_plant_formunico_docsinternos where id='".$_GET["variabtrami"]."' ";
$resseldocum = pg_query($conn, $sqlseldocum);

$paramelorigen_tipodoc=pg_fetch_result($resseldocum,0,0);
$paramelorigen_tipotram=pg_fetch_result($resseldocum,0,1);
$paramelorigen_asunto=pg_fetch_result($resseldocum,0,2);
*/

}

if($_GET["varespuestusu"]==2)
{
	
if($_GET["txtingresdias"]!="")
{
 $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( codi_barras,  destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_enviado,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,fech_tiempo_dias,codif_id_tipodoc,origen_tipodoc,codif_systdoc,item_ordendoc,codigo_documento,resp_estado_anterior)   VALUES (  '0', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['sesusuario_cedula']."','".$_SESSION['sesusuario_nomcompletos']."','".$_SESSION['sesusuario_cargousu']."','".$_SESSION['sesusuario_nomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['sesusuario_cedula']."','".$_GET["radioopcstado"]."','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png','".$_GET["txtingresdias"]."','".$vartipodocid."','".$vartipodocdetalle."','".$varcodificacionfintxt."','".$varcodificnumerinicial."','".$varcodificacionfinun."','ENVIADO' );";
$resfre = pg_query($conn, $sql);
}
else
{
  $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( codi_barras,  destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_enviado,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,codif_id_tipodoc,origen_tipodoc,codif_systdoc,item_ordendoc,codigo_documento,resp_estado_anterior)   VALUES ( '0', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['sesusuario_cedula']."','".$_SESSION['sesusuario_nomcompletos']."','".$_SESSION['sesusuario_cargousu']."','".$_SESSION['sesusuario_nomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['sesusuario_cedula']."','".$_GET["radioopcstado"]."','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png','".$vartipodocid."','".$vartipodocdetalle."','".$varcodificacionfintxt."','".$varcodificnumerinicial."','".$varcodificacionfinun."','ENVIADO' );";
$resfre = pg_query($conn, $sql);
}


////////SELECCIONAR AÑO ACTUAL
 $sqlalt = "SELECT numer_actual  FROM tbli_esq_plant_formato_numeracion WHERE ref_id_departam='".$variddepartamactual."' and cod_tipo_doc='".$vartipodocodigounic."' and anio_actual='".$paramanioactual."';";
$resmalt = pg_query($conn, $sqlalt);
$paramnumactualval=pg_fetch_result($resmalt,0,0);

$paramnumactual=(int)$paramnumactualval;
$paramnumactual=$paramnumactual+1;

		$varnumauxconvreal="";

		if ($paramnumactual > 0  and $paramnumactual < 10) {
		$varnumauxconvreal='0000'.$paramnumactual;
		} 
		if ($paramnumactual > 9  and $paramnumactual < 100) {
		$varnumauxconvreal='000'.$paramnumactual;
		} 
		if ($paramnumactual > 99  and $paramnumactual < 1000) {
		$varnumauxconvreal='00'.$paramnumactual;
		}
		if ($paramnumactual > 999  and $paramnumactual < 10000) {
		$varnumauxconvreal='0'.$paramnumactual;
		}
		if ($paramnumactual > 9999  and $paramnumactual < 100000) {
		$varnumauxconvreal=$paramnumactual;
		}
		

/////////////actualizar contadores
 $sqlalt = "UPDATE public.tbli_esq_plant_formato_numeracion  SET numer_actual='".$varnumauxconvreal."' WHERE ref_id_departam='".$variddepartamactual."' and cod_tipo_doc='".$vartipodocodigounic."' and anio_actual='".$paramanioactual."';";
$resmalt = pg_query($conn, $sqlalt);



}



echo "<script>parent.w1.close();</script>";




?>