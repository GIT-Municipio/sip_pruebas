<?php

$latabla='tblb_org_departamento';  /////son clave
$elsubcamponombre='nombre_departamento';    ////campos importantes   ///son clave
$elidprinorder='id';     ///////////////son claves
$elsubcampoenlace='parent_id';     ///////////////son claves
$elsubcampoenlacenro='8';
$numerdedatos=0;
//$latabla=$_GET[pontabla];
//////////seleccionar tabla///


require_once('../../clases/conexion.php');

$sql = "SELECT  id, nombre_departamento, codigo_unif, parent_id from ".$latabla." order by ".$elidprinorder;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

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
	   if(pg_field_name($res,$col)==$elsubcampoenlace)
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
			if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340,";
			else
			$tamcamposver.="100,";
			if(pg_field_name($res,$col)==$elsubcampoenlace)
			   $tipocamposver.="co,";
		    else
		   	   $tipocamposver.="txt,";
			$tipcamposorden.="str,";
			$filtrocampos.="#text_filter,";
		 }
		else
		if(is_numeric(pg_fetch_result($res,0,$col)))
		{
			if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340,";
			else
			$tamcamposver.="100,";
			if(pg_field_name($res,$col)==$elsubcampoenlace)
			   $tipocamposver.="co,";
		    else
		       $tipocamposver.="edn,";
			$tipcamposorden.="int,";
			$filtrocampos.="#text_filter,";
		}
		else
		 {
			if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340,";
			else
	    	$tamcamposver.="100,";
			if(pg_field_name($res,$col)==$elsubcampoenlace)
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
			 if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340";
			else
	  		$tamcamposver.="100";
	  		$posicamposver.="left";
			if(pg_field_name($res,$col)==$elsubcampoenlace)
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
			if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340";
			else
	  		$tamcamposver.="100";
	  		$posicamposver.="left";
			if(pg_field_name($res,$col)==$elsubcampoenlace)
	          $tipocamposver.="co";
	        else
	   		$tipocamposver.="edn";
	   		$tipcamposorden.="int";
	   		$filtrocampos.="#text_filter";
		}
		else
		 {
      		$camposver.=pg_field_name($res,$col);
			if(pg_field_name($res,$col)==$elsubcamponombre)
				$tamcamposver.="340";
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
	pattern: "2U",
	cells: [{id: "a", text: ".." },{id: "b", text: "Informacion", width: 520  }]
				
			});
			
			myLayout.cells("b").hideHeader();	
	/*		
	myLayout.cells("b").hideHeader();		
	myLayout.cells("a").attachObject("layoutmenuizq");		
	myLayout.cells("b").attachObject("layoutmenusuperderecha");	
	
		myTabbar = myLayout.cells("c").attachTabbar({
				tabs: [
					{ id: "tab1", text: "DEPARTAMENTOS DE LA INSTITUCION", active: true },
					{ id: "tab2", text: "ESTRUCTURA DEPARTAMENTAL" }
				]
			});
		*/	
		 myLayout.cells("b").attachURL("form_data_list.php?opt=nuevo");
		 
			//myLayout.cells("b").collapse();
	////////////////////////////ARBOLES VENTANA/////////////////////
			tree = myLayout.cells("a").attachTree();    ////para layout
			//tree = myTabbar.tabs("tab2").attachTree();
			//tree.attachHeader("#text_search")
			//tree.setColTypes("tree");
			tree.setSkin('dhx_skyblue');
			tree.setImagePath("../../componentes/codebase/imgs/dhxtree_skyblue/");
            tree.enableDragAndDrop(true);
            tree.enableItemEditor(true);
			tree.setOnClickHandler(tonclick);
			tree.loadXML("php/oper_get_arbol_depart.php?mitabla=<?php echo $latabla;?>&minombredato=<?php echo $elsubcamponombre ;?>&elidprincipal=<?php echo $elidprinorder ;?>&ref_parent_padre=<?php echo $elsubcampoenlace ;?>");
            
			////metodos otros
			//tree.findItem('CONCEJO', 0, 1); 
			////metodos para guardar en el arbol
        	
			
			myDataProcessortree = new dataProcessor("php/oper_update_arbol_depart.php?mitabla=<?php echo $latabla;?>&minombredato=<?php echo $elsubcamponombre ;?>&elidprincipal=<?php echo $elidprinorder ;?>&ref_parent_padre=<?php echo $elsubcampoenlace ;?>");
        	
			myDataProcessortree.init(tree);
			
			function tonclick(id){
			   // alert(id);
			    myLayout.cells("b").expand();	
	            myLayout.cells("b").attachURL("form_data_list.php?envionodoprin="+id);		
		
		    };
	//tree.enableKeyboardNavigation(true);
	//tree.enableKeySearch(true);
			
	menusuptools = myLayout.cells("a").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "xml/barbtns_opcionlay.xml",
								
			});
			
	menusuptools.setAlign('right');		
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xexpandir")
			{
				tree.openAllItems(0);
			}
			if(id=="xcolapsar")
			{
				tree.closeAllItems(0);
			}
			if(id=="xveritem")
			{
				tree.openItem(tree.getSelectedItemId());
			}
			if(id=="xcerraritem")
			{
				tree.closeItem(tree.getSelectedItemId());
			}
			if(id=="xbtnodotextbuscar")
			{
				var selvarinfo=menusuptools.getValue("xbtnbusqtext");
				//alert(selvarinfo);
				tree.findItem(selvarinfo, 0, 1); 
				//tree.closeItem(tree.getSelectedItemId());
			}
			if(id=="xbtnodoreinibuscar")
			{
				document.location.href="arb_data.php";
				
			}

	});
	
	
	myMenu = new dhtmlXMenuObject();
	myMenu.setIconsPath("../../componentes/common/imgs/");
	myMenu.renderAsContextMenu();
	myMenu.attachEvent("onClick",onButtonClick);
	myMenu.loadStruct("xml/btncontext_menutree.xml");
	function onButtonClick(menuitemId,type){
		
		var data = tree.contextID.split("_");
		var retdat=data[0];
		//alert(retdat);
		  //var miPopupadminmetadatos;
		   if(menuitemId=="addbusq")
		   {
			  // alert(retdat);
			   myLayout.cells("b").attachURL("form_data_list.php?opt=nuevo&envionodoprin="+retdat);
		   }
		   if(menuitemId=="deletebusq")
		   {
			    dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="crea_eliminar.php?vafil="+retdat;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
		   }
		   if(menuitemId=="creanodo")
		   {
			  // alert(retdat);
			   myLayout.cells("b").attachURL("form_data_list.php?opt=nuevo");
		   }
		   if(menuitemId=="mostrarpersonal")
		   {
			   myLayout.cells("b").attachURL("lista_personal.php?envionodoprin="+retdat);
		   }
		   if(menuitemId=="mostrarprocs")
		   {
			   myLayout.cells("b").attachURL("lista_procesos.php?envionodoprin="+retdat);
		   }
		   
		   
			
		}
	tree.enableContextMenu(myMenu);		
	///////////////////////////////////////////////////////////		

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
      <a href="form_data_departamentos.php?opt=nuevo" >
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
    <td>
      <a href="javascript:void(0)" onClick="myDataProcessor.sendData();">
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
        </a>
      </td>
  </tr>
  <tr>
    <td> <a href="javascript:void(0)" onClick="mygrid.deleteSelectedItem()">
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
      </a></td>
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
    <td width="81" align="center"><a href="subirdatos_csv_departamentos.php" ><img src="../../imagenes/excel_icon.png" width="20" height="20" border="0"></a></td>
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
    <td height="21" align="center"><a href="subirdatos_csv_departamentos.php" >Importar</a></td>
    <td align="center">&nbsp;</td>
    </tr>
</table>
<table width="195" border="0" align="right">
  <tr>
    <td width="81" align="center"><a href="#" onClick="mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');"><img src="../../imagenes/excel_icon.png" width="20" height="20" border="0"></a></td>
    <td width="100" align="center"><a href="javascript:abrevenimpresion('visor_datostabla_impresion.php?pontabla=<?php echo $latabla; ?>');"><img src="../../imagenes/imprimir.png" width="20" height="20" border="0"></a></td>
    <td width="169" align="center"><a href="#" onClick="mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');" ><img src="../../imagenes/pdficon.png" width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td align="center"><a href="#" onClick="mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');">Exportar</a></td>
    <td align="center"><a href="javascript:abrevenimpresion('visor_datostabla_impresion.php?pontabla=<?php echo $latabla; ?>');">Imprimir</a></td>
    <td height="21" align="center"><a href="#" onClick="mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');" >PDF</a></td>
 
  </tr>
</table>
</div>
</body>
</html>