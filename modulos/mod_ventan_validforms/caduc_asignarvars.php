<?php


require_once('clases/conexion.php');

$ponciudireccion="";
$ponciutelf="";
$ponciumail="fausluc@gmail.com";
$listadepartxver="";

//echo "hola ";


/////////////////SELECCION DE LOS USUARIOS
if($_GET["varselecionusuarioenv"]!="")
$sqlmr = "SELECT  usua_cedula, usua_nomb, usua_apellido,usua_cargo, usua_dependencia  FROM public.vista_listasuarios where id='".$_GET["varselecionusuarioenv"]."';";
else
$sqlmr = "SELECT  usua_cedula, usua_nomb, usua_apellido,usua_cargo, usua_dependencia  FROM public.vista_listasuarios where selec_tempo=1;";
$resmigra = pg_query($conn, $sqlmr);
//////////////////procso de insercion al gestor documental

/////////////////SELECCION DE LOS DATOS DE FORMULARIO
if($_GET["varespuestusu"]==0)
{
 $sqlseldocum = "SELECT origen_tipo_doc,origen_tipo_tramite,form_asunto  FROM public.tbli_esq_plant_formunico where id='".$_GET["variabtrami"]."' ";
}
else
{
 $sqlseldocum = "SELECT destino_tipodoc,destino_tipo_tramite,destino_form_asunto  FROM public.tbli_esq_plant_formunico_docsinternos where id='".$_GET["variabtrami"]."' ";
}
if($_GET["variabtrami"]!="")
{
$resseldocum = pg_query($conn, $sqlseldocum);
$paramelorigen_tipodoc=pg_fetch_result($resseldocum,0,0);
$paramelorigen_tipotram=pg_fetch_result($resseldocum,0,1);
$paramelorigen_asunto=pg_fetch_result($resseldocum,0,2);
}
else
{
	if($_GET["varespuestusu"]==-1)
	{
		$paramelorigen_tipodoc="MEMORANDO DIRECCION";
		$paramelorigen_tipotram="MEMORANDO";
	}
	if($_GET["varespuestusu"]==-2)
	{
		$paramelorigen_tipodoc="OFICIO DIRECCION";
		$paramelorigen_tipotram="OFICIO";
	}
	if($_GET["varespuestusu"]==-3)
	{
		$paramelorigen_tipodoc="RESOLUCION DIRECCION";
		$paramelorigen_tipotram="RESOLUCION";
	}

}
///////////////////////////////////////////////////////////////////////////////////
if($_GET["informacioncontenido"]!="")
{
$parasumillenviarcontexto=$_GET["informacioncontenido"];
$paramelorigen_asunto=$parasumillenviarcontexto;
}
else
$parasumillenviarcontexto="Finalizado con exito el Tramite: ".$paramelorigen_asunto;
///////////////////////////////////////////////////////////////////////////////////

