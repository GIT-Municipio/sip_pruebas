﻿<?php
///////////codigo departamento
$envcodidepartgen = '';
session_start();
require_once('../../clases/conexion.php');
///////////////limìar y crear el usuario de
$sqlini = "delete from tblu_seleccion_usuarios where activ_sesionuser='" . $_SESSION['sesusuario_cedula'] . "';insert into tblu_seleccion_usuarios(usua_cedula, usua_nomb, usua_apellido, usua_email,  usua_cargo,  usu_departamento,estado_envio_dpc,activ_sesionuser) (SELECT usua_cedula, usua_nomb, usua_apellido, usua_email,  usua_cargo,  usu_departamento,'DE','" . $_SESSION['sesusuario_cedula'] . "' FROM public.tblu_migra_usuarios  where usua_cedula='" . $_SESSION['sesusuario_cedula'] . "' );";
$resfreini = pg_query($conn, $sqlini);
$latabla = 'tblu_seleccion_usuarios';
$elidprinorder = 'id';
$elsubcampoenlace = "";
$elsubcampocarg = "";
$elsubcamptipousu = "";
$elsubcampusuactiv = "";
$numerdedatos = "";
$elsubcamponombre = "";
$_SESSION["mvpr"] = "999";
$_SESSION['cedula_destinatario'] = "1002813424";

//$bandera = $_GET['bandera']; ??no llama de ningun lado
//////////seleccionar tabla///

$cedula = $_SESSION['sesusuario_cedula'];


$sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo,
	usu_departamento, usu_biografia, ultima_mac_acceso
	FROM public.tblu_migra_usuarios where  usua_cedula='" . $cedula . "';";
$result = pg_query($conn, $sqlus);
$nombre_temp = pg_fetch_result($result, 0, "usua_nomb");
$apellido_temp = pg_fetch_result($result, 0, "usua_apellido");
$cargo_temp = pg_fetch_result($result, 0, "usua_cargo");
$departamento_temp = pg_fetch_result($result, 0, "usu_departamento");
$abr_temp = pg_fetch_result($result, 0, "usua_abr_titulo");
$jefes = pg_fetch_result($result, 0, "usu_biografia");
$vistobueno = pg_fetch_result($result, 0, "ultima_mac_acceso");

$jefes = $cedula . ',' . $jefes;
$phone_number = "001-234-567678";
$arr_ph = explode(",", $jefes);
$contador = 0;
foreach ($arr_ph as $i) {
	if ($i != null && $i != '') {
		$sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo,
			usu_departamento, usu_biografia
			FROM public.tblu_migra_usuarios where  usua_cedula='" . $i . "';";
		$result = pg_query($conn, $sqlus);
		$nombre_temp = pg_fetch_result($result, 0, "usua_nomb");
		$apellido_temp = pg_fetch_result($result, 0, "usua_apellido");
		$cargo_temp = pg_fetch_result($result, 0, "usua_cargo");
		$departamento_temp = pg_fetch_result($result, 0, "usu_departamento");
		$remitentesborrador[$contador][0] = $i;
		$remitentesborrador[$contador][1] = $nombre_temp . ' ' . $apellido_temp . ' - ' . $cargo_temp;
		// echo "<script type='text/javascript'>alert('$nombre_temp');</script>";
		$contador++;
	}
}
$long = count($remitentesborrador);
// echo "<script type='text/javascript'>alert('$long');</script>";

$sql = "SELECT id, usua_nomb, usua_apellido, usua_email, usua_cargo, usu_departamento,usua_abr_titulo,estado_envio_dpc FROM public.tblu_seleccion_usuarios order by id;";
$res = pg_query($conn, $sql);
$numercampos = pg_num_fields($res);

