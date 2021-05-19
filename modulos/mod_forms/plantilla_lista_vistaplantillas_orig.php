<?php

$numerdedatos =0;
$latabla='tbli_esq_plant_form_plantilla';
$latablavista='tbli_esq_plant_form_plantilla';
$elsubcamponombre='nombre_plantilla';    ////campos importantes
////////////////campos para combo principal de agrupacion
$elsubcampoenlace='';
////////////////campos para combos extras
$elsubcampocarg='';
$elsubcampocargnro='';
////////////////campos para combos extras
$elsubcamptipousu='';
$elsubcamptipousunro='';
////////////////campos para combos extras
//$elsubcampusuactiv='data_tipo_activusuarios';
$elsubcampusuactiv='';
//$elsubcampusactivunro='12';
///////////////fin combos

$elidprinorder='id';
//$latabla=$_GET[pontabla];
//////////seleccionar tabla///


require_once('../../clases/conexion.php');

$sql = "SELECT id,nombre_plantilla,fecha_pub from ".$latablavista." order by ".$elidprinorder;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);
$camposver="id,nombre_plantilla,fecha_pub";
////////////////////////fin/////////////
$vectortiposcamps=explode(",",$tipocamposver);
$contarvecamps=count($vectortiposcamps);

$camposver=strtoupper($camposver);

$camposporactualizar="nombre_plantilla";

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    
    <script type="text/javascript">
	
	function abreventanatablagrafaux(pagina)
	{
	var miPopupmapaobjtabauxgrf;
	miPopupmapaobjtabauxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopupmapaobjtabauxgrf.focus();
	}
	
	function abrevenimpresion(pagina)
	{
	var miPopimpresionxgrf;
	miPopimpresionxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopimpresionxgrf.focus();
	}
	
	</script>
    
<style type="text/css">    

		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #dce7fa;
			overflow: hidden;
			font-family: verdana, arial, helvetica, sans-serif;
           
		}
		
		
  a:link { 
    /*color: #FF0000;*/
	color: #036;
    font-family: Arial;
    font-size: 11px;
  }
  a:active { 
    /*color: #0000FF;*/
    font-family: Arial;
    font-size: 11px;
  }
  a:visited { 
   /*color: #800080;*/
    color: #033;
    font-family: Arial;
    font-size: 11px;
  }
  
  

#layoutmenusuperderecha{
	background-color:#e7f1ff;
	width:100%;
	height: 100%;
	font-size: 11px;
	}
	
#layoutmenuizq{
	background-color:#e7f1ff;
	width:100%;
	height: 100%;
	font-size: 11px;
	}
	
	#estilointerbtn{
		font-size: 11px;
		}
</style>
<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData;
	
	function btn_regresarpagprin()
	{
		// myLayout.cells("c").collapse();		
	     //myLayout.cells("b").attachURL("form_data_personal.php?opt=nuevo");
		 parent.document.location.href="../../index.php";
	}
	
	function btn_crearnuevodato()
	{
		// myLayout.cells("c").collapse();		
	     //myLayout.cells("b").attachURL("form_data_personal.php?opt=nuevo");
		 document.location.href="plantilla_crear.php?opt=nuevo";
	}
	
	