for($mig=0;$mig<pg_num_rows($resmigra);$mig++)
{
//////////////////parametros del empleado al que se va enviar

$paramemplced=pg_fetch_result($resmigra,$mig,0);
$paramemplnom=pg_fetch_result($resmigra,$mig,1);
$paramemplapel=pg_fetch_result($resmigra,$mig,2);
$paramemplcargo=pg_fetch_result($resmigra,$mig,3);
$paramempldepartament=pg_fetch_result($resmigra,$mig,4);

$listadepartxver.=pg_fetch_result($resmigra,$mig,4).",";
//$listacedulstxver.=pg_fetch_result($resmigra,$mig,0).",";
$listacedulstxver.= "NOMBRE: ".$paramemplnom." ".$paramemplapel." CARGO: ".$paramemplcargo.","."\n";
///////////////BUSCAR USUARIO SI NO EXISTE CREARLO

$sqlactciuda="select count(*) from  usuarios where  USUA_CEDULA='".$_GET["xced"]."';"; 
$consveciudadano=pg_query($conn,$sqlactciuda);
$miresulverciud=pg_fetch_result($consveciudadano,0,0);
if($miresulverciud==0)
{
	 $sqlinsertciu= "INSERT INTO CIUDADANO (INST_CODI,CIU_ESTADO,CIU_CEDULA,CIU_NOMBRE,CIU_APELLIDO,CIU_DIRECCION,CIU_EMAIL,CIU_TELEFONO,CIUDAD_CODI,CIU_NUEVO,USUA_CODI_ACTUALIZA,CIU_FECHA_ACTUALIZA,CIU_OBS_ACTUALIZA) VALUES (1,1,'".$_GET["xced"]."','".$_GET["xnom"]."','".$_GET["xapel"]."','".$ponciudireccion."','".$ponciumail."','".$ponciutelf."',213,0,0,now(),'Registro Nuevo'); update ciudadano set ciu_nuevo=1, ciu_pasw=md5('".$_GET["xced"]."') where ciu_cedula='".$_GET["xced"]."';";

$consverfre=pg_query($conn,$sqlinsertciu);
}

///////////////////////////////////////////////SELECCIONAMOS CLIENTE CREADO ORIGEN
$sqlselusucread =	"SELECT usua_codi,USUA_CEDULA,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO   FROM usuarios where usua_cedula='".$_GET["xced"]."'";
$resusuariorig=pg_query($conn,$sqlselusucread);
$resusuario_orig_id=pg_fetch_result($resusuariorig,0,0);


///////////////////////////////////////////////SELECCIONAMOS CLIENTE CREADO DESTINO 
 $sqlselusuprop =	"SELECT usua_codi,USUA_CEDULA,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO   FROM usuarios where usua_cedula='".$paramemplced."'";
$resusuaridestin=pg_query($conn,$sqlselusuprop);
$resusuario_destin_id=pg_fetch_result($resusuaridestin,0,0);



////////////////////////////////////////////////////////////////////////////////////////////////
///TRATAMIENTO DE LA INFORMACION
$codnumdepenidprocesgd=1;

 $sql =	"select count(*) from radicado_sec_temp where depe_codi='".$codnumdepenidprocesgd."' ";
$consul=pg_query($conn,$sql);
$verifexistemp=pg_fetch_result($consul,0,0);
/*
if($verifexistemp==0)
{
$sql =	 "insert into radicado_sec_temp (depe_codi,secuencia) values ('".$codnumdepenidprocesgd."' ,1)";
$consul=pg_query($conn,$sql);
}
*/
 $sql =	"select max(secuencia) from radicado_sec_temp where depe_codi='".$codnumdepenidprocesgd."' ";
$consul=pg_query($conn,$sql);
$numersecun=pg_fetch_result($consul,0,0)+1;   /////secuencia


$sql =	"update radicado_sec_temp set secuencia=".$numersecun." where depe_codi='".$codnumdepenidprocesgd."' ;";
$consul=pg_query($conn,$sql);

///SECUENCIA DEL RADICADO ORIGEN
$sql =	"select max(RADI_NUME_RADI) from RADICADO";
$consul=pg_query($conn,$sql);
$numersecdocumorig=pg_fetch_result($consul,0,0)+1;   /////secuencia

////hast mientras
//$numersecdocumorig = "20180000030000".$numersecun;

/// FUNCION QUE INSERTA UN RADICADO NUEVO
/// @param $tpRad Tipo de radicado o documento
/// @param $Dependencia Area

///////////COMO ES CIUDADANO SIEMPRE ES ESTE CODIGO
$codigDependencia=1;////  1 para ciudadanos 3 para GADC institut
$tpRad=1;           /////oficio
$secNew = $numersecun; 	
$numersecdocumorig = date("Y") . str_pad($codigDependencia,6,"0", STR_PAD_LEFT) . str_pad($secNew,9,"0", STR_PAD_LEFT) . $tpRad;

/*
 $sql =	"INSERT INTO RADICADO (RADI_NUME_RADI,RADI_NUME_TEMP,RADI_NUME_TEXT,RADI_TEXT_TEMP,RADI_FECH_RADI,RADI_FECH_OFIC,
ESTA_CODI,RADI_USUA_RADI,RADI_USUA_ACTU,RADI_INST_ACTU,RADI_TIPO,
RADI_FLAG_IMPR,RADI_USUA_REM,RADI_USUA_DEST,RADI_ASUNTO,RADI_PERMISO,RADI_OCULTAR_RECORRIDO,
RADI_USUA_REDIRIGIDO,USAR_PLANTILLA,AJUST_TEXTO,RADI_TIPO_IMPRESION,COD_CODI,CAT_CODI) 
VALUES ('".$numersecdocumorig."','".$numersecdocumorig."','CIUDADANO-2018-".$numersecun."-O','CIUDADANO-2018-".$numersecun."-O',now(),now(),
1,".$resusuario_orig_id.",".$resusuario_orig_id.",3,3,
0,'-".$resusuario_orig_id."-','-".$resusuario_destin_id."-','".$paramelorigen_asunto."',0,0,
0,1,100,'1',0,0)";
$consul=pg_query($conn,$sql);


$sql =	"select max(TEXT_CODI) from RADI_TEXTO";
$consul=pg_query($conn,$sql);
$numsecraditextcod=pg_fetch_result($consul,0,0)+1;   /////secuencia

 $sql =	"INSERT INTO RADI_TEXTO (TEXT_CODI,RADI_NUME_RADI,TEXT_FECHA,TEXT_TEXTO) VALUES ('".$numsecraditextcod."',".$numersecdocumorig.",now(),'Solicitar de la manera mas comedida el tramite de: ".$paramelorigen_asunto."')";
$consul=pg_query($conn,$sql);


$sql =	"UPDATE RADI_TEXTO SET RADI_NUME_RADI='".$numersecdocumorig."',TEXT_FECHA=now(),TEXT_TEXTO='Solicitar de la manera mas comedida el tramite de: ".$paramelorigen_asunto."' WHERE TEXT_CODI='".$numsecraditextcod."'";
$consul=pg_query($conn,$sql);

$sql =	"UPDATE RADICADO SET RADI_TEXTO='".$numsecraditextcod."' WHERE RADI_NUME_RADI='".$numersecdocumorig."'";
$consul=pg_query($conn,$sql);


$sql =	"insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) values ('".$numersecdocumorig."',".$resusuario_orig_id.",".$resusuario_destin_id.",2,'Documento No. CIUDADANO-2018-".$numersecun."-O',now());";
$consul=pg_query($conn,$sql);


$sql =	"update radicado set RADI_LEIDO=1    where  radi_usua_actu = ".$resusuario_orig_id."  and  radi_nume_radi = '".$numersecdocumorig."';";
$consul=pg_query($conn,$sql);


$sql = "INSERT INTO log_archivo_descarga (usua_codi,fecha,radi_nume_radi,arch_tipo,tipo_descarga) VALUES (".$resusuario_orig_id.",now(),'".$numersecdocumorig."',0,'embeded');";
$consul=pg_query($conn,$sql);


$sql = "insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) values ('".$numersecdocumorig."',".$resusuario_orig_id.",".$resusuario_destin_id.",65,'Atencion Ciudadana',now());";
$consul=pg_query($conn,$sql);


/////////////////SE inserta el origen cambiar datos de usuario que emite
$sql = "INSERT INTO USUARIOS_RADICADO (RADI_NUME_RADI,RADI_USUA_TIPO,USUA_CEDULA,USUA_NOMBRE,USUA_APELLIDO,USUA_TITULO,USUA_ABR_TITULO,USUA_INSTITUCION,USUA_EMAIL,USUA_AREA_CODI,USUA_CODI,INST_CODI,USUA_CIUDAD,USUA_AREA,USUA_CARGO) VALUES ('".$numersecdocumorig."',1,'".$_GET["xced"]."','".$_GET["xnom"]."','".$_GET["xapel"]."','Señor','Sr.','Ciudadano','".$ponciumail."',3,".$resusuario_orig_id.",3,'Cotacachi','Ciudadanos','CIUDADANO')";
$consul=pg_query($conn,$sql);

/////////////////SE inserta el destino cambiar datos de usuario que recibe

$sql = "INSERT INTO USUARIOS_RADICADO (RADI_NUME_RADI,RADI_USUA_TIPO,USUA_CEDULA,USUA_NOMBRE,USUA_APELLIDO,USUA_TITULO,USUA_ABR_TITULO,USUA_INSTITUCION,USUA_EMAIL,USUA_AREA_CODI,USUA_CODI,INST_CODI,USUA_CIUDAD,USUA_AREA,USUA_CARGO) VALUES ('".$numersecdocumorig."',2,'".$paramemplced."','".$paramemplnom."','".$paramemplapel."','Señor','Sr.','GAD MUNICIPAL DE COTACACHI','fausluc@gmail.com',3,".$resusuario_destin_id.",3,'Cotacachi','GAD MUNICIPAL DE COTACACHI','JEFE')";
$consul=pg_query($conn,$sql);
*/
/*
$sql =	"select count(*) from formato_numeracion where depe_codi='".$codnumdepenidprocesgd."' and fn_tiporad=1 ";
$consul=pg_query($conn,$sql);
$verifexistemp=pg_fetch_result($consul,0,0);


if($verifexistemp==0)
{
$sql = "insert into formato_numeracion (fn_abr_texto, fn_formato, depe_codi, depe_numeracion, fn_tiporad)
                            values ('O', 'inst-dep-anio-secuencial-tipodoc', '".$codnumdepenidprocesgd."', '".$codnumdepenidprocesgd."', 1)";
$consul=pg_query($conn,$sql);
}

$sql = "UPDATE formato_numeracion SET fn_contador=".$numersecun."  WHERE fn_tiporad=1 and depe_codi='".$codnumdepenidprocesgd."' ";
$consul=pg_query($conn,$sql);

///SECUENCIA DEL RADICADO DESTINO
$sql =	"select max(RADI_NUME_RADI) from RADICADO";
$consul=pg_query($conn,$sql);
$numersecdocumdestino=pg_fetch_result($consul,0,0)+1;   /////secuencia
*/
////hasta mientras
//$numersecdocumdestino = "20180000050000".$numersecun;

/// FUNCION QUE INSERTA UN RADICADO NUEVO
/// @param $tpRad Tipo de radicado o documento
/// @param $Dependencia Area

/*
/////////////////CAMBIAR LA DEPENDENCIA
$codigDependencia=3;////  1 para ciudadanos 3 para GADC institut
$tpRad=1;           /////oficio
$secNew = $numersecun; 	
$numersecdocumdestino = date("Y") . str_pad($codigDependencia,6,"0", STR_PAD_LEFT) . str_pad($secNew,9,"0", STR_PAD_LEFT) . $tpRad;



 $sql = "INSERT INTO RADICADO (RADI_NUME_RADI,RADI_NUME_TEMP,RADI_NUME_TEXT,RADI_TEXT_TEMP,RADI_FECH_RADI,RADI_FECH_OFIC,
ESTA_CODI,RADI_USUA_RADI,RADI_USUA_ACTU,RADI_INST_ACTU,RADI_TIPO,
RADI_FLAG_IMPR,RADI_USUA_REM,RADI_USUA_DEST,RADI_ASUNTO,RADI_PERMISO,RADI_OCULTAR_RECORRIDO,
RADI_USUA_REDIRIGIDO,USAR_PLANTILLA,AJUST_TEXTO,RADI_TIPO_IMPRESION,COD_CODI,CAT_CODI) 
VALUES ('".$numersecdocumdestino."','".$numersecdocumorig."','CIUDADANO-2018-".$numersecun."-O','CIUDADANO-2018-".$numersecun."-O',now(),now(),
4,".$resusuario_orig_id.",".$resusuario_orig_id.",3,3,
1,'-".$resusuario_orig_id."-','-".$resusuario_destin_id."-','".$paramelorigen_asunto."',0,0,
0,1,100,'1',0,0)";
$consul=pg_query($conn,$sql);

$sql = "insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) values ('".$numersecdocumdestino."',".$resusuario_orig_id.",".$resusuario_destin_id.",2,'Recepcion Atencion Ciudadana',now());";
$consul=pg_query($conn,$sql);


$sql = "insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH,HIST_REFERENCIA) values ('".$numersecdocumorig."',".$resusuario_orig_id.",".$resusuario_destin_id.",2,'Se generó documento para Marisol Tulcanaza.',now(),'".$numersecdocumdestino."')";
$consul=pg_query($conn,$sql);

$sql = "update radicado set radi_fech_agend=null, esta_codi=3 , radi_fech_ofic = now(), radi_nume_text='CIUDADANO-2018-".$numersecun."-O' where RADI_NUME_RADI = '".$numersecdocumorig."'";
$consul=pg_query($conn,$sql);

$sql = "update radicado set esta_codi=5 where radi_nume_radi<>'".$numersecdocumorig."' and radi_nume_temp='".$numersecdocumorig."';";
$consul=pg_query($conn,$sql);

$sql = "update radicado set esta_codi=6 where radi_nume_radi='".$numersecdocumorig."';";
$consul=pg_query($conn,$sql);

$sql = "update radicado set esta_codi=2, radi_usua_actu=".$resusuario_destin_id.", radi_nomb_usua_firma=null, radi_fech_firma=null, radi_leido=0 where radi_nume_radi='".$numersecdocumdestino."';";
$consul=pg_query($conn,$sql);

$sql = "insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) values ('".$numersecdocumdestino."',".$resusuario_orig_id.",".$resusuario_destin_id.",19,'Recepcion Atencion Ciudadana&lt;br/>',now());";
$consul=pg_query($conn,$sql);


$sql = "insert into HIST_EVENTOS(RADI_NUME_RADI,USUA_CODI_ORI,USUA_CODI_DEST,SGD_TTR_CODIGO,HIST_OBSE,HIST_FECH) values ('".$numersecdocumorig."',".$resusuario_orig_id.",".$resusuario_destin_id.",19,'Recepcion Atencion Ciudadana&lt;br/>Envío manual del documento al usuario',now());";
$consul=pg_query($conn,$sql);
*/
/////////////////////////////////////////////////////////////////////////////////////////////////

session_start();
//-------------------------------
header("Refresh: 1210");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 1200; //20min.

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


if($_GET["varespuestusu"]==0)
{
	 $sqlaactfre ="select origen_id_tipo_tramite from public.tbli_esq_plant_formunico WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);
$varorigidtrwm=pg_fetch_result($resfre,0,0);

if( $varorigidtrwm!="")
{
 $sqlaactfre ="SELECT  ced_responsable,ced_asistente,ref_id_depart  FROM public.tbli_esq_plant_form_cuadro_clasif WHERE id='".$varorigidtrwm."';";
$resfre = pg_query($conn, $sqlaactfre);
$varusu_ref_id_depart=pg_fetch_result($resfre,0,'ref_id_depart');
}
else
$varusu_ref_id_depart=1;
//////////////////////////////////////////////////////////////////////////////////

 $sqlseleentrad = "SELECT cedula,  ciud_apellidos, ciud_nombres,ciud_domicilio, ciud_telefono, ciud_email,  origen_tipo_tramite, origen_tipo_doc, origen_nro_documento, origen_urbano_rural, origen_institucion,  origen_id_tipo_tramite, origen_id_tipo_doc, usu_asigdepartamento, usu_asigresponsable,origen_institucion,codigo_tramite  FROM public.tbli_esq_plant_formunico WHERE id='".$_GET["variabtrami"]."';";
$ressenetradausu = pg_query($conn, $sqlseleentrad);

$varorigen_cedul=pg_fetch_result($ressenetradausu,0,'cedula');
$varorigen_nombres=pg_fetch_result($ressenetradausu,0,'ciud_nombres').' '.pg_fetch_result($ressenetradausu,0,'ciud_apellidos');
$varorigen_cargo='CIUDADANO';
$varorigen_departament='CIUDADANO';
$varorigen_tipo_tramite=pg_fetch_result($ressenetradausu,0,'origen_tipo_tramite');
$varorigen_tipodoc=pg_fetch_result($ressenetradausu,0,'origen_tipo_doc');
$varorigen_form_asunto=pg_fetch_result($ressenetradausu,0,'origen_tipo_tramite');
$varorigen_urbano_rural=pg_fetch_result($ressenetradausu,0,'origen_urbano_rural');

$varciud_domicilio=pg_fetch_result($ressenetradausu,0,'ciud_domicilio');
$varciud_telefono=pg_fetch_result($ressenetradausu,0,'ciud_telefono');
$varciud_email=pg_fetch_result($ressenetradausu,0,'ciud_email');
$varorigen_institucion=pg_fetch_result($ressenetradausu,0,'origen_institucion');
$varorigen_nro_documento=pg_fetch_result($ressenetradausu,0,'origen_nro_documento');
///////////////////////////////////////////
$varcodigo_tramite=pg_fetch_result($ressenetradausu,0,'codigo_tramite');
if(pg_fetch_result($ressenetradausu,0,'origen_id_tipo_doc'))
$varorigen_id_tipo_doc=pg_fetch_result($ressenetradausu,0,'origen_id_tipo_doc');
else
$varorigen_id_tipo_doc=0;
//////////////////////////////////////////////////////


  $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( codi_refid, codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,usu_respons_edit,  origen_tipo_tramite, origen_tipodoc,origen_form_asunto, origen_urbano_rural,origen_institucion,origen_nro_documento,codigo_tramite,codif_id_tipodoc,usu_asigdepartamento)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$varorigen_cedul."','".$varorigen_nombres."','".$varorigen_cargo."','".$varorigen_departament."',1,'".$_SESSION['vermientuscedula']."','".$varorigen_tipo_tramite."','".$varorigen_tipodoc."','".$varorigen_form_asunto."','".$varorigen_urbano_rural."','".$varorigen_institucion."' ,'".$varorigen_nro_documento."','".$varcodigo_tramite."','".$varorigen_id_tipo_doc."','".$varusu_ref_id_depart."');";

////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_pendiente.png' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);

}

if($_GET["varespuestusu"]==1)
{
$sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id, codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,est_respuesta_enedicion,usu_respons_edit,respuesta_estado)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$parasumillenviarcontexto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_atendido.png',0,'".$_SESSION['vermientuscedula']."','RECIBIDO' );";

/*
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET  img_respuesta_estado='imgs/btninfo_estado_finalizado.png',  est_respuesta_enviado=1,est_respuesta_atendido=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."', respuesta_comentariotxt='".$parasumillenviarcontexto."'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);
*/
/////////////

$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET  IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,img_respuesta_estado='imgs/btninfo_estado_finalizado.png',  est_respuesta_enviado=1,est_respuesta_atendido=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."', respuesta_comentariotxt='".$parasumillenviarcontexto."',respuesta_estado='ENVIADO'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);



$mensobsre="Se Respondio a: ".$paramemplnom." ".$paramemplapel." CARGO: ".$paramemplcargo;

////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_atendido.png', observacion='".$mensobsre."',estadodoc='ENVIADO' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);


}

