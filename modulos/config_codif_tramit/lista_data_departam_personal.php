<?php

$latabla='data_modusuarios';
$elsubcamponombre='nombre';    ////campos importantes
////////////////campos para combo principal de agrupacion
$elsubcampoenlace='ref_departamento';
$elsubcampoenlacenro='7';
////////////////campos para combos extras
$elsubcampocarg='ninguno';
$elsubcampocargnro='3';
////////////////campos para combos extras
$elsubcamptipousu='ninguno';
$elsubcamptipousunro='10';
////////////////campos para combos extras
$elsubcampusuactiv='ninguno';
$elsubcampusactivunro='11';
///////////////fin combos

$elidprinorder='id';
//$latabla=$_GET[pontabla];
//////////seleccionar tabla///
require_once('../../clases/conexion.php');

$sql = "SELECT id, nombres, apellidos, cargo, titulo, email, telefono, ref_departamento from ".$latabla." order by ".$elidprinorder;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

//////////////////////departamentos
$sql = "SELECT id, nombre from data_departamento_direccion order by id";
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
$vectortiposcamps=split(",",$tipocamposver);
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
	var myLayout, myAcc, myForm, formData;
	
	
function doOnLoad() {
	

	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "3L",
	cells: [{id: "a", text: "Menu", width: 90, height: 140   },{id: "b", text: "MENU SUPERIOR", height: 30  },{id: "c", text: "PERSONAL TECNICO DE CADA DEPARTAMENTO"} ]
				
			});
			
	myLayout.cells("b").hideHeader();		
	myLayout.cells("a").attachObject("layoutmenuizq");		
	myLayout.cells("b").attachObject("layoutmenusuperderecha");	
	
				
	
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid = myLayout.cells("c").attachGrid();
	mygrid.setImagePath("../../componentes/codebase/imgs/");
	mygrid.setHeader("<?php echo $camposver; ?>");
	mygrid.attachHeader("<?php echo $filtrocampos; ?>");
	mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
	mygrid.setColAlign("<?php echo $posicamposver; ?>");
	mygrid.setColTypes("<?php echo $tipocamposver; ?>");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
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
	
///////////////////////////////DEPARTAMENTO  $numercamposdep    $resdepartament;
<?php if ($elsubcampoenlace=="ref_departamento") {?>
	coroColumn = mygrid.getCombo(<?php echo $elsubcampoenlacenro; ?>);
	coroColumn.put("0","PRINCIPAL");
	<?
	 for($comp=0;$comp < pg_num_rows($resdepartament); $comp++)
   		{
			echo "coroColumn.put('".pg_fetch_result($resdepartament,$comp,0)."','".pg_fetch_result($resdepartament,$comp,1)."');"   ;
		}
 	?>
	 
	 ////////////////////////////AGRUPACION DE DATOS///////
	   mygrid.customGroupFormat=function(text,count){
		var datotext= coroColumn.get(text); ///obtiene el dato
		if(text==0)
        return "Personal existente en la Institución ( "+count+" )"
		else
        return "DIRECCIÓN DE "+datotext+" ( "+count+" )"
      };
	<?php }  //// se activara siempre y cuando haya un campo de enlace ?>  
//////////////////////////////////////////////
///////////////////////////////CARGO
<?php if ($elsubcampocarg=="cargo") {?>
	coroColumncargo = mygrid.getCombo(<?php echo $elsubcampocargnro; ?>);
	coroColumncargo.put("0","SIN CARGO");
	<?
	 for($comp=0;$comp < pg_num_rows($rescargos); $comp++)
   		{
			echo "coroColumncargo.put('".pg_fetch_result($rescargos,$comp,0)."','".pg_fetch_result($rescargos,$comp,1)."');"   ;
		}
    } //// se activara siempre y cuando haya un campo de enlace  fin de if
 	?>


///////////////////////////////tipo usuario
<?php if ($elsubcamptipousu=="tipo_usuario") {?>
	coroColumntipousu = mygrid.getCombo(<?php echo $elsubcamptipousunro; ?>);
	coroColumntipousu.put("0","PRINCIPAL");
	<?
	 for($comp=0;$comp < pg_num_rows($restipousu); $comp++)
   		{
			echo "coroColumntipousu.put('".pg_fetch_result($restipousu,$comp,0)."','".pg_fetch_result($restipousu,$comp,1)."');"   ;
		}
    } //// se activara siempre y cuando haya un campo de enlace  fin de if
 	?>
	
	///////////////////////////////tipo usuario
<?php if ($elsubcampusuactiv=="data_tipo_activusuarios") {?>
	coroColumnactivusu = mygrid.getCombo(<?php echo $elsubcampusactivunro; ?>);
	coroColumnactivusu.put("0","PRINCIPAL");
	<?
	 for($comp=0;$comp < pg_num_rows($restusuactivo); $comp++)
   		{
			echo "coroColumnactivusu.put('".pg_fetch_result($restusuactivo,$comp,0)."','".pg_fetch_result($restusuactivo,$comp,1)."');"   ;
		}
    } //// se activara siempre y cuando haya un campo de enlace  fin de if
 	?>

