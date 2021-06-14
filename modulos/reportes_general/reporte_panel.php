<?php

require_once('../../clases/conexion.php');
session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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

$latabla='tbli_esq_plant_formunico'; 
$sql = "SELECT id,form_cod_barras,date(fecha) as fecha,form_hora_ingreso,origen_tipo_tramite,origen_tipo_doc,form_asunto, cedula, ciud_nombres, ciud_apellidos,  origen_nro_documento, origen_institucion, origen_urbano_rural,origen_id_tipo_tramite,observacion,sumillado_a_responsables,estado_gestor, img_anexoficio, img_sumillaestado,codigo_tramite,sumillado_a_departamentos  FROM tbli_esq_plant_formunico order by id;";
$camposvertitulos="ID,CODIGO,FECHA,HORA,TIPO_TRAMITE,TIPO_DOC,ASUNTO,CEDULA,NOMBRES,APELLIDOS,NRO_DOCUMENTO,INSTITUCION,URBANO_RURAL,origen_id_tipo_tramite,OBSERVACION,ASIGNADO,ESTADO,ANEXO,ASIGNAR,COD_ARCH,sumillado_a_departamentos"; 

//$camposverupdate="ID,FORM_COD_BARRAS,FECHA,FORM_HORA_INGRESO,ORIGEN_TIPO_TRAMITE,ORIGEN_TIPO_DOC,FORM_ASUNTO,CEDULA,CIUD_NOMBRES,CIUD_APELLIDOS,ORIGEN_NRO_DOCUMENTO,ORIGEN_INSTITUCION,ORIGEN_URBANO_RURAL,origen_id_tipo_tramite";		  

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

/////////////////////////////////////
$camposvertitulos=$camposver;


$tamcamposver="1,75,70,55,200,150,200,80,80,80,80,80,80,1,80,170,85,85,85,110,110";
$tipocamposver="dyn,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,img,img,img,ro,ro";

?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="estilo/estil.css"/>

    <link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
    <script src="../../componentes/codebase/dhtmlx.js"></script>
    
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    
    <!-- 
    <link rel="stylesheet" type="text/css" href="componentes/codebase/dhtmlxgrid.css">
    <script  src="componentes/codebase/dhtmlxcommon.js"></script>
    <script  src="componentes/codebase/dhtmlxgrid.js"></script>
    <script src="componentes/codebase/ext/dhtmlxgrid_splt.js"></script>
    <script src="componentes/codebase/dhtmlxgridcell.js"></script>
    -->
    <!-- 
    <script src="componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <script  src="codebase/dhtmlxgridcell.js"></script>	
    -->
   
    <!-- nuevos estilos -->
    
    <link rel="stylesheet" href="jquery/jquery-ui.css">
   <link rel="stylesheet" href="jquery/jquery-ui.css">
  <script src="jquery/jqueryfecha.js"></script>
  <script src="jquery/jquery-ui.js"></script>
  <script>
  $( function() {
	 // $("#txtselotrafecha").datepicker();
	  $("#txtfechainiver").datepicker({ dateFormat: 'yy-mm-dd' });
	  $("#txtfechafinver").datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  
  function cambiaselfecha()
  {
	 // alert(document.getElementById("txtselotrafecha").value);
	  document.location.href = "index.php?envnfilfecha="+document.getElementById("txtselotrafecha").value;
  }
  </script>
  <!-- fin nuevos estilos -->
    


<style type="text/css"> 

	html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
			/*font-size: 10px;*/
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
div.tab_busquedas {
			/*color: blue;*/
			background-image:url(imgs/buscnombresdat.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_perspermisos {
			/*color: blue;*/
			background-image:url(imgs/permisosusu.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}			
    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar, mygrid;
	
	
	function btn_regresarpagprin()
	{
		document.location.href="reporte_panel.php";
	}
	
	
	////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Datos",  height: 62   },{id: "b", text: "REPORTE GENERAL"  }
	 ] });
	 
	
	myLayout.cells("a").hideHeader();
	myLayout.cells("b").hideHeader();
	myLayout.cells("a").attachObject("layoutmenusuperderecha");	


	mygrid = new dhtmlXGridObject('gridbox');
		      		   
		   
	mygrid = myLayout.cells("b").attachGrid();
			 			
	mygrid.setImagePath("../../componentes/codebase/imgs/");
	
	mygrid.setHeader("<?php echo $camposvertitulos; ?>");
	mygrid.attachHeader("<?php echo $filtrocampos; ?>");
	mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
	mygrid.setColAlign("<?php echo $posicamposver; ?>");
	mygrid.setColTypes("<?php echo $tipocamposver; ?>");
	mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
	
	//mygrid.setSkin("dhx_skyblue");
	//	mygrid.attachEvent("onRowSelect",doOnRowSelected);
	//mygrid.enableEditEvents(true,false,false);

    //////////estilo de columnas
	mygrid.setColumnColor("white,#d5f1ff,#d5f1ff,#fcfbd2,,#fcfbd2,,,,,,,,#faedd1,#faedd1,#d5f1ff");
	
    
   // mygrid.makeSearch("searchFilter",1);
  	///////////////////////inicio seteo numeros///////////////////////////////
		////////////////////////fin seteo numeros/////////////////////////////////
	//mygrid.setDateFormat("%m/%d/%Y", "%Y/%m/%d");
	mygrid.setDateFormat("%Y-%m-%d");
	//mygrid.setNumberFormat("0,000.00",0,"'",".");
	//mygrid.setDateFormat("%Y-%m-%d");
	
	//////sirve para ocultar columnas sin afectar la actualizacion
	//mygrid.setColumnHidden(0, true);
	////////////bloqueo de las columnas
	
	

		mygrid.init();
	
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
			if(id=="xdepart")
			{
				mygrid.groupBy(20);
				mygrid.expandAllGroups();   
				//mygrid.collapseAllGroups();
				//mygrid.expandGroup('MULTIPOLYGON'); 
			}
			if(id=="xtiptramite")
			{
				mygrid.groupBy(4);
				mygrid.expandAllGroups();   
				//mygrid.collapseAllGroups();
				//mygrid.expandGroup('MULTIPOLYGON'); 
			}
			if(id=="xtipodoc")
			{
				mygrid.groupBy(5);
				mygrid.expandAllGroups();   
				//mygrid.collapseAllGroups();
			}
			if(id=="xatencion")
			{
				mygrid.groupBy(15);
				mygrid.expandAllGroups();   
				//mygrid.collapseAllGroups();
			}
			
			
	});
 
	////////para agrupar
	 mygrid.customGroupFormat=function(text,count){
		//var datovalorcodbarras=mygrid.cells(rowId,1).getValue(); 
		return "Expediente: "+text+", Resp: "+count;
      };

	////////////////para pasar a una grilla normal sin grupos
			   
   mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>&enviusurespons=<?php echo $_GET['txtusurespons']; ?>&enviusudestinat=<?php echo $_GET['txtusudestinat']; ?>&enviusfechaini=<?php echo $_GET['txtfechainiver']; ?>&enviusfechafin=<?php echo $_GET['txtfechafinver']; ?>",function(){
	//	mygrid.groupBy(1);
		//mygrid.collapseAllGroups();    ////agrupar todo
		//mygrid.expandAllGroups();      /////expandir todo
		//mygrid.expandGroup('MULTIPOLYGON');   ///expandir un solo grupo
		//mygrid.collapseGroup('MULTIPOLYGON'); ///colapse un solo grupo
		//////en el caso de requerir  totales utilizar
		//mygrid.groupBy(7,["#stat_max","#title","","#stat_total"]);
	});	

		
  ///////////fin metodo onload()
	}
	
	function btnacutalizarall()
	{
		doOnLoad();
	}
	
