<?php
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

/////iniciacion
$dat_varitem1="";
$dat_varitem2="";
$dat_varitem3="";
$dat_varitem4="";
$dat_varitem5="";
$dat_varitem6="";
/////////////condiciones
$dat_varitem7="";
$dat_varitem8="";
$dat_varitem9="";
$dat_varitem10="";
$dat_varitem11="";
$dat_varitem12="";
///////////////////////////////////////////////

if(isset($_GET["envidprimaria"])!="")
{

$_SESSION["varestaticmyid"]=$_GET["envidprimaria"];	
	
require_once('../../conexion.php');

 $sqlconsitem="select doc_titulo,param_cod_tipo_docum,param_tipo_documento,doc_fecha_conserv_emision,doc_param_vigencia_anios,doc_responsable_emision,est_oficina,est_general,est_pasivo,est_historico,est_digital,doc_observacion,doc_fecha_conserv_final,doc_fecha_conserv_alerta_1 from tbl_archivos_procesados  WHERE id='".$_GET["envidprimaria"]."'";
$resultcitem=pg_query($conn, $sqlconsitem);

$dat_varitem1=pg_fetch_result($resultcitem,0,0);
$dat_varitem2=pg_fetch_result($resultcitem,0,1);
$dat_varitem3=pg_fetch_result($resultcitem,0,2);
$dat_varitem4=pg_fetch_result($resultcitem,0,3);
$dat_varitem5=pg_fetch_result($resultcitem,0,4);
$dat_varitem6=pg_fetch_result($resultcitem,0,5);
/////////////condiciones
$dat_varitem7=pg_fetch_result($resultcitem,0,6);
$dat_varitem8=pg_fetch_result($resultcitem,0,7);
$dat_varitem9=pg_fetch_result($resultcitem,0,8);
$dat_varitem10=pg_fetch_result($resultcitem,0,9);
$dat_varitem11=pg_fetch_result($resultcitem,0,10);
$dat_varitem12=pg_fetch_result($resultcitem,0,11);


}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>

	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <script src="estilo/event.js"></script>
    <!-- nuevos estilos -->
    
	<script  src="codebase/dhtmlxgridcell.js"></script>	

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
		background-color:#FFF;
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

    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar;

function mostrarcodigobarabig()
{
	//alert(varplantid);
	 var popupgeomap; 
    popupgeomap = window.open("obt_visorqrsimpres.php", "mostrafullmetad", "width=220,height=220,scrollbars=no");
    popupgeomap.focus();
	
}

function mostrarbarcodebig()
{
	//alert(varplantid);
	 var popupgeomap; 
    popupgeomap = window.open("obt_visorbarcodesimpres.php", "mostrafullmetad", "width=220,height=220,scrollbars=no");
    popupgeomap.focus();
	
}

function abrirPopMetadatos(varplantid)
{
	//alert(varplantid);
	 var popupgeomap;
	 if(varplantid!="0")
	 {
        popupgeomap = window.open("../metadatos/presentametadato.php?laopt=1&micaparchivid="+varplantid, "mostrafullmetad", "width=600,height=535,scrollbars=no");
        popupgeomap.focus();
	 }
	 else
	 {
		 alert("Es necesario seleccionar un documento");
	 }
}
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [
	         {id: "a", text: "Grupo" , width: 680, height: 90 },{id: "b", text: "Documento Activo#<?php echo $_SESSION["varestaticmyid"]; ?>" }
		   ] 
    });
	
	myLayout.cells("a").hideHeader();
	//myLayout.cells("a").collapse();
	myLayout.cells("a").attachObject("encabezgrupoactivo");
    //myLayout.cells("c").attachURL("modulos/proyectos/modprincipal_proyectos.php");
 
/////////////////////////////////////////FORMULARIO DE SUBIDA DE ARCHIVOS
	
		//////////////elementos
