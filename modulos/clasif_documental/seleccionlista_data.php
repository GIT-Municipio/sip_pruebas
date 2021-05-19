<?php

$numerdedatos =0;
$latabla='vista_cuadroclasificacion';
$elsubcamponombre='';    ////campos importantes
////////////////campos para combo principal de agrupacion
$elsubcampoenlace='';
$elsubcampoenlacenro='';
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

$sql = "SELECT id, ref_id_proceso, requisitos, gestion, archivo, cod_clase, cod_grupo, detalle, anio_actual from ".$latabla." order by ".$elidprinorder;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

/*
//////////////////////departamentos
$sql = "SELECT id, nombre_departamento from data_departamento_direccion order by id";
$resdepartament = pg_query($conn, $sql);
$numercamposdep=pg_num_fields($resdepartament);

//////////////////////cargos
$sql = "SELECT id, descripcion from data_tipo_personalcargo order by id";
$rescargos = pg_query($conn, $sql);
$numercampcargos=pg_num_fields($rescargos);

//////////////////////tipo usuario
$sql = "SELECT id, descripcion from data_tipo_usuarios order by id";
$restipousu = pg_query($conn, $sql);
$numercamtipousu=pg_num_fields($restipousu);

//////////////////////tipo usuario
$sql = "SELECT id, descripcion from data_tipo_activusuarios order by id";
$restusuactivo = pg_query($conn, $sql);
$numercamusuactivo=pg_num_fields($restusuactivo);

*/
/*
///////retornar configuracion de TABLA
 $sqlgraf = "select id, nombre_tabla,fuente from public.elemento_estadistico where nombre_tab_base='".$latabla."'";
$resgrafxtab = pg_query($conn, $sqlgraf);
 $campoprimariotab=pg_fetch_result($resgrafxtab,0,0);    //id
 $camponombretab=pg_fetch_result($resgrafxtab,0,1);      //nombre
 $campofuentetab=pg_fetch_result($resgrafxtab,0,2);      //fuente
/////////////////////////////////////////
*/

$camposver="";
$tamcamposver="";
$posicamposver="";
$tipocamposver="";
$tipcamposorden="";
$filtrocampos="";
for($col=0;$col<$numercampos;$col++)
{
   if($col<$numercampos-1)
   {
      $camposver.=pg_field_name($res,$col).",";
	  $posicamposver.="left,";
	  if($col==0)
	  {
	   $tamcamposver.="50,";
	   if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
	   $tipocamposver.="co,";
	   else
	   $tipocamposver.="dyn,";
	   $tipcamposorden.="int,";
	   $filtrocampos.="#text_filter,";
	  }
	  else
	  {
		 if($numerdedatos==0)
		 {
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200,";
			else
			$tamcamposver.="100,";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
			   $tipocamposver.="co,";
		    else
		   	   $tipocamposver.="txt,";
			$tipcamposorden.="str,";
			$filtrocampos.="#text_filter,";
		 }
		else
		if(is_numeric(pg_fetch_result($res,0,$col)))
		{
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200,";
			else
			$tamcamposver.="100,";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
			   $tipocamposver.="co,";
		    else
		       $tipocamposver.="edn,";
			$tipcamposorden.="int,";
			$filtrocampos.="#text_filter,";
		}
		else
		 {
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200,";
			else
	    	$tamcamposver.="100,";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
	          $tipocamposver.="co,";
	        else
		    $tipocamposver.="txt,";
			$tipcamposorden.="str,";
			$filtrocampos.="#text_filter,";
		 }
	  }
   }
   else
   {
	   if($numerdedatos==0)
		 {
			 $camposver.=pg_field_name($res,$col);
			 if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200";
			else
	  		$tamcamposver.="100";
	  		$posicamposver.="left";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
	          $tipocamposver.="co";
	        else
	   		$tipocamposver.="txt";
	   		$tipcamposorden.="str";
	   		$filtrocampos.="#text_filter";
		 }
		else
	   if(is_numeric(pg_fetch_result($res,0,$col)))
		{
			$camposver.=pg_field_name($res,$col);
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200";
			else
	  		$tamcamposver.="100";
	  		$posicamposver.="left";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
	          $tipocamposver.="co";
	        else
	   		$tipocamposver.="edn";
	   		$tipcamposorden.="int";
	   		$filtrocampos.="#text_filter";
		}
		else
		 {
      		$camposver.=pg_field_name($res,$col);
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200";
			else
	  		$tamcamposver.="100";
	  		$posicamposver.="left";
	   		$tipocamposver.="txt";
	   		$tipcamposorden.="str";
	   		$filtrocampos.="#text_filter";
		 }
   }
}
////////////////////////fin/////////////
$vectortiposcamps=explode(",",$tipocamposver);
$contarvecamps=count($vectortiposcamps);

