<?php
require_once('../../clases/conexion.php');
include('phpqrcode/qrlib.php');
session_start();

$sql = "SELECT inst_ruc, inst_nombre, inst_logo, inst_email,  inst_logo_docs, inst_bannersup_docs, inst_bannerinf_docs, inst_fondomarcaguaborr_docs, inst_fondomarcaguaorig_docs, inst_mensaje_slogan_docs FROM public.institucion where inst_ruc='1060000420001';";
$resxpres = pg_query($conn, $sql);
$darmecodgestrdms = pg_fetch_result($resxpres, 0, 0);

$sql = "SELECT *
  FROM public.tbli_esq_plant_formunico_docsinternos where id='" . $_GET["mvpr"] . "'  ;";
$resxpresdocum = pg_query($conn, $sql);

$dargestrdmsfecha = pg_fetch_result($resxpresdocum, 0, 'origen_fecha_creado');
$dargestrdmsbrras = pg_fetch_result($resxpresdocum, 0, 'codi_barras');
$dargestrdmscedul = pg_fetch_result($resxpresdocum, 0, 'origen_cedul');
$dargestrdmsnoms = pg_fetch_result($resxpresdocum, 0, 'origen_nombres');
$dargestrdmsapels = pg_fetch_result($resxpresdocum, 0, 'origen_departament');
$dargestrdmsolicit = pg_fetch_result($resxpresdocum, 0, 'origen_form_asunto');

$dargestrdmscargo = pg_fetch_result($resxpresdocum, 0, 'origen_cargo');


$dargestrdmsolciudomi = pg_fetch_result($resxpresdocum, 0, 'origen_ciud_domicilio');
$dargestrdmsolciutelf = pg_fetch_result($resxpresdocum, 0, 'origen_ciud_telefono');

$dargesolicitfuncnom = pg_fetch_result($resxpresdocum, 0, 'destino_nombres');
$dargesolicitfuncdep = pg_fetch_result($resxpresdocum, 0, 'destino_departament');
/////////////////otros parametros
$varorigen_tipodoc = pg_fetch_result($resxpresdocum, 0, 'origen_tipodoc');
$varorigen_tipo_tramite = pg_fetch_result($resxpresdocum, 0, 'origen_tipo_tramite');
$varimg_respuesta_estado = pg_fetch_result($resxpresdocum, 0, 'img_respuesta_estado');
$varimg_bandera_tatencion = pg_fetch_result($resxpresdocum, 0, 'img_bandera_tatencion');

$varcodigo_documento = pg_fetch_result($resxpresdocum, 0, 'codigo_tramite');
$cod_tramite_tempo = pg_fetch_result($resxpresdocum, 0, 'codigo_documento');
$num_memocreado = pg_fetch_result($resxpresdocum, 0, 'num_memocreado');


///////////////////////consultor ciudadano
$sqlciudadver = "SELECT count(*) FROM public.tbli_esq_plant_formunico_docsinternos where codi_barras='" . $dargestrdmsbrras . "' ;";
$resverciudadanox = pg_query($conn, $sqlciudadver);
$varexisteciud = pg_fetch_result($resverciudadanox, 0, 0);
$varmostrarciudadan = "";
if ($varexisteciud >  1) {
	$sqlciudadverint = "SELECT origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email FROM public.tbli_esq_plant_formunico_docsinternos where codi_barras='" . $dargestrdmsbrras . "';";
	$verciudaencontr = pg_query($conn, $sqlciudadverint);
	$varmostrarciudadan = "Cédula: " . pg_fetch_result($verciudaencontr, 0, 'origen_cedul') . " Nombres: " . pg_fetch_result($verciudaencontr, 0, 'origen_nombres') . " Direccion: " . pg_fetch_result($verciudaencontr, 0, 'origen_ciud_domicilio') . " Telefono: " . pg_fetch_result($verciudaencontr, 0, 'origen_ciud_telefono') . " Email: " . pg_fetch_result($verciudaencontr, 0, 'origen_ciud_email');
}
/////////////////////////////FIN DE CONSULTAR CIUDADANO

