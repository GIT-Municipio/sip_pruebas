<?php
require_once('../../conexion.php');
//////////CANTIDAD DE DOCUMENTOS AL DIA
$sql = "SELECT count(*) FROM public.tbl_archivos_scanimgs where est_eliminado=0 and date(fecha)=date(now())";
$resul = pg_query($conn, $sql);
$totalaldia=pg_fetch_result($resul,0,0);
//////////CANTIDAD DE DOCUMENTOS AL MES
$sql = "SELECT count(*) FROM public.tbl_archivos_scanimgs where est_eliminado=0 and date_part('month',fecha) = date_part('month', now())";
$resul = pg_query($conn, $sql);
$totalalmes=pg_fetch_result($resul,0,0);
//////////CANTIDAD DE DOCUMENTOS AL DIA
$sql = "select count(*) AS total_archivos from  tbl_archivos_procesados proc, tbl_archivos_scanimgs img,data_departamento_direccion dep where proc.id=img.ref_archprocesados and proc.param_departamento=dep.id and proc.est_eliminado=0 AND img.est_eliminado = 0;";
$resul = pg_query($conn, $sql);
$totalalgeneral=pg_fetch_result($resul,0,0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>

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
		
    .estilolog {
		background-image:url(imgs/fondolog.png);
	}

div.tab_portafolio {
			/*color: red;*/
			color: blue;
			background-image:url(imgs/icon_portafolio.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_reportes {
			color: blue;
			background-image:url(imgs/tag_orange.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}



div.tab_recibidos {
			/*color: blue;*/
			background-image:url(imgs/icon_recibidos.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_nuevos {
			/*color: blue;*/
			background-image:url(imgs/icon_nuevodoc.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enedicion {
			/*color: blue;*/
			background-image:url(imgs/icon_enedicion.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enviados {
			/*color: blue;*/
			background-image:url(imgs/icon_enviados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_reasignados {
			/*color: blue;*/
			background-image:url(imgs/icon_reasignados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_informados {
			/*color: blue;*/
			background-image:url(imgs/icon_informados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_archivados {
			/*color: blue;*/
			background-image:url(imgs/icon_archivado.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_eliminados {
			/*color: blue;*/
			background-image:url(imgs/icon_elimmsj.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_perspermisos {
			/*color: blue;*/
			background-image:url(imgs/permisosusu.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
		
div.tab_estadist {
			/*color: blue;*/
			background-image:url(imgs/acepload.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}		

    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar,mygrid_itemd;
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "4T",
	cells: [
	         {id: "a", text: "Datos", height: 150 },{id: "b", text: "Reporte por Categorias" },{id: "c", text: "Reporte por Departamento"},{id: "d", text: "Reporte por Usuario"}
		   ] 
    });
	
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("a").collapse();
	myLayout.cells("a").attachObject("reportetotalesbase");
	
	myTabbar = myLayout.cells("b").attachTabbar({
				tabs: [
					 { id: "a1", text: "POR CATEGORIA", active: true },
					 { id: "a2", text: "POR BODEGA" },
					 { id: "a3", text: "POR ESTANTERIA" },
					 { id: "a4", text: "POR NIVEL" },		
					 { id: "a5", text: "POR TRAMITE" },		
				]
			});
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itema1 = myTabbar.tabs("a1").attachGrid();
	mygrid_itema1.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itema1.setHeader("ID,CATEGORIA,VALOR");
   // mygrid_itema1.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itema1.setInitWidths("50,250,100");
	mygrid_itema1.setColAlign("left,left,left");
	mygrid_itema1.setColTypes("dyn,txt,txt");
    mygrid_itema1.setSkin("dhx_skyblue");
	mygrid_itema1.setColSorting("int,str,str");
    mygrid_itema1.init();
	mygrid_itema1.setColumnHidden(0, true);
    mygrid_itema1.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_categoria&enviocampos=id,categoria,total_archivos");	

	menuexportgrid_itema1 = myTabbar.tabs("a1").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml",
				onload: function() {
					calendarInput = menuexportgrid_itema1.getInput("xbtnfecha");
		     		myCalendar = new dhtmlXCalendarObject(calendarInput);
					myCalendar.setDateFormat("%Y-%m-%d");
					menuexportgrid_itema1.setValue("xbtnfecha", myCalendar.getFormatedDate());
					myCalendar.attachEvent("onClick", function(date){
						//menuexportgrid_itemc.setValue("xbtnfecha", myCalendar.getFormatedDate(null,date));
						var selfechainfo=myCalendar.getFormatedDate(null,date);
  				        //alert(selfechainfo);
						  mygrid_itema1.clearAll();
						  mygrid_itema1.loadXML("php/oper_get_datos_xfecha_xcat.php?mitabla=vista_estad_totalarch_categoria&enviocampos=id,categoria,total_archivos&enviofechacons="+selfechainfo);
						
						});
				}
			});
	menuexportgrid_itema1.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itema1.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itema1.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itema1.clearAll();
				mygrid_itema1.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_categoria&enviocampos=id,categoria,total_archivos");		
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itema1.clearAll();
				mygrid_itema1.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_categoria&enviocampos=id,categoria,total_archivos");		
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itema2 = myTabbar.tabs("a2").attachGrid();
	mygrid_itema2.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itema2.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itema2.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itema2.setInitWidths("50,250,100");
	mygrid_itema2.setColAlign("left,left,left");
	mygrid_itema2.setColTypes("dyn,txt,txt");
    mygrid_itema2.setSkin("dhx_skyblue");
	mygrid_itema2.setColSorting("int,str,str");
    mygrid_itema2.init();
	mygrid_itema2.setColumnHidden(0, true);
    mygrid_itema2.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_bodega&enviocampos=id,nombre,total_archivos");	

	menuexportgrid_itema2 = myTabbar.tabs("a2").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml"
			});
	menuexportgrid_itema2.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itema2.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itema2.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itema2.clearAll();
				mygrid_itema2.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_bodega&enviocampos=id,nombre,total_archivos");		
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itema2.clearAll();
				mygrid_itema2.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_bodega&enviocampos=id,nombre,total_archivos");		
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itema3 = myTabbar.tabs("a3").attachGrid();
	mygrid_itema3.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itema3.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itema3.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itema3.setInitWidths("50,250,100");
	mygrid_itema3.setColAlign("left,left,left");
	mygrid_itema3.setColTypes("dyn,txt,txt");
    mygrid_itema3.setSkin("dhx_skyblue");
	mygrid_itema3.setColSorting("int,str,str");
    mygrid_itema3.init();
	mygrid_itema3.setColumnHidden(0, true);
    mygrid_itema3.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_estanteria&enviocampos=id,nombre,total_archivos");	

	menuexportgrid_itema3 = myTabbar.tabs("a3").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml"
			});
	menuexportgrid_itema3.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itema3.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itema3.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itema3.clearAll();
				mygrid_itema3.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_estanteria&enviocampos=id,nombre,total_archivos");		
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itema3.clearAll();
				mygrid_itema3.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_estanteria&enviocampos=id,nombre,total_archivos");		
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itema4 = myTabbar.tabs("a4").attachGrid();
	mygrid_itema4.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itema4.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itema4.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itema4.setInitWidths("50,250,100");
	mygrid_itema4.setColAlign("left,left,left");
	mygrid_itema4.setColTypes("dyn,txt,txt");
    mygrid_itema4.setSkin("dhx_skyblue");
	mygrid_itema4.setColSorting("int,str,str");
    mygrid_itema4.init();
	mygrid_itema4.setColumnHidden(0, true);
    mygrid_itema4.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_nivel&enviocampos=id,nombre,total_archivos");	

	menuexportgrid_itema4 = myTabbar.tabs("a4").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml"
			});
	menuexportgrid_itema4.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itema4.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itema4.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itema4.clearAll();
				mygrid_itema4.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_nivel&enviocampos=id,nombre,total_archivos");			
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itema4.clearAll();
				mygrid_itema4.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_nivel&enviocampos=id,nombre,total_archivos");			
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itema5 = myTabbar.tabs("a5").attachGrid();
	mygrid_itema5.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itema5.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itema5.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itema5.setInitWidths("50,250,100");
	mygrid_itema5.setColAlign("left,left,left");
	mygrid_itema5.setColTypes("dyn,txt,txt");
    mygrid_itema5.setSkin("dhx_skyblue");
	mygrid_itema5.setColSorting("int,str,str");
    mygrid_itema5.init();
	mygrid_itema5.setColumnHidden(0, true);
    mygrid_itema5.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_documento&enviocampos=id,nombre,total_archivos");	

	menuexportgrid_itema5 = myTabbar.tabs("a5").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml"
			});
	menuexportgrid_itema5.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itema5.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itema5.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itema5.clearAll();
				mygrid_itema5.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_documento&enviocampos=id,nombre,total_archivos");				
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itema5.clearAll();
				mygrid_itema5.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_documento&enviocampos=id,nombre,total_archivos");				
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itemc = myLayout.cells("c").attachGrid();
	mygrid_itemc.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itemc.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itemc.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itemc.setInitWidths("50,250,100");
	mygrid_itemc.setColAlign("left,left,left");
	mygrid_itemc.setColTypes("dyn,txt,txt");
    mygrid_itemc.setSkin("dhx_skyblue");
	mygrid_itemc.setColSorting("int,str,str");
    mygrid_itemc.init();
	mygrid_itemc.setColumnHidden(0, true);
    mygrid_itemc.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_depar&enviocampos=id,nombre_departamento,total_archivos");	

	menuexportgrid_itemc = myLayout.cells("c").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml",
				onload: function() {
					calendarInput = menuexportgrid_itemc.getInput("xbtnfecha");
		     		myCalendar = new dhtmlXCalendarObject(calendarInput);
					myCalendar.setDateFormat("%Y-%m-%d");
					menuexportgrid_itemc.setValue("xbtnfecha", myCalendar.getFormatedDate());
					myCalendar.attachEvent("onClick", function(date){
						//menuexportgrid_itemc.setValue("xbtnfecha", myCalendar.getFormatedDate(null,date));
						var selfechainfo=myCalendar.getFormatedDate(null,date);
  				       // alert(selfechainfo);
						 mygrid_itemc.clearAll();
						 mygrid_itemc.loadXML("php/oper_get_datos_xfecha_xdep.php?enviofechacons=vista_estad_totalarch_depar&enviocampos=id,nombre_departamento,total_archivos&enviofechacons="+selfechainfo);
						
						});
				}
			});
	menuexportgrid_itemc.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itemc.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itemc.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itemc.clearAll();
				mygrid_itemc.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_depar&enviocampos=id,nombre_departamento,total_archivos");	
	
			}
			if(id=="xbtndiario")
			{
				mygrid_itemc.clearAll();
				mygrid_itemc.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_depar&enviocampos=id,nombre_departamento,total_archivos");	
	
			}
	});
	//////////////////////////////////////////////////////////////////////
	
	
	//////////////////////////GRID REPORTE/////////////////////////////
	mygrid_itemd = myLayout.cells("d").attachGrid();
	mygrid_itemd.setImagePath("../../componentes/codebase/imgs/");
    mygrid_itemd.setHeader("ID,DESCRIPCION,VALOR");
   // mygrid_itemd.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid_itemd.setInitWidths("50,250,100");
	mygrid_itemd.setColAlign("left,left,left");
	mygrid_itemd.setColTypes("dyn,txt,txt");
    mygrid_itemd.setSkin("dhx_skyblue");
	mygrid_itemd.setColSorting("int,str,str");
    mygrid_itemd.init();
	mygrid_itemd.setColumnHidden(0, true);
    mygrid_itemd.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_xusuarios&enviocampos=id,usuario,total_archivos");	

	menuexportgrid_itemd = myLayout.cells("d").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "../../componentes/common/barbtns_opcionlay.xml",
				onload: function() {
					calendarInput = menuexportgrid_itemd.getInput("xbtnfecha");
		     		myCalendar = new dhtmlXCalendarObject(calendarInput);
					myCalendar.setDateFormat("%Y-%m-%d");
					menuexportgrid_itemd.setValue("xbtnfecha", myCalendar.getFormatedDate());
					myCalendar.attachEvent("onClick", function(date){
						//menuexportgrid_itemc.setValue("xbtnfecha", myCalendar.getFormatedDate(null,date));
						var selfechainfo=myCalendar.getFormatedDate(null,date);
  				        //alert(selfechainfo);
						 mygrid_itemd.clearAll();
						 mygrid_itemd.loadXML("php/oper_get_datos_xfecha_xus.php?enviofechacons=vista_estad_totalarch_xusuarios&enviocampos=id,usuario,total_archivos&enviofechacons="+selfechainfo);
						
						});
				}
			});
	menuexportgrid_itemd.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid_itemd.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid_itemd.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			if(id=="xbtntotal")
			{
				mygrid_itemd.clearAll();
				mygrid_itemd.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_totalarch_xusuarios&enviocampos=id,usuario,total_archivos");	
			}
			if(id=="xbtndiario")
			{
				mygrid_itemd.clearAll();
				mygrid_itemd.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_diarioarch_xusuarios&enviocampos=id,usuario,total_archivos");	
			}
	});
	//////////////////////////////////////////////////////////////////////
  ///////////fin metodo onload()
	}
	
</script>
</head>
<body onLoad="doOnLoad();">

<div id="reportetotalesbase">
<table width="436" border="0">
  <tr>
    <td width="246"><font color="#FF0000">Total Documentos Dia Actual</font></td>
    <td width="174"><font color="#FF0000"><?php  echo $totalaldia; ?></font></td>
  </tr>
  <tr>
    <td><font color="#006633">Total Documentos Mes Actual</font></td>
    <td><font color="#006633"><?php  echo $totalalmes; ?></font></td>
  </tr>
  <tr>
    <td><font color="#003366">Total Documentos General</font></td>
    <td><font color="#003366"><?php  echo $totalalgeneral; ?></font></td>
  </tr>
</table>


</div>

</body>
</html>
