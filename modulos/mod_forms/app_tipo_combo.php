<?php

//$laidaplic='bdd_estadistica_nacional.nacional';
// $laidaplic=$_GET["pontabla"];
//////////seleccionar tabla///
require_once '../../clases/conexion.php';

$latabla = "plantillas." . $_GET["pontabla"];
$sql = "select *from plantillas." . $_GET["pontabla"];
$res = pg_query($conn, $sql);

$numercampos = pg_num_fields($res);
$numerfilas = pg_num_rows($res);

$camposver = "id,item_nom";

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
	<script src="codebase/dhtmlx.js"></script>

    
<style type="text/css">    
html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
  a:link { 
    /*color: #FF0000;*/
	color: #036;
    font-family: Arial;
    font-size: 12px;
  }
  a:active { 
    /*color: #0000FF;*/
    font-family: Arial;
    font-size: 12px;
  }
  a:visited { 
   /*color: #800080;*/
    color: #033;
    font-family: Arial;
    font-size: 12px;
  }
</style>
<script>

	//carga de informacion
	var cargaridselecnado;
	////////////////vista de campos
	
	
	function doOnLoad() {
			
			////////////inicializando
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				pattern: "1C",
				cells: [{id: "a", text: "Tabla"   } ]
	
			});
		
	myLayout.cells("a").hideHeader();		
	///////////////////////////////////
	mygrid = myLayout.cells("a").attachGrid();
	mygrid.setImagePath("codebase/imgs/");
	
	
	mygrid.setHeader("id,ACTUALIZAR ITEMS DEL COMBO:");
	//mygrid.attachHeader("#text_filter,#text_filter");
	mygrid.setInitWidths("100,400");
	mygrid.setColAlign("left,left");
	mygrid.setColTypes("ro,ed");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("str,str");


	
    mygrid.enableSmartRendering(true,50);
	///////////////////////inicio seteo numeros///////////////////////////////
	<?php 
	for($hcont=0;$hcont<count($vectortiposcamps);$hcont++) 
	    {
			if($vectortiposcamps[$hcont]=="edn")
			 {
	            ?> mygrid.setNumberFormat('0,000.00',<?php echo $hcont; ?>,',','.'); <?php
	         }
		}
	?>
	mygrid.setDateFormat("%Y-%m-%d %H:%i");
	////////////////////////fin seteo numeros/////////////////////////////////
	
	////////////////////////MENU CONTEXTUAL
	myMenu = new dhtmlXMenuObject();
	myMenu.setIconsPath("../../componentes/common/imgs/");
	myMenu.renderAsContextMenu();
	myMenu.attachEvent("onClick",onButtonClick);
	myMenu.loadStruct("xml/barbtns_menucontext.xml");
	function onButtonClick(menuitemId,type){
		
		var data = mygrid.contextID.split("_");
		var retdat=data[0];
		//alert(retdat);
		  var miPopupadminmetadatos;
		   if(menuitemId=="addbusq")
		   {
			document.location.href='php/add_nuevoinfo_combo.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
		   }
		   
		   if(menuitemId=="deleteobj")
		   {
			   dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
										document.location.href='php/elim_info_combo.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&retidobj='+retdat+'&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
			  
		   }

			
		}
	
	
	mygrid.enableContextMenu(myMenu);
	////////////////////////////////FIN 
	
	
	
	mygrid.init();
    mygrid.setColumnHidden(0, true);
///////////////////////////fin de paginado

	mygrid.loadXML("php/oper_get_datosgrid_hybridcombo.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>&varclaveuntramusu=0");	//used just
	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,true,false);
//============================================================================================
	myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================

	
///////////mensajes de salida
 menusuptools = myLayout.cells("a").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "xml/barbtns_opcionlay_combo.xml",
				
			});
			
	menusuptools.setAlign('left');		
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			
			if(id=="xbtnnuevoinfo")
			{
				document.location.href='php/add_nuevoinfo_combo.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
			}
			
			
			
			
	});


	}
</script>


</head>
<body  onload="doOnLoad();">
</body>
</html>