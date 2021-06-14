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
///////////codigo departamento
if (($_SESSION['sesusuario_usutipo_rol'] == "3") or ($_SESSION['sesusuario_usutipo_rol'] == "2")) {
	$envcodidepartgen = "INGRESO";
} else
	$envcodidepartgen = 'INGRESO';
///////////////////
$latabla = 'tblu_migra_usuarios';
$elidprinorder = 'id';
$elsubcampoenlace = "";
$elsubcampocarg = "";
$elsubcamptipousu = "";
$elsubcampusuactiv = "";
$numerdedatos = "";
$elsubcamponombre = "";
//////////seleccionar tabla///
$sql = "SELECT id, usua_nomb, usua_apellido, usua_email,  usua_cargo,  usua_dependencia,selec_temporadimg,usua_abr_titulo FROM public.tblu_migra_usuarios where usu_activo=1 order by id;";
$res = pg_query($conn, $sql);
$numercampos = pg_num_fields($res);
////////////////////consultar tiempos al cuadro de clasificacion
$sqltextm = "SELECT id,codi_barras,origen_id_tipo_tramite,ref_procesoform,codigo_tramite,
origen_cedul,origen_nombres,origen_cargo,origen_departament, num_memocreado, codigo_documento
FROM public.tbli_esq_plant_formunico_docsinternos where id='" . $_GET["vafil"] . "'  ";
$restxtmem = pg_query($conn, $sqltextm);
$varcodgenerado = pg_fetch_result($restxtmem, 0, 'codi_barras');
$varcodtramite = pg_fetch_result($restxtmem, 0, 'origen_id_tipo_tramite');
$varcodprocesoid = pg_fetch_result($restxtmem, 0, 'ref_procesoform');
$variabtrami = pg_fetch_result($restxtmem, 0, 'id');
$varcodifarchiv = pg_fetch_result($restxtmem, 0, 'codigo_tramite');
$numerotramite = pg_fetch_result($restxtmem, 0, 'num_memocreado');
$cedularemitente = pg_fetch_result($restxtmem, 0, 'origen_cedul');
$nombresremitente =  strtoupper(pg_fetch_result($restxtmem, 0, 'origen_nombres'));
$cargoremitente = strtoupper(pg_fetch_result($restxtmem, 0, 'origen_cargo'));
$departamentoremitente = strtoupper(pg_fetch_result($restxtmem, 0, 'origen_departament'));
$remitentetexto = $nombresremitente . ' - ' . $cargoremitente;
$codigodocumento = pg_fetch_result($restxtmem, 0, 'codigo_documento');

$sql = "SELECT id, usua_cedula, usua_nomb, usua_apellido, usua_email, usua_cargo, usua_dependencia,selec_temporadimg,usua_abr_titulo FROM public.tblu_migra_usuarios where usua_cedula='" . $cedularemitente . "';";
$respuesta = pg_query($conn, $sql);
$idremitente = pg_fetch_result($respuesta, 0, 'id');
$nombreremitente = pg_fetch_result($respuesta, 0, 'usua_nomb');
$apellidoremitente = pg_fetch_result($respuesta, 0, 'usua_apellido');
$emailremitente = pg_fetch_result($respuesta, 0, 'usua_email');
$tituloremitente = pg_fetch_result($respuesta, 0, 'usua_abr_titulo');
////////////////////////////TIEMPOS
$sqlcuadclas = "SELECT id,atencion_tiempo_dias,vigencia_tiempo_dias FROM public.tbli_esq_plant_form_cuadro_clasif where id='" . $varcodtramite . "'";
$rescuadtemps = pg_query($conn, $sqlcuadclas);
$vartiempodiasaten = pg_fetch_result($rescuadtemps, 0, 'atencion_tiempo_dias');
$vartiempodiasvigencia = pg_fetch_result($rescuadtemps, 0, 'vigencia_tiempo_dias');
//////////////////////////

$sql = "SELECT codigo_tramite, campo_7, campo_8
FROM plantillas.plantilla_998 where cod_traminterno='" . $varcodifarchiv . "'  ;";

