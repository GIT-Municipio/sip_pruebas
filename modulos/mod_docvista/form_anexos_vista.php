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
$_SESSION["varidtramenvtmp"]=$_GET["mvpr"];
$_SESSION["varcodbarraexped"]=$_GET["varcodgenerado"];

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
			/*background-color: #ebebeb;*/
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
			background-image: url(imgs/acepload.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
			height: 100px;
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../../images/menus//cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		
		#menutopsupervis{
width:100%;background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255));border: 1px solid #a4bed4; height:29px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;text-decoration: none;  	
	}
		
	</style>
	<script>
		var myLayout, myGrid, myForm, myMenuContex, myGridhist;
		
		function doOnLoad() {
			
			////////////inicializando
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				//parent: "layoutObj",
				pattern: "3J",
				cells: [{id: "a", text: "Cargar Documento(s) Escaneados >>> ", width: 410, height: 220   },{id: "b", text: "Visualizar Informacion"   },{id: "c", text: "Visualizar Anexo"   } ]
	
			});
			
			
	myLayout.cells("a").collapse();	
	 
	  
			//////////////elementos
formData = [
  {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 120},
	{type: "fieldset", label: "Anexos: ",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 360, list:[		
					//{type: "newcolumn"},
	
		{type: "template", label: "Imagen", name: "imagenicon",inputWidth: 140, value: ""},
		{type: "upload", name: "myFiles", inputWidth: 310,   offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
]},

	{type:"newcolumn"},
{type: "button", value: ">>>  ACEPTAR <<<", name: "send", offsetLeft: 10,offsetTop: 20,  width: 160,   className: "button_save"}			
			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onUploadComplete",function(count){
				//alert("todo bien");
			    myGrid.loadXML("php/oper_mostrar_elem.php?mitabla=<?php echo "tbli_esq_plant_formunico_anexo"; ?>&enviocampos=<?php echo "id,nombre_anexo,url_anexo,validado,img_respuesta_eliminar"; ?>&envioclientid=<?php echo $_GET["varcodgenerado"]; ?>");
			});
			
			////////////////////eventos boton
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "cancel") 
				{
					document.location.href="lista_data_departamentos.php";
				}
				
				if (id == "send") 
					{
						
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se agregó el archivo correctamente!!",
						    callback: function() {
								
								window.opener.location.reload(true);
								
								window.close();
							
							 }
							});
							
					}
			});
			///////////////////////////////////////////////////////////////////////////////
			//myForm.setSkin("Skyblue");
			
		
			myGrid = new dhtmlXGridObject('gridbox');
			////////////////elemento grid
			myGrid = myLayout.cells("c").attachGrid();
			myGrid.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID, NOMBRE_ARCHIVO, URL_ARCHIVO, CORRECTO, ELIMINAR");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("1,150,100,70,85");
			myGrid.setColAlign("center,left,left,center,left");
			myGrid.setColTypes("dyn,txt,ro,ch,img");
			myGrid.setColSorting("int,str,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			//myGrid.enableContextMenu(myMenuContex);
			myGrid.attachEvent("onRowSelect",doOnRowSelected);
			myGrid.init();
			
			myGrid.loadXML("php/oper_mostrar_elem.php?mitabla=<?php echo "tbli_esq_plant_formunico_anexo"; ?>&enviocampos=<?php echo "id,nombre_anexo,url_anexo,validado,img_respuesta_eliminar"; ?>&envioclientid=<?php echo $_GET["varcodgenerado"]; ?>");
			
			myGrid.enableEditEvents(false,true,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo "tbli_esq_plant_formunico_anexo"; ?>&enviocampos=<?php echo "id,nombre_anexo,url_anexo,validado"; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida
   			//myDataProcessor.attachEvent("onAfterUpdate",function(){ dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"}); });
	       
			////////////////////EVENTOS DEL GRID
			function doOnRowSelected(rowId,cellIndex){
				/////ubicar en las datos
			   var datovaloranex=myGrid.cells(rowId,2).getValue();  
			   var datovalorid=myGrid.cells(rowId,0).getValue();
			     //alert(datovaloranex);
				  myLayout.cells("b").attachURL("../../../sip_bodega/archciuventanilla/"+datovaloranex);
				  
				  if(cellIndex==4)
					{  
		     		dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="opt_acciones/crea_eliminar_anexo_ciud.php?vafil="+datovalorid;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
					}
				  
			  }
			
			//////////////////elemnto mapa vista
		//	myLayout.cells("b").attachURL("../zgis_mapsver/verobjetogeo.php");
			
		}
	</script>
    <link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue_blue/dhtmlx.css"/>
</head>
<body onload="doOnLoad();">

<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>	
</body>
</html>