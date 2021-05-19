<?php
require_once('../../clases/conexion.php');

session_start();



?>
<!DOCTYPE html>
<html>
<head>
	<title>Datos geo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/fonts/font_roboto/roboto.css"/>
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/dhtmlx.css"/>
	<script src="../../dhtmlx51/codebase/dhtmlx.js"></script>
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
				pattern: "2U",
				cells: [{id: "a", text: "Grupos Disponibles", width: 500   },{id: "b", text: "Visualizar Plantilla"   } ]
	
			});
	
	        
			
			//myLayout.cells("a").collapse();	
		
			
			////////////////elemento grid
			myGrid = myLayout.cells("a").attachGrid();
			myGrid.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID,  TITULO, ACTIVO, PUBLICO, VER_TITULO,ELIMINAR");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("50,190,65,65,75,85");
			myGrid.setColAlign("center,left,center,center,center,center");
			myGrid.setColTypes("ro,ed,ch,ch,ch,img");
			myGrid.setColSorting("int,str,str,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			//myGrid.enableContextMenu(myMenuContex);
			myGrid.attachEvent("onRowSelect",doOnRowSelected);
			myGrid.init();
			myGrid.setColumnHidden(0, true);
			myGrid.enableDragAndDrop(true);
			
			
			myGrid.load("php/oper_mostrar_elem.php?mitabla=<?php echo "tbli_esq_plant_form_plantilla_grupo"; ?>&enviocampos=<?php echo "id,titulo_grupo,activo,publico,mostrar_titulo,img_eliminar"; ?>&envcampocondi=<?php echo "ref_plantilla"; ?>&envalorcondi=<?php echo $_GET["varidplanty"]; ?>");
			
			myGrid.enableEditEvents(false,true,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo "tbli_esq_plant_form_plantilla_grupo"; ?>&enviocampos=<?php echo "id,titulo_grupo,activo,publico,mostrar_titulo"; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
			
//============================================================================================
///////////mensajes de salida
   			myDataProcessor.attachEvent("onAfterUpdate",function(){ 
			myLayout.cells("b").attachURL("form_presenta_plantilla.php?varidplanty=<?php if(isset($_GET["varidplanty"])) echo $_GET["varidplanty"];  ?>");
			});
	       
			////////////////////EVENTOS DEL GRID
			function doOnRowSelected(rowId,cellIndex){
				/////ubicar en las coordenadas
				// myLayout.cells("b").attachURL("../zgis_mapsver/verobjetogeo.php?lacapaselecid="+id);
				    var datovalorid=myGrid.cells(rowId,0).getValue();
				//alert(datovalorid);
		if(cellIndex==5)
		{  
		     dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="php/elimi_grups_plantill.php?varidplanty=<?php echo $_GET["varidplanty"]; ?>&vafil="+datovalorid;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
		}
		///////////////////FIN ELIMINAR
			  }
			
			//////////////////elemnto mapa vista
			myLayout.cells("b").attachURL("form_presenta_plantilla.php?varidplanty=<?php if(isset($_GET["varidplanty"])) echo $_GET["varidplanty"];  ?>");
			
		}
	</script>
    <link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue/dhtmlx.css"/>
</head>
<body onload="doOnLoad();">
	

</body>
</html>