formData = [
	   {type: "settings", position: "label-left", labelWidth: 120, inputWidth: "auto"},
	   {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 360, list:	[
	   //{type: "image", name: "photo", label: "", imageWidth: 50, imageHeight: 50, url: "images/menus/btn_loginusuario.png"},
	   {type:"newcolumn"},
	   //{type: "template", label: "", value: "Ingrese su Usuario y Clave: "},
	        {type: "hidden", label: "ID",  width: 180,  name: "id", value: "<?php if(isset($_GET["envidprimaria"])) echo $_GET["envidprimaria"]; ?>"},
		    {type: "input", label: "Titulo",  width: 180,  name: "doc_titulo", required: true, value: "<?php if($dat_varitem1!="") echo $dat_varitem1; ?>"},
			
			
		//{type: "hidden", label: "cod",  width: 180,  name: "param_cod_tipo_docum", value: "<?php  if($dat_varitem2!="")  echo $dat_varitem2; ?>"},	
				
			<?php if($dat_varitem3=="") { ?>
			{type: "combo", label: "Tipo Documento", name: "param_tipo_documento",  width: 180, filtering: true, connector: "php/zoptions_tipodocum_text.php?t=combo" },
	
			
			<?php }else{ ?>
			
			{type: "input", label: "Tipo Doc",  width: 180,  name: "param_tipo_documento", value: "<?php  if($dat_varitem3!="") echo $dat_varitem3; ?>"},
			<?php } ?>
			
			{type: "calendar", dateFormat: "%Y-%m-%d",  width: 180, name: "doc_fecha_conserv_emision",required: true, label: "Emision", value:"<?php  if($dat_varitem4!="") echo $dat_varitem4; ?>", enableTime: true, calendarPosition: "right"},
			{type: "input", label: "Vigencia Años",  width: 180,  name: "doc_param_vigencia_anios", value: "<?php if($dat_varitem5!="") echo $dat_varitem5;  else echo "5";?>"},
			{type: "input", label: "Responsable Emision",  width: 180,  name: "doc_responsable_emision", value: "<?php  if($dat_varitem6!="")  echo $dat_varitem6; ?>"},
			{type: "combo", label: "Tipo Configuracion", name: "param_tipo_conservacion",  width: 180, filtering: true, connector: "php/zoptions_tipodocumconserva.php?t=combo",required: true },
	   ]},
	   
	   
	   
			{type:"newcolumn"},
			  {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 250, list:	[
			  {type: "label", label: "Almacen"},
			  
			    <?php if ($dat_varitem1!="") {?>
				{type: "radio", name: "caret",  value: "est_oficina", label: "Archivo Oficina" <?php if($dat_varitem7==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_general", label: "Archivo General"<?php if($dat_varitem8==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_pasivo", label: "Archivo Pasivo"<?php if($dat_varitem9==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_historico", label: "Archivo Historico"<?php if($dat_varitem10==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_digital", label: "Archivo Digital"<?php if($dat_varitem11==1) echo ", checked: true"; ?>},
				 <?php } else { ?>
				{type: "radio", name: "caret",  value: "est_oficina", label: "Archivo Oficina"},
				{type: "radio", name: "caret", value: "est_general", label: "Archivo General", checked: true},
				{type: "radio", name: "caret", value: "est_pasivo", label: "Archivo Pasivo"},
				{type: "radio", name: "caret", value: "est_historico", label: "Archivo Historico"},
				{type: "radio", name: "caret", value: "est_digital", label: "Archivo Digital"},
				 <?php } ?>
			
			]},
			{type:"newcolumn"},
			  {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 130, list:	[
			  {type: "template", name: "link", label: "", value: "dhtmlx.com",    format:format_imgmetadato},
			  
			  ]},
			
			{type:"newcolumn"},
			  {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 480, list:	[
			  
			 {type: "input", label: "Observacion",  width: 350,  name: "doc_observacion", value: "<?php echo $dat_varitem12; ?>"}, 
			
			{type: "template", label: "", value: ""},
		{type: "button", value: ">>>  Guardar Informacion <<<", name: "send", offsetLeft: 20,  width: 200, className: "button_save"},			
       // {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 160,  width: 100, className: "button_cancel"}			
				]},
			];

			myForm = myLayout.cells("b").attachForm(formData);
			
			myForm.attachEvent("onUploadComplete",function(count){
				//alert("todo bien");
			   myGrid.load("php/get_xusuario.php?mitabla=<?php echo "tbl_archivos_procesados"; ?>&enviocampos=<?php echo "id, fecha_registro, form_cod_barras, doc_numfolio, doc_titulo"; ?>");
			   
			});
			
			myForm.attachEvent("onChange", function(name, value){
				
				//myForm.setItemValue("param_tipo_documento",myForm.getItemValue("param_cod_tipo_docum"));
				if(name=="codidocaux")
				{
					myForm.setItemValue("param_cod_tipo_docum",myForm.getItemValue("codidocaux"));
					var valorcomb=myForm.getItemValue("param_cod_tipo_docum");
					dhx.ajax("php/z_selecciontexto.php?envolid="+valorcomb, function(text){
						 myForm.setItemValue("param_tipo_documento",text);
							});
				}
				
				
			});
			////////////////////eventos boton
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "cancel") 
				{
					document.location.href="lista_data_departamentos.php";
				}
				
				if (id == "send") 
					{
							myForm.send("obt_guardarficha.php", function(loader, response){
						         // alert(response);  
									dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    		callback: function() {
										
										<?php if(isset($_GET["estventanaok"])=="1") { ?>
										window.close();								       
										<?php }else{ ?>
										 document.location.href="obtencion_formficha.php?envidprimaria=<?php if(isset($_GET["envidprimaria"])) echo $_GET["envidprimaria"]; ?>";
										<?php } ?>
									}
									});
					         });
					}
			});
