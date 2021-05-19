<?php

require_once('../../clases/conexion.php');
session_start();
/////////////////se
if($_POST["txtestadoactualiz"]==0)
{


///////////////////////////INCLUIR EL CIUDADANO EN CASO DE NO EXISTIR
$sqlactciuda="select actualizar_listaciudadanos('" . $_POST["txtciu"] . "','" . $_POST["txtcedula"] . "','" . $_POST["txtapellidos"] . "','" . $_POST["txtnombres"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txtinstitu"] . "','CIUDADANO','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "')"; 
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
if($_POST["txtcedjeferesp"]!="")
{
 $sqlpersona = "SELECT usua_cedula, usua_nomb, usua_apellido,usua_cargo,  usua_dependencia  FROM public.tblu_migra_usuarios where usua_cedula='".$_POST["txtcedjeferesp"]."' ;";
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
if($_POST["txtcedasistenresp"]!="")
{
 $sqlpersona = "SELECT usua_cedula, usua_nomb, usua_apellido,usua_cargo,  usua_dependencia  FROM public.tblu_migra_usuarios where usua_cedula='".$_POST["txtcedasistenresp"]."' ;";
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

 $sqlcodif = "SELECT id,  ".$misecuenciacodif." as codifica_actual,numer_inicial,numer_final,cast(numer_actual as int) as num  FROM tbli_esq_plant_form_cuadro_clasif where id='".$_POST["txttramitid"]."';";
$rescodif = pg_query($conn, $sqlcodif);
$varcoditramite = pg_fetch_result($rescodif,0,'codifica_actual');
$varauxnum = pg_fetch_result($rescodif,0,'num');

/////LLENAR LA PRIMER TABLA
if(($_POST["txtcedjeferesp"]!="")&&($_POST["txtcedasistenresp"]!=""))
{
	////////////////////envio copia a
 $sqlnuevotram="INSERT INTO tbli_esq_plant_formunico(id,usu_respons_edit,anexos,cedula,ciud_nombres,ciud_apellidos,ciud_domicilio,ciud_telefono,ciud_email,form_asunto,usu_asigdepartamento,usu_asigresponsable,origen_institucion,img_sumillaestado,estado_gestor,estadodoc,sumillado_a_responsables,ciud_parroquia,origen_tipo_tramite,origen_id_tipo_tramite,origen_tipo_doc,origen_id_tipo_doc,codigo_tramite,ref_procesoform,origen_urbano_rural,asignado)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $_POST["txtcedula"] . "','" . $_POST["txtnombres"] . "','" . $_POST["txtapellidos"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "','" . $_POST["txtasuntosol"] . "','" . $_POST["txtasigndepart"] . "','" . $_POST["txtcedasistenresp"] . "','" . $_POST["txtinstitu"] . "','imgs/btninfo_sumillaok.png','imgs/btninfo_estado_pendiente.png','PENDIENTE','" . $asisconvinodestinusu . "','" . $_POST["txtseleccionarubic"] . "','" . $_POST["txttramitnom"] . "','" . $_POST["txttramitid"] . "','" . $_POST["txttipdocdescrip"] . "','" . $_POST["txttipdocid"] . "','".$varcoditramite."','".$_POST["txtprcocesoid"]."','".$_POST["txturbanorural"]."',0)";    
	
$rescodpers = pg_query($conn, $sqlnuevotram);

$sqlnuevotram="SELECT id,  form_cod_barras  FROM public.tbli_esq_plant_formunico where codigo_tramite='".$varcoditramite."'";
$rescodform = pg_query($conn, $sqlnuevotram);
$refvarformunicoid = pg_fetch_result($rescodform,0,'id');
$refvarformunicobarras = pg_fetch_result($rescodform,0,'form_cod_barras');
////////////////////////////////////////////////////////ENVIADO CON COPIA
 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $_POST["txtcedula"] . "','" . $_POST["txtnombres"] . " " . $_POST["txtapellidos"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $_POST["txtasigndepart"] . "','" . $_POST["txttipdocdescrip"] . "','" . $_POST["txtinstitu"] . "','" . $_POST["txtcedjeferesp"] . "',1,'CIUDADANO','CIUDADANO','" . $vardestnomcomplet . "','" . $vardestccarg . "','" . $vardestdepend . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $_POST["txttipdocid"] . "','" . $varcoditramite . "','".$_POST["txttramitid"]."','".$_POST["txtprcocesoid"]."','COPIA','COPIA')";
                      
$rescodpers = pg_query($conn, $insertdato);

/////////////////////////////////////ENVIADO AL PUNTUAL
 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $_POST["txtcedula"] . "','" . $_POST["txtnombres"] . " " . $_POST["txtapellidos"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $_POST["txtasigndepart"] . "','" . $_POST["txttipdocdescrip"] . "','" . $_POST["txtinstitu"] . "','" . $_POST["txtcedasistenresp"] . "',1,'CIUDADANO','CIUDADANO','" . $asisdestnoms . "','" . $asisdestccarg . "','" . $asisdestdepend . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $_POST["txttipdocid"] . "','" . $varcoditramite . "','".$_POST["txttramitid"]."','".$_POST["txtprcocesoid"]."','ENVIADO','ENVIADO')";
                      

$rescodpers = pg_query($conn, $insertdato);
	
}
else
if(($_POST["txtcedjeferesp"]!="")&&($_POST["txtcedasistenresp"]==""))
{
	////////////////////envio copia a
 $sqlnuevotram="INSERT INTO tbli_esq_plant_formunico(id,usu_respons_edit,anexos,cedula,ciud_nombres,ciud_apellidos,ciud_domicilio,ciud_telefono,ciud_email,form_asunto,usu_asigdepartamento,usu_asigresponsable,origen_institucion,img_sumillaestado,estado_gestor,estadodoc,sumillado_a_responsables,ciud_parroquia,origen_tipo_tramite,origen_id_tipo_tramite,origen_tipo_doc,origen_id_tipo_doc,codigo_tramite,ref_procesoform,origen_urbano_rural,asignado)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $_POST["txtcedula"] . "','" . $_POST["txtnombres"] . "','" . $_POST["txtapellidos"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "','" . $_POST["txtasuntosol"] . "','" . $_POST["txtasigndepart"] . "','" . $_POST["txtcedjeferesp"] . "','" . $_POST["txtinstitu"] . "','imgs/btninfo_sumillaok.png','imgs/btninfo_estado_pendiente.png','PENDIENTE','" . $varconvinodestinusu . "','" . $_POST["txtseleccionarubic"] . "','" . $_POST["txttramitnom"] . "','" . $_POST["txttramitid"] . "','" . $_POST["txttipdocdescrip"] . "','" . $_POST["txttipdocid"] . "','".$varcoditramite."','".$_POST["txtprcocesoid"]."','".$_POST["txturbanorural"]."',0)";    
	
$rescodpers = pg_query($conn, $sqlnuevotram);     

$sqlnuevotram="SELECT id,  form_cod_barras  FROM public.tbli_esq_plant_formunico where codigo_tramite='".$varcoditramite."'";
$rescodform = pg_query($conn, $sqlnuevotram);
$refvarformunicoid = pg_fetch_result($rescodform,0,'id');
$refvarformunicobarras = pg_fetch_result($rescodform,0,'form_cod_barras');

 $insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior)  VALUES (default,'" . $_SESSION['sesusuario_cedula'] . "','','" . $_POST["txtcedula"] . "','" . $_POST["txtnombres"] . " " . $_POST["txtapellidos"] . "','" . $_POST["txtdireccion"] . "','" . $_POST["txttelefono"] . "','" . $_POST["txtmail"] . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $_POST["txtasigndepart"] . "','" . $_POST["txttipdocdescrip"] . "','" . $_POST["txtinstitu"] . "','" . $_POST["txtcedjeferesp"] . "',1,'CIUDADANO','CIUDADANO','" . $vardestnomcomplet . "','" . $vardestccarg . "','" . $vardestdepend . "','" . $_POST["txttramitnom"] . "','" . $_POST["txtasuntosol"] . "','" . $refvarformunicoid . "','" . $refvarformunicobarras . "','" . $_POST["txttipdocid"] . "','" . $varcoditramite . "','".$_POST["txttramitid"]."','".$_POST["txtprcocesoid"]."','ENVIADO','ENVIADO')";
                      
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

 $sqlcodifact = "UPDATE public.tbli_esq_plant_form_cuadro_clasif  SET  numer_actual='".$varnumfinalac."'    WHERE id='".$_POST["txttramitid"]."';";
$rescodifact = pg_query($conn, $sqlcodifact);


}
//////////////////////////////ACTUALIZAR EN CABILDO
$sqlpersinstitu = "SELECT actualizociusbdd  FROM tblb_org_institucion where id=1 ;";
$rescodinstit = pg_query($conn, $sqlpersinstitu);
$varpregres = pg_fetch_result($rescodinstit,0,'actualizociusbdd');

if($varpregres=='1')
{

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('GESTORSP','GESTORSP',$dbstr);

if(isset($_POST["txtcedula"]))
  if($_POST["txtcedula"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
if(isset($_POST["txtfechanac"])!="") {
  $sql = "UPDATE gen01
   SET gen01ruc='".$_POST["txtcedula"]."', gen01nom='".$_POST["txtnombres"]."', gen01ape='".$_POST["txtapellidos"]."', gen01dir='".$_POST["txtdireccion"]."', gen01telf='".$_POST["txttelefono"]."',  gen01email='".$_POST["txtmail"]."',  gen01fnac='".$_POST["txtfechanac"]."',  gen01disca='".$_POST["txtdiscapaci"]."'  WHERE gen01codi=".$_POST["txtciu"]." and gen01cont = 'O'";
} else { 
  $sql = "UPDATE gen01
   SET gen01ruc='".$_POST["txtcedula"]."', gen01nom='".$_POST["txtnombres"]."', gen01ape='".$_POST["txtapellidos"]."', gen01dir='".$_POST["txtdireccion"]."', gen01telf='".$_POST["txttelefono"]."',  gen01email='".$_POST["txtmail"]."'  WHERE gen01codi=".$_POST["txtciu"]." and gen01cont = 'O'";
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
echo "<script>document.location.href='"."form_anexos.php?mvpr=".$refvarformunicoid."&varcodgenerado=".$refvarformunicobarras."&vercodigotramitext=".$varcoditramite."&vartxtciudcedula=".$_POST["txtcedula"]."'</script>";
}
else
{
	if($_POST["txtestadoactualiz"]==0)
    {
echo '<script>window.open("service_imprimecods.php?micodappsc='.$refvarformunicobarras.'" , "ventana1" , "width=700,height=500,scrollbars=NO")</script>';
	}
echo "<script>alert('Se actualizo correctamente');document.location.href='mostrar_panel.php'</script>";
}


?>