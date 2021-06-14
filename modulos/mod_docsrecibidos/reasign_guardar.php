<?php

require_once('../../clases/conexion.php');
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
///////////////////////////////////////////////
require '../../mailer/src/Exception.php';
require '../../mailer/src/PHPMailer.php';
require '../../mailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';
$mail = new PHPMailer(true);
if ($_GET["varselecionusuarioenv"] != "") {
  $sqlmr = "SELECT  usua_cedula, usua_nomb, usua_apellido,usua_cargo, usua_dependencia  FROM public.tblu_migra_usuarios where id='" . $_GET["varselecionusuarioenv"] . "';";
  $resmigra = pg_query($conn, $sqlmr);

  $paramemplced = pg_fetch_result($resmigra, $mig, 0);
  $paramemplnom = pg_fetch_result($resmigra, $mig, 1);
  $paramemplapel = pg_fetch_result($resmigra, $mig, 2);
  $paramemplcargo = pg_fetch_result($resmigra, $mig, 3);
  $paramempldepartament = pg_fetch_result($resmigra, $mig, 4);

  $sqlseldocum = "SELECT  destino_tipodoc,destino_tipo_tramite,destino_form_asunto, codigo_documento, num_memocreado, origen_departament  FROM public.tbli_esq_plant_formunico_docsinternos where id='" . $_GET["variabtrami"] . "' ";
  $resseldocum = pg_query($conn, $sqlseldocum);

  $paramelorigen_tipodoc = pg_fetch_result($resseldocum, 0, 0);
  $paramelorigen_tipotram = pg_fetch_result($resseldocum, 0, 1);
  $paramelorigen_asunto = pg_fetch_result($resseldocum, 0, 2);
  $codigodocumento = pg_fetch_result($resseldocum, 0, 3);
  $numerotramite = pg_fetch_result($resseldocum, 0, 4);
  $origen_departament = pg_fetch_result($resseldocum, 0, 5);
}

$cedulaRemitente = $_SESSION['sesusuario_cedula'];
$nombresRemitente = $_SESSION['sesusuario_nombres'];
$apellidosRemitente = $_SESSION['sesusuario_apellidos'];
$departamentoRemitente = $_SESSION['sesusuario_nomdepartameusu'];
$sqlus = "SELECT usua_abr_titulo FROM public.tblu_migra_usuarios where  usua_cedula='" . $cedulaRemitente . "';";
$result = pg_query($conn, $sqlus);
$abr = pg_fetch_result($result, 0, "usua_abr_titulo");