</script>

 
</head>
<body onLoad="doOnLoad();">
<div id="gridbox"></div>
<div id="tramitesgridbox"></div>

<div id="layoutmenusuperderecha" style="background-color:#e7f1ff">
<table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25" align="center"><img src="../../imagenes/imgusuarios/esquinaizquierda.png" width="25" height="51"></td>
    <td width="70" align="center"><a href="#" onClick="btn_regresarpagprin()" ><img src="../../imagenes/imgusuarios/regresar.gif" width="66" height="51"></a></td>
    <td width="25" align="center"><img src="../../imagenes/imgusuarios/esquinaderecha.png" width="25" height="51"></td>
    <td width="495" align="center">
    <form action="reporte_panel.php" id="formdatosbusq" name="formdatosbusq">
    <table width="672" border="0">
      <tr>
        <td width="143" align="left" ><a href="#" >Buscar_Responsable:</a></td>
        <td width="240"><input  name="txtusurespons" type="text"   id="txtusurespons"  title="search" value="<?php echo $_GET['txtusurespons']; ?>" size="40"  placeholder="Escribir Cedula para Buscar..."></input></td>
        <td width="103" align="right"><a href="#" >Buscar_Fecha_Inicial</a></td>
        <td width="60"><input name="txtfechainiver" type="text"   id="txtfechainiver"   title="search" value="<?php echo $_GET['txtfechainiver']; ?>" size="10"  placeholder="Fecha Inicial para Buscar..."></td>
        <td width="104" rowspan="2" align="right">
          <input type="submit" name="btnenviar" id="btnenviar" value="BUSCAR" style=" width: 80px; height: 50px;"></td>
        </tr>
      <tr>
        <td align="left" ><a href="#" >Buscar_Destinatario</a></td>
        <td><input  name="txtusudestinat" type="text"   id="txtusudestinat"  title="search" value="<?php echo $_GET['txtusudestinat']; ?>" size="40"  placeholder="Escribir Nombre o Apellido para Buscar..."></td>
        <td align="left"><a href="#" >Buscar_Fecha_Final</a></td>
        <td><input name="txtfechafinver" type="text"   id="txtfechafinver"  title="search" value="<?php echo $_GET['txtfechafinver']; ?>" size="10"  placeholder="Fecha Final para Buscar..."></td>
        </tr>
      </table>
      </form>
      </td>
  </tr>
  </table>
<table width="100" border="0" align="right">
  <tr>
    <td width="77" align="center"><a href="#" onClick="mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');"><img src="../../imagenes/excel_icon.png" width="20" height="20" border="0"></a></td>
    <td width="73" align="center"><a href="#" onClick="mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');" ><img src="../../imagenes/pdficon.png" width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td align="center"><a href="#" onClick="mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');">Exportar</a></td>
    <td height="21" align="center"><a href="#" onClick="mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');" >Reporte</a></td>
 
  </tr>
</table>
</div>

</body>
</html>
