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


$idtramite = $_GET["idtramite"];

$sql = "SELECT codigo_documento, num_memocreado, origen_cedul, usuario_cedseguim,origen_nombres, origen_cargo, origen_departament, codigo_tramite
	FROM tbli_esq_plant_formunico_docsinternos 
	where id='" . $idtramite . "'";
$res = pg_query($conn, $sql);
$codigotramite = pg_fetch_result($res, 0, 'codigo_tramite');
$cedularemitente = pg_fetch_result($res, 0, 'usuario_cedseguim');
$cargoremitente = pg_fetch_result($res, 0, 'origen_cargo');
$departamentoremitente = pg_fetch_result($res, 0, 'origen_departament');
$nummemocreado = pg_fetch_result($res, 0, 'num_memocreado');
// echo "<script type='text/javascript'>alert('$cedularemitente');</script>";

$sql = "SELECT id, fecha, fecha_atencion, cod_tramite_tempo, cod_traminterno,codi_barras, 
	codigo_tramite, ciu_cedula, campo_0, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, 
	campo_7, campo_8, campo_9, campo_10, campo_11, campo_12, campo_13 FROM plantillas.plantilla_998
	where cod_traminterno='" . $codigotramite . "'  ;";
$resxpresdocum = pg_query($conn, $sql);
$nombresremitente = pg_fetch_result($resxpresdocum, 0, 'campo_0');
$cargoremitente = pg_fetch_result($resxpresdocum, 0, 'campo_1');
$arearemitente = pg_fetch_result($resxpresdocum, 0, 'campo_2');
$txtcuadroclasificacion = pg_fetch_result($resxpresdocum, 0, 'campo_3');
$correos = '';
$txtdescripcion = pg_fetch_result($resxpresdocum, 0, 'campo_4');
$numerotramite = pg_fetch_result($resxpresdocum, 0, 'codigo_tramite');
$txtcedula = pg_fetch_result($resxpresdocum, 0, 'campo_5');
$txtnombres = pg_fetch_result($resxpresdocum, 0, 'campo_7');
$txtdenominacion = pg_fetch_result($resxpresdocum, 0, 'campo_8');
$fecha = pg_fetch_result($resxpresdocum, 0, 'campo_9');
$txtfecha = pg_fetch_result($resxpresdocum, 0, 'campo_10');
$txttelefono = pg_fetch_result($resxpresdocum, 0, 'campo_11');
$txtcorreo = pg_fetch_result($resxpresdocum, 0, 'campo_12');
$txtobservacion = pg_fetch_result($resxpresdocum, 0, 'campo_13');


/////////////////////////////////////////////

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

	<script type="text/javascript">
		var myLayout, myAcc, myForm, formData, myDataProcessor, mygrid, dhxWinsusus;

		function cerrarventanadoc() {
			sessionStorage.setItem("correosSeleccionados", "");
			window("w1").close();
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

							var form = document.createElement("form");
							form.setAttribute("method", "post");
							form.setAttribute("action", "../mod_forms/form_pubanex_form_externo_planificacion.php?mvpr=999&pontblanexo=anexo_6&varidplanty=998".concat("&tipodocumento=").concat(tipodocumento.value).concat("&usuarioseleccionado=").concat(user.value).concat("&txtcedula=").concat(txtcedula.value).concat("&txtnombres=").concat(txtnombres.value).concat("&txttelefono=").concat(txttelefono.value).concat("&txtcorreo=").concat(txtcorreo.value).concat("&cuadroclasificacion=").concat(cuadrocalsificacion.value).concat("&txtobservacion=").concat(txtobservacion.value));
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
	</style>

</head>

<body onLoad="doOnLoad()">
	<form method="GET" id="formnamedats">
		<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="60%" colspan="2" align="center" background="../../imgs/piepag.png" height="30">
					<input type='button' onClick='parent.close("w1").close();' name='Submit3' value='Cancelar' class="botones" title="Sale de la creación de documentos sin grabar">
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
							<td>
								<font color="#003366">Trámite:</font>
							</td>
							<td width="">
								<input class="form-control" name="txttramite" type="text" maxlength="200" id="txtcedula" style="width: 100%;color:red;font:bold;" placeholder="Campo obligatorio..." required value="<?php echo $nummemocreado ?>" readonly="true">
							</td>

						</tr>
					
						<tr>
							<td width="">
								<font color="#003366">Cuadro de clasificación</font>
							</td>
							<td width="">
								<input class="form-control" name="txtcuadroclasificacion" type="text" maxlength="200" id="txtcuadroclasificacion" style="width: 100%;color:red;font:bold;" placeholder="Campo obligatorio..." required value="<?php echo $txtcuadroclasificacion ?>" readonly="true">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Origen cédula:</font>
							</td>
							<td width="">
								<input name="txtcedula" type="text" maxlength="200" id="txtcedula" style="width: 100%;" placeholder="Campo obligatorio..." value="<?php echo $txtcedula ?>" readonly="true">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Nombres y apellidos/Razón social:</font>
							</td>
							<td width="">
								<input name="txtnombres" type="text" maxlength="200" id="txtnombres" style="width: 100%;" placeholder="Campo obligatorio..." value="<?php echo $txtnombres ?>" readonly="true">
							</td>
						</tr>
						<tr>
						<tr>
							<td>
								<font color="#003366">Teléfono:</font>
							</td>
							<td width="">
								<input name="txttelefono" type="text" maxlength="200" id="txttelefono" style="width: 100%;" placeholder="Campo opcional..." value="<?php echo $txttelefono ?>" readonly="true">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Correo:</font>
							</td>
							<td width="">
								<input name="txtcorreo" type="text" maxlength="200" id="txtcorreo" style="width: 100%;" placeholder="Campo opcional..." value="<?php echo $txtcorreo ?>" readonly="true">
							</td>
						</tr>
						<tr>
							<td>
								<font color="#003366">Observación:</font>
							</td>
							<td><textarea id="txtobservacion" name="txtobservacion" placeholder="Ingrese observación..." cols="90" rows="2" readonly="true"  ><?php echo $txtobservacion ?></textarea></td>
						</tr>
					</table>
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