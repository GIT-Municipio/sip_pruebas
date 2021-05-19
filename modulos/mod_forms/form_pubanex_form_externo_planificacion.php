<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');
session_start();

///////////////////////////////////////////////
require '../../mailer/src/Exception.php';
require '../../mailer/src/PHPMailer.php';
require '../../mailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';
$mail = new PHPMailer(true);
/////////////////////////////////////////////////////////////////////////////////////////
//////GARANTIZA QUE SE CARGUE LA CLASE UNA SOLA VEZ DESPUES DEL MÉTODO GET///////////////
/////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION["inicia"] == null || $_SESSION["inicia"] = "")
	$_SESSION["inicia"] = "ingreso";
else
	$_SESSION["inicia"] = "ingreso";
$inicial = $_SESSION["inicia"];
/////////////////////////////////////////////////////////////////////////////////////////
if ($inicial) {
	$_SESSION["tempoanex_mvpr"] = "998";
	$plantilla = $_SESSION["mvpr"];
	if ($plantilla != null && $plantilla == "998")
		$_SESSION["mvpr"] = $plantilla;


	$_SESSION["tempoanex_codbarras"] = "100003104";
	$cedulaRemitente = $_SESSION['sesusuario_cedula'];
	$nombresRemitente = $_SESSION['sesusuario_nombres'];
	$apellidosRemitente = $_SESSION['sesusuario_apellidos'];
	$ponnombresrespon = $_SESSION['sesusuario_nomcompletos'];
	$cargoRemitente = $_SESSION['sesusuario_cargousu'];
	$departamentoRemitente = $_SESSION['sesusuario_nomdepartameusu'];
	if ($_SESSION["sesusuario_usu_ventanilla"] == 1) {
		$_SESSION["tempoanex_verventan"] = 1;
		$_SESSION["tempoanex_verasist"] = 0;
	} else {
		$_SESSION["tempoanex_verventan"] = 0;
		$_SESSION["tempoanex_verasist"] = 1;
	}

	$sqlus = "SELECT usua_abr_titulo FROM public.tblu_migra_usuarios where  usua_cedula='" . $cedulaRemitente . "';";
	$result = pg_query($conn, $sqlus);
	$abr = pg_fetch_result($result, 0, "usua_abr_titulo");

	$_GET["myidcuadclasif"] = 998;
	$sql = "select *  FROM tbli_esq_plant_form_plantilla  where id='998'  order by id;";
	$resulverplan = pg_query($conn, $sql);
	$content = "BIENVENIDOS AL BALCON MUNICIPAL DE COTACACHI";

	QRcode::png($content, "../../../sip_bodega/codqr/" . "plantilla_999_comp_qr.png", QR_ECLEVEL_L, 10, 2);
	$verimgqrdado = "../../../sip_bodega/codqr/" . "plantilla_999_comp_qr.png";

	/////////////////////parametros generales plantilla
	$retorn_tableplan = pg_fetch_result($resulverplan, 0, 'nombre_tablabdd');
	$retorn_tableanex = pg_fetch_result($resulverplan, 0, 'nombre_tabla_anexos');

	/////////////////////////////////////////////////////////////////////////////
	//////////////////////DECODIFICAR XML DESTINATARIOS SELECCIONADOS////////////
	/////////////////////////////////////////////////////////////////////////////

	$usuarioseleccionado = $_GET["usuarioseleccionado"];
	$tipodocumento = $_GET["tipodocumento"];
	$txtobservacion = $_GET['txtobservacion'];
	$txtnombres = $_GET["txtnombres"];
	$txtcedula = $_GET["txtcedula"];
	$txttelefono = $_GET["txttelefono"];
	$txtcorreo = $_GET["txtcorreo"];
	$cuadroclasificacion = $_GET["cuadroclasificacion"];

	///OBTENER TIPO DE DOCUMENTO vista_cuadroclasificacion
	$sqlus = "SELECT * FROM tbli_esq_plant_form_cuadro_clasif where  id='998';";
	$result = pg_query($conn, $sqlus);
	$cod_clase = pg_fetch_result($result, 0, "cod_clase");
	$numer_actual_formulario = pg_fetch_result($result, 0, "numer_actual");
	// $gestion = pg_fetch_result($result, 0, "gestion");
	// $detalle = pg_fetch_result($result, 0, "detalle");

	$sqlus = "SELECT * FROM vista_plantillas_xclasifproc_externos where  id='  $cuadroclasificacion  ';";
	$result = pg_query($conn, $sqlus);
	$detalle = pg_fetch_result($result, 0, "nombre_tramite");


	$sqlus = "SELECT usua_cedula, usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
		FROM public.tblu_migra_usuarios where  id=" . $usuarioseleccionado . ";";
	$result = pg_query($conn, $sqlus);
	$nombre_usuario = pg_fetch_result($result, 0, "usua_nomb");
	$apellido_usuario = pg_fetch_result($result, 0, "usua_apellido");
	$cargo_usuario = pg_fetch_result($result, 0, "usua_cargo");
	$departamento_usuario = pg_fetch_result($result, 0, "usu_departamento");
	$abr_usuario = pg_fetch_result($result, 0, "usua_abr_titulo");
	$usuarioseleccionado = pg_fetch_result($result, 0, "usua_cedula");

	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////GENERANDO CODIFIACION///////////////////////////////////////////
	///////////////////CÓDIGO TRÁMITE//////////////////////////////////////////////////////
	$sqlcodiftram = "SELECT campo,artificio  FROM tbli_esq_plant_form_configcodift where cod_temporal=1 order by item_orden;";
	$rescodiftr = pg_query($conn, $sqlcodiftram);
	$misecuenciacodif = "";
	for ($bm = 0; $bm < pg_num_rows($rescodiftr); $bm++) {
		if ($bm == pg_num_rows($rescodiftr) - 1)
			$misecuenciacodif .= pg_fetch_result($rescodiftr, $bm, 'campo');
		else
			$misecuenciacodif .= pg_fetch_result($rescodiftr, $bm, 'campo') . "||'" . pg_fetch_result($rescodiftr, $bm, 'artificio') . "'||";
	}
	$sqlcodif = "SELECT id, numer_actual, " . $misecuenciacodif . " as codifica_actual,numer_inicial,numer_final,cast(numer_actual_tempo as int) as num  FROM tbli_esq_plant_form_cuadro_clasif where id='998';";
	$rescodif = pg_query($conn, $sqlcodif);
	$varcoditramite = pg_fetch_result($rescodif, 0, 'codifica_actual');
	$varauxnum = pg_fetch_result($rescodif, 0, 'num');
	////////////ACTUALIZO CONTADOR
	$varnumfinalac = "";
	$varauxnum = $varauxnum + 1;
	if ($varauxnum > 0 && $varauxnum < 10)
		$varnumfinalac = "0000" . $varauxnum;
	if ($varauxnum > 9 && $varauxnum < 100)
		$varnumfinalac = "000" . $varauxnum;
	if ($varauxnum > 99 && $varauxnum < 1000)
		$varnumfinalac = "00" . $varauxnum;
	if ($varauxnum > 999 && $varauxnum < 10000)
		$varnumfinalac = "0" . $varauxnum;
	if ($varauxnum > 9999 && $varauxnum < 99999)
		$varnumfinalac = $varauxnum;
	$sqlcodifact = "UPDATE public.tbli_esq_plant_form_cuadro_clasif SET numer_actual_tempo='" . $varnumfinalac . "' WHERE id='998';";
	$rescodifact = pg_query($conn, $sqlcodifact);
	//////////////////////////////////////////////////

	///////////////////////GENERANDO CODIFIACION///////////////////////////////////////////
	///////////////////NÚMERO TRÁMITE//////////////////////////////////////////////////////
	$sqlcodif = "SELECT id, numer_actual, cast(numer_actual as int) as num, anio_actual 
	FROM tbli_esq_plant_form_cuadro_clasif where id='900';";
	$rescodif = pg_query($conn, $sqlcodif);
	$numerotramite = pg_fetch_result($rescodif, 0, 'numer_actual');
	$anio = pg_fetch_result($rescodif, 0, 'anio_actual');
	$varauxnum = pg_fetch_result($rescodif, 0, 'num');
	$numerotramite = substr($anio, count($anio) - 3, 2) . $numerotramite;
	////////////ACTUALIZO CONTADOR
	$varnumfinal = "";
	$varauxnum = $varauxnum + 1;
	if ($varauxnum > 0 && $varauxnum < 10)
		$varnumfinal = "0000" . $varauxnum;
	if ($varauxnum > 9 && $varauxnum < 100)
		$varnumfinal = "000" . $varauxnum;
	if ($varauxnum > 99 && $varauxnum < 1000)
		$varnumfinal = "00" . $varauxnum;
	if ($varauxnum > 999 && $varauxnum < 10000)
		$varnumfinal = "0" . $varauxnum;
	if ($varauxnum > 9999 && $varauxnum < 99999)
		$varnumfinal = $varauxnum;
	$sqlcodifact = "UPDATE public.tbli_esq_plant_form_cuadro_clasif SET numer_actual='" . $varnumfinal . "' WHERE id='900';";
	$rescodifact = pg_query($conn, $sqlcodifact);
	//////////////////////////////////////////////////
	//////////////OBTENER NOMENCLATURA Y SECUENCIAL///
	//////////////////////////////////////////////////
	$sqlnomenclatura = "SELECT id, nombre_departamento, img_fondo as nomenclatura, color_letra as anio, cast(color_fondo as int) as num, color_fondo as secuencial FROM tblb_org_departamento where id='" . $_SESSION["sesusuario_dependencia"] . "';";
	$rescodif = pg_query($conn, $sqlnomenclatura);
	$nomenclatura = pg_fetch_result($rescodif, 0, 'nomenclatura');
	$anio = pg_fetch_result($rescodif, 0, 'anio');
	$secuencial = pg_fetch_result($rescodif, 0, 'secuencial');
	$codigoDocumento = $nomenclatura . "-" . $anio . "-" . $secuencial . "-OF";
	$varauxnum = pg_fetch_result($rescodif, 0, 'num');
	//////////////////////////////////////////////////

	//////////////////////////////////////////////////
	/////////////////***********************************************************////////////
	/////////////////**************CREANDO PLANTILLA POR PRIMERA VEZ*************///////////
	/////////////////***********************************************************///////////
	$darmeid = "998";
	$sqlquer = "select nombre_tablabdd from tbli_esq_plant_form_plantilla where  id = '" . $darmeid . "'";
	$consulcamps = pg_query($conn, $sqlquer);
	$darmetabla = pg_fetch_result($consulcamps, 0, 0);

	$sqlquer = "select campo_creado,ref_tcamp from tbli_esq_plant_form_plantilla_campos where  ref_plantilla = '" . $darmeid . "'";
	$consulcamps = pg_query($conn, $sqlquer);
	$vertamancpm = pg_num_rows($consulcamps);
	$arrayMeses = array(
		'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
		'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
	);
	$fecha = strftime("Cotacachi, %d de " . $arrayMeses[date('m') - 1] . " de %Y");
	$cadeninsert = "INSERT INTO plantillas." . $darmetabla . "( cod_tramite_tempo, codi_barras, codigo_tramite,
	campo_0, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_7, campo_8, campo_9, campo_10, campo_11, campo_12, campo_13, ciu_cedula, cod_traminterno) VALUES ( ";
	// $texto = urlencode($correos);
	$nume = '100' . $numerotramite;
	$nombres = $abr . '. ' . $nombresRemitente . ' ' . $apellidosRemitente;
	$cadeninsert .= " '$varcoditramite', '$nume', '$numerotramite',
	'$nombres', '$cargoRemitente','$departamentoRemitente', '$detalle',  '$txtobservacion', '$txtcedula', '$detalle','$txtnombres', '','$fecha', '', '$txttelefono', '$txtcorreo', '$txtobservacion',
	'$cedulaRemitente','$varcoditramite')";

	$consulcamps = pg_query($conn, $cadeninsert);

	////////////ACTUALIZO CONTADOR
	$varnumfinalac = "";
	$varauxnum = $varauxnum + 1;
	if ($varauxnum > 0 && $varauxnum < 10)
		$varnumfinalac = "0000" . $varauxnum;
	if ($varauxnum > 9 && $varauxnum < 100)
		$varnumfinalac = "000" . $varauxnum;
	if ($varauxnum > 99 && $varauxnum < 1000)
		$varnumfinalac = "00" . $varauxnum;
	if ($varauxnum > 999 && $varauxnum < 10000)
		$varnumfinalac = "0" . $varauxnum;
	if ($varauxnum > 9999 && $varauxnum < 99999)
		$varnumfinalac = $varauxnum;
	$codigoDocumento = $varcoditramite;
	//////////////GENERAR CODIGO UNICO DEL TRAMITE
	$sqlcverinseted = "select id from plantillas." . $darmetabla . " where cod_tramite_tempo='" . $codigoDocumento . "' ";
	$rescodifinsert = pg_query($conn, $sqlcverinseted);
	$varclaveunictramitusu = pg_fetch_result($rescodifinsert, 0, 0);
	// ///////////////////////DESPLEGAR TODAS LAS TABLAS
	$crtablasprocs = "select id,nombre_tablacmp  FROM tbli_esq_plant_form_plantilla_campos  where ref_plantilla='998' and nombre_tablacmp is not null  order by id;";
	$consprocstabs = pg_query($conn, $crtablasprocs);

	for ($ik = 0; $ik < pg_num_rows($consprocstabs); $ik++) {
		$varmydtabs = pg_fetch_result($consprocstabs, $ik, 'id');
		$crtablasql = "select id,campo_creado  FROM tbli_esq_plant_form_plantilla_cmpcolumns  where ref_elementcampo='" . $varmydtabs . "'  order by id;";
		$consprosqlcmps = pg_query($conn, $crtablasql);
		$coleccioncamps = "";
		for ($iw = 0; $iw < pg_num_rows($consprosqlcmps); $iw++) {
			if ($iw == pg_num_rows($consprosqlcmps) - 1)
				$coleccioncamps .= pg_fetch_result($consprosqlcmps, $iw, 'campo_creado');
			else
				$coleccioncamps .= pg_fetch_result($consprosqlcmps, $iw, 'campo_creado') . ",";
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////ENVIADO AL PUNTUAL///////////////////////////////////////////
	if ($usuarioseleccionado != null) {
		$insertdato = "INSERT INTO tbli_esq_plant_formunico_docsinternos(id,usu_respons_edit,respuesta_anexotxt,
		codigo_documento ,origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email,
		origen_tipo_tramite,origen_form_asunto,usu_asigdepartamento,origen_tipodoc,origen_institucion,
		destino_cedul,est_respuesta_recibido,origen_cargo,origen_departament,destino_nombres,destino_cargo,
		destino_departament,destino_tipo_tramite,destino_form_asunto,codi_refid,codi_barras,codif_id_tipodoc,
		codigo_tramite,origen_id_tipo_tramite,ref_procesoform,respuesta_estado,resp_estado_anterior, 
		est_respuesta_enviado, num_memocreado)  VALUES 
		(default,'" . $cedulaRemitente . "','','" . $varcoditramite . "','" . $cedulaRemitente . "',
		'" . $txtnombres . "',' ',' ',' ', '" . $detalle . "', 
		'" . $detalle . "','1','TRAMITE','EXTERNO','" . $usuarioseleccionado . "', 1,'-',
		'-','" . $nombre_usuario . ' ' . $apellido_usuario . "','" . $cargo_usuario . "','" . $departamento_usuario . "', 
		'" . $detalle . "', '" . $detalle . "','1','" . "100" . $numerotramite . "', '" . $cuadroclasificacion . "',
		'" . $varcoditramite . "','" . $cuadroclasificacion . "', '" . $cuadroclasificacion . "','ENVIADO','ENVIADO', 1,'" . $numerotramite . "')";
		$rescodpers = pg_query($conn, $insertdato);
	}
	////////////////////////////////////////////////////////////////////////////////////////
	$_SESSION["inicia"] = "begin";
}