$resxpresdocum = pg_query($conn, $sql);
$resxpresdocum = pg_query($conn, $sql);
if (pg_num_rows($resxpresdocum) > 0) {
	$nombrepara = pg_fetch_result($resxpresdocum, 0, 'campo_7');
	$denominacionpara = pg_fetch_result($resxpresdocum, 0, 'campo_8');
}

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
////////////////////////fin/////////////
$vectortiposcamps = explode(",", $tipocamposver);
$contarvecamps = count($vectortiposcamps);
$camposver = strtoupper($camposver);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
	<link rel="stylesheet" type="text/css" href="estilo/estil.css" />
	<script src="../../componentes/codebase/dhtmlx.js"></script>
	<script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
	<script src="estilo/event.js"></script>
	<!-- nuevos estilos -->
	<script>
		//carga de informacion
		var myLayout, myAcc, myForm, formData, myDataProcessor, mygrid;
		//////////////////////////////////////////guardar formulario
		function guardarformrespuesta() {
			var comprobclient = document.getElementById("txtcomentarioreasign").value;
			if (comprobclient != "") {
				var fre = document.getElementById('varselecionusuarioenv');
				// if (fre.value == null || fre.value == "") {
				// 	dhtmlx.alert({
				// 		title: "Importante!",
				// 		type: "alert-error",
				// 		text: "Debe Seleccionar el Usuario para Reasignar!!.."
				// 	});
				// } else {
				document.getElementById("formnamedats").submit();
				// }
				////////////////////////////
			} else {
				dhtmlx.alert({
					title: "Mensaje Error!",
					type: "alert-warning", /////puede ser error  warning  solo alert es para normal   
					text: "Es necesario Ingresar un comentario"
				});
			}
		}

		function doOnLoad() {

			myLayout = new dhtmlXLayoutObject({
				parent: "layoutObj",
				pattern: "1C",
				cells: [{
					id: "a",
					text: "Seleccionar Usuario:",
					height: 200
				}]
			});
			mygrid = new dhtmlXGridObject('gridbox');
			mygrid = myLayout.cells("a").attachGrid();
			mygrid.setImagePath("../../componentes/codebase/imgs/");
			mygrid.setHeader("ID,   USUA_NOMB, USUA_APELLIDO, USUA_EMAIL,  USUA_CARGO,  USUA_DEPENDENCIA, SELECCIONAR,usua_abr_titulo");
			mygrid.attachHeader("<?php echo $filtrocampos; ?>");
			mygrid.setInitWidths("5,180,180,200,200,200,90,1");
			mygrid.setColAlign("left,left,left,left,left,left,center,center");
			mygrid.setColTypes("ro,ro,ro,ed,ed,co,img");
			mygrid.setSkin("dhx_skyblue");
			mygrid.enableEditEvents(false, false, false);
			mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
			//////////estilo de columnas
			mygrid.setColumnColor("white,#d5f1ff,#d5f1ff,#d5f1ff,,,#d5f1ff");
			mygrid.setColumnHidden(5, true);
			mygrid.attachEvent("onRowSelect", doOnRowSelected);
			////////////bloqueo de las columnas
			////////////////////////////FINAL//////////////
			mygrid.makeSearch("searchFilter", 3);
			mygrid.init();
			mygrid.loadXML("php/oper_get_datospersonal.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>", function() {
				mygrid.groupBy(5);
			});

			function doOnRowSelected(rowId, cellIndex) {
				var datovalorid = mygrid.cells(rowId, 0).getValue();
				var retornidrad = document.getElementById('varselecionusuarioenv').value;
				if (retornidrad > 0) {
					mygrid.cellById(retornidrad, 6).setValue("imgs/btnselec_rad_false.png");
				}
				mygrid.cellById(rowId, 6).setValue("imgs/btnselec_rad_true.png");
				// alert(mygrid.cells(rowId, 1).getValue());
				document.getElementById('varselecionusuarioenv').value = datovalorid;
				document.getElementById("txtnombres").value = mygrid.cells(rowId, 1).getValue().toUpperCase() + " " + mygrid.cells(rowId, 2).getValue().toUpperCase();
				document.getElementById("txtcargo").value = mygrid.cells(rowId, 4).getValue().toUpperCase();
				document.getElementById("txtdepartamento").value = mygrid.cells(rowId, 5).getValue().toUpperCase();
			}
		}

		function btnacutalizarall() {
			doOnLoad();
		}

		function validateForm() {
			var fre = document.getElementById('varselecionusuarioenv');
			if (fre.value == null || fre.value == "") {
				dhtmlx.alert({
					title: "Importante!",
					type: "alert-error",
					text: "Debe Seleccionar el Usuario para Reasignar!!.."
				});
				return false;
			}
		}

		function respondermemo() {
			var xmlString = "<rows><row>" +
				"<cell>" + "<?php echo $idremitente; ?>" + "</cell>" +
				"<cell>" + "<?php echo $cedularemitente; ?>" + "</cell>" +
				"<cell>" + "<?php echo $nombreremitente; ?>" + "</cell>" +
				"<cell>" + "<?php echo $apellidoremitente; ?>" + "</cell>" +
				"<cell>" + "<?php echo $emailremitente; ?>" + "</cell>" +
				"<cell>" + "<?php echo $cargoremitente; ?>" + "</cell>" +
				// "<cell>"+"<?php echo $departamentoremitente; ?>"+"</cell>"+
				"<cell>" + "<?php echo $tituloremitente; ?>" + "</cell>" +
				"<cell>" + "PARA" + "</cell>" +
				"<cell>" + "<?php echo $cedularemitente; ?>" + "</cell>" +
				"<cell>" + "http://localhost/html/sip_gd/modulos/mod_docsenelab/imgs/btn_user_borrar.png" + "</cell>" +
				"</row></rows>";
			sessionStorage.setItem("correosSeleccionados", xmlString);
			var miPopupmapaobjtabauxgrf;
			miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_doc_oficio.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mvpr=<?php echo $_GET['mvpr']; ?>&idtramite=<?php echo $_GET["vafil"]; ?>&codigotramite=<?php echo $_GET["codigotramite"]; ?>", "moswinform", "width=940,height=600,scrollbars=no,left=400");
			miPopupmapaobjtabauxgrf.focus();
		}

		function cancelar() {
			window.close();
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

		#txtcomentarioreasign {
			resize: none;
		}
	</style>
