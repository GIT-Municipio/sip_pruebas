<?php
require_once('../clases/conexion.php');

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

$_GET["envieitemidarbol"]=1;
if($_GET["envieitemidarbol"]!="")
{
//$_SESSION["guardo_idproyectogen"]=$_GET["envieitemidarbol"];
 $sql = "SELECT  nombre_menu   FROM public.tbl_cat_menucatalogo where idcapageo='".$_GET["envieitemidarbol"]."';";
$resul = pg_query($conn, $sql);
//$_SESSION["guardo_nomproyectogen"]=pg_fetch_result($resul,0,0);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Datos geo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="../dhtmlx51/codebase/fonts/font_roboto/roboto.css"/>
	<link rel="stylesheet" type="text/css" href="../dhtmlx51/codebase/dhtmlx.css"/>
	<script src="../dhtmlx51/codebase/dhtmlx.js"></script>
	<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
		div.gridbox table.obj td {

font-family:Arial;
font-size:11px;
}

		.dhtmlxGrid_selection {
			-moz-opacity: 0.5;
			filter: alpha(opacity = 50);
			background-color:#83abeb;
			opacity:0.5;
		}
		
		div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(../componentes/common/imgs/guardar.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../componentes/common/imgs/cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		
	</style>
	<script>
		var myLayout, myGrid, myForm, myMenuContex, myGridhist;
		
		function doOnLoad() {
			
			////////////inicializando
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				pattern: "3J",
				cells: [{id: "a", text: "Plantillas Disponibles", width: "30%", height: 250   },{id: "b", text: "Visualizar Plantilla", width: 690   },{id: "c", text: "Configuracion de Campos" } ]
	
			});
	
	        
			myLayout.cells("a").attachObject("cabecera_plantillasver");
			
		
			myGrid = new dhtmlXGridObject('gridbox');
			////////////////elemento grid
			myGrid = myLayout.cells("c").attachGrid();
			myGrid.setImagePath("../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID,  NOMBRE_CAMPO, REQUERIDO,ACTIVO");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("80,200,100,100");
			myGrid.setColAlign("center,left,left,left");
			myGrid.setColTypes("dyn,txt,ch,ch");
			myGrid.setColSorting("int,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			//myGrid.enableContextMenu(myMenuContex);
			//myGrid.attachEvent("onRowSelect",doOnRowSelected);
			myGrid.init();
			
			myGrid.enableDragAndDrop(true);
			
			myGrid.load("php/oper_mostrar_elem.php?mitabla=<?php echo "tbli_esq_camposplantilla"; ?>&enviocampos=<?php echo "id,campo_nombre,requerido,activo"; ?>&envcampocondi=<?php echo "ref_plantilla"; ?>&envalorcondi=<?php echo $_GET["mvpr"]; ?>");
			
			myGrid.enableEditEvents(false,true,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo "tbli_esq_camposplantilla"; ?>&enviocampos=<?php echo "id,campo_nombre,requerido,activo"; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida
   			//myDataProcessor.attachEvent("onAfterUpdate",function(){ dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"}); });
	       
			////////////////////EVENTOS DEL GRID
			function doOnRowSelected(id){
				/////ubicar en las coordenadas
				// myLayout.cells("b").attachURL("../zgis_mapsver/verobjetogeo.php?lacapaselecid="+id);
			  }
			
			//////////////////elemnto mapa vista
			myLayout.cells("b").attachURL("../form_plantilla_comprob.php?mvpr=<?php if(isset($_GET["mvpr"])) echo $_GET["mvpr"]; else echo "1"; ?>");
			
		}
	</script>
    <link rel="stylesheet" type="text/css" href="../dhtmlx51/skins/skyblue/dhtmlx.css"/>
</head>
<body onload="doOnLoad();">
<div id="gridbox" style="width: 767px; height:315px; background-color:white;overflow:hidden"></div>	
<div id="cabecera_plantillasver">

<table width="400" border="0" cellpadding="10" cellspacing="10">
  <tr>
    <td><a href="form_grids.php?mvpr=1"><div align="center" style="width:200px; height: 70px; background-color:#F5F5F5; border:1px solid #999;border-radius:8px;box-shadow:0 0 10px #999;"><br/>FICHA DE BIENES INMUEBLES</div></a></td>
    <td><a href="form_grids.php?mvpr=2"><div align="center" style="width:200px; height: 70px; background-color:#F5F5F5; border:1px solid #999;border-radius:8px;box-shadow:0 0 10px #999;"><br/>FICHA DE ESPACIOS PÚBLICOS</div></a></td>
  </tr>
  <tr>
    <td><a href="form_grids.php?mvpr=3"><div align="center" style="width:200px; height: 70px; background-color:#F5F5F5; border:1px solid #999;border-radius:8px;box-shadow:0 0 10px #999;"><br/>FICHA DE CONJUNTOS URBANOS</div></a></td>
    <td><a href="form_grids.php?mvpr=4"><div align="center" style="width:200px; height: 70px; background-color:#F5F5F5; border:1px solid #999;border-radius:8px;box-shadow:0 0 10px #999;"><br/>FICHA DE EQUIPAMIENTO FUNERARIO</div></a></td>
  </tr>
</table>

</div>
</body>
</html>