/*
$sqlcqr = "SELECT id, campo, descripcion FROM public.tbli_esq_plant_form_configqr where activo=1;";
$resconfigqr = pg_query($conn, $sqlcqr);
$content ="";
for($i=0;$i<pg_num_rows($resconfigqr);$i++)
{
	$content .=  pg_fetch_result($resconfigqr,$i,2).": ".pg_fetch_result($resultcitem,0,pg_fetch_result($resconfigqr,$i,1))."\n";
}
*/

$content = "TRAMITE Nro: " . pg_fetch_result($resxpresdocum, 0, "codi_barras") . "\n CEDULA: " . pg_fetch_result($resxpresdocum, 0, "origen_cedul") . "\n NOMBRES: " . pg_fetch_result($resxpresdocum, 0, "origen_nombres") . "\n TRAMITE: " . pg_fetch_result($resxpresdocum, 0, "origen_tipo_tramite") . "\n DOCUMENTO: " . pg_fetch_result($resxpresdocum, 0, "origen_tipodoc") . "\n DETALLE: " . pg_fetch_result($resxpresdocum, 0, "origen_departament") . "\n ESTADO: " . pg_fetch_result($resxpresdocum, 0, "respuesta_estado");


QRcode::png($content, "../../../sip_bodega/codqr/" . pg_fetch_result($resxpresdocum, 0, "codi_barras") . "_comp_qr.png", QR_ECLEVEL_L, 10, 2);

