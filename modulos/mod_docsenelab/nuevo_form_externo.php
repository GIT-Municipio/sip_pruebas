<?php
///////////codigo departamento
$envcodidepartgen = '';
session_start();
require_once('../../clases/conexion.php');
///////////////limìar y crear el usuario de
// $sqlini = "delete from tblu_seleccion_usuarios where activ_sesionuser='" . $_SESSION['sesusuario_cedula'] . "';insert into tblu_seleccion_usuarios(usua_cedula, usua_nomb, usua_apellido, usua_email,  usua_cargo,  usu_departamento,estado_envio_dpc,activ_sesionuser) (SELECT usua_cedula, usua_nomb, usua_apellido, usua_email,  usua_cargo,  usu_departamento,'DE','" . $_SESSION['sesusuario_cedula'] . "' FROM public.tblu_migra_usuarios  where usua_cedula='" . $_SESSION['sesusuario_cedula'] . "' );";
// $resfreini = pg_query($conn, $sqlini);
$latabla = 'tblu_migra_usuarios';
$elidprinorder = 'id';
$elsubcampoenlace = "";
$elsubcampocarg = "";
$elsubcamptipousu = "";
$elsubcampusuactiv = "";
$numerdedatos = "";
$elsubcamponombre = "";
$_SESSION["mvpr"] = "998";
$_SESSION['cedula_destinatario'] = "1002813424";
// $bandera = $_GET['bandera'];
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