if($_GET["varespuestusu"]==2)
{
	
if($_GET["txtingresdias"]!="")
{
$sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,fech_tiempo_dias)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['vermientuscedula']."','REASIGNADO','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png','".$_GET["txtingresdias"]."' );";
}
else
{
$sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['vermientuscedula']."','REASIGNADO','".$_GET["txtcomentarioreasign"]."','imgs/btninfo_reasignarblok.png' );";
}


/*
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET img_respuesta_reasignar='imgs/btninfo_reasignarblok.png',  img_respuesta_estado='imgs/btninfo_estado_reasignado.png',  est_respuesta_reasignado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);
*/
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,  est_respuesta_reasignado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."',img_respuesta_estado='imgs/btninfo_estado_reasignado.png',respuesta_estado='REASIGNADO'   WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);


$mensobsre="Se Reasigno a : ".$paramemplnom." ".$paramemplapel." CARGO: ".$paramemplcargo;
////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_reasignado.png', observacion='".$mensobsre."',estadodoc='REASIGNADO' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);
}

if($_GET["varespuestusu"]==3)
{
$sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_informado.png','".$_SESSION['vermientuscedula']."','INFORMADO' );";
/*
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET  img_respuesta_estado='imgs/btninfo_estado_informado.png',  est_respuesta_informado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);
*/

$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET  IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,img_respuesta_estado='imgs/btninfo_estado_informadook.png',  est_respuesta_informado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."',respuesta_estado='INFORMADO'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);

////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_informadook.png', observacion='INFORMADO',estadodoc='INFORMADO' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);

}

