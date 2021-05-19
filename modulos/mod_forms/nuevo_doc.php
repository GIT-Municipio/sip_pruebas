<?php

 ///////////codigo departamento
 //$envcodidepartgen='107';
 ///////////////////

$latabla='tblu_migra_usuarios';
$elidprinorder='id';
$elsubcampoenlace="";
$elsubcampocarg="";
$elsubcamptipousu="";
$elsubcampusuactiv="";
$numerdedatos ="";
$elsubcamponombre="";
//////////seleccionar tabla///

require_once('../../clases/conexion.php');


//$sql = "SELECT id,form_cod_barras,date(fecha) as fecha,hora,  solic_text_defecto, tipo_doc, nro_documento, origen_instit, date(fecha_sumilla) as fecha_sumilla, sumillado_a, observacion,validado FROM tbli_esq_plant_formunico order by id;";
$sql = "SELECT id,  usua_nomb, usua_apellido, usua_email,  usua_cargo,  usua_dependencia,selec_temporadimg FROM public.tblu_migra_usuarios where usu_activo=1  order by id;";
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

$sqltextm = "SELECT count(*) FROM public.tbli_esq_plant_formunico_docsinternos where origen_tipodoc='MEMORANDO DIRECCION'";
$restxtmem = pg_query($conn, $sqltextm);
$pregnumermemo=pg_fetch_result($restxtmem,0,0);
/////////////////////////////////////////////
$vernummemoultm=1;
if($pregnumermemo==0)
{
	$ponernumdocumnew="GADC-PLAN-MEM-".$vernummemoultm;
}
else
{
	$sqltextnumemox = "SELECT max(num_memocreado) FROM public.tbli_esq_plant_formunico_docsinternos where origen_tipodoc='MEMORANDO DIRECCION'";
	$restxtnumemo = pg_query($conn, $sqltextnumemox);
	$vernummemoultm=pg_fetch_result($restxtnumemo,0,0)+1;
	$ponernumdocumnew="GADC-PLAN-MEMO-".$vernummemoultm;
}

/////////////////////////////////////////////

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
		{
		if(is_numeric(pg_fetch_result($res,0,$col)))
		{
			if((pg_field_name($res,$col)==$elsubcamponombre))
				$tamcamposver.="200,";
			else
			{
			 $tamcamposver.="100,";
			if((pg_field_name($res,$col)==$elsubcampoenlace)||(pg_field_name($res,$col)==$elsubcampocarg)||(pg_field_name($res,$col)==$elsubcamptipousu)||(pg_field_name($res,$col)==$elsubcampusuactiv))
			   $tipocamposver.="co,";
		    else
		       $tipocamposver.="edn,";
			$tipcamposorden.="int,";
			$filtrocampos.="#text_filter,";
			}
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
    <link rel="stylesheet" type="text/css" href="estilo/estil.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <script src="estilo/event.js"></script>
    <!-- nuevos estilos -->


    
	<script  src="codebase/dhtmlxgridcell.js"></script>	

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid;
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	//parent: document.body,
	parent: "layoutObj",
	pattern: "1C",
	cells: [{id: "a", text: "Seleccionar Usuario:",  height: 300   }
	 ] });
	
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("a").collapse();
	//myLayout.cells("a").attachObject("encabez");	
	//myLayout.cells("b").hideHeader();	
	//myLayout.cells("b").collapse();	
	//myLayout.cells("b").attachObject("contenidodelmemo");	
	
	
	/*myLayout.cells("b").attachObject("layoutmenuizq");	*/
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid = myLayout.cells("a").attachGrid();
	mygrid.setImagePath("../../componentes/codebase/imgs/");
	//mygrid.setHeader("<?php echo $camposver; ?>");
	mygrid.setHeader("ID,   USUA_NOMB, USUA_APELLIDO, USUA_EMAIL,  USUA_CARGO,  USUA_DEPENDENCIA, SELECCIONAR");
	mygrid.attachHeader("<?php echo $filtrocampos; ?>");
	//mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
	mygrid.setInitWidths("5,180,180,200,200,200,90");
	//mygrid.setColAlign("<?php echo $posicamposver; ?>");
	mygrid.setColAlign("left,left,left,left,left,left,center");
	//mygrid.setColTypes("<?php echo $tipocamposver; ?>");
	mygrid.setColTypes("ro,ro,ro,ed,ed,co,img");
	mygrid.setSkin("dhx_skyblue");
	mygrid.enableEditEvents(false,false,false);
	mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
    //////////estilo de columnas
	mygrid.setColumnColor("white,#d5f1ff,#d5f1ff,#d5f1ff,,,#d5f1ff");
	//mygrid.setRowTextStyle("row1", "background-color: red; font-family: arial;");
	//mygrid.setCellTextStyle("row1",0,"color:red;border:1px solid gray;");
	//mygrid.enableMultiline(true);
	//mygrid.setColSorting("date,str,str,str,str,date,str,str");
	mygrid.setColumnHidden(5, true);
	mygrid.attachEvent("onRowSelect",doOnRowSelected);
	////////////bloqueo de las columnas
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",3);
	mygrid.init();

	mygrid.loadXML("php/oper_get_datospersonal.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>&envcodidepart=<?php echo $envcodidepartgen; ?>",function(){
		mygrid.groupBy(5);
		//////en el caso de requerir  totales utilizar
		//mygrid.groupBy(7,["#stat_max","#title","","#stat_total"]);
	});
	
 
	function doOnRowSelected(rowId,cellIndex){
		var datovalorid=mygrid.cells(rowId,0).getValue();
        //mygrid.cellById(rowId, 6).setValue(true);
		var retornidrad=document.getElementById('varselecionusuarioenv').value;
		 if(retornidrad > 0)
		   {
			   mygrid.cellById(retornidrad, 6).setValue("imgs/btnselec_rad_false.png");
		   }
		   mygrid.cellById(rowId, 6).setValue("imgs/btnselec_rad_true.png");	
		document.getElementById('varselecionusuarioenv').value=datovalorid;
	}
	
	
	//mygrid.sortRows(6,"str","des");
	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	//mygrid.enableEditEvents(true,false,false);
	/*
//============================================================================================
	myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>"); //lock feed url
	
	

	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida
   myDataProcessor.attachEvent("onAfterUpdate",function(){ 
      // dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
	 // myDataProcessor.sendData();
	// doOnLoad();
	    })
		*/
		
  ///////////fin metodo onload()
	}
	
	function btnacutalizarall()
	{
		doOnLoad();
	}
	
