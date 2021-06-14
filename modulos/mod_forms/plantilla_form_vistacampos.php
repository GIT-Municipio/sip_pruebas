<?php
require_once('../../clases/conexion.php');

session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
//if(!isset($_GET["varidplatycmps"]))
//$_GET["varidplatycmps"]=1;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Datos geo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
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
				cells: [{id: "a", text: "Campos Disponibles", width: 500   },{id: "b", text: "Visualizar Plantilla"   } ]
	
			});
	
	        
			//myLayout.cells("a").collapse();		
			
		
			
			////////////////elemento grid
			myGrid = myLayout.cells("a").attachGrid();
			myGrid.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID,  NOMBRE_CAMPO,ACTIVO,REQUERIDO,PUBLICO,VISIBLE,ELIMINAR,GRUPO");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("1,150,60,65,60,55,85,1");
			myGrid.setColAlign("center,left,center,center,center,center,left,left");
			myGrid.setColTypes("ro,ed,ch,ch,ch,ch,img,ro");
			myGrid.setColSorting("int,str,str,str,str,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			//myGrid.enableContextMenu(myMenuContex);
			myGrid.attachEvent("onRowSelect",doOnRowSelected);
			myGrid.init();
			//myGrid.setColumnHidden(0, true);
			myGrid.enableDragAndDrop(true);
			
			<?php if(($_GET["varidplatycmps"])!="") {  ?>
			myGrid.loadXML("php/oper_mostrar_elem.php?mitabla=<?php echo "tbli_esq_plant_form_plantilla_campos"; ?>&enviocampos=<?php echo "id,campo_nombre,campo_activo,campo_requerido,publico,visible,img_eliminar,ref_nombregrupo"; ?>&envcampocondi=<?php echo "ref_plantilla"; ?>&envalorcondi=<?php echo $_GET["varidplatycmps"]; ?>",function(){
		myGrid.groupBy(7);

	});
			
			
			myGrid.enableEditEvents(false,true,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo "tbli_esq_plant_form_plantilla_campos"; ?>&enviocampos=<?php echo "id,campo_nombre,campo_activo,campo_requerido,publico,visible"; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
//============================================================================================
<?php } ?>
///////////mensajes de salida
   			myDataProcessor.attachEvent("onAfterUpdate",function(){ 
			myLayout.cells("b").attachURL("form_presenta_plantilla.php?varidplanty=<?php if(isset($_GET["varidplatycmps"])) echo $_GET["varidplatycmps"]; ?>");
			});
	       
			////////////////////EVENTOS DEL GRID
			function doOnRowSelected(rowId,cellIndex){
				
				var datovalorid=myGrid.cells(rowId,0).getValue();
				//alert(datovalorid);
		if(cellIndex==6)
		{  
		     dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="php/elimi_camps_plantill.php?varidplatycmps=<?php echo $_GET["varidplatycmps"]; ?>&vafil="+datovalorid;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
		}
				
				
			  }
			
			//////////////////elemnto mapa vista
			myLayout.cells("b").attachURL("form_presenta_plantilla.php?varidplanty=<?php if(isset($_GET["varidplatycmps"])) echo $_GET["varidplatycmps"]; ?>");
			
		}
	</script>
    <link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue/dhtmlx.css"/>
</head>
<body onload="doOnLoad();">

</body>
</html>