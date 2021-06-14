<?php

/////////////////se
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


 $sql = "select *  FROM tbli_esq_plant_form_plantilla  where id='".$_GET['varidplanty']."'  order by id;";
$resulverplan = pg_query($conn, $sql);
$retorn_tableplan=pg_fetch_result($resulverplan,0,'nombre_tablabdd');
$retorn_tableanex=pg_fetch_result($resulverplan,0,'nombre_tabla_anexos');
$retorn_codclasif=pg_fetch_result($resulverplan,0,'ref_clasif_doc');
/////////////////tipo de documento de ingreso
$txvaresp_tipodocid=4;
$txvaresp_tipodocnomb='FE: FORMULARIO EXTERNO';
$txvaresp_selubicacion='COTACACHI';
$txvaresp_selurbanrural='U-R';

$sqlusuar = "select *  FROM plantillas.".$retorn_tableplan."  where id='".$_GET['varclaveuntramusu']."'  order by id;";
$resulverplauser = pg_query($conn, $sqlusuar);

$varusu_ciu=pg_fetch_result($resulverplauser,0,'campo_0');
$varusu_cedula=pg_fetch_result($resulverplauser,0,'campo_1');
$varusu_nombres=pg_fetch_result($resulverplauser,0,'campo_2');
$varusu_apellidos=pg_fetch_result($resulverplauser,0,'campo_3');
$varusu_telefono=pg_fetch_result($resulverplauser,0,'campo_4');
$varusu_email=pg_fetch_result($resulverplauser,0,'campo_5');
$varusu_direccion=pg_fetch_result($resulverplauser,0,'campo_6');

////////////////////consultar responsables
$sqlucuadclasif = "select *  FROM tbli_esq_plant_form_cuadro_clasif where id='".$retorn_codclasif."'  order by id;";
$ressqlucuadclasif = pg_query($conn, $sqlucuadclasif);

$txvaresp_cedresponsable=pg_fetch_result($ressqlucuadclasif,0,'ced_responsable');
$txvaresp_cedasistente=pg_fetch_result($ressqlucuadclasif,0,'ced_asistente');
$txvaresp_procesoid=pg_fetch_result($ressqlucuadclasif,0,'ref_id_proceso');
$txvaresp_refiddepart=pg_fetch_result($ressqlucuadclasif,0,'ref_id_depart');
$txvaresp_nombretram=pg_fetch_result($ressqlucuadclasif,0,'detalle');
$txvaresp_asunto="Solicitar el tramite de ".pg_fetch_result($resulverplan,0,'nombre_plantilla') ;



///////////////////////////INCLUIR EL CIUDADANO EN CASO DE NO EXISTIR
$sqlactciuda="select actualizar_listaciudadanos('" . $varusu_ciu . "','" . $varusu_cedula . "','" . $varusu_apellidos . "','" . $varusu_nombres . "','" . $varusu_direccion . "','" . " " . "','CIUDADANO','" . $varusu_telefono . "','" . $varusu_email . "')"; 
$consveciudadano=pg_query($conn,$sqlactciuda);


//////////////////////////////inicializando variables
$vardestced =  "";
$vardestnoms =  "";
$vardestccarg =  "";
$vardestdepend =  "";
$varconvinodestinusu = "";

$asisdestced = "";
$asisdestnoms = "";
$asisdestccarg = "";
$asisdestdepend = "";
$asisconvinodestinusu = "";