//////////////////////////////////////////////
	//  mygrid.expandAllGroups();
     //mygrid.collapseAllGroups();
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",1);
//var combo=mygrid.getColumnCombo(0);
//combo.addOption('TestV1','TestName 1');
	
	/////para una grilla con grupos e items maneja hasta el 2do nivel para otros niveles tree

	mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>",function(){
		mygrid.groupBy(<?php echo $elsubcampoenlacenro; ?>);
		//////en el caso de requerir  totales utilizar
		//mygrid.groupBy(7,["#stat_max","#title","","#stat_total"]);
	});
	
	////////////////para pasar a una grilla normal sin grupos
//mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>");	
	

	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,true,false);
//============================================================================================
	myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida

   myDataProcessor.attachEvent("onAfterUpdate",function(){ dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"}); })

	}
	
</script>
</head>
<body onLoad="doOnLoad();">
<div id="layoutmenuizq" style="background-color:#e7f1ff">
<table width="81" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="71">
   <a href="javascript:void(0)" onClick="mygrid.addRow((new Date()).valueOf(),[0,'','','0','','mail','telf','0'],mygrid.getRowIndex(mygrid.getSelectedId()))">
    <table width="200" border="0" align="center" id="menulateraldiv">
      <tr>
        <td><table width="41" border="0" align="center" cellpadding="0" cellspacing="0" id="estilointerbtn">
          <tr>
             <td width="31" align="center"><img src="../../imagenes/categories.png" width="30" height="30" border="0"></td>
          </tr>
          <tr>
            <td height="21" align="center">Nuevo</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </a>
    </td>
  </tr>
  <tr>
    <td><a href="javascript:void(0)" onClick="myDataProcessor.sendData();">
        <table width="200" border="0" align="center" id="menulateraldiv">
          <tr>
            <td><table width="58" border="0" align="center" cellpadding="0" cellspacing="0" id="estilointerbtn">
              <tr>
                <td width="48" align="center"><img src="../../imagenes/guardar.png" width="32" height="32" border="0"></td>
                </tr>
              <tr>
                <td align="center">Actualizar<input type="hidden" name="some_name" value="update" /></td>
                </tr>
            </table></td>
          </tr>
        </table>
        </a></td>
  </tr>
  <tr>
    <td>
      <a href="javascript:void(0)" onClick="mygrid.deleteSelectedItem()">
        <table width="200" border="0" align="center" id="menulateraldiv">
          <tr>
            <td><table width="52" border="0" align="center" cellpadding="0" cellspacing="0" id="estilointerbtn">
              <tr>
                <td width="42" align="center"><img src="../../imagenes/elim.png" width="30" height="30" border="0"></td>
                </tr>
              <tr>
                <td align="center">Eliminar</td>
                </tr>
            </table></td>
          </tr>
        </table>
        </a>
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  </table>
</div>
<div id="gridbox" style="width:600px;height:270px;overflow:hidden"></div>
<div id="layoutmenusuperderecha" style="background-color:#e7f1ff">
<table width="195" border="0" align="left">
  <tr>
    <td width="81" align="center"><a href="subirdatos_csv.php" ><img src="../../imagenes/excel_icon.png" width="20" height="20" border="0"></a></td>
    <td width="100" align="center"><img src="../../imagenes/tapodato.png" width="52" height="25"></td>
    <td width="169" rowspan="2" align="center"><table width="400" border="0">
      <tr>
        <td width="144" align="center" ><a href="#" >Buscar Informacion:</a></td>
        <td width="10"><img src="../../imagenes/btnbuscarsubmit.png" width="25" height="25"></td>
        <td width="241"><input type="text"   id="searchFilter"  title="search" size="40"  placeholder="Escribir informacion para Buscar..."></input></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="21" align="center"><a href="subirdatos_csv.php" >Importar</a></td>
    <td align="center">&nbsp;</td>
    </tr>
</table>
<table width="195" border="0" align="right">
  <tr>
    <td width="81" align="center"><a href="#" onClick="mygrid.toExcel('../componentes/codebase/grid-excel-php/generate.php');"><img src="../../imagenes/excel_icon.png" width="20" height="20" border="0"></a></td>
    <td width="100" align="center"><a href="javascript:abrevenimpresion('visor_datostabla_impresion.php?pontabla=<?php echo $latabla; ?>');"><img src="../../imagenes/imprimir.png" width="20" height="20" border="0"></a></td>
    <td width="169" align="center"><a href="#" onClick="mygrid.toPDF('../componentes/codebase/grid-pdf-php/generate.php');" ><img src="../../imagenes/pdficon.png" width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td align="center"><a href="#" onClick="mygrid.toExcel('../componentes/codebase/grid-excel-php/generate.php');">Exportar</a></td>
    <td align="center"><a href="javascript:abrevenimpresion('visor_datostabla_impresion.php?pontabla=<?php echo $latabla; ?>');">Imprimir</a></td>
    <td height="21" align="center"><a href="#" onClick="mygrid.toPDF('../componentes/codebase/grid-pdf-php/generate.php');" >PDF</a></td>
 
  </tr>
</table>
</div>
</body>
</html>