$verimgqrdado = "../../../sip_bodega/codqr/" . pg_fetch_result($resxpresdocum, 0, "codi_barras") . "_comp_qr.png";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Documento sin título</title>
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
	<script src="../../componentes/codebase/dhtmlx.js"></script>
	<script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		html,
		body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #dce7fa;*/
			/*overflow: hidden;*/
			/*font-family: verdana, arial, helvetica, sans-serif;*/
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;

		}

		#layoutmenusuperderecha {
			background-color: #e7f1ff;
			width: 100%;
			height: 100%;
			font-size: 11px;
		}

		div.tab_docsitems {
			/*color: blue;*/
			background-image: url(imgs/book.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}

		div.tab_docsitemsciu {
			/*color: blue;*/
			background-image: url(imgs/user_add.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}

		div.tab_docsitemsinst {
			/*color: blue;*/
			background-image: url(imgs/btn_institucion.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}

		div.tab_docsitemsform {
			/*color: blue;*/
			background-image: url(imgs/icon_newresolucion.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}

		div.tab_docsitemstree {
			/*color: blue;*/
			background-image: url(imgs/btntreeseg.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	</style>
	<script>
		//carga de informacion
		var myLayout, myTabbar, mygrid;

		function mostrarcodigobarabig() {
			//alert(varplantid);
			var popupgeomap;
			popupgeomap = window.open("vercodqr_zoom.php?mvpr=<?php echo $_GET["mvpr"]; ?>", "mostrafullmetad", "width=220,height=220,scrollbars=no");
			popupgeomap.focus();

		}

		function btn_elimarinfodoc() {
			dhtmlx.confirm({
				title: "Mensaje!",
				type: "confirm-error",
				text: "Confirma que desea Eliminar?",
				callback: function(result) {
					if (result) {
						document.location.href = "crea_eliminar_vista.php?vafil=<?php echo $_GET["mvpr"]; ?>";
					} else
						alert("Se cancelo la Operacion");
				}
			});
		}


		function btn_archivarinfodoc() {
			dhtmlx.confirm({
				title: "Mensaje!",
				type: "confirm-warning",
				text: "Confirma que desea Archivar?",
				callback: function(result) {
					if (result) {
						document.location.href = "crea_archivar_vista.php?vafil=<?php echo $_GET["mvpr"]; ?>";
					} else
						alert("Se cancelo la Operacion");
				}
			});

		}

		function btn_reasignarinfodoc() {
			document.location.href = "../../deparpersonal_reasign.php?vafil=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&varespuestusu=2";
		}

		function btn_informarinfodoc() {
			document.location.href = "../../deparpersonal.php?vafil=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&varespuestusu=3";
		}


		function doOnLoad() {

			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				//parent: "layoutObj",
				pattern: "2E",
				cells: [{
					id: "a",
					text: "Elementos Enviados...",
					height: 80
				}, {
					id: "b",
					text: "Documentos Enviados..."
				}]

			});

			myLayout.cells("a").hideHeader();
			//myLayout.cells("c").hideHeader();	
			//myLayout.cells("b").hideHeader();		
			myLayout.cells("a").attachObject("layoutmenusuperderecha");
			//  myLayout.cells("c").attachURL("arb_principal_codigos.php");
			// myLayout.cells("b").attachObject("layoutinformatext");

			myTabbar = myLayout.cells("b").attachTabbar({
				//parent: "accObj",
				tabs: [{
						id: "a1",
						text: "<div class='tab_docsitems'>-- INFORMACION --</div>",
						active: true
					},
					// {
					// 	id: "a2",
					// 	text: "<div class='tab_docsitemsciu'>-- ANEXOS DEL CIUDADANO  --</div>"
					// },
					{
						id: "a3",
						text: "<div class='tab_docsitemstree'>-- RECORRIDO --</div>"
					},
					{
						id: "a4",
						text: "<div class='tab_docsitemsinst'>-- ANEXOS  --</div>"
					},
					// {
					// 	id: "a6",
					// 	text: "<div class='tab_docsitemsinst'>-- SEGUIMIENTO  --</div>"
					// },
					<?php if ($_GET["vermyplantillx"] != 0) { ?> {
							id: "a5",
							text: "<div class='tab_docsitemsform'>-- FORMULARIO  --</div>"
						},
					<?php } ?>

				]
			});

			myTabbar.tabs("a1").attachObject("layoutinformatext");

			// myTabbar.tabs("a2").attachURL("../mod_docsrecibidos/vistaform_anexos_ciud.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>");

			myTabbar.tabs("a3").attachURL("../mod_docseguimtree/modtreeseguim.php?enviocodid=<?php echo $_GET["mvpr"]; ?>");

			myTabbar.tabs("a4").attachURL("../mod_docsrecibidos/vistaform_anexos_instit.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>");

			myTabbar.tabs("a5").attachURL("../mod_forms/form_tec.php?rp=<?php echo $_GET["vermyplantillx"]; ?>&varclaveuntramusu=<?php echo $_GET["vermicodidtramitx"]; ?>");
			/////////////////////////////////////
			// myTabbar.tabs("a6").attachURL("http://172.16.3.35:4200/tramites");
		}
	</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" onLoad="doOnLoad();">

	<div id="layoutinformatext" style="background-color:#fff">
		<table width="98%" border="0" align="center">

			<tr>
				<td bgcolor="#a6cbf7">
					<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td height="28"><b>ID Tramite</b></td>
							<td bgcolor="#e3e8ec"><strong><h4><?php echo $num_memocreado; ?></h4>&nbsp;</strong></td>
						</tr>
						<tr>
							<td height="28"><b>Codigo Documento</b></td>
							<td bgcolor="#e3e8ec"><?php echo $cod_tramite_tempo; ?>&nbsp;</td>
						</tr>
						<tr>
							<td width="125" height="28"><b>Fecha:</b></td>
							<td width="461" bgcolor="#e3e8ec">Cotacachi, <?php echo $dargestrdmsfecha; ?></td>
						</tr>
						<?php if ($varexisteciud >  1) { ?>
							<tr>
								<td height="28"><b>Ciudadano:</b></td>
								<td bgcolor="#e3e8ec"><?php echo $varmostrarciudadan; ?>&nbsp;</td>
							</tr>
						<?php } ?>

						<tr>
							<td height="28"><b>De:</b></td>
							<td bgcolor="#e3e8ec">Nombre: <?php echo $dargestrdmsnoms; ?> - <?php echo $dargestrdmscargo; ?></td>
						</tr>
						<tr>
							<td height="28"><b>Para:</b></td>
							<td bgcolor="#e3e8ec"><?php echo $dargesolicitfuncnom . ' - ' . $dargesolicitfuncdep; ?>&nbsp;</td>
						</tr>
						<tr>
							<td height="28"><b>Tipo Documento:</b></td>
							<td bgcolor="#e3e8ec"><?php echo $varorigen_tipodoc; ?></td>
						</tr>
						<tr>
							<td height="28"><b>Tipo de Tramite:</b></td>
							<td bgcolor="#e3e8ec"><?php echo $varorigen_tipo_tramite; ?></td>
						</tr>
						<tr>
							<td height="28"><b>Solicitud</b></td>
							<td bgcolor="#e3e8ec"><?php echo $dargestrdmsolicit; ?>&nbsp;</td>
						</tr>
						<tr>
							<td height="28"><b>Estado</b></td>
							<td bgcolor="#e3e8ec">
								<font color="#FF0000"><?php echo pg_fetch_result($resxpresdocum, 0, "respuesta_estado"); ?></font>&nbsp;
							</td>
						</tr>
						<tr>
							<td height="28"><b>Atencion</b></td>
							<td bgcolor="#e3e8ec"><img src="<?php echo $varimg_bandera_tatencion; ?>" width="25" height="25" />&nbsp;</td>
						</tr>

						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br>
		<br>
		<div style="text-align: center;">
		<button type="button" class="btn btn-success" onclick="abrirSeguimiento()">Seguimiento <span class="badge"> new</span></button>
		</div>
	</div>
	<script>
		function abrirSeguimiento() {
			var miPopupmapaobjtabauxgrf;
			miPopupmapaobjtabauxgrf = window.open("http://172.16.3.35:4200/arbol-tramite-sip?tramite=" + <?php echo $_GET["varcodgenerado"]; ?>, "moswinform", "width=950,height=900,scrollbars=no,left=400");
			miPopupmapaobjtabauxgrf.focus();
		}
	</script>
	<div id="layoutmenusuperderecha" style="background-color:#ffffff">
		<table width="100%" border="0">
			<tr>
				<td width="57%" height="85">

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
						<tr>
							<td width="25" height="60" align="center"><img src="imgs/menu_sup/esquinaizquierda.png" width="25" height="51"></td>
							<?php if ($_SESSION['vermientipologusu'] == "1" or $_SESSION['vermientipologusu'] == "2") { ?>
								<td width="66" align="center"><a href="#" onClick="btn_elimarinfodoc()"><img src="imgs/menu_sup/eliminar.gif" width="66" height="51"></a></td>
								<td width="66" align="center"><a href="#" onClick="btn_reasignarinfodoc()"><img src="imgs/menu_sup/reasignar.gif" width="66" height="51"></a></td>
							<?php } ?>
							<td width="66" align="center"><a href="#" onClick="btn_archivarinfodoc()"><img src="imgs/menu_sup/archivar.gif" width="66" height="51"></a></td>
							<td width="66" align="center"><a href="#" onClick="btn_informarinfodoc()"><img src="imgs/menu_sup/informar.gif" width="66" height="51"></a></td>


							<td width="25" align="center"><img src="imgs/menu_sup/esquinaderecha.png" width="25" height="51"></td>
							<td width="437" align="center">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td width="19%" align="center"><a href="#" onClick="mostrarcodigobarabig();"><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0"></a>&nbsp;</td>
				<!-- <td width="24%" align="right"><?php
													require_once('phpbarcode/barcode.inc.php');
													new barCodeGenrator($dargestrdmsbrras, 1, 'barcode.gif', 180, 42, true);
													echo '<img src="barcode.gif" width = "120" height="60" />';
													?></td> -->
			</tr>
		</table>







	</div>

</body>

</html>