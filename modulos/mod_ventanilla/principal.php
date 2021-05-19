<?php


require_once('../../clases/conexion.php');
session_start();

$_SESSION["configmodusesion"]="openmod_ventanilla";

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




$sql = "SELECT id,gestion,detalle,cod_clase,cod_grupo,ref_id_proceso,requisitos from ".$latabla." order by ".$elidprinorder;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);


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



?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
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
	pattern: "3J",
	cells: [{id: "a", text: "CUADRO DE CLASIFICACION DOCUMENTAL",  width: 400, height: 160   },{id: "b", text: "PARAMETROS USUARIO"  },{id: "c", text: ".."  }]
				
			});
			
	
	myLayout.cells("b").hideHeader();
	myLayout.cells("c").hideHeader();
	//myLayout.cells("b").hideHeader();	
	<?php /// if($_SESSION['sesusuario_usutipo_rol']==3) { ?>
	<?php if(($_SESSION['sesusuario_usu_ventanilla']==1) or ($_SESSION['sesusuario_asisdepart']==1)) { ?>
	myLayout.cells("a").expand();	
	myLayout.cells("c").expand();	
	<?php } else { ?>
	myLayout.cells("a").collapse();
	<?php } ?>
	//myLayout.cells("c").collapse();		
	//myLayout.cells("a").attachObject("layoutmenusuperderecha");	
	myLayout.cells("b").attachURL("mostrar_panel.php");
	//////////////////////////
	formData = [
				{type: "settings", position: "label-left", labelWidth: 120, inputWidth: "auto"},
			{type: "fieldset", label: "Busqueda",  offsetLeft: 4, offsetRight: 0, offsetTop: 0, inputWidth: 390, list:[
					
	
					{type: "combo", label: "Documento Entrada", name: "ref_tipodocum",  width: 200,  connector: "../parametros/options_lista_tipodoc.php?t=combo" },
					
					{type: "combo", label: "Buscar por Clase:", name: "ref_tipoclase",  width: 200,  connector: "../parametros/options_lista_clases.php?t=combo" },
					
					{type: "input", label: "Buscar por Codigo:", width: 200, name: "ref_codigo" },

	
		
				]},
			];
			
		myForm = myLayout.cells("a").attachForm(formData);
		
		myForm.attachEvent("onChange", function(name,value,is_checked){
			    if(name=='ref_tipoclase')
				{
					mygridseleccion.getFilterElement(3).value = value;
                    mygridseleccion.filterByAll(); 
				}
				//alert("onChange, item name '"+name+"', value '"+value+"', is checked '"+(is_checked?"true":"false")+"'<br>");
			});
		myForm.attachEvent("onKeyUp",function(inp,ev,id,value){
				if (id=='ref_codigo') {
					mygridseleccion.getFilterElement(4).value = myForm.getItemValue('ref_codigo');
                    mygridseleccion.filterByAll();  
				}
			});
		////////////////////////////////////////////////////////////////////////////////
	

	
	mygridseleccion = myLayout.cells("c").attachGrid();
	mygridseleccion.setImagePath("../../componentes/codebase/imgs/");
	//mygridseleccion.setHeader("<?php echo $camposver; ?>");
	
	
	mygridseleccion.setHeader("ID,GESTION,DETALLE,CLASE,GRUPO,PROCESO,REQUISITOS");



	mygridseleccion.attachHeader(",,#text_filter,#text_filter,#text_filter,#text_filter,");

	//mygridseleccion.attachHeader("<?php echo $filtrocampos; ?>");
	//mygridseleccion.setInitWidths("<?php echo $tamcamposver; ?>");
	mygridseleccion.setColAlign("<?php echo $posicamposver; ?>");
	//mygridseleccion.setColTypes("<?php echo $tipocamposver; ?>");
	
	mygridseleccion.setColAlign("left,left,left,left,left,left,left");
	mygridseleccion.setInitWidths("20,20,400,70,70,70,70");
	mygridseleccion.setColTypes("ro,ro,txt,txt,txt,txt,ed");


	
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
	mygridseleccion.setColumnHidden(0, true);
	mygridseleccion.setColumnHidden(1, true);
	//mygridseleccion.makeSearch("searchFilter",1);

	mygridseleccion.attachEvent("onRowSelect",doOnRowSelected);
	function doOnRowSelected(rowId,cellIndex){
		
		var datovalorid=mygridseleccion.cells(rowId,0).getValue();
		//alert(datovalorid);
		var vartipodocsel = myForm.getItemValue("ref_tipodocum");
		//alert(vartipodocsel);
		<?php if($_SESSION['sesusuario_usutipo_rol']=="3" and $_SESSION['sesusuario_asisdepart']=="1" ) { ?>
		if(vartipodocsel!="")
			myLayout.cells("b").attachURL("mostrar_panel.php?myidcuadclasif="+datovalorid+"&myidtipodocum="+vartipodocsel);
		else
			myLayout.cells("b").attachURL("mostrar_panel.php?myidcuadclasif="+datovalorid);
		<?php } else { ?>
		if(vartipodocsel!="")
			myLayout.cells("b").attachURL("mostrar_panel.php?mybusq=2&myidcuadclasif="+datovalorid+"&myidtipodocum="+vartipodocsel);
		else
			myLayout.cells("b").attachURL("mostrar_panel.php?mybusq=1&myidcuadclasif="+datovalorid);
		<?php }  ?>
		
		var varrequisitos  = mygridseleccion.cells(rowId,6).getValue();
		//alert(varrequisitos);
		if(varrequisitos==1)
		{
			var varidproceso =  mygridseleccion.cells(rowId,5).getValue();
			//alert(varidproceso);
			if(varidproceso!=0)
			window.open("mostrar_requisitos.php?mvpr="+varidproceso, "ventanarequs" , "width=400,height=400,scrollbars=NO");
			
		}
		

	}
	/////para una grilla con grupos e items maneja hasta el 2do nivel para otros niveles tree
     ////////////////////////////AGRUPACION DE DATOS///////
	////////////////para pasar a una grilla normal sin grupos

mygridseleccion.loadXML("php/oper_get_grid_select.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>",function(){
		//mygridseleccion.groupBy(1);
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
</body>
</html>