$sql = "SELECT id, usua_nomb, usua_apellido, usua_email, usua_cargo, usu_departamento,selec_temporadimg FROM public.tblu_migra_usuarios order by id;";
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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<script src="../../componentes/codebase/dhtmlx.js"></script>
	<script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
	<script src="estilo/event.js"></script>
	<!-- <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script> -->
	<!-- <script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script> -->
	<script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/decoupled-document/ckeditor.js"></script>
	<script src="codebase/dhtmlxgridcell.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

			var d = new Date();
			d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toUTCString();



			var txtcedula = document.getElementById('txtcedula');
			var txtnombres = document.getElementById('txtnombres');
			var tipodocumento = document.getElementById('myidtipodocum');
			var txtobservacion = document.getElementById('txtobservacion').value;
			var txttelefono = document.getElementById('txttelefono');
			var txtcorreo = document.getElementById('txtcorreo');
			var cuadrocalsificacion = document.getElementById('cuadroclasificacion');

			var user = document.getElementById('varselecionusuarioenv');

			if (user.value == null || user.value == "") {
				dhtmlx.alert({
					title: "Importante!",
					type: "alert-error",
					text: "Seleccione un usuario antes de continuar!"
				});
				return false;
			} else if (txtcedula.value == null || txtcedula.value == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese cédula"
				});
			} else if (txtnombres.value == null || txtnombres.value == "") {
				dhtmlx.alert({
					title: "Mensaje!",
					text: "Ingrese nombres"
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
							form.setAttribute("action", "../mod_forms/form_pubanex_form_externo_planificacion.php?mvpr=999&pontblanexo=anexo_6&varidplanty=998".concat("&tipodocumento=").concat(tipodocumento.value).concat("&usuarioseleccionado=").concat(user.value).concat("&txtcedula=").concat(txtcedula.value).concat("&txtnombres=").concat(txtnombres.value).concat("&txttelefono=").concat(txttelefono.value).concat("&txtcorreo=").concat(txtcorreo.value).concat("&cuadroclasificacion=").concat(cuadrocalsificacion.value).concat("&txtobservacion=").concat(txtobservacion));
							form.setAttribute("target", "_self");
							var hiddenField1 = document.createElement("input");
							hiddenField1.setAttribute("type", "hidden");
							form.appendChild(hiddenField1);
							document.body.appendChild(form);
							form.submit();
							parent.window.close();
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

		}
		//////////////////////////////////////////vista previa documento
		function vistapreviadocumento() {

		}

		function pasarValores() {
			document.formnamedats.contenidodelmemo.correos.value = sessionStorage.getItem("correosSeleccionados");
		}

		function doOnLoad() {
			myLayout = new dhtmlXLayoutObject({
				parent: "layoutObj",
				height: 50,
				pattern: "1C",
				cells: [{
					id: "a",
					height: 50,
					text: "Adjuntar anexos...",
				}]
			});

			myTabbar = myLayout.cells("a").attachTabbar({
				tabs: [{
					id: "a1",
					text: "<div class='tab_docsitemsinst'>-- SELECCIONAR USUARIO  --</div>",
					height: 300,
					active: true
				}, {
					id: "a2",

				}]
			});
			myTabbar.tabs("a2").attachURL("vistaform_anexos_instit_memo.php?reasign=true&mvpr=<?php echo $_GET["mvpr"]; ?>&varclaveuntramusu=<?php echo $varclaveunictramitusu ?>&varcodgenerado=<?php echo '100' . $numerotramite ?>&numerotramite=<?php echo $numerotramite ?>");
			mygrid = new dhtmlXGridObject('gridbox');
			mygrid = myTabbar.tabs("a1").attachGrid();
			mygrid.setImagePath("../../componentes/codebase/imgs/");
			mygrid.setHeader("ID,   USUA_NOMB, USUA_APELLIDO, USUA_EMAIL, USUA_CARGO ,  USUA_DEPENDENCIA, SELECCIONAR");
			mygrid.attachHeader("<?php echo $filtrocampos; ?>");
			mygrid.setInitWidths("5,180,180,200,200,200,90");
			mygrid.setColAlign("left,left,left,left,left,left,center");
			mygrid.setColTypes("ro,ro,ro,ed,ed,co,img");
			mygrid.setSkin("dhx_skyblue");
			mygrid.enableEditEvents(false, false, false);
			mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
			mygrid.setColumnColor("white,#d5f1ff,#d5f1ff,#d5f1ff,,,#d5f1ff");
			mygrid.setColumnHidden(5, true);
			mygrid.attachEvent("onRowSelect", doOnRowSelected);
			mygrid.makeSearch("searchFilter", 3);
			mygrid.init();

			mygrid.loadXML("php/oper_get_datospersonal.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>&envcodidepart=<?php echo $envcodidepartgen; ?>", function() {
				mygrid.groupBy(5);
			});

			function doOnRowSelected(rowId, cellIndex) {
				var datovalorid = mygrid.cells(rowId, 0).getValue();
				var retornidrad = document.getElementById('varselecionusuarioenv').value;
				if (retornidrad > 0) {
					mygrid.cellById(retornidrad, 6).setValue("imgs/btnselec_rad_false.png");
				}
				mygrid.cellById(rowId, 6).setValue("imgs/btnselec_rad_true.png");
				document.getElementById('varselecionusuarioenv').value = datovalorid;

			}
		}

		function btnacutalizarall() {
			doOnLoad();
		}

		function abrirFichaTec() {
			var cuadrocalsificacion = document.getElementById('cuadroclasificacion').value;
			var popupgeomapfich;
			popupgeomapfich = window.open("requisitos_tramites.php?mvpr=" + cuadrocalsificacion, "mostrarfich", "width=600,height=500,scrollbars=no");
			popupgeomapfich.focus();
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
			margin-left: 0px;
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


		/* Dropdown Button */
		.dropbtn {
			background-color: #4CAF50;
			color: white;
			padding: 16px;
			font-size: 16px;
			border: none;
			cursor: pointer;
		}

		/* Dropdown button on hover & focus */
		.dropbtn:hover,
		.dropbtn:focus {
			background-color: #3e8e41;
		}

		/* The search field */
		#myInput {
			box-sizing: border-box;
			background-image: url('searchicon.png');
			background-position: 14px 12px;
			background-repeat: no-repeat;
			font-size: 16px;
			padding: 14px 20px 12px 45px;
			border: none;
			border-bottom: 1px solid #ddd;
		}

		/* The search field when it gets focus/clicked on */
		#myInput:focus {
			outline: 3px solid #ddd;
		}

		/* The container <div> - needed to position the dropdown content */
		.dropdown {
			position: relative;
			display: inline-block;
		}

		/* Dropdown Content (Hidden by Default) */
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f6f6f6;
			min-width: 230px;
			border: 1px solid #ddd;
			z-index: 1;
		}

		/* Links inside the dropdown */
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}

		/* Change color of dropdown links on hover */
		.dropdown-content a:hover {
			background-color: #f1f1f1
		}

		/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
		.show {
			display: block;
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
					<!-- <input type="button" name="btn_usuarios" id="btn_usuarios" value="Buscar Destinatarios" class="botones_largo" title="Buscar por nombre o cédula, al Remitente, Destinatarios del Documento, y/o Con copia a" onClick="SeleccUsuario();">&nbsp;&nbsp; -->
					<input type="button" name='Aceptar' class="botones" title="Graba el documento y pasa a la página de consulta del documento" value="Enviar" onclick="guardarformrespuesta()">&nbsp;&nbsp;
					<!-- <input type="button" name='Guardar' class="botones_largo" title="Guarda un borrador del documento actual" value="Guardar borrador" onclick="guardarBorrador();">&nbsp;&nbsp; -->
					<input type='button' onClick='cerrarventanadoc()' name='Submit3' value='Cancelar' class="botones" title="Sale de la creación de documentos sin grabar">
					<!-- <input type='button' onClick='vistapreviadocumento()' name='vista' value='Vista previa' class="botones" title="Vista previa del documento"> -->
				</td>
			</tr>
			<?php
			?>
		</table>
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
							<td width="308">
								<select name="myidtipodocum" id="myidtipodocum" style="background-color:#FF9; width: 300px; display:none;">
									<?php
									$sqltipdoc = "SELECT id, tipo as documento  FROM public.tbli_esq_plant_formunico_tipodoc where id=4 and est_eliminado=0  order by id";
									$restipdoc = pg_query($conn, $sqltipdoc);
									for ($i = 0; $i < pg_num_rows($restipdoc); $i++) {
										echo '<option value="' . pg_fetch_result($restipdoc, $i, 'id') . '">' . pg_fetch_result($restipdoc, $i, 'documento') . '</option>';
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
						</tr>
						<tr>
							<td width=""> 
								<font color="#003366">Cuadro de clasificación</font>
							</td>
							<td width="">
								<select name="cuadroclasificacion" id="cuadroclasificacion" style="background-color:#FF9; width: 500px" onkeyup="filterFunction()">
									<?php
									$sqltipdoc = "SELECT id, nombre_tramite as detalle  FROM vista_plantillas_xclasifproc_externos order by detalle";
									$restipdoc = pg_query($conn, $sqltipdoc);
									for ($i = 0; $i < pg_num_rows($restipdoc); $i++) {
										echo '<option value="' . pg_fetch_result($restipdoc, $i, 'id') . '">' . pg_fetch_result($restipdoc, $i, 'detalle') . '</option>';
									}
									
									?>
								</select></td>
							<td>
								<button onclick="javascript:abrirFichaTec();" class="fa fa-search" type="button">Requisitos</button>
							</td>
						</tr>

						<tr>
							<td>
								<font color="#003366">Origen cédula:</font>
							</td>
							<td width="">
								<input name="txtcedula" type="text" maxlength="200" id="txtcedula" style="width: 100%;" placeholder="Campo obligatorio..." required>
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Nombres y apellidos/Razón social:</font>
							</td>
							<td width="">
								<input name="txtnombres" type="text" maxlength="200" id="txtnombres" style="width: 100%;" placeholder="Campo obligatorio..." required>
							</td>
						</tr>
						<tr>
						<tr>
							<td>
								<font color="#003366">Teléfono:</font>
							</td>
							<td width="">
								<input name="txttelefono" type="text" maxlength="200" id="txttelefono" style="width: 100%;" placeholder="Campo opcional...">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Correo:</font>
							</td>
							<td width="">
								<input name="txtcorreo" type="text" maxlength="200" id="txtcorreo" style="width: 100%;" placeholder="Campo opcional...">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Observación:</font>
							</td>
							<td><textarea id="txtobservacion" name="txtobservacion" placeholder="Ingrese observación..." cols="65" rows="2"></textarea></td>
						</tr>
					</table>

					<div id="layoutObj" style="width:100%;height:350px;overflow:hidden"></div>
					<div id="gridbox" style="width:100%;"></div>
				</div>
			</div>

			<script>
				function myFunction() {
					document.getElementById("myDropdown").classList.toggle("show");
				}

				function filterFunction() {
					var input, filter, ul, li, a, i;
					input = document.getElementById("myInput");
					filter = input.value.toUpperCase();
					div = document.getElementById("myDropdown");
					a = div.getElementsByTagName("detalle");
					for (i = 0; i < a.length; i++) {
						txtValue = a[i].textContent || a[i].innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1) {
							a[i].style.display = "";
						} else {
							a[i].style.display = "none";
						}
					}
				}
			</script>

		</div>
	</form>
</body>

</html>