/////////////////////////////////////////////////////////
 function format_imgmetadato(name, value) 
			    {
			if (name == "link") return "<div class='simple_link'><a href='#' style='text-decoration: none;' onclick='abrirPopMetadatos(<?php if(isset($_GET["envidprimaria"])) echo $_GET["envidprimaria"]; else echo "0"; ?>)' ><br/><table width='70' ><tr><td> <img src='type_image/metadato.png' width='64' height='60' /></td></tr></table>&nbsp;</a></div>";
		      	}
/////////////////////////////////////////////////////////				
	}
	
</script>
</head>
<body onLoad="doOnLoad();">
<?php   if(isset($_SESSION['varses_grup_codigo'])!=""){  
$mensjprincip="Grupo@: ".$_SESSION['varses_grup_codigo'];
 } else { ?>
<script>funcion_creaciongrupo();</script>
<?php } ?>

<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>

<div id="encabezgrupoactivo"  style="font-size:9px;">

<table width="100%" border="0">
  <tr>
    <td rowspan="2"> <a href="#" onClick="mostrarcodigobarabig();"><img src="<?php if(isset($_SESSION['varses_grup_codigogenqrusu'])) echo $_SESSION['varses_grup_codigogenqrusu']; ?>" width="50" height="50" border="0"></a></td>
    <td rowspan="2"><a href="#" onClick="mostrarbarcodebig();"><img src="<?php 
	        if(isset($_SESSION['varses_grup_codigo']))
			{
	        require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator($_SESSION['varses_grup_codigo'],1,$_SESSION['varses_grup_codigo'].'_barcode.png', 120, 60, true);
  			//echo '<img src="barcode.gif" width = "120" height="60" />';
			echo $_SESSION['varses_grup_codigo'].'_barcode.png';
			}
	
	 ?>" width="120" height="60" border="0"></a></td>
     
    <td>
    <table width="100%" border="0">
  <tr>
    <td width="5%"><font size="2" color="#006699">Grupo:</font></td>
    <td width="23%"><font size="1"><?php if(isset($_SESSION['varses_grup_nombregrup']))  echo $_SESSION['varses_grup_nombregrup']; ?></font></td>
    <td width="6%">&nbsp;</td>
    <td width="6%"><font size="2" color="#006699">Categoria:</font></td>
    <td width="60%"><font size="1"><?php  if(isset($_SESSION['varses_grup_categ'])) echo $_SESSION['varses_grup_categ']; ?></font></td>
  </tr>
</table> 
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0">  
        <tr>
          <td><font size="2" color="#FF0000">Departamento</font></td>
          <td><font size="1"><?php if(isset($_SESSION['varses_grup_depart'])) echo $_SESSION['varses_grup_depart']; ?></font></td>
          <td>&nbsp;</td>
          <td><font size="2" color="#FF0000">Bodega</font></td>
          <td><font size="1"><?php if(isset($_SESSION['varses_grup_bodega'])) echo $_SESSION['varses_grup_bodega']; ?></font></td>
          <td>&nbsp;</td>
          <td><font size="2" color="#FF0000">Estanteria</font></td>
          <td><font size="1"><?php if(isset($_SESSION['varses_grup_estanteria'])) echo $_SESSION['varses_grup_estanteria']; ?></font></td>
          <td>&nbsp;</td>
          <td><font size="2" color="#FF0000">Nivel</font></td>
          <td><font size="1"><?php if(isset($_SESSION['varses_grup_nivel']))  echo $_SESSION['varses_grup_nivel']; ?></font></td>
          </tr>
  </table>
    </td>
  </tr>
</table>

 


</div>

</body>
</html>