$sqltextm = "SELECT count(*) FROM public.tbli_esq_plant_formunico_docsinternos where origen_tipodoc='MEMORANDO DIRECCION'";
$restxtmem = pg_query($conn, $sqltextm);
$pregnumermemo = pg_fetch_result($restxtmem, 0, 0);
/////////////////////////////////////////////
$vernummemoultm = 1;
if ($pregnumermemo == 0) {
	$ponernumdocumnew = "GADC-PLAN-MEM-" . $vernummemoultm;
} else {
	$sqltextnumemox = "SELECT max(num_memocreado) FROM public.tbli_esq_plant_formunico_docsinternos where origen_tipodoc='MEMORANDO DIRECCION'";
	$restxtnumemo = pg_query($conn, $sqltextnumemox);
	$vernummemoultm = pg_fetch_result($restxtnumemo, 0, 0) + 1;
	$ponernumdocumnew = "GADC-PLAN-MEMO-" . $vernummemoultm;
}
/////////////////////////////////////////////
$camposver = "";
$tamcamposver = "";
$posicamposver = "";
$tipocamposver = "";
$tipcamposorden = "";
$filtrocampos = "";
for ($col = 0; $col < $numercampos; $col++) {
	if ($col < $numercampos - 1) {
		$camposver .= pg_field_name($res, $col) . ",";
		$posicamposver .= "left,";
		if ($col == 0) {
			$tamcamposver .= "50,";
			if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
				$tipocamposver .= "co,";
			else
				$tipocamposver .= "dyn,";
			$tipcamposorden .= "int,";
			$filtrocampos .= "#text_filter,";
		} else {
			if ($numerdedatos == 0) {
				if ((pg_field_name($res, $col) == $elsubcamponombre))
					$tamcamposver .= "200,";
				else
					$tamcamposver .= "100,";
				if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
					$tipocamposver .= "co,";
				else
					$tipocamposver .= "txt,";
				$tipcamposorden .= "str,";
				$filtrocampos .= "#text_filter,";
			} else {
				if (is_numeric(pg_fetch_result($res, 0, $col))) {
					if ((pg_field_name($res, $col) == $elsubcamponombre))
						$tamcamposver .= "200,";
					else {
						$tamcamposver .= "100,";
						if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
							$tipocamposver .= "co,";
						else
							$tipocamposver .= "edn,";
						$tipcamposorden .= "int,";
						$filtrocampos .= "#text_filter,";
					}
				} else {
					if ((pg_field_name($res, $col) == $elsubcamponombre))
						$tamcamposver .= "200,";
					else
						$tamcamposver .= "100,";
					if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
						$tipocamposver .= "co,";
					else
						$tipocamposver .= "txt,";
					$tipcamposorden .= "str,";
					$filtrocampos .= "#text_filter,";
				}
			}
		}
	} else {
		if ($numerdedatos == 0) {
			$camposver .= pg_field_name($res, $col);
			if ((pg_field_name($res, $col) == $elsubcamponombre))
				$tamcamposver .= "200";
			else
				$tamcamposver .= "100";
			$posicamposver .= "left";
			if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
				$tipocamposver .= "co";
			else
				$tipocamposver .= "txt";
			$tipcamposorden .= "str";
			$filtrocampos .= "#text_filter";
		} else
	   if (is_numeric(pg_fetch_result($res, 0, $col))) {
			$camposver .= pg_field_name($res, $col);
			if ((pg_field_name($res, $col) == $elsubcamponombre))
				$tamcamposver .= "200";
			else
				$tamcamposver .= "100";
			$posicamposver .= "left";
			if ((pg_field_name($res, $col) == $elsubcampoenlace) || (pg_field_name($res, $col) == $elsubcampocarg) || (pg_field_name($res, $col) == $elsubcamptipousu) || (pg_field_name($res, $col) == $elsubcampusuactiv))
				$tipocamposver .= "co";
			else
				$tipocamposver .= "edn";
			$tipcamposorden .= "int";
			$filtrocampos .= "#text_filter";
		} else {
			$camposver .= pg_field_name($res, $col);
			if ((pg_field_name($res, $col) == $elsubcamponombre))
				$tamcamposver .= "200";
			else
				$tamcamposver .= "100";
			$posicamposver .= "left";
			$tipocamposver .= "txt";
			$tipcamposorden .= "str";
			$filtrocampos .= "#text_filter";
		}
	}
}
$vectortiposcamps = explode(",", $tipocamposver);
$contarvecamps = count($vectortiposcamps);
$camposver = strtoupper($camposver);
// $correos = $_SESSION["correosSeleccionados"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
	<link rel="stylesheet" type="text/css" href="estilo/estil.css" />
	<script src="../../componentes/codebase/dhtmlx.js"></script>
	<script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
	<script src="estilo/event.js"></script>
	<!-- <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script> -->
	<!-- <script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script> -->
	<script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/decoupled-document/ckeditor.js"></script>
	<script src="http://localhost/sip_pruebas/componentes/codebase/dhtmlxgridcell.js"></script>

	<script type="text/javascript">
		var myLayout, myAcc, myForm, formData, myDataProcessor, mygrid, dhxWinsusus;

		function cerrarventanadoc() {
			sessionStorage.setItem("correosSeleccionados", "");
			parent.dhxWins.window("w1").close();
		}
		///////////////////
		function SeleccUsuario() {
			dhxWinsusus = new dhtmlXWindows();
			wuser1 = dhxWinsusus.createWindow("wuser1", 2, 10, 930, 550);
			wuser1.setText("Seleccion de Usuarios");
			wuser1.button("park").disable();
			wuser1.button("minmax").disable();
			wuser1.button("close").disable();
			wuser1.attachURL("nuevo_doc_users.php");
			wuser1.setModal(false); ////sirve para bloquear la pantalla para quitar simplemente se pone false
			mygrid.parse(sessionStorage.getItem("correosSeleccionados"));
			mygrid.groupBy(7);
			wuser1.attachEvent("onClose", function() {
				doOnLoad();
				wuser1.hide();
			});
		}

		//////////////////////////////////////////guardar formulario
		function guardarformrespuesta() {
			var correos = sessionStorage.getItem('correosSeleccionados');
			correos = correos.split('<cell>http://localhost/html/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.split('<cell>http://www.cotacachienlinea.gob.ec/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.replace(/>[0-9][0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/>[0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/id='[0-9][0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9]'/g, '');
			correos = correos.replace(/id='[a-zA-Z]*'/g, '');
			correos = correos.replace(/<row >/g, '<row>');
			correos = correos.replace(/>PARA</g, '>PARA1<');
			correos = correos.replace(/>COPIA</g, '>COPIA1<');
			correos = correos.replace(/[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]*)/g, '');
			correos = correos.replace(/>\s*[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+\s*</g, '><');
			correos = correos.replace(/<cell \/>/g, '');
			correos = correos.replace(/<?= '1.0' ?>'/g, '');
			correos = correos.replace(/<cell>\s*<\/cell>/g, '');
			correos = correos.split('<rows>')[1];
			correos = '<rows>'.concat(correos);
			correos = correos.replace(/>PARA1</g, '>PARA<');
			correos = correos.replace(/>COPIA1</g, '>COPIA<');
			var d = new Date();
			d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toUTCString();
			document.cookie = "correos= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
			document.cookie = "correos=" + correos + ";" + expires + ";path=/";

			var txtasunto = document.getElementById('txtasunto');
			var tipodocumento = document.getElementById('myidtipodocum');

			var vb = document.getElementById('vb').checked;
			if (vb)
				vb = "<?php echo $vistobueno; ?>";
			else
				vb = '';

			var txtdescripcion = document.getElementById('editor').innerHTML;
			txtdescripcion = txtdescripcion.replace(/<svg(.*?)svg>/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="true"/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="false"/g, '');
			txtdescripcion = txtdescripcion.replace(/<table>/g, '<table style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<tbody>/g, '<tbody style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<td/g, '<td style="border: 1px solid black;" ');

			if (correos == null || correos == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Selecciones destinatarios"
				});
			} else if (txtasunto.value == null || txtasunto.value == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese asunto"
				});
			} else if (txtdescripcion == null || txtdescripcion == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese descripción de memorando"
				});
			} else {
				dhtmlx.confirm({
					title: "Mensaje!",
					text: "Se generará un NUEVO TRÁMITE. \n ¿Desea continuar?",
					callback: function(result) {
						if (result) {
							sessionStorage.setItem("correosSeleccionados", "");
							document.getElementById("formnamedats").style.display = "none";
							document.getElementById("loader").style.display = "inline-block";

							var form = document.createElement("form");
							form.setAttribute("method", "post");
							form.setAttribute("action", "../mod_forms/form_pubanex_memo.php?mvpr=999&pontblanexo=anexo_6&varidplanty=999".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value).concat("&vistobueno=").concat(vb));
							form.setAttribute("target", "_self");
							var hiddenField1 = document.createElement("input");
							hiddenField1.setAttribute("type", "hidden");
							hiddenField1.setAttribute("name", "txtdescripcion");
							hiddenField1.setAttribute("value", txtdescripcion);
							form.appendChild(hiddenField1);
							document.body.appendChild(form);
							// window.open('../mod_forms/form_pubanex_memo.php', 'ventanarequs', "width=700,height=500,scrollbars=NO");
							form.submit();
							parent.window.close();
							// document.location.href = "../mod_forms/form_pubanex_memo.php?mvpr=999&pontblanexo=anexo_6&varidplanty=999".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value);
						} else {
							dhtmlx.alert({
								title: "Mensaje Advertencia!",
								text: "Se cancelo la operacion"
							});
						}
					}
				});
			}
		}


		function guardarBorrador() {
			var correos = sessionStorage.getItem('correosSeleccionados');
			correos = correos.split('<cell>http://localhost/html/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.split('<cell>http://www.cotacachienlinea.gob.ec/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.replace(/>[0-9][0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/>[0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/id='[0-9][0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9]'/g, '');
			correos = correos.replace(/id='[a-zA-Z]*'/g, '');
			correos = correos.replace(/<row >/g, '<row>');
			correos = correos.replace(/>PARA</g, '>PARA1<');
			correos = correos.replace(/>COPIA</g, '>COPIA1<');
			correos = correos.replace(/[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]*)/g, '');
			correos = correos.replace(/>\s*[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+\s*</g, '><');
			correos = correos.replace(/<cell \/>/g, '');
			correos = correos.replace(/<?= '1.0' ?>'/g, '');
			correos = correos.replace(/<cell>\s*<\/cell>/g, '');
			correos = correos.split('<rows>')[1];
			correos = '<rows>'.concat(correos);
			correos = correos.replace(/>PARA1</g, '>PARA<');
			correos = correos.replace(/>COPIA1</g, '>COPIA<');
			var d = new Date();
			d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toUTCString();
			document.cookie = "correos= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
			document.cookie = "correos=" + correos + ";" + expires + ";path=/";

			var txtasunto = document.getElementById('txtasunto');
			var tipodocumento = document.getElementById('myidtipodocum');
			var remitenteseleccionado = document.getElementById('jefes').value;
			var txtdescripcion = document.getElementById('editor').innerHTML;
			txtdescripcion = txtdescripcion.replace(/<svg(.*?)svg>/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="true"/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="false"/g, '');
			txtdescripcion = txtdescripcion.replace(/<table>/g, '<table style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<tbody>/g, '<tbody style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<td/g, '<td style="border: 1px solid black;" ');
			document.cookie = "txtdescripcion= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
			document.cookie = "txtdescripcion=" + txtdescripcion + ";" + expires + ";path=/";

			if (txtasunto.value == null || txtasunto.value == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese asunto"
				});
			} else if (txtdescripcion == null || txtdescripcion == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese descripción de memorando"
				});
			} else {
				dhtmlx.confirm({
					title: "Mensaje!",
					text: "Se guardará un borrador del documento en la bandeja seleccionada . \n ¿Desea continuar?",
					callback: function(result) {
						if (result) {
							sessionStorage.setItem("correosSeleccionados", "");

							var form = document.createElement("form");
							form.setAttribute("method", "post");
							form.setAttribute("action", "../mod_forms/form_pubanex_borrador.php?cedularemitente=&mvpr=999&pontblanexo=anexo_6&varidplanty=999".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value).concat("&cedularemitente=").concat(remitenteseleccionado));
							form.setAttribute("target", "_self");
							var hiddenField1 = document.createElement("input");
							hiddenField1.setAttribute("type", "hidden");
							hiddenField1.setAttribute("name", "txtdescripcion");
							hiddenField1.setAttribute("value", txtdescripcion);
							form.appendChild(hiddenField1);
							document.body.appendChild(form);
							// window.open('../mod_forms/form_pubanex_memo.php', 'ventanarequs', "width=700,height=500,scrollbars=NO");
							form.submit();
							parent.window.close();

							// document.location.href = "../mod_forms/form_pubanex_borrador.php?cedularemitente=&mvpr=999&pontblanexo=anexo_6&varidplanty=999".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value).concat("&cedularemitente=").concat(remitenteseleccionado);
						} else {
							dhtmlx.alert({
								title: "Mensaje Advertencia!",
								text: "Se cancelo la operacion"
							});
						}
					}
				});
			}
		}
		//////////////////////////////////////////vista previa documento
		function vistapreviadocumento() {
			var correos = sessionStorage.getItem('correosSeleccionados');
			correos = correos.split('<cell>http://localhost/html/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.split('<cell>http://www.cotacachienlinea.gob.ec/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png</cell>').join('');
			correos = correos.replace(/>[0-9][0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/>[0-9][0-9][0-9]</g, '><');
			correos = correos.replace(/id='[0-9][0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9][0-9]'/g, '');
			correos = correos.replace(/id='[0-9]'/g, '');
			correos = correos.replace(/id='[a-zA-Z]*'/g, '');
			correos = correos.replace(/<row >/g, '<row>');
			correos = correos.replace(/>PARA</g, '>PARA1<');
			correos = correos.replace(/>COPIA</g, '>COPIA1<');
			correos = correos.replace(/[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]*)/g, '');
			correos = correos.replace(/>\s*[a-zA-ZáéíóúÁÉÍÓÚñÑ(),\/-]+\s*</g, '><');
			correos = correos.replace(/<cell \/>/g, '');
			correos = correos.replace(/<?= '1.0' ?>'/g, '');
			correos = correos.replace(/<cell>\s*<\/cell>/g, '');
			correos = correos.split('<rows>')[1];
			correos = '<rows>'.concat(correos);
			correos = correos.replace(/>PARA1</g, '>PARA<');
			correos = correos.replace(/>COPIA1</g, '>COPIA<');
			var d = new Date();
			d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toUTCString();
			document.cookie = "correos= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
			document.cookie = "correos=" + correos + ";" + expires + ";path=/";
			var txtdescripcion = document.getElementById('editor').innerHTML;
			var remitenteseleccionado = document.getElementById('jefes').value;
			var vb = document.getElementById('vb').checked;
			txtdescripcion = txtdescripcion.replace(/<svg(.*?)svg>/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="true"/g, '');
			txtdescripcion = txtdescripcion.replace(/contenteditable="false"/g, '');
			txtdescripcion = txtdescripcion.replace(/<table>/g, '<table style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<tbody>/g, '<tbody style="border: 1px solid black;">');
			txtdescripcion = txtdescripcion.replace(/<td/g, '<td style="border: 1px solid black;" ');
			if (vb)
				vb = "<?php echo $vistobueno; ?>";
			else
				vb = '';
			document.cookie = "txtdescripcion= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
			document.cookie = "txtdescripcion=" + txtdescripcion + ";" + expires + ";path=/";
			var txtasunto = document.getElementById('txtasunto');
			var tipodocumento = document.getElementById('myidtipodocum');

			var correos1 = sessionStorage.getItem('correosSeleccionados');
			if (correos1 == null || correos1 == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Seleccione Destinatario"
				});
			} else if (txtasunto.value == null || txtasunto.value == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese asunto"
				});
			} else if (txtdescripcion == null || txtdescripcion == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese descripción de memorando"
				});
			} else {
				var form = document.createElement("form");
				form.setAttribute("method", "post");
				form.setAttribute("action", "../mod_forms/vista_previa_memo.php?cedularemitente=<?php echo $_SESSION['sesusuario_cedula'] ?>&nombresremitente=<?php echo $_SESSION['sesusuario_nomcompletos'] ?>&dependencia=<?php echo $_SESSION['sesusuario_dependencia']; ?>&mvpr=999&pontblanexo=anexo_6&varidplanty=999&area=<?php echo $_SESSION['sesusuario_nomdepartameusu'] ?>&cargo=<?php echo $_SESSION['sesusuario_cargousu'] ?>".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value).concat("&remitenteseleccionado=").concat(remitenteseleccionado).concat("&vistobueno=").concat(vb));
				form.setAttribute("target", "ventanarequs");
				var hiddenField1 = document.createElement("input");
				hiddenField1.setAttribute("type", "hidden");
				hiddenField1.setAttribute("name", "txtdescripcion");
				hiddenField1.setAttribute("value", txtdescripcion);
				form.appendChild(hiddenField1);
				document.body.appendChild(form);
				window.open('../mod_forms/vista_previa_memo.php', 'ventanarequs', "width=700,height=500,scrollbars=NO");
				form.submit();
				// window.open("../mod_forms/vista_previa_memo.php?cedularemitente=<?php echo $_SESSION['sesusuario_cedula'] ?>&nombresremitente=<?php echo $_SESSION['sesusuario_nomcompletos'] ?>&dependencia=<?php echo $_SESSION['sesusuario_dependencia']; ?>&mvpr=999&pontblanexo=anexo_6&varidplanty=999&area=<?php echo $_SESSION['sesusuario_nomdepartameusu'] ?>&cargo=<?php echo $_SESSION['sesusuario_cargousu'] ?>".concat("&txtasunto=").concat(txtasunto.value).concat("&tipodocumento=").concat(tipodocumento.value), "ventanarequs", "width=700,height=500,scrollbars=NO");
			}
		}

		function pasarValores() {
			document.formnamedats.contenidodelmemo.correos.value = sessionStorage.getItem("correosSeleccionados");
		}

		function doOnLoad() {
			myLayout = new dhtmlXLayoutObject({
				parent: "layoutObj",
				pattern: "1C",
				cells: [{
					id: "a",
					text: "Seleccionar Usuario:",
					height: 140
				}]
			});
			myLayout.cells("a").hideHeader();
			mygrid = new dhtmlXLayoutObject('gridbox');
			mygrid = myLayout.cells("a").attachGrid();
			mygrid.setImagePath("../../componentes/codebase/imgs/");
			mygrid.setHeader("ID, CEDULA, NOMBRES, APELLIDOS, EMAIL, CARGO, DEPENDENCIA, TITULO,DE");
			mygrid.setInitWidths("1,1,210,210,1,230,200,1,1");
			mygrid.setColAlign("left,left,left,left,left,left,center, center,center");
			mygrid.setColTypes("ro,ro,ro,ed,ed,ro,ro,ro,ro");
			mygrid.setSkin("dhx_skyblue");
			mygrid.enableEditEvents(false, false, false);
			mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
			mygrid.setColumnColor("white,#d5f1ff,#d5f1ff,#d5f1ff,,,#d5f1ff");
			// mygrid.setColumnHidden(7, true);
			mygrid.attachEvent("onRowSelect", doOnRowSelected);
			////////////bloqueo de las columnas
			mygrid.makeSearch("searchFilter", 3);
			mygrid.init();
			if (sessionStorage.getItem("correosSeleccionados") == null || sessionStorage.getItem("correosSeleccionados") == "") {
				mygrid.filterBy(6, function(data) {
					return data.toString().indexOf("DE") == -1;
				}, true);
				mygrid.groupBy(6);
			} else {
				mygrid.parse(sessionStorage.getItem("correosSeleccionados"));
				mygrid.filterBy(8, function(data) {
					return data.toString().indexOf("DE") == -1;
				}, true);
				mygrid.groupBy(8);
			}

			function doOnRowSelected(rowId, cellIndex) {
				var datovalorid = mygrid.cells(rowId, 0).getValue();
				var retornidrad = document.getElementById('varselecionusuarioenv').value;
				if (retornidrad > 0) {}
				document.getElementById('varselecionusuarioenv').value = datovalorid;
			}
			if (bandera == null || bandera == '') {
				var bandera = 'true';
				// alert(bandera);
				sessionStorage.setItem("correosSeleccionados", sessionStorage.getItem("correosSeleccionados"));
			}
			// $bandera='true';
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST", true); //set mode as send-all-by-post
			myDataProcessor.init(mygrid); //link dataprocessor to the grid
			myDataProcessor.attachEvent("onAfterUpdate", function() {})
		}

		function btnacutalizarall() {
			doOnLoad();
		}
	</script>
	<style>
		html,
		body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}

		.menulatdivinfer {
			background-image: linear-gradient(to bottom, rgba(225, 238, 255), rgba(199, 224, 255));
			border: 1px solid #a4bed4;
			height: 20px;
			font-family: Tahoma, Geneva, sans-serif;
			font-size: 11px;
			color: #000;
			padding: 0px 0px 0px 0px;
			margin-bottom: 0px;

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

		body {
			background-color: #ebf3ff;
		}

		.botones_largo {
			height: 25px;
			font-size: 12px;
			width: 150px;
			background-image: url(../../imgs/tablogin.png);
			color: #FFFFFF;
			border: thin solid #aaa;
			box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0, 0, 0, .4);
			border-color: #FFF;
			border-radius: 10px;
			box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0, 0, 0, .4);

		}

		.botones {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			background-image: url(../../imgs/btnnuevo.png);
			background-repeat: no-repeat;
			background-size: 100% 100%;

			color: #fff;
			text-align: center;
			height: 25px;
			width: 90px;
			cursor: pointer;
			border: 1px solid #000000;
			border-color: #FFF;
			border-radius: 10px;
			box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0, 0, 0, .4);
		}

		#selecdocumentotips {
			width: 98%;
			background-color: #FFF;
			border: 1px solid #003366;
			border-color: #003366;
			border-radius: 10px;
			margin-top: 6px;
			margin-bottom: 6px;
		}

		#selecdocumentotipsArea {
			width: 98%;
			background-color: #FFF;
			border: 1px solid #003366;
			border-color: #003366;
			border-radius: 10px;
			margin-top: 10px;
			margin-bottom: 6px;
		}

		#txtdescripcion {
			margin-left: 10px;
			resize: none;
		}

		#txtremitente {
			font: bold;
		}

		.dic {

			border: 1px solid var(--ck-color-base-border);
			border-radius: var(--ck-border-radius);
			/* Set vertical boundaries for the document editor. */
			max-height: 700px;
			/* This element is a flex container for easier rendering. */
			display: flex;
			flex-flow: column nowrap;
			z-index: 1;
			box-shadow: 0 0 5px hsla(0, 0%, 0%, .2);
			border-bottom: 1px solid var(--ck-color-toolbar-border);
			padding: calc(2 * var(--ck-spacing-large));
			background: var(--ck-color-base-foreground);
			overflow-y: scroll;
			width: 15.8cm;
			min-height: 21cm;
			padding: 1cm 1cm 2cm 2cm;
			border: 1px hsl(0, 0%, 82.7%) solid;
			border-radius: var(--ck-border-radius);
			background: white;
			box-shadow: 0 0 5px hsla(0, 0%, 0%, .1);
			margin: 0 auto;
			border: 0;
			border-radius: 0;
			font-size: 1em;
			line-height: 1.63em;
			padding-top: .5em;
			margin-bottom: 1.13em;
			font-family: Georgia, serif;
			font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
		}

		#loader {
			border: 16px solid #f3f3f3;
			/* Light grey */
			border-top: 16px solid #3498db;
			/* Blue */
			border-radius: 50%;
			width: 120px;
			height: 120px;
			animation: spin 2s linear infinite;

			position: absolute;
			top: 40%;
			left: 40%;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>