$camposver=strtoupper($camposver);

$camposporactualizar="id,ref_id_proceso,gestion,archivo,cod_grupo,detalle,observacion,requisitos,anio_actual";

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
  
  
#menulateraldiv:hover{
background-color:#ecf2ff;
background:linear-gradient(#fffad0,#f3c767);
box-shadow: 3px 3px 10px #000;
border-radius: 10px;
font-family:inherit;
font-size: 10px;
font-weight: bold;
text-transform: none;
width: 70px;
}


#menulateraldiv{
background-color:#ecf2ff;
background:linear-gradient(#c8dbf9,#b2c4de);
box-shadow: 3px 3px 8px #000;
border-radius: 10px;
font-family:inherit;
font-size: 10px;
font-weight: bold;
text-transform: none;
width: 60px;
margin-top: 7px;
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
	var myLayout, myAcc, myForm, formData, mygridseleccion;
	
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
		 document.location.href="form_data.php?opt=nuevo";
	}
	
	
function doOnLoad() {
	

	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "INGRESO NUEVO DOCUMENTO",  height: 170   },{id: "b", text: "CUADRO DE CLASIFICACION DOCUMENTAL"  }]
				
			});
			
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("b").hideHeader();		
	//myLayout.cells("c").collapse();		
	//myLayout.cells("a").attachObject("layoutmenusuperderecha");	
	//myLayout.cells("c").attachURL("modulos/ciudadanos/lista_data_personaltenico.php");
	formData = [
				{type: "settings", position: "label-left", labelWidth: 80, inputWidth: "auto"},
			{type: "fieldset", label: "Nuevo",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 600, list:[
					
					
					{type: "input", label: "Clase",position: "label-right", width: 30, name: "cod_clase", value: "G", required: true },
					{type:"newcolumn"},
					{type: "input", label: "Tipo",position: "label-right", width: 30, name: "cod_tipo", value: "1", required: true, validate: "NotEmpty" },
					{type:"newcolumn"},
					{type: "input", label: "Grupo",position: "label-right", width: 30, name: "cod_grupo", value: "01", required: true, validate: "NotEmpty" },
					{type:"newcolumn"},
					{type: "input", label: "Detalle", width: 260, name: "detalle", value: "", required: true, validate: "NotEmpty" },
					{type:"newcolumn"},			
					{type: "combo", label: "Proceso", name: "ref_id_proceso", value: "", width: 260, filtering: true, connector: "../parametros/options_lista_procesos.php?t=combo" },

{type:"newcolumn"},
		{type: "button", value: ">>>  Guardar <<<", name: "send", offsetLeft: 10,  width: 100, className: "button_save"},			
		
		
				]},
			];
			
		//	myForm = new dhtmlXForm("myForm", formData);
		myForm = myLayout.cells("a").attachForm(formData);
		
		
	myForm.attachEvent("onKeyUp",function(inp,ev,id,value){
				if (id=='detalle') {
					mygridseleccion.getFilterElement(7).value = myForm.getItemValue('detalle');
                    mygridseleccion.filterByAll();  
				}
			});
			
			myForm.attachEvent("onButtonClick", function(id){
				
				
				if (id == "cancel") 
				{
					document.location.href="lista_data.php";
				}
				
				if (id == "send") 
					{
						
						 myForm.send("php/data_nuevo_basic.php", function(loader, response){
						   // alert(response);
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se Registro con exito!!",
						    callback: function() { document.location.href="seleccionlista_data.php?mvpr=<?php echo $_GET["mvpr"];?>"; }
							});
							/////////////////////////////////
					      });
					}
			});
	
	//mygridseleccion.filterBy(7,"con");

	mygridseleccion = new dhtmlXGridObject('gridbox');
	mygridseleccion = myLayout.cells("b").attachGrid();
	mygridseleccion.setImagePath("../../componentes/codebase/imgs/");
	//mygridseleccion.setHeader("<?php echo $camposver; ?>");
	
	
	mygridseleccion.setHeader("ID,REF_ID_PROCESO,REQUISITOS,GESTION,ARCHIVO,CLASE,COD_GRUPO,DETALLE,ANIO_ACTUAL,");



	mygridseleccion.attachHeader(",,,,,#text_filter,#text_filter,#text_filter,");

	//mygridseleccion.attachHeader("<?php echo $filtrocampos; ?>");
	//mygridseleccion.setInitWidths("<?php echo $tamcamposver; ?>");
	mygridseleccion.setColAlign("<?php echo $posicamposver; ?>");
	//mygridseleccion.setColTypes("<?php echo $tipocamposver; ?>");
	
	mygridseleccion.setColAlign("left,left,left,left,left,center,center,left,center,center,center,center");
	mygridseleccion.setInitWidths("100,1,1,1,100,85,85,300,85");
	mygridseleccion.setColTypes("ro,ro,txt,txt,txt,txt,txt,txt,txt");


	mygridseleccion.setSkin("dhx_skyblue");
	mygridseleccion.setColSorting("<?php echo $tipcamposorden; ?>");
	//mygridseleccion.groupBy(2);  //buscar por este
		
	///////////////////////inicio seteo numeros///////////////////////////////
	<?php 
	for($hcont=0;$hcont<count($vectortiposcamps);$hcont++) 
	    {
			if($vectortiposcamps[$hcont]=="edn")
			 {
	            ?> mygridseleccion.setNumberFormat('0,000.00',<?php echo $hcont; ?>,',','.'); <?php
	         }
		}
	?>
	////////////////////////fin seteo numeros/////////////////////////////////
	
	 mygridseleccion.init();
	// mygridseleccion.setColumnHidden(0, true);
	//mygridseleccion.makeSearch("searchFilter",1);

	mygridseleccion.attachEvent("onRowSelect",doOnRowSelected);
	function doOnRowSelected(rowId,cellIndex){
		
		var datovalorid=mygridseleccion.cells(rowId,0).getValue();
		
		var datovalortexto=mygridseleccion.cells(rowId,7).getValue();
		//myLayout.cells("c").expand();		
		
	    //alert(datovalorid);
		// opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
		// opener.parent.mygrid.cellById(<?php echo $_GET["mvpr"];?>, 4).setValue(datovalortexto);
		// opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
		//window.close();
		/////boton configurar
		
		if(cellIndex==9)
		{  
		    
		     
			 opener.parent.mygrid.cellById(<?php echo $_GET["mvpr"];?>, 13).setValue(datovalorid);
			 opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
		     opener.parent.mygrid.cellById(<?php echo $_GET["mvpr"];?>, 4).setValue(datovalortexto);
		     opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
			 window.close();
		}
		else
		{  
		     
			 opener.parent.mygrid.cellById(<?php echo $_GET["mvpr"];?>, 13).setValue(datovalorid);
			 opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
		     opener.parent.mygrid.cellById(<?php echo $_GET["mvpr"];?>, 4).setValue(datovalortexto);
		     opener.parent.myDataProcessor.setUpdated(<?php echo $_GET["mvpr"];?>,true);
			  window.close();
		}
		
		
	}
	/////para una grilla con grupos e items maneja hasta el 2do nivel para otros niveles tree

     ////////////////////////////AGRUPACION DE DATOS///////
	 
	  
	////////////////para pasar a una grilla normal sin grupos
//mygridseleccion.loadXML("php/oper_get_datosusua_activo.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>");	
mygridseleccion.loadXML("php/oper_get_grid_select.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>",function(){
		mygridseleccion.groupBy(3);
		//mygridseleccion.collapseAllGroups();    ////agrupar todo
		//mygridseleccion.expandAllGroups();      /////expandir todo
		//mygridseleccion.expandGroup('MULTIPOLYGON');   ///expandir un solo grupo
		//mygridseleccion.collapseGroup('MULTIPOLYGON'); ///colapse un solo grupo
		//////en el caso de requerir  totales utilizar
		//mygridseleccion.groupBy(7,["#stat_max","#title","","#stat_total"]);
	});
	

	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygridseleccion.enableEditEvents(false,false,false);
	
	
	

	}
	
</script>
</head>
<body onLoad="doOnLoad();">

<div id="gridbox" style="width:600px;height:270px;overflow:hidden"></div>

</body>
</html>