/////////////////////////////////////////////////////////CONSULTAR LOS ASESORES SUS DATOS
if($txvaresp_cedresponsable!="")
{
 $sqlpersona = "SELECT usua_cedula, usua_nomb, usua_apellido,usua_cargo,  usua_dependencia  FROM public.tblu_migra_usuarios where usua_cedula='".$txvaresp_cedresponsable."' ;";
$rescodpers = pg_query($conn, $sqlpersona);
$vardestced = pg_fetch_result($rescodpers,0,'usua_cedula');
$vardestnoms = pg_fetch_result($rescodpers,0,'usua_nomb');
$vardestapel = pg_fetch_result($rescodpers,0,'usua_apellido');
$vardestnomcomplet=$vardestnoms." ".$vardestapel;
$vardestccarg = pg_fetch_result($rescodpers,0,'usua_cargo');
$vardestdepend = pg_fetch_result($rescodpers,0,'usua_dependencia');
$varconvinodestinusu = "Nombre: ".$vardestnoms." ".$vardestapel." Cargo: ".$vardestccarg;
}
//////////////////////CONSULTA ASISTENTE
if($txvaresp_cedasistente!="")
{
 $sqlpersona = "SELECT usua_cedula, usua_nomb, usua_apellido,usua_cargo,  usua_dependencia  FROM public.tblu_migra_usuarios where usua_cedula='".$txvaresp_cedasistente."' ;";
$rescodpers = pg_query($conn, $sqlpersona);
$asisdestced = pg_fetch_result($rescodpers,0,'usua_cedula');
$asisdestnoms = pg_fetch_result($rescodpers,0,'usua_nomb');
$asisdestapel = pg_fetch_result($rescodpers,0,'usua_apellido');
$asisdestccarg = pg_fetch_result($rescodpers,0,'usua_cargo');
$asisdestdepend = pg_fetch_result($rescodpers,0,'usua_dependencia');
$asisconvinodestinusu = "Nombre: ".$asisdestnoms." ".$asisdestapel." Cargo: ".$asisdestccarg;
}
///////////////////////////////////////////////////////////////////////////////////
/////////////////configurar codigo
$sqlcodiftram = "SELECT campo,artificio  FROM tbli_esq_plant_form_configcodift where activo=1 order by item_orden;";
$rescodiftr= pg_query($conn, $sqlcodiftram);
$misecuenciacodif="";
for($bm=0; $bm<pg_num_rows($rescodiftr); $bm++)
{
	if($bm==pg_num_rows($rescodiftr)-1)
	$misecuenciacodif.=pg_fetch_result($rescodiftr,$bm,'campo');
	else
	$misecuenciacodif.=pg_fetch_result($rescodiftr,$bm,'campo')."||'".pg_fetch_result($rescodiftr,$bm,'artificio')."'||";
}
///////////////////

 $sqlcodif = "SELECT id,  ".$misecuenciacodif." as codifica_actual,numer_inicial,numer_final,cast(numer_actual as int) as num  FROM tbli_esq_plant_form_cuadro_clasif where id='".$retorn_codclasif."';";
$rescodif = pg_query($conn, $sqlcodif);
$varcoditramite = pg_fetch_result($rescodif,0,'codifica_actual');
$varauxnum = pg_fetch_result($rescodif,0,'num');

/////LLENAR LA PRIMER TABLA
if(($txvaresp_cedresponsable!="")&&($txvaresp_cedasistente!=""))
{
	////////////////////envio copia a
 $sqlnuevotram="INSERT INTO tbli_esq_plant_formunico(id,usu_respons_edit,anexos,cedula,ciud_nombres,ciud_apellidos,ciud_domicilio,ciud_telefono,ciud_email,form_asunto,usu_asigdepartamento,usu_asigresponsable,origen_institucion,img_sumillaestado,estado_gestor,estadodoc,sumillado_a_responsables,ciud_parroquia,origen_tipo_tramite,origen_id_tipo_tramite,origen_tipo_doc,origen_id_tipo_doc,codigo_tramite,ref_procesoform,origen_urbano_rural,asignado,ref_plantilla,ref_tramwebid)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $varusu_cedula . "','" . $varusu_nombres . "','" . $varusu_apellidos . "','" . $varusu_direccion . "','" . $varusu_telefono . "','" . $varusu_email . "','" . $txvaresp_asunto . "','" . $txvaresp_refiddepart . "','" . $txvaresp_cedasistente . "','" . " " . "','imgs/btninfo_sumillaok.png','imgs/btninfo_estado_pendiente.png','PENDIENTE','" . $asisconvinodestinusu . "','" . $txvaresp_selubicacion . "','" . $txvaresp_nombretram . "','" . $retorn_codclasif . "','" . $txvaresp_tipodocnomb . "','" . $txvaresp_tipodocid . "','".$varcoditramite."','".$txvaresp_procesoid."','".$txvaresp_selurbanrural."',0,'".$_GET['varidplanty']."', '".$_GET['varclaveuntramusu']."')";    
	
$rescodpers = pg_query($conn, $sqlnuevotram);

$sqlnuevotram="SELECT id,  form_cod_barras  FROM public.tbli_esq_plant_formunico where codigo_tramite='".$varcoditramite."'";
$rescodform = pg_query($conn, $sqlnuevotram);
$refvarformunicoid = pg_fetch_result($rescodform,0,'id');
$refvarformunicobarras = pg_fetch_result($rescodform,0,'form_cod_barras');
////////////////////////////////////////////////////////ENVIADO CON COPIA
 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior,ref_plantilla,ref_tramwebid)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $varusu_cedula . "','" . $varusu_nombres . " " . $varusu_apellidos . "','" . $varusu_direccion . "','" . $varusu_telefono . "','" . $varusu_email . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $txvaresp_refiddepart . "','" . $txvaresp_tipodocnomb . "','" . " " . "','" . $txvaresp_cedresponsable . "',1,'CIUDADANO','CIUDADANO','" . $vardestnomcomplet . "','" . $vardestccarg . "','" . $vardestdepend . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $txvaresp_tipodocid . "','" . $varcoditramite . "','".$retorn_codclasif."','".$txvaresp_procesoid."','COPIA','COPIA','".$_GET['varidplanty']."', '".$_GET['varclaveuntramusu']."')";
                      