if ($usuarioseleccionado != null) {
	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'municotacachi@gmail.com';                     // SMTP username
		$mail->Password   = 'Rootbg25@';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		//Recipients
		$mail->setFrom('municotacachi@gmail.com', utf8_decode('Gestión Documental'));
		$emails = "";

		$sqlus = "SELECT usua_email	FROM public.tblu_migra_usuarios where  usua_cedula='" . $usuarioseleccionado . "';";
		$result = pg_query($conn, $sqlus);
		$usua_email = pg_fetch_result($result, 0, "usua_email");
		$mail->addAddress($usua_email);     // Add a recipient
		if ($mail != null)
			$emails += $mail;

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = utf8_decode("Nuevo trámite");
		$mail->Body    = utf8_decode("
		<img style='left: 40%;' src='http://www.cotacachienlinea.gob.ec/sip_gd/imgs/logos/mail.png' width='200' /> <br>
		Ha recibido un nuevo formulario externo en el Sistema de Gesti&oacute;n Documental - Municipio de Cotacachi, <br>
		<br>Nro. Trámite: " . $numerotramite . "
		<br>Nro. Documento: " . $codigoDocumento . "
		<br>Asunto: Nuevo trámite
		<br>Origen: " . $nombres . " - " . $departamentoRemitente . "  
		<br><br><b>por favor ingrese al sistema>>></b></br> 
		http://www.cotacachienlinea.gob.ec/sip_gd/index.php
		<br><br>Sub Dirección de Tecnología y Sistemas
		<br><p style='font-size:10px'>*Mensaje generado automaticamente, no responda a este correo.</p>");
		$mail->AltBody = 'No reponder a este correo.';
		if ($emails != null) {
			$mail->send();
			echo 'Message ha sido enviado';
		}
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Datos geo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/fonts/font_roboto/roboto.css" />
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/dhtmlx.css" />
	<script src="../../dhtmlx51/codebase/dhtmlx.js"></script>
	<style>
		html,
		body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #ebebeb;*/
			overflow: hidden;
		}

		div.gridbox table.obj td {

			font-family: Arial;
			font-size: 11px;
		}

		.dhtmlxGrid_selection {
			-moz-opacity: 0.5;
			filter: alpha(opacity=50);
			background-color: #83abeb;
			opacity: 0.5;
		}

		div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(imgs/btn_sig.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 5px;
			margin: 0px 15px 0px 12px;
			height: 100px;
		}

		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(imgs/btn_anter.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 5px;
			margin: 0px 15px 0px 12px;
		}

		#menutopsupervis {
			width: 100%;
			background-image: linear-gradient(to bottom, rgba(225, 238, 255), rgba(199, 224, 255));
			border: 1px solid #a4bed4;
			height: 29px;
			font-family: Tahoma, Geneva, sans-serif;
			font-size: 11px;
			color: #000;
			text-decoration: none;
		}

		#layoutmenusuperderecha {
			background-color: #e7f1ff;
			width: 100%;
			height: 100%;
			font-size: 11px;
		}
	</style>
	<script>
		var myLayout, myGrid, myForm, myMenuContex, myGridhist, correos;

		function doOnLoad() {
			correos = sessionStorage.getItem("correosSeleccionados");
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				pattern: "2E",
				cells: [{
					id: "a",
					text: "Adjuntar anexos...",
				}, {
					id: "b",
					text: "",
					height: 1
				}]
			});
			myLayout.cells("b").hideHeader();
			myTabbar = myLayout.cells("a").attachTabbar({
				tabs: [{
					id: "a1",
					text: "<div class='tab_docsitemsinst'>-- ANEXOS DE RESPUESTA  --</div>",
					active: true
				}]
			});
			myTabbar.tabs("a1").attachURL("vistaform_anexos_instit_memo.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varclaveuntramusu=<?php echo $varclaveunictramitusu ?>&varcodgenerado=<?php echo '100' . $numerotramite ?>&txtasunto=<?php echo $asunto ?>&numerotramite=<?php echo $numerotramite ?>&tipodocumento=<?php echo $tipodocumento ?>");
		}
	</script>
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue_blue/dhtmlx.css" />
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" onLoad="doOnLoad();">
	<div id="layoutinformatext" style="background-color:#fff">
	</div>
	<div style="background-color:#ffffff">
		<table width="100%" border="0">
			<tr>
				<table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
					</tr>
	</div>
</body>

</html>