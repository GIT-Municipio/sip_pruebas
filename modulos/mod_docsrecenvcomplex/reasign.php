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
 ///////////codigo departamento
 if(($_SESSION['sesusuario_usutipo_rol']=="3") or ($_SESSION['sesusuario_usutipo_rol']=="2"))
 {
 $envcodidepartgen=$_SESSION['sesusuario_codigodepartamasig'];
 }
 else
  $envcodidepartgen='';
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




//$sql = "SELECT id,form_cod_barras,date(fecha) as fecha,hora,  solic_text_defecto, tipo_doc, nro_documento, origen_instit, date(fecha_sumilla) as fecha_sumilla, sumillado_a, observacion,validado FROM tbli_esq_plant_formunico order by id;";
$sql = "SELECT id,  usua_nomb, usua_apellido, usua_email,  usua_cargo,  usua_dependencia,selec_temporadimg FROM public.tblu_migra_usuarios where usu_activo=1 order by id;";
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);



////////////////////consultar tiempos al cuadro de clasificacion
 $sqltextm = "SELECT id,codi_barras,origen_id_tipo_tramite,ref_procesoform,codigo_tramite FROM public.tbli_esq_plant_formunico_docsinternos where id='".$_GET["vafil"]."'  ";
$restxtmem = pg_query($conn, $sqltextm);
$varcodgenerado=pg_fetch_result($restxtmem,0,'codi_barras');
$varcodtramite=pg_fetch_result($restxtmem,0,'origen_id_tipo_tramite');
$varcodprocesoid=pg_fetch_result($restxtmem,0,'ref_procesoform');
$variabtrami=pg_fetch_result($restxtmem,0,'id');
$varcodifarchiv=pg_fetch_result($restxtmem,0,'codigo_tramite');

////////////////////////////TIEMPOS
 $sqlcuadclas = "SELECT id,atencion_tiempo_dias,vigencia_tiempo_dias FROM public.tbli_esq_plant_form_cuadro_clasif where id='".$varcodtramite."'";
$rescuadtemps = pg_query($conn, $sqlcuadclas);
$vartiempodiasaten=pg_fetch_result($rescuadtemps,0,'atencion_tiempo_dias');
$vartiempodiasvigencia=pg_fetch_result($rescuadtemps,0,'vigencia_tiempo_dias');
//////////////////////////

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
	
	function validateForm()
        {
            var fre=document.getElementById('varselecionusuarioenv');
			if (fre.value==null || fre.value=="")
			{
			   dhtmlx.alert({
								title:"Importante!",
								type:"alert-error",
								text:"Debe Seleccionar el Usuario para Reasignar!!.."
							});
			   return false;
			}
			
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
<div id="layoutObj" style="width:100%;height:360px;overflow:hidden" ></div>
<div id="gridbox" style="width:100%;"></div>

<div id="contenidodelmemo">

<form action="reasign_guardar.php" method="get" onSubmit="return validateForm();" > 
<input type="hidden" id="variabtrami" name="variabtrami" value="<?php  if(isset($_GET["vafil"])) echo $_GET["vafil"]; ?>" />
<input type="hidden" id="varcodgenerado" name="varcodgenerado" value="<?php  if(isset($varcodgenerado)) echo $varcodgenerado; ?>" />

<input type="hidden" id="varcodtramite" name="varcodtramite" value="<?php  if(isset($varcodtramite)) echo $varcodtramite; ?>" />
<input type="hidden" id="varcodprocesoid" name="varcodprocesoid" value="<?php  if(isset($varcodprocesoid)) echo $varcodprocesoid; ?>" />
<input type="hidden" id="varcodifarchiv" name="varcodifarchiv" value="<?php  if(isset($varcodifarchiv)) echo $varcodifarchiv; ?>" />
<input type="hidden" id="varespuestusu" name="varespuestusu" value="2" />
<input type="hidden" id="varselecionusuarioenv" name="varselecionusuarioenv"  />
<div align="center">
<table width="200" border="0">
  <tr>
    <td colspan="2">
    
    <table width="460" border="0" align="center">
      <tr>
        <td width="306"><font color="#0033FF" size="2" >Tiempo Máximo del Trámite en dias: </font></td>
        <td width="144"><input name="txtingresdias" type="number" id="txtingresdias"   required="true"
         oninput="(function(e){e.setCustomValidity(''); return !e.validity.valid && e.setCustomValidity(' ')})(this)"
         oninvalid="this.setCustomValidity('Es Necesario Ingresar Valor de dias de Atencion del Tramite')" placeholder="Escribir Total de dias ..." value="<?php echo $vartiempodiasaten; ?>" ></td>
        </tr>
    </table>
   
    
    </td>
    </tr>
  <tr>
    <td><font color="#FF0000" size="2">Comentario: </font></td>
    <td><textarea name="txtcomentarioreasign" cols="80" rows="5" id="txtcomentarioreasign"></textarea></td>
  </tr>
</table>
</div>
<div align="center">
<table width="200" border="0" align="center" >
  <tr>
    <td><img src="imgs/btnacepflec.png" width="20" height="20" border="0"></td>
    <td><input type="submit" style="width: 200px; height: 50px;" class="menulatdivinfer" value="ACEPTAR"></td>
  </tr>
</table>
 </div>
</form> 

</div>


</body>
</html>