$rescodpers = pg_query($conn, $insertdato);

/////////////////////////////////////ENVIADO AL PUNTUAL
 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior,ref_plantilla,ref_tramwebid)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $varusu_cedula . "','" . $varusu_nombres . " " . $varusu_apellidos . "','" . $varusu_direccion . "','" . $varusu_telefono . "','" . $varusu_email . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $txvaresp_refiddepart . "','" . $txvaresp_tipodocnomb . "','" . " " . "','" . $txvaresp_cedasistente . "',1,'CIUDADANO','CIUDADANO','" . $asisdestnoms . "','" . $asisdestccarg . "','" . $asisdestdepend . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $txvaresp_tipodocid . "','" . $varcoditramite . "','".$retorn_codclasif."','".$txvaresp_procesoid."','ENVIADO','ENVIADO','".$_GET['varidplanty']."', '".$_GET['varclaveuntramusu']."')";
                      

$rescodpers = pg_query($conn, $insertdato);
	
}
else
if(($txvaresp_cedresponsable!="")&&($txvaresp_cedasistente==""))
{
	////////////////////envio copia a
 $sqlnuevotram="INSERT INTO tbli_esq_plant_formunico(id,usu_respons_edit,anexos,cedula,ciud_nombres,ciud_apellidos,ciud_domicilio,ciud_telefono,ciud_email,form_asunto,usu_asigdepartamento,usu_asigresponsable,origen_institucion,img_sumillaestado,estado_gestor,estadodoc,sumillado_a_responsables,ciud_parroquia,origen_tipo_tramite,origen_id_tipo_tramite,origen_tipo_doc,origen_id_tipo_doc,codigo_tramite,ref_procesoform,origen_urbano_rural,asignado,ref_plantilla,ref_tramwebid)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $varusu_cedula . "','" . $varusu_nombres . "','" . $varusu_apellidos . "','" . $varusu_direccion . "','" . $varusu_telefono . "','" . $varusu_email . "','" . $txvaresp_asunto . "','" . $txvaresp_refiddepart . "','" . $txvaresp_cedresponsable . "','" . " " . "','imgs/btninfo_sumillaok.png','imgs/btninfo_estado_pendiente.png','PENDIENTE','" . $varconvinodestinusu . "','" . $txvaresp_selubicacion . "','" . $txvaresp_nombretram . "','" . $retorn_codclasif . "','" . $txvaresp_tipodocnomb . "','" . $txvaresp_tipodocid . "','".$varcoditramite."','".$txvaresp_procesoid."','".$txvaresp_selurbanrural."',0,'".$_GET['varidplanty']."', '".$_GET['varclaveuntramusu']."')";    
	
$rescodpers = pg_query($conn, $sqlnuevotram);     

$sqlnuevotram="SELECT id,  form_cod_barras  FROM public.tbli_esq_plant_formunico where codigo_tramite='".$varcoditramite."'";
$rescodform = pg_query($conn, $sqlnuevotram);
$refvarformunicoid = pg_fetch_result($rescodform,0,'id');
$refvarformunicobarras = pg_fetch_result($rescodform,0,'form_cod_barras');

 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior,ref_plantilla,ref_tramwebid)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $varusu_cedula . "','" . $varusu_nombres . " " . $varusu_apellidos . "','" . $varusu_direccion . "','" . $varusu_telefono . "','" . $varusu_email . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $txvaresp_refiddepart . "','" . $txvaresp_tipodocnomb . "','" . " " . "','" . $txvaresp_cedresponsable . "',1,'CIUDADANO','CIUDADANO','" . $vardestnomcomplet . "','" . $vardestccarg . "','" . $vardestdepend . "','" . $txvaresp_nombretram . "','" . $txvaresp_asunto . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $txvaresp_tipodocid . "','" . $varcoditramite . "','".$retorn_codclasif."','".$txvaresp_procesoid."','ENVIADO','ENVIADO','".$_GET['varidplanty']."', '".$_GET['varclaveuntramusu']."')";
                      