function doOnLoad() {
	

	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2U",
	cells: [{id: "a", text: "Menu", width: 310   },{id: "b", text: "Vista Previa de Plantillas"  }]
				
			});
			
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("b").hideHeader();		
	//myLayout.cells("c").collapse();		
	//myLayout.cells("a").attachObject("layoutmenusuperderecha");	
	myLayout.cells("b").attachURL("vista_plantillasprevias.php?varidplanty=<?php echo $_GET['varidplanty']; ?>");
	/*
	myTabbar = myLayout.cells("b").attachTabbar({
				tabs: [
					 { id: "a1", text: "CUADRO DE CLASIFICACION DOCUMENTAL", active: true },
					 { id: "a2", text: "ELEMENTOS ELIMINADOS" }
					 		
				]
			});
			
	//myTabbar.tabs("a2").attachURL("reportes/visor_estadisticas.php?xvarenvist=vista_estad_tipotramites&xvarentipgraf=radar");
	*/
	
	
	mygrid = myLayout.cells("a").attachGrid();
	//mygrid = myTabbar.tabs("a1").attachGrid();
	///////////////////////////////////////////////
	mygrid.setImagePath("../../componentes/codebase/imgs/");
	/*
	mygrid.setHeader("<?php echo $camposver; ?>");
	mygrid.attachHeader("<?php echo $filtrocampos; ?>");
	mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
	mygrid.setColAlign("<?php echo $posicamposver; ?>");
	mygrid.setColTypes("<?php echo $tipocamposver; ?>");
    mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
*/
    mygrid.setHeader("ID,NOMBRE_PLANTILLA,FECHA_PUB");
	mygrid.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("50,200,100");
	mygrid.setColAlign("left,left,left");
	mygrid.setColTypes("dyn,txt,ro");
	mygrid.setColSorting("int,str,str");

	
	mygrid.setSkin("dhx_skyblue");
	
	//mygrid.groupBy(2);  //buscar por este
		
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
	////////////////////////fin seteo numeros/////////////////////////////////
	
	 mygrid.init();
	mygrid.setColumnHidden(0, true);
	
 	/////////////////FIN DE DEPARTAMENTOS
 	
	//  mygrid.expandAllGroups();
     //mygrid.collapseAllGroups();
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",1);
//var combo=mygrid.getColumnCombo(0);
//combo.addOption('TestV1','TestName 1');
	mygrid.attachEvent("onRowSelect",doOnRowSelected);
	function doOnRowSelected(rowId,cellIndex){
		
		var datovalorid=mygrid.cells(rowId,0).getValue();
		//////consultar codigo del procesos
		//var datovalidproces=mygrid.cells(rowId,0).getValue();
		//myLayout.cells("c").expand();		
		
	     //alert(datovalorid);
		/////boton configurar
		myLayout.cells("b").expand();		
		myLayout.cells("b").attachURL("vista_plantillasprevias.php?varidplanty="+datovalorid);
		/*
		if(cellIndex==15)
		{  
		    myLayout.cells("c").expand();		
		    myLayout.cells("c").attachURL("form_actualizo_data.php?valorusuid="+datovalorid+"&varmosrequs=1");
		   
		}
		/////boton eliminar
		if(cellIndex==16)
		{  
		     dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="crea_eliminar_perman.php?vafil="+rowId;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
		}
		*/
	}
	/////para una grilla con grupos e items maneja hasta el 2do nivel para otros niveles tree

	////////////////para pasar a una grilla normal sin grupos
//mygrid.loadXML("php/oper_get_datosusua_activo.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>");	
mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=<?php echo $latablavista; ?>&enviocampos=<?php echo $camposver; ?>",function(){
		//mygrid.groupBy(17);
		//mygrid.collapseAllGroups();    ////agrupar todo
		//mygrid.expandAllGroups();      /////expandir todo
		//mygrid.expandGroup('MULTIPOLYGON');   ///expandir un solo grupo
		//mygrid.collapseGroup('MULTIPOLYGON'); ///colapse un solo grupo
		//////en el caso de requerir  totales utilizar
		//mygrid.groupBy(7,["#stat_max","#title","","#stat_total"]);
	});
	

	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,false,false);
	/*
//============================================================================================
	myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposporactualizar; ?>"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
	*/
//============================================================================================
///////////mensajes de salida

   myDataProcessor.attachEvent("onAfterUpdate",function(){ 
   //dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
    })
  /*
    menusuptools = myLayout.cells("b").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "xml/barbtns_opcionlay.xml",
				
			});
			
	menusuptools.setAlign('right');		
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xdesagrup")
			{
				mygrid.unGroup();
			}
			if(id=="xcargoantes")
			{
				mygrid.groupBy(17);
				mygrid.collapseAllGroups();
				//mygrid.expandGroup('MULTIPOLYGON'); 
			}
			if(id=="xcargo")
			{
				mygrid.groupBy(18);
				mygrid.collapseAllGroups();
				//mygrid.expandGroup('MULTIPOLYGON'); 
			}
			if(id=="xdepart")
			{
				mygrid.groupBy(19);
				mygrid.collapseAllGroups();
				//mygrid.expandGroup('MULTIPOLYGON'); 
			}
			
	});
  */

	}
	
</script>
</head>
<body onLoad="doOnLoad();">
</body>
</html>