</head>

<body onLoad="doOnLoad()">
	<div id="loader" style="display: none;"></div>
	<form method="GET" id="formnamedats">

		<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="60%" colspan="2" align="center" background="../../imgs/piepag.png" height="30">
					<input type="button" name="btn_usuarios" id="btn_usuarios" value="Buscar Destinatarios" class="botones_largo" title="Buscar por nombre o cédula, al Remitente, Destinatarios del Documento, y/o Con copia a" onClick="SeleccUsuario();">&nbsp;&nbsp;
					<input type="button" name='Aceptar' class="botones" title="Graba el documento y pasa a la página de consulta del documento" value="Enviar" onclick="guardarformrespuesta()">&nbsp;&nbsp;
					<input type="button" name='Guardar' class="botones_largo" title="Guarda un borrador del documento actual" value="Guardar borrador" onclick="guardarBorrador();">&nbsp;&nbsp;
					<input type='button' onClick='cerrarventanadoc()' name='Submit3' value='Cancelar' class="botones" title="Sale de la creación de documentos sin grabar">
					<input type='button' onClick='vistapreviadocumento()' name='vista' value='Vista previa' class="botones" title="Vista previa del documento">
				</td>
			</tr>
			<?php
			?>
		</table>

		<div id="layoutObj" style="width:100%;height:140px;overflow:hidden"></div>
		<div id="gridbox" style="width:100%;"></div>

		<div id="contenidodelmemo">
			<input type="hidden" id="variabtrami" name="variabtrami" value="<?php if (isset($_GET["vafil"])) echo $_GET["vafil"]; ?>" />
			<input type="hidden" id="varcodgenerado" name="varcodgenerado" value="<?php if (isset($_GET["varcodgenerado"])) echo $_GET["varcodgenerado"]; ?>" />
			<input type="hidden" id="varespuestusu" name="varespuestusu" value="2" />
			<input type="hidden" id="varselecionusuarioenv" name="varselecionusuarioenv" />
			<input type="hidden" id="varusulocalactiv" name="varusulocalactiv" value="<?php if (isset($_GET["retornmiusuarioseguim"])) echo $_GET["retornmiusuarioseguim"]; ?>" />
			<div align="center">
				<div align="center" name="selecdocumentotips" id="selecdocumentotips">
					<table width="98%" border="0" bgcolor="#FFF">
						<tr>
							<td width="146">
								<font color="#003366" size="2">Tipo_Documento</font>
							</td>
							<td width="308">
								<select name="myidtipodocum" id="myidtipodocum" style="background-color:#FF9; width: 300px">
									<?php
									$sqltipdoc = "SELECT id, tipo as documento  FROM public.tbli_esq_plant_formunico_tipodoc where activo=1 and est_eliminado=0  order by id";
									$restipdoc = pg_query($conn, $sqltipdoc);
									for ($i = 0; $i < pg_num_rows($restipdoc); $i++) {
										echo '<option value="' . pg_fetch_result($restipdoc, $i, 'documento') . '">' . pg_fetch_result($restipdoc, $i, 'documento') . '</option>';
									}
									$sqllosreqcc = "select id from tbli_esq_plant_form_cuadro_clasif where ref_id_proceso='" . $_GET["mvpr"] . "'";
									$consveresquscc = pg_query($conn, $sqllosreqcc);
									$codcuad = pg_fetch_result($consveresquscc, 0, "id");

									$sqllosreqcc = "select count(*) from tbli_esq_plant_form_plantilla where ref_clasif_doc='" . $codcuad . "'";
									$consveresquscc = pg_query($conn, $sqllosreqcc);
									$codtadorppka = pg_fetch_result($consveresquscc, 00);
									if ($codtadorppka != 0) {
										$sqllosreqcc = "select id from tbli_esq_plant_form_plantilla where ref_clasif_doc='" . $codcuad . "'";
										$consveresquscc = pg_query($conn, $sqllosreqcc);
										$codplantilla = pg_fetch_result($consveresquscc, 0, "id");
										echo  '<tr>
	<td valign="bottom" bgcolor="#525659" align="center"><a href="../mod_forms/form_vista.php?rp=' . $codplantilla . '"><img src="images/form_btnformu.png" width="202" height="44" /></a></td>
	</tr>';
									}
									?>
								</select></td>
							<td width="395">
								<table width="294" border="0" align="center">
									<tr>
										<td width="184">
											<font color="#003366" size="2">Tiempo_Respuesta en dias: </font>
										</td>
										<td width="100"><input name="txtingresdias" type="number" id="txtingresdias" style="width: 100px;" required="true" oninput="(function(e){e.setCustomValidity(''); return !e.validity.valid && e.setCustomValidity(' ')})(this)" oninvalid="this.setCustomValidity('Es Necesario Ingresar Valor de dias de Atencion del Tramite')" placeholder="# de dias ..." value="2"></td>
									</tr>
								</table>
							</td>
							<td width="4">&nbsp;</td>
							<td width="5">&nbsp;</td>
						</tr>
						<!-- <tr>
							<td>
								<font color="#003366" size="2">De:</font>
							</td>
							<td colspan="2"><input readonly="true" name="txtremitente" type="text" id="txtremitente" style="width: 100%; font: bold;" value="<?php echo $_SESSION['sesusuario_nomcompletos']; ?> (<?php echo $_SESSION['sesusuario_cargousu'] ?>)"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr> -->
						<tr>
							<td>
								<font color="#003366" size="2">De:</font>
							</td>
							<td width="400px">
								<select name="jefes" id="jefes" style="background-color:#FF9;">
									<?php
									foreach ($remitentesborrador as $i) {
										echo '<option value="' . $i[0] . '" >' . $i[1] . '</option>';
									}
									?>
								</select>
							</td>

							<td width="80px">
								<input type="checkbox" name="vb" id="vb" value="ok" />
								<label for="vb" style="font-size: 12px;"> Visto bueno</label>
							</td>

						</tr>
						<tr>
							<td>
								<font color="#003366" size="2">Asunto:</font>
							</td>
							<td colspan="2"><input class="form-control" name="txtasunto" type="text" maxlength="200" id="txtasunto" style="width: 100%;" placeholder="Campo obligatorio..." required></td>
						</tr>
					</table>
				</div>
			</div>

			<font color="#003366" size="2">Descripción:</font>
			<div style="height: 290px; overflow: scroll; ">
				<!-- <textarea name="content" id="txtdescripcion" class="dic">
										&lt;p&gt;&lt;/p&gt;
									</textarea> -->

				<div id="toolbar-container"></div>
				<div id="editor" class="dic" style="font-size: 12px;;">
				</div>
			</div>
			<div align="right">

			</div>
			<script>
				DecoupledEditor
					.create(document.querySelector('#editor'))
					.then(editor => {
						const toolbarContainer = document.querySelector('#toolbar-container');

						toolbarContainer.appendChild(editor.ui.view.toolbar.element);
					})
					.catch(error => {
						console.error(error);
					});
			</script>
		</div>
	</form>
</body>

</html>