</head>

<body onLoad="doOnLoad();relojillo()">
	<!-- <div id="layoutObj" style="width:100%;height:260px;overflow:hidden"></div>
	<div id="gridbox" style="width:100%;"></div> -->
	<div id="contenidodelmemo">
		<form action="responder_guardar.php" id="formnamedats" name="formnamedats" method="get" onSubmit="return validateForm();">
			<input type="hidden" id="variabtrami" name="variabtrami" value="<?php if (isset($_GET["vafil"])) echo $_GET["vafil"]; ?>" />
			<input type="hidden" id="varcodgenerado" name="varcodgenerado" value="<?php if (isset($varcodgenerado)) echo $varcodgenerado; ?>" />
			<input type="hidden" id="varcodtramite" name="varcodtramite" value="<?php if (isset($varcodtramite)) echo $varcodtramite; ?>" />
			<input type="hidden" id="varcodprocesoid" name="varcodprocesoid" value="<?php if (isset($varcodprocesoid)) echo $varcodprocesoid; ?>" />
			<input type="hidden" id="varcodifarchiv" name="varcodifarchiv" value="<?php if (isset($varcodifarchiv)) echo $varcodifarchiv; ?>" />
			<input type="hidden" id="varespuestusu" name="varespuestusu" value="2" />
			<input type="hidden" id="varselecionusuarioenv" name="varselecionusuarioenv" />
			</br>
			</br>
			<div align="center">
				<table width="400" border="0">
					<tr>
						<td colspan="2">
							<br>
							<br>
							<br>
							<table width="600" border="0" align="center">
								<tr>
									<td width="400">
										<font color="#0033FF" size="2">Responder a: </font>
									</td>
									<td><input style="width: 350px" name="txtnombres" disabled id="txtnombres" value="<?php echo $nombrepara; ?>"></textarea></td>
								</tr>
								<tr>
									<td width="400">
										<font color="#0033FF" size="2"></font>
									</td>
									<td><input style="width: 350px" name="txtcargo" disabled id="txtcargo" value="<?php echo $denominacionpara; ?>"></textarea></td>
								</tr>
								<br>
								<br>
								<tr>
									<td>
										<font color="#FF0000" size="2">Comentario: </font>
									</td>
									<td><textarea name="txtcomentarioreasign" maxlength="300" cols="50" rows="5" id="txtcomentarioreasign"></textarea></td>
								</tr>
							</table>
						</td>
						<td rowspan="2" valign="top">
							<table width="200" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="display: none">
								<tr>
									<td>
										<table width="200" border="0">
											<tr>
												<td background="images/bagkboton.png">
													<font color="#0033FF" size="2">SELECCIONE ESTADO:</font>
												</td>
											</tr>
											<!-- <tr>
												<td background="imgs/btnopc3.png"><input name="radioopcstado" type="radio" id="btnopcionesresp1" value="EN_RESPUESTA" checked>
													<label for="btnopcionesresp1">
														<font color="#000" size="2">RESPONDER</font>
													</label></td>
											</tr> -->
											<tr>
												<td background="imgs/btnopc1.png"><input type="radio" name="radioopcstado" id="btnopcionesresp4" value="FINALIZADO" checked>
													<label for="btnopcionesresp4">
														<font color="#000" size="2">FINALIZAR</font>
													</label></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			</br>
			</br>
			</br>
			<div align="center">
				<table width="200" border="0" align="center">
					<tr>
						<td>
							<input type="button" style="width: 200px; height: 50px;" class="menulatdivinfer" onClick="respondermemo()" value="RESPONDER CON OFICIO"></td>
						<td><input type="button" style="width: 200px; height: 50px;" class="menulatdivinfer" onClick="guardarformrespuesta()" value="FINALIZAR"></td>
						<td><input type="button" style="width: 200px; height: 50px;" class="menulatdivinfer" onClick="cancelar()" value="CANCELAR"></td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</body>

</html>