if ($_GET["varespuestusu"] == 2) {

  if ($_GET["txtingresdias"] != "") {
    $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codigo_documento,
 destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,
 origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,origen_nombres,
 origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,usu_respons_edit,
 respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,fech_tiempo_dias,origen_id_tipo_tramite,
 ref_procesoform,codigo_tramite,est_respuesta_reasignado,resp_estado_anterior, num_memocreado, est_respuesta_enviado)   
 VALUES ( '" . $_GET["variabtrami"] . "', '" . $_GET["varcodgenerado"] . "', '" . $codigodocumento . "','" . $paramemplced . "', 
 '" . $paramemplnom . " " . $paramemplapel . "', '" . $paramemplcargo . "', '" . $paramempldepartament . "', now() ,
  '" . $paramelorigen_tipodoc . "','" . $paramelorigen_tipotram . "','" . $paramelorigen_asunto . "',
  '" . $paramelorigen_tipotram . "','" . $paramelorigen_asunto . "','" . $_SESSION['sesusuario_cedula'] . "',
  '" . $_SESSION['sesusuario_nomcompletos'] . "','" . $_SESSION['sesusuario_cargousu'] . "',
  '" . $origen_departament . "',1,'imgs/btninfo_estado_pendiente.png',
  '" . $_SESSION['sesusuario_cedula'] . "','REASIGNADO','" . $_GET["txtcomentarioreasign"] . "',
  'imgs/btninfo_reasignarblok.png','" . $_GET["txtingresdias"] . "','" . $_GET["varcodtramite"] . "',
  '" . $_GET["varcodprocesoid"] . "','" . $_GET["varcodifarchiv"] . "',0 ,'REASIGNADO', '" . $numerotramite . "', 0);";
    $resfre = pg_query($conn, $sql);
  } else {
    $sql = "INSERT INTO public.tbli_esq_plant_formunico_docsinternos( parent_id,codi_barras, codigo_documento,
  destino_cedul, destino_nombres, destino_cargo,destino_departament,destino_fecha_creado,destino_tipodoc,
  origen_tipo_tramite,origen_form_asunto,destino_tipo_tramite,destino_form_asunto,origen_cedul,
  origen_nombres,origen_cargo,origen_departament,est_respuesta_recibido,img_respuesta_estado,
  usu_respons_edit,respuesta_estado,respuesta_comentariotxt,img_respuesta_reasignar,origen_id_tipo_tramite,
  ref_procesoform,codigo_tramite,est_respuesta_reasignado,resp_estado_anterior, num_memocreado, est_respuesta_enviado)  
  VALUES ( '" . $_GET["variabtrami"] . "', '" . $_GET["varcodgenerado"] . "', '" . $codigodocumento . "',
  '" . $paramemplced . "', '" . $paramemplnom . " " . $paramemplapel . "', '" . $paramemplcargo . "', '" . $paramempldepartament . "', 
  now() , '" . $paramelorigen_tipodoc . "','" . $paramelorigen_tipotram . "','" . $paramelorigen_asunto . "',
  '" . $paramelorigen_tipotram . "','" . $paramelorigen_asunto . "','" . $_SESSION['sesusuario_cedula'] . "',
  '" . $_SESSION['sesusuario_nomcompletos'] . "','" . $_SESSION['sesusuario_cargousu'] . "',
  '" . $origen_departament . "',1,'imgs/btninfo_estado_pendiente.png',
  '" . $_SESSION['sesusuario_cedula'] . "','REASIGNADO','" . $_GET["txtcomentarioreasign"] . "',
  'imgs/btninfo_reasignarblok.png','" . $_GET["varcodtramite"] . "','" . $_GET["varcodprocesoid"] . "',
  '" . $_GET["varcodifarchiv"] . "',0 ,'REASIGNADO', '" . $numerotramite . "', 0);";
    $resfre = pg_query($conn, $sql);
  }

  $sqlaactfre = "UPDATE public.tbli_esq_plant_formunico_docsinternos    SET IMG_RESP_ATENDER=NULL,IMG_RESP_DEVOLVER=NULL,IMG_RESP_FINALIZAR=NULL,IMG_RESPUESTA_TEXTO=NULL,IMG_RESPUESTA_REASIGNAR=NULL,IMG_RESPUESTA_ANEXO=NULL,IMG_RESPUESTA_INFORMAR=NULL,  est_respuesta_reasignado=1, est_respuesta_enviado=0, ultimonivel='false', usu_respons_edit='" . $_SESSION['sesusuario_cedula'] . "',img_respuesta_estado='imgs/btninfo_estado_reasignado.png',resp_estado_anterior='REASIGNADO',respuesta_comentariotxt  ='" . $_GET["txtcomentarioreasign"] . "' ,resp_comentario_anterior='" . $_GET["txtcomentarioreasign"] . "'  WHERE id='" . $_GET["variabtrami"] . "'";
  $resfre = pg_query($conn, $sqlaactfre);

  $mensobsre = "Se Reasigno a : " . $paramemplnom . " " . $paramemplapel . " CARGO: " . $paramemplcargo;
  ////actualizo el tramite
  $sqlaactfre = "UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_reasignado.png', observacion='" . $mensobsre . "',estadodoc='REASIGNADO' WHERE form_cod_barras='" . $_GET["varcodgenerado"] . "';";
  $resfre = pg_query($conn, $sqlaactfre);
}

if ($paramemplced != null) {
  try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'municotacachi@gmail.com';                     // SMTP username
    $mail->Password   = 'Rootbg25@';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->setFrom('municotacachi@gmail.com', utf8_decode('Gestión Documental'));
    $emails = "";
    $sqlus = "SELECT usua_email	FROM public.tblu_migra_usuarios where  usua_cedula='" . $paramemplced . "';";
    $result = pg_query($conn, $sqlus);
    $usua_email = pg_fetch_result($result, 0, "usua_email");
    $mail->addAddress($usua_email);     // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = utf8_decode("Documento reasignado");
    $mail->Body    = utf8_decode("
		<img style='left: 40%;' src='http://www.cotacachienlinea.gob.ec/sip_gd/imgs/logos/mail.png' width='200' /> <br>
		Se le ha reasignado un documento en el Sistema de Gesti&oacute;n Documental - Municipio de Cotacachi, <br>
		<br>Nro. Trámite: " . $numerotramite . "
		<br>Nro. Documento: " . $codigodocumento . "
		<br>Asunto: Documento Reasignado " . $paramelorigen_asunto . "
    <br>" . $_GET["txtcomentarioreasign"] . "
		<br>Origen: " . $abr . ". " . $nombresRemitente . " " . $apellidosRemitente . " - " . $departamentoRemitente . "  
		<br><br><b>por favor ingrese al sistema>>></b></br> 
		http://www.cotacachienlinea.gob.ec/sip_gd/index.php
		<br><br>Sub Dirección de Tecnología y Sistemas
		<br><p style='font-size:10px'>*Mensaje generado automaticamente, no responda a este correo.</p>");
    $mail->AltBody = 'No reponder a este correo.';
    if ($mail != null) {
      $mail->send();
      echo 'Message ha sido enviado';
    }
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}


echo "<script>window.opener.location.reload(true);window.close();</script>";

/*
echo "<script>document.location.href='"."form_anexosint_reasig.php?mvpr=".$refvarformunicoid."&varcodgenerado=".$refvarformunicobarras."&vercodigotramitext=".$varcoditramite."&vartxtciudcedula=".$_POST["txtcedula"]."'</script>";
*/
