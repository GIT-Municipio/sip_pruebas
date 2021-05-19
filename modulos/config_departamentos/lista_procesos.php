<?php

require_once('../../clases/conexion.php');

//if($_GET["envionodoprin"]!="")
//echo $sql = "SELECT  * from tble_proc_proceso where ref_departamento='".$_GET["envionodoprin"]."' ";
//$resul = pg_query($conn, $sql);
//$vareldcodigdepglob=pg_fetch_result($resul,0,"codigo_depengen");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Institucion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
     <script src="php/connector/dhtmlxdataprocessor.js"></script>
      <style>
	  
	  
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #dce7fa;
			overflow: hidden;
			font-family: verdana, arial, helvetica, sans-serif;
           
		}
		
	      div#simpleLog {
			width: 500px;
		/*	height: 300px;*/
			font-family: Tahoma;
			font-size: 11px;
			overflow: auto;
			/*margin-top: 10px;*/
		}
		
		div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(../../componentes/common/imgs/guardar.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../../componentes/common/imgs/cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		
		div#datosfisl{
			height: 500px;
			}
		
	</style>
	<script>
		var myForm, formData, myPop, logObj,mygrid;
		var myIds;
		var dp;
		function doOnLoad() {
			
			
			myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "1C",
	cells: [{id: "a", text: "Lista General de Procesos Asignados",  height: 260   } ]
				
			});
			
	
	menusuptools = myLayout.cells("a").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "xml/barbtns_opcionlay_procesos.xml",
								
			});
			
	menusuptools.setAlign('right');		
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xcrearproces")
			{
				var miPopimpresionxgrf;
	miPopimpresionxgrf = window.open("http://cotacachienlinea.gob.ec/sip/gap/sip.php","mostrarmapawindgrafaux","width=800,height=550,scrollbars=no,left=400");
	miPopimpresionxgrf.focus();
			}
			if(id=="xbtnexcel")
			{
				mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			

	});
	
				
	mygrid = myLayout.cells("a").attachGrid();
	mygrid.setImagePath("../../dhtmlx51/codebase/imgs/");
	mygrid.setHeader("ID,PROCESO,TIEMPO,COSTO,DONDE");
	//mygrid.attachHeader("#text_filter,#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("1,300,100,100,100");
	mygrid.setColAlign("left,left,left,left,left");
	mygrid.setColTypes("txt,txt,txt,txt,txt");
	//mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("int,str,str,str,str");	
	///////////////////////inicio seteo numeros///////////////////////////////
		////////////////////////fin seteo numeros/////////////////////////////////
	mygrid.init();
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",1);
    mygrid.loadXML("php/oper_get_datosgrid_xprocs.php?mitabla=tble_proc_proceso&enviocampos=id,nombre_proceso,tiempo,costo,donde_realizar&envioidepart=<?php echo $_GET["envionodoprin"]; ?>");	
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,true,false);
 
 
   myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=tble_proc_proceso&enviocampos=id,nombre_proceso,tiempo,costo"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida

   myDataProcessor.attachEvent("onAfterUpdate",function(){ 
   
   //dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
    })


			
		}
		
		
		
	</script>
</head>
<body onload="doOnLoad();">
<form id="realForm" method="POST" enctype="multipart/form-data"  >
<table width="415" border="0" align="center">
  <tr>
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
 </form>
 <div id="simpleLog"></div>
</body>
</html>
