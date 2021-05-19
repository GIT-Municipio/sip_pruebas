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


$camposver = "";
$tamcamposver = "";
$posicamposver = "";
$tipocamposver = "";
$tipcamposorden = "";
$filtrocampos = "";

for ($col = 1; $col < $numercampos; $col++) {
	
	   if (pg_field_name($res, $col) != 'id') {
	    $datosqltip="SELECT id, campo_creado,  campo_tipo,campo_tamanio,campo_bloqueo  FROM public.tbli_esq_plant_form_plantilla_cmpcolumns where ref_elementcampo='".$_GET["varitabcmpid"]."' and campo_creado='".pg_field_name($res, $col)."'";
		$resticmp = pg_query($conn, $datosqltip);
		$refidcampo=pg_fetch_result($resticmp,0,'campo_tipo');
		$refbloqcampo=pg_fetch_result($resticmp,0,'campo_bloqueo');
		$reftamancampo=pg_fetch_result($resticmp,0,'campo_tamanio');
	   }
		
	if (pg_field_name($res, $col) != 'ref_plantillausu') {
		if($col<$numercampos-1)
		{
		$camposver.=pg_field_name($res,$col).",";
		$tamcamposver .= $reftamancampo.",";
		$posicamposver.="left,";
		
		
		
		if($refidcampo==1)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "ed,";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro,";
			else	
				$tipocamposver .= "ed,";	
			}
		}
		else if($refidcampo==2)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "txt,";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro,";
			else	
				$tipocamposver .= "txt,";	
			}
		}
		else if($refidcampo==3)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "edn,";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro,";
			else	
				$tipocamposver .= "edn,";	
			}
		}
		else if($refidcampo==4)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "dhxCalendarA,";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro,";
			else	
				$tipocamposver .= "dhxCalendarA,";	
			}
		}
		else if($refidcampo==5)
		$tipocamposver .= "ch,";
		else
		$tipocamposver .= "ed,";
		
		
		$tipcamposorden .= "str,";
		$filtrocampos .= "#text_filter,";
		}
		else
		{
		$camposver.=pg_field_name($res,$col);
		$tamcamposver .= $reftamancampo;
		$posicamposver.="left";
		
		
		
		if($refidcampo==1)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "ed";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro";
			else	
				$tipocamposver .= "ed";	
			}
		}
		else if($refidcampo==2)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "txt";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro";
			else	
				$tipocamposver .= "txt";	
			}
		}
		else if($refidcampo==3)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "edn";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro";
			else	
				$tipocamposver .= "edn";	
			}
		}
		else if($refidcampo==4)
		{
			if(($_GET["varclaveuntramusu"])==0)
		         $tipocamposver .= "dhxCalendar";
			else
			{
			if($refbloqcampo==1)
		   		$tipocamposver .= "ro";
			else	
				$tipocamposver .= "dhxCalendar";	
			}
		}
		else if($refidcampo==5)
		$tipocamposver .= "ch";
		else
		$tipocamposver .= "ed";
		
		
		$tipcamposorden .= "str";
		$filtrocampos .= "#text_filter";
		}
		
		
	}
}



////////////////////////fin/////////////
$vectortiposcamps = explode(",", $tipocamposver);
$contarvecamps = count($vectortiposcamps);
$camposver = strtoupper($camposver);
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
	<?php 
	
	  $sqlcmps = "SELECT  campo_nombre   FROM tbli_esq_plant_form_plantilla_cmpcolumns where ref_elementcampo='".$_GET["varitabcmpid"]."'  order by id;";
     $reselemcmps = pg_query($conn, $sqlcmps);
	 $numdcmps=pg_num_rows($reselemcmps);
	 $aliascampostab="id,";
	 for($colk=0;$colk<$numdcmps;$colk++)
    {
   			if($colk<$numdcmps-1)
  			{
      		$aliascampostab.=pg_fetch_result($reselemcmps,$colk,0).",";
   			}
			else
			{
      		$aliascampostab.=pg_fetch_result($reselemcmps,$colk,0);
   			}
	}
	//echo $aliascampostab; 
	
	
	?>
	
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
	mygrid.setHeader("<?php echo $aliascampostab; ?>");
	//mygrid.attachHeader("<?php echo $filtrocampos; ?>");
	mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
	mygrid.setColAlign("<?php echo $posicamposver; ?>");
	mygrid.setColTypes("<?php echo $tipocamposver; ?>");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
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
			document.location.href='php/add_nuevoinfo.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
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
										document.location.href='php/elim_info.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&retidobj='+retdat+'&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
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

	mygrid.loadXML("php/oper_get_datosgrid_hybrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>");	//used just
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
				<?php if(($_GET["varclaveuntramusu"])==0) { ?>
				xml: "xml/barbtns_opcionlay.xml",
				<?php } else { ?>
				xml: "xml/barbtns_opcionlay_tabpub.xml",
				<?php } ?>
				
			});
			
	menusuptools.setAlign('right');		
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnomcampos")
			{
				
			document.location.href='actualizo_columnas.php?varitab=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>';
			}
			if(id=="xbtnnuevoinfo")
			{
				document.location.href='php/add_nuevoinfo.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
			}
			if(id=="xbtnagregacampo")
			{
				var nombrecol = prompt("Ingrese Nombre de Columna", "NuevaColumna");
		if (nombrecol != null)
	      document.location.href='php/add_column.php?pontabla=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&nomcolumn='+nombrecol+'&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
				
			}
			if(id=="xbtnelimcampo")
			{
				document.location.href='elimino_columnas.php?varitab=<?php echo $_GET["pontabla"]; ?>&varitabcmpid=<?php echo $_GET["varitabcmpid"]; ?>&varclaveuntramusu=<?php echo $_GET["varclaveuntramusu"]; ?>';
			}
			
			
			
			
	});


	}
</script>


</head>
<body  onload="doOnLoad();">
</body>
</html>