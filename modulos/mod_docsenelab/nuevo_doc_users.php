<?php
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Documento sin título</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
	<script src="../../componentes/codebase/dhtmlx.js"></script>
	<script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
	<script>
		var myGrid, myGrid2;

		function cerrarventana() {
			// if(sessionStorage.getItem("correosSeleccionadostemporal")!=null && sessionStorage.getItem("correosSeleccionadostemporal")!='')
			sessionStorage.setItem("correosSeleccionados", sessionStorage.getItem("correosSeleccionados"));
			// sessionStorage.setItem("correosSeleccionadostemporal", '');
			parent.dhxWinsusus.window("wuser1").close();
		}

		function pasar_datos() {
			sessionStorage.setItem("correosSeleccionados", myGrid2.serialize());
			parent.dhxWinsusus.window("wuser1").close();
		}

		function cargar() {
			opener.location.reload();
			window.close();
		}

		function doOnLoad() {
			myGrid = new dhtmlXGridObject('gridbox');
			myGrid.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID, CEDULA, NOMBRES, APELLIDOS, EMAIL, CARGO, DEPENDENCIA, TITULO, DE, PARA, COPIA");
			myGrid.attachHeader("#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,,,");
			myGrid.setInitWidths("1,1,150,150,190,190,160,1,0,100,100");
			myGrid.setColAlign("left,left,left,left,left,left,left,center,center,center,center");
			myGrid.setColTypes("ro,ro,ro,ro,ed,ed,ro,ro,img,img,img");
			myGrid.enableEditEvents(false, false, false);
			myGrid.setColSorting("int,str,str,str,str,str,str,str");
			myGrid.setColumnHidden(6, true);
			myGrid.attachEvent("onRowSelect", doOnRowSelectorigen);

			function doOnRowSelectorigen(rowId, cellIndex) {
				var datovalorid = myGrid.cells(rowId, 0).getValue();
				if (cellIndex == 9) {
					if (myGrid.getSelectedId())
						myGrid2.addRow(rowId, ['', myGrid.cells(rowId, 1).getValue(), myGrid.cells(rowId, 2).getValue(), myGrid.cells(rowId, 3).getValue(), '', myGrid.cells(rowId, 5).getValue(), myGrid.cells(rowId, 6).getValue(), '', 'PARA', '', 'imgs/btn_user_borrar.png'], myGrid.getRowIndex(myGrid.getSelectedId()));
				} else
				if (cellIndex == 10) {
					if (myGrid.getSelectedId())
						myGrid2.addRow(rowId, ['', myGrid.cells(rowId, 1).getValue(), myGrid.cells(rowId, 2).getValue(), myGrid.cells(rowId, 3).getValue(), '', myGrid.cells(rowId, 5).getValue(), myGrid.cells(rowId, 6).getValue(), '', 'COPIA', '', 'imgs/btn_user_borrar.png'], myGrid.getRowIndex(myGrid.getSelectedId()));
				}
			};
			////////////bloqueo de las columnas
			////////////////////////////FINAL//////////////
			myGrid.init();
			myGrid.loadXML("php/oper_get_datospersonal.php?mitabla=tblu_migra_usuarios&enviocampos=ID,usua_cedula,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO,USU_DEPARTAMENTO,usua_abr_titulo,img_btn_de,img_btn_para,img_btn_copia&envcodidepart=", function() {
				myGrid.groupBy(6);
			});

			/////////////////////////////////////////////////////////////
			myGrid2 = new dhtmlXGridObject('gridbox2');
			myGrid2.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid2.setHeader("ID, CEDULA, NOMBRES, APELLIDOS, EMAIL, CARGO, DEPENDENCIA, TITULO, EST, activ_sesionuser,BORRAR");
			myGrid2.setInitWidths("1,1,220,220,1,170,170,1,1,1,100");
			myGrid2.setColAlign("left,left,left,left,left,left,left,center,center,center");
			myGrid2.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,img");
			myGrid2.enableEditEvents(false, false, false);
			myGrid2.setColSorting("int,str,str,str,str,str,str,str");
			// myGrid2.setColumnHidden(5, true);
			myGrid2.attachEvent("onRowSelect", doOnRowSelected);

			function doOnRowSelected(rowId, cellIndex) {
				var datovalorid = myGrid2.cells(rowId, 0).getValue();
				/////boton eliminar

				if (myGrid2.cells(rowId, 8).getValue() != 'DE') {
					if (cellIndex == 10) {
						// dhtmlx.confirm({
						// 	title: "Mensaje!",
						// 	type: "confirm-error",
						// 	text: "Confirma que desea Eliminar?",
						// 	callback: function(result) {
						// 		if (result) {
						// 			if (myGrid2.getSelectedId())
										myGrid2.deleteRow(rowId);
						// 		}
						// 	}
						// });
					}
				} else {
					dhtmlx.alert({
						title: "Mensaje!",
						type: "error",
						text: "No puede eliminar el Remitente.",
					});
				}

			};
			////////////bloqueo de las columnas
			////////////////////////////FINAL//////////////
			myGrid2.init();
			myGrid2.clearAll();

			if (sessionStorage.getItem("correosSeleccionados") == null || sessionStorage.getItem("correosSeleccionados") == '') {
				// myGrid2.loadXML("php/oper_get_datosgrid.php?mitabla=tblu_seleccion_usuarios&enviocampos=ID,usua_cedula,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO,USU_DEPARTAMENTO,usua_abr_titulo,estado_envio_dpc,activ_sesionuser,img_btn_borrar&envcodidepart=", function() {
				// 	myGrid2.filterBy(8, function(data) {
				// 		return data.toString().indexOf("DE") == -1;
				// 	}, true);
				// 	myGrid2.groupBy(8);
				// });
				// alert('1');

				myGrid2.filterBy(8, function(data) {
					return data.toString().indexOf("DE") == -1;
				}, true);
				myGrid2.groupBy(8);
			}
			// } else {
			// myGrid2.reload(true);
			// myGrid2.parse(sessionStorage.getItem("correosSeleccionados"));
			else {
			

				myGrid2.parse(sessionStorage.getItem("correosSeleccionados"));
				myGrid2.filterBy(8, function(data) {
					return data.toString().indexOf("DE") == -1;
				}, true);
				myGrid2.groupBy(8);
			}
			// myGrid2.groupBy(8);
			// 	// alert('2');
			// }
			// myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=tblu_seleccion_usuarios&enviocampos=ID,usua_cedula,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO,USU_DEPARTAMENTO,usua_abr_titulo,estado_envio_dpc,activ_sesionuser"); //lock feed url
			// myDataProcessor.setTransactionMode("POST", true); //set mode as send-all-by-post
			// myDataProcessor.init(myGrid2); //link dataprocessor to the grid
			///////////mensajes de salida
			// myDataProcessor.attachEvent("onAfterUpdate", function(rowId) {
			// 	myGrid2.clearAll();
			// 	// myGrid2.parse(sessionStorage.getItem("correosSeleccionados"));
			// 	if(sessionStorage.getItem("correosSeleccionados")==null || sessionStorage.getItem("correosSeleccionados")=='')
			// 		myGrid2.loadXML("php/oper_get_datosgrid.php?mitabla=tblu_seleccion_usuarios&enviocampos=ID,usua_cedula,USUA_NOMB,USUA_APELLIDO,USUA_EMAIL,USUA_CARGO,USU_DEPARTAMENTO,usua_abr_titulo,estado_envio_dpc,activ_sesionuser,img_btn_borrar&envcodidepart=", function() {

			// 	myGrid2.filterBy(8,function(data){
			// 	 	return   data.toString().indexOf("DE")==-1; 
			// 			},true);
			// 		myGrid2.groupBy(8);
			// 	});
			// 	// sessionStorage.setItem("correosSeleccionadostemporal", sessionStorage.getItem("correosSeleccionados"));
			// })
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
	</style>

</head>

<body onload="doOnLoad()" topmargin="0" leftmargin="0" rightmargin="0">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td background="../../imgs/btnestilo.jpg" align="center">Seleccionar Personal</td>
		</tr>
		<tr>
			<td>
				<div id="gridbox" style="width:100%;height:250px;background-color:white;"></div>
			</td>
		</tr>
		<tr>
			<td background="../../imgs/btnestilo.jpg" align="center">Personal seleccionado para Documento</td>
		</tr>
		<tr>
			<td>
				<div id="gridbox2" style="width:100%;height:190px;background-color:white;"></div>
			</td>
		</tr>
		<tr>
			<td>
				<div style="background-image:url(../../imgs/piepag.png)">
					<form method="get" id="fornulario">
						<table width="100%" border="0" align="center" name='tbl_botones' id='tbl_botones' cellspacing="0" cellpadding="0">
							<tr>
								<td width="25%">&nbsp;</td>
								<td height="30">
									<center><input type='button' value='Aceptar' class="botones_largo" onclick='pasar_datos()' title="Almacena la información en el documento"></center>
								</td>
								<td>
									<center><input type='button' value='Cancelar' class="botones_largo" onclick='cerrarventana()'></center>
								</td>
								<td width="25%">&nbsp;</td>
							</tr>
						</table>
					</form>

				</div>
			</td>
		</tr>
	</table>
</body>

</html>