if($_GET["varespuestusu"]==6)
{
$sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,respuesta_estado,respuesta_comentariotxt)   VALUES ( '".$_GET["variabtrami"]."', '".$_GET["varcodgenerado"]."', '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png','".$_SESSION['vermientuscedula']."','DEVOLUCION','".$_GET["txtcomentarioreasign"]."' );";
/*
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET img_respuesta_reasignar='imgs/btninfo_reasignarblok.png',  img_respuesta_estado='imgs/btninfo_estado_devolucion.png',  est_respuesta_reasignado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);
*/
$sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,  img_respuesta_estado='imgs/btninfo_estado_devolucion.png',  est_respuesta_reasignado=1,ultimonivel='false', usu_respons_edit='".$_SESSION['vermientuscedula']."',respuesta_estado='DEVOLUCION'  WHERE id='".$_GET["variabtrami"]."'";
$resfre = pg_query($conn, $sqlaactfre);




////actualizo el tramite
 $sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_devolucion.png', observacion='".$_GET["txtcomentarioreasign"]."',estadodoc='DEVOLUCION' WHERE form_cod_barras='".$_GET["varcodgenerado"]."';";
$resfre = pg_query($conn, $sqlaactfre);
}



//////////////////////////////////////MEMORANDUMS nuevos
if(($_GET["varespuestusu"]==-1)||($_GET["varespuestusu"]==-2)||($_GET["varespuestusu"]==-3))
{
 $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos(   codi_gestor, destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,est_respuesta_enedicion,usu_respons_edit,respuesta_estado,num_memocreado,codigo_documento,origen_tipodoc)   VALUES (  '".$numersecdocumdestino."', '".$paramemplced."', '".$paramemplnom." ".$paramemplapel."', '".$paramemplcargo."', '".$paramempldepartament."', now() , '".$paramelorigen_tipodoc."','".$paramelorigen_tipotram."','".$parasumillenviarcontexto."','".$paramelorigen_tipotram."','".$paramelorigen_asunto."','".$_SESSION['vermientuscedula']."','".$_SESSION['vermientnomusu']."','".$_SESSION['vermientnomcargousu']."','".$_SESSION['vermientnomdepartameusu']."',1,'imgs/btninfo_estado_pendiente.png',0,'".$_SESSION['vermientuscedula']."','ENVIADO','".$_GET["varnewnummemos"]."','".$_GET["varnewcodificamemos"]."','".$paramelorigen_tipodoc."' );";
}


$res = pg_query($conn, $sql);


echo "<script>window.opener.location.reload(true);window.close();</script>";


}

///////ATUALIZO MI PLANTILLA
if($_GET["variabtrami"]!="")
{
$sql = "UPDATE tbli_esq_plant_formunico  SET sumillado_a_departamentos='".$listadepartxver."', sumillado_a_responsables='".$listacedulstxver."', img_sumillaestado='imgs/btninfo_sumillaok.png',enviado=1 where id='".$_GET["variabtrami"]."' ";
$res = pg_query($conn, $sql);
//////reiniciamos seleccion
$sql = "UPDATE public.tbli_esq_verusuarios  SET selec_tempo=0";
$res = pg_query($conn, $sql);
}
?>