</script>
<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
.menulatdivinfer{
		background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255)); border: 1px solid #a4bed4; height:20px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;padding: 0px 0px 0px 0px;margin-bottom: 0px;
	
	}
	#menutopsupervis{
width:100%;background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255));border: 1px solid #a4bed4; height:29px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;text-decoration: none;  	
	}
</style>

</head>
<body onLoad="doOnLoad();relojillo()">
<div id="layoutObj" style="width:100%;height:270px;overflow:hidden" ></div>
<div id="gridbox" style="width:100%;"></div>

<div id="contenidodelmemo">

<form action="asignarvars.php" method="get"> 


<?php 
    
    include("fckeditor/fckeditor.php") ; 
    $oFCKeditor = new FCKeditor('informacioncontenido') ;
    $oFCKeditor->BasePath = 'fckeditor/';
	///$oFCKeditor->ToolbarSet = 'Basic';    ///EN CASO DE QUE SE NECESITE UN EDITOR SOLO BASICO CASO CONTRARIO DEJAMOSDESACTIVADO
	$oFCKeditor->Value = 'Descripcion del Memo';     ////sirve para asginar los datos que sale de la base de datos
	//$oFCKeditor->Value = pg_fetch_result($restxtmem,0,0);  
	
    $oFCKeditor->Width  = '100%' ;
    $oFCKeditor->Height = '320' ;
    $oFCKeditor->Create() ;
	
		
?> 

<input type="hidden" id="variabtrami" name="variabtrami" value="<?php  if(isset($_GET["vafil"])) echo $_GET["vafil"]; ?>" />
<input type="hidden" id="varcodgenerado" name="varcodgenerado" value="<?php  if(isset($_GET["varcodgenerado"])) echo $_GET["varcodgenerado"]; ?>" />
<input type="hidden" id="varespuestusu" name="varespuestusu" value="<?php  if(isset($_GET["varespuestusu"])) echo $_GET["varespuestusu"]; ?>" />
<input type="hidden" id="varselecionusuarioenv" name="varselecionusuarioenv" />
<div align="center">
<table width="100%" border="0">
  <tr>
  <td width="10"><font color="#FF0000">MEMORANDO</font></td>
    <td width="300"><font size="2"><b>Nro_Memo:</b> <?php echo $ponernumdocumnew; ?><input type="hidden" id="varnewnummemos" name="varnewnummemos" value="<?php echo $vernummemoultm; ?>" /><input type="hidden" id="varnewcodificamemos" name="varnewcodificamemos" value="<?php echo $ponernumdocumnew; ?>" /></font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="../img/flechover1.png" width="20" height="20" border="0"></td>
    <td><input type="submit" style="width: 200px; height: 50px;" class="menulatdivinfer" value="ENVIAR RESPUESTA"></td>
  </tr>
</table>
 </div>
</form> 

</div>


</body>
</html>