$rescodpers = pg_query($conn, $insertdato);     
	
}
////////////ACTUALIZO CONTADOR
$varnumfinalac="";
$varauxnum=$varauxnum+1;
if($varauxnum>0 && $varauxnum<10)
$varnumfinalac="0000".$varauxnum;
if($varauxnum>9 && $varauxnum<100)
$varnumfinalac="000".$varauxnum;
if($varauxnum>99 && $varauxnum<1000)
$varnumfinalac="00".$varauxnum;
if($varauxnum>999 && $varauxnum<10000)
$varnumfinalac="0".$varauxnum;
if($varauxnum>9999 && $varauxnum<99999)
$varnumfinalac=$varauxnum;

 $sqlcodifact = "UPDATE public.tbli_esq_plant_form_cuadro_clasif  SET  numer_actual='".$varnumfinalac."'    WHERE id='".$retorn_codclasif."';";
$rescodifact = pg_query($conn, $sqlcodifact);

/////////////////////////ACTUALIZO ESTADO
$sqlusuarvalid = "UPDATE plantillas.".$retorn_tableplan." SET estadodoc='VALIDADO', cod_traminterno='".$varcoditramite."' where id='".$_GET['varclaveuntramusu']."';";
$rescodifact = pg_query($conn, $sqlusuarvalid);

//////////////////////////////ACTUALIZAR EN CABILDO
$sqlpersinstitu = "SELECT actualizociusbdd  FROM tblb_org_institucion where id=1 ;";
$rescodinstit = pg_query($conn, $sqlpersinstitu);
$varpregres = pg_fetch_result($rescodinstit,0,'actualizociusbdd');

if($varpregres=='1')
{

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('GESTORSP','GESTORSP',$dbstr);

if(isset($varusu_cedula))
  if($varusu_cedula!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
if(isset($_POST["txtfechanac"])!="") {
  $sql = "UPDATE gen01
   SET gen01ruc='".$varusu_cedula."', gen01nom='".$varusu_nombres."', gen01ape='".$varusu_apellidos."', gen01dir='".$varusu_direccion."', gen01telf='".$varusu_telefono."',  gen01email='".$varusu_email."',  gen01fnac='".$_POST["txtfechanac"]."',  gen01disca='".$_POST["txtdiscapaci"]."'  WHERE gen01codi=".$varusu_ciu." and gen01cont = 'O'";
} else { 
  $sql = "UPDATE gen01
   SET gen01ruc='".$varusu_cedula."', gen01nom='".$varusu_nombres."', gen01ape='".$varusu_apellidos."', gen01dir='".$varusu_direccion."', gen01telf='".$varusu_telefono."',  gen01email='".$varusu_email."'  WHERE gen01codi=".$varusu_ciu." and gen01cont = 'O'";
}
  
$res = oci_parse($conn,$sql);
//oci_free_statement($res);
$result = oci_execute($res, OCI_COMMIT_ON_SUCCESS);
if (!$result) {  echo oci_error();  }
//oci_close($conn);
}

}
//////////////////////////////FIN ACTUALIZAR EN CABILDO





if($_POST["txtprcoconanex"]=="999")
{
echo "<script>document.location.href='"."form_anexos.php?mvpr=".$refvarformunicoid."&varcodgenerado=".$refvarformunicobarras."&vercodigotramitext=".$varcoditramite."&vartxtciudcedula=".$varusu_cedula."'</script>";
}
else
{
echo '<script>window.open("service_imprimecods.php?micodappsc='.$refvarformunicobarras.'" , "ventana1" , "width=700,height=500,scrollbars=NO")</script>';
echo "<script>document.location.href='listagestion.php?varidplanty=".$_GET['varidplanty']."'</script>";
}




?>