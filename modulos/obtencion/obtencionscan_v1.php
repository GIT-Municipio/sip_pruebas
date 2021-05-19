<?php
session_start();
require_once('../../conexion.php');

$cadenaurl_comp="";

if(isset($_SESSION["varses_grup_departid"]))
{
if(isset($_SESSION["vermientuscedula"]))
{
 $sqlusauxdep="SELECT count(*) as numcontcat FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."' and grupo_codbarras_tramite='".$_SESSION["varses_grup_codigo"]."' and param_departamento='".$_SESSION["varses_grup_departid"]."' and param_cod_categoria='".$_SESSION["varses_grup_categid"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$varverexisdtid=pg_fetch_result($resultcodauc,0,0);
if($varverexisdtid==0)
{
$_SESSION["varestaticmyid"]="0";
}
else
{
$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."' and grupo_codbarras_tramite='".$_SESSION["varses_grup_codigo"]."' and param_departamento='".$_SESSION["varses_grup_departid"]."' and param_cod_categoria='".$_SESSION["varses_grup_categid"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$_SESSION["varestaticmyid"]=pg_fetch_result($resultcodauc,0,'codultim');
}
}
}


if(isset($_SESSION['varses_grup_codigo'])!="")
{

/////////////////PARAMETROS DE INSERCION
$directoriobodega="D:/xampp/htdocs/siasys/siasys_bodega/";
//////////////////////////////////////////
$sqlbod = "SELECT enlaceurl FROM public.dato_bodega where id='".$_SESSION["varses_grup_bodega"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_bodega=pg_fetch_result($ressbod,0,0);
$sqlbod = "SELECT enlaceurl FROM public.dato_estanteria where id='".$_SESSION["varses_grup_estanteria"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_estanter=pg_fetch_result($ressbod,0,0);
$sqlbod = "SELECT enlaceurl FROM public.dato_nivel where id='".$_SESSION["varses_grup_nivel"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_nivel=pg_fetch_result($ressbod,0,0);

$cadenaurl_comp=$directoriobodega.$cedenaurl_bodega.$cedenaurl_estanter.$cedenaurl_nivel;

//echo $cadenaurl_comp;
//echo $cadenaurl_comp = str_replace('/', '\\', $cadenaurl_comp); 

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
		
#zombarraprogresiva {
	position:absolute;
	left:412px;
	top:153px;
	width:226px;
	height:231px;
	z-index:1000;
	background-image:url(imgs/loading.gif);
}	

    </style>
 

<script type="text/javascript">
function myFunctionllamarexe(){
	//alert("No se a detectado el Scanner");
    document.location.href="obt_invocarscan.php";
	/* var popupgeomap;
        popupgeomap = window.open("c://mibat.bat", "mostrarparascanner", "width=600,height=400,scrollbars=no");
        popupgeomap.focus();
	*/
   
}
</SCRIPT>
    

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar;

///////////////////////////////////////////////////////////////////////////////////////
function funcion_creaciongrupo()
  {
	 dhxWins = new dhtmlXWindows();
	 w1 = dhxWins.createWindow("w1", 400, 70, 400, 330);
	 w1.setText("Ingreso de Nuevo Grupo");
	 w1.button("minmax").disable();
	 //w1.button("close").disable();
	 //w1.attachObject("obj");
	 //w1.attachURL("../common/test_page_1.html");
	 //w1.attachHTMLString('datos htmls');
	 w1.setModal(true);  ////sirve para bloquear la pantalla para quitar simplemente se pone false
	 //////////////////crear formulario
	 formDataingrupo = [
	   {type: "settings", position: "label-left", labelWidth: 110, inputWidth: "auto"},
	   {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 370, list:	[
	   //{type: "image", name: "photo", label: "", imageWidth: 50, imageHeight: 50, url: "images/menus/btn_loginusuario.png"},
	   {type:"newcolumn"},
	   //{type: "template", label: "", value: "Ingrese su Usuario y Clave: "},
	        {type: "input", label: "TERMINAL",  width: 200,  name: "gterminal_usu", value: "<?php if(isset($_SESSION["ses_usuterminalacceso"])) echo $_SESSION["ses_usuterminalacceso"]; ?>", readonly : "true"},
			//{type: "input", label: "Nombre de Grupo",  width: 200,  name: "grup_nombre", value: ""},
			{type: "combo", label: "Departamento", name: "gparam_departamento", value: "", width: 195, filtering: true, connector: "php/zoptions_departam.php?t=combo",  validate: "NotEmpty" },
			//{type: "input", label: "Categoria/Tramite",  width: 200,  name: "gparam_nom_categoria", value: ""},
			
			{type: "combo", label: "Categoria/Tramite", name: "gparam_nom_categoria", value: "", width: 195, filtering: true, connector: "php/zoptions_categorianom.php?t=combo",  validate: "NotEmpty" },
			
			
			//{type: "combo", label: "Categoria/Tramite", name: "gparam_cod_categoria", value: "", width: 195, filtering: true, connector: "php/zoptions_categoria.php?t=combo",  validate: "NotEmpty" },
			{type: "combo", label: "Bodega", name: "gparam_bodega", value: "", width: 195, filtering: true, connector: "php/zoptions_bodega.php?t=combo",  validate: "NotEmpty" },
			{type: "combo", label: "Estanteria", name: "gparam_estanteria", value: "", width: 195, filtering: true, connector: "php/zoptions_estanteria.php?t=combo",  validate: "NotEmpty" },
			{type: "combo", label: "Nivel", name: "gparam_nivel", value: "", width: 195, filtering: true, connector: "php/zoptions_nivel.php?t=combo",  validate: "NotEmpty" },
			{type:"newcolumn"},
			{type: "template", label: "", value: ""},
		{type: "button", value: ">>>  Crear Grupo <<<", name: "send", offsetLeft: 140,  width: 100, className: "button_save"},			
		{type:"newcolumn"},
		{type: "template", label: "", value: ""},
		{type: "template", label: "", value: ""},
       // {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 160,  width: 100, className: "button_cancel"}			
				]},
			];
	 
	 
	
	
	 
	 myFormgrup = w1.attachForm(formDataingrupo);
	 myFormgrup.attachEvent("onButtonClick", function(id){
				
				if (id == "cancel") 
				{
					w1.close();
				}
				
				if (id == "send") 
					{
						////////////////envio de los datos para login
						 myFormgrup.send("obt_creagrupo.php", function(loader, response){
							//alert(response);
							var mensajeret="";
							var ustip="";
						    var resusp = response.split("#");
							if(resusp[0]=="ok")
							{
							    mensajeret="Bienvenido: "+resusp[1];
								//ustip=resusp[3];
							}
							else
							{
							    mensajeret=resusp[1];
							}
							 /////////////mensaje inicio
							 dhtmlx.alert({
								title:"Mensaje!",
						 		 //  type:"confirm",
						   		text: " >> "+mensajeret+" << ",
						    	callback: function() { 
								///////esto es para salirse del iframe local q lo contiene
								//document.location.href="lista_form_grid_actual.php";
								////es para salirse a la raiz :  parent.location.href
								    	if(resusp[0]=="ok")
											document.location.href="obtencionscan.php";
										else
										    document.location.href="obtencionscan.php";
										    //w1.close();
							 	}
							});
							//////////////////////////////mensaje fin 
						   // alert(response);
					      });
						////////// fin form envio de los datos para login	
					}  ///fin de if send
			});
  };
  ///////////////////////////////////////////////////////////////
 
  	
	
function doOnLoad() {
	document.getElementById("zombarraprogresiva").style.display = "none";
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "3J",
	cells: [
	         {id: "a", text: "Scanner" , width: 680, height: 160 },{id: "b", text: "Parametros" },{id: "c", text: "<?php if(isset($_SESSION['varses_grup_avisogrupo'])!="") echo $_SESSION['varses_grup_avisogrupo']; ?>" }
		   ] 
    });
	
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("a").collapse();
	//myLayout.cells("a").attachObject("encabez");
    myLayout.cells("b").attachURL("obtencion_formficha.php");
/////////////////////////////////////////FORMULARIO DE SUBIDA DE ARCHIVOS
	
		//////////////elementos
formData = [
  {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 120},

	{type: "fieldset", label: "Anexos: ",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 350, list:[		
					//{type: "newcolumn"},
	    
		{type: "template", label: "Imagen", name: "imagenicon",inputWidth: 140, value: ""},
		{type: "upload", name: "myFiles", inputWidth: 300,   offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
]},
{type:"newcolumn"},
	{type: "fieldset", label: "Informacion Desde Escaner",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 300, list:[	
	{type: "template", name: "link", label: "Obtener desde Scanner:", value: "dhtmlx.com", format:format_a},
	]},			
			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onFileAdd", function (name, old_value, new_value){
				document.getElementById("zombarraprogresiva").style.display = "block";
                
			});
			
			
			myForm.attachEvent("onUploadComplete",function(count){
				//alert("Carga Correcta");
				var x = document.getElementById("zombarraprogresiva");
    		    x.style.display = "none";
				
				dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Archivo(s) Procesados Correctamente!!",
						    callback: function() {
								//alert("Carga Correcta");
								
								document.location.href="obt_crea_procesarchivstxt.php";
								/*
								 myGrid.load("php/get_xusuario_obtencion.php?mitabla=<?php echo "tbl_archivos_procesados"; ?>&enviocampos=<?php echo "id, fecha_registro, form_cod_barras, doc_numfolio, doc_titulo,img_verdocumento,img_configdocum,img_validado,doc_tipo_info,doc_url_info"; ?>");
								 */

							 }
							});
							
			  
			   
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
						
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se agregó el archivo correctamente!!",
						    callback: function() {
								
								window.opener.location.reload(true);
								
								window.close();
							
							 }
							});
							
					}
			});
			
/////////////////////////////////////////////////////////////////////////////
			myGrid = new dhtmlXGridObject('gridbox');
			////////////////elemento grid
			myGrid = myLayout.cells("c").attachGrid();
			myGrid.setImagePath("codebase/imgs/");
			myGrid.setHeader("ID, FECHA, COD, #FOLIO, TITULO, DOCUMENTO,CONFIGURAR, VALIDAR,TIPO_INFO,URL_INFO");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("50,70,80,60,180,85,85,85,1,1");
			myGrid.setColAlign("center,left,left,left");
			myGrid.setColTypes("dyn,ro,ro,ro,ed,img,img,img,txt,txt");
			myGrid.setColSorting("int,str,str,str,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			myGrid.setColumnHidden(0, true);
			//myGrid.enableContextMenu(myMenuContex);
			myGrid.attachEvent("onRowSelect",doOnRowSelected);
			
			//////////////mi menucontextual
			myMenu = new dhtmlXMenuObject();
			myMenu.setIconsPath("../../componentes/common/imgs/");
			myMenu.renderAsContextMenu();
			myMenu.attachEvent("onClick",onButtonClick);
			myMenu.loadStruct("../../componentes/common/btncontext_gridobjs.xml");
			function onButtonClick(menuitemId,type){
		
				var data = myGrid.contextID.split("_");
				var retdat=data[0];
				var datovalorid=data[0];
			    var datovalor_tipoinfo=myGrid.cells(retdat,8).getValue();
			  var datovalor_urlinfo=myGrid.cells(retdat,9).getValue();
	       //alert(retdat);
		    //alert(datovalor_tipoinfo);
			// alert(datovalor_urlinfo);
		  var miPopupadminmetadatos;
		  
		   if(menuitemId=="btnvista_doc")
		   {
			  
			  if(datovalor_tipoinfo=="pdf")
			      miPopupadminmetadatos = window.open(datovalor_urlinfo,"mostrarmapawindconfig","width=450,height=500,scrollbars=no");
			  if(datovalor_tipoinfo=="jpg")
				 miPopupadminmetadatos = window.open("obt_vistaimgdocum.php?envidprimaria="+datovalorid,"mostrarmapawindconfig","width=450,height=500,scrollbars=no");

			 miPopupadminmetadatos.focus(); 
		   }
		   
		   if(menuitemId=="btnconfig_doc")
		   {
			   miPopupadminmetadatos = window.open("obtencion_formficha.php?envidprimaria="+retdat+"&estventanaok=1","mostrarmapawindconfig","width=650,height=480,scrollbars=no");
			miPopupadminmetadatos.focus();
		   }
		   
		   
			
		}
		///////////////////////////////////////////////
			myGrid.enableContextMenu(myMenu);
			myGrid.init();
			
			myGrid.load("php/get_xusuario_obtencion.php?mitabla=<?php echo "tbl_archivos_procesados"; ?>&enviocampos=<?php echo "id, fecha_registro, form_cod_barras, doc_numfolio, doc_titulo,img_verdocumento,img_configdocum,img_validado,doc_tipo_info,doc_url_info"; ?>");
			
			myGrid.enableEditEvents(true,false,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/update_allgrid.php?mitabla=<?php echo "tbl_archivos_procesados"; ?>&enviocampos=<?php echo "id, fecha_registro, form_cod_barras, doc_numfolio, doc_titulo"; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida
   			myDataProcessor.attachEvent("onAfterUpdate",function(rowId){ 

			myLayout.cells("b").attachURL("obtencion_formficha.php?envidprimaria="+rowId);
			
			 });
	       
			////////////////////EVENTOS DEL GRID
			function doOnRowSelected(rowId,cellIndex){

			  var datovalorid=myGrid.cells(rowId,0).getValue();
			  var datovalor_tipoinfo=myGrid.cells(rowId,8).getValue();
			  var datovalor_urlinfo=myGrid.cells(rowId,9).getValue();
			  
			  // alert(datovalor_tipoinfo);
			   
			  if(datovalor_tipoinfo=="pdf")
			       myLayout.cells("b").attachURL(datovalor_urlinfo);
			  if(datovalor_tipoinfo=="jpg")
			       myLayout.cells("b").attachURL("obt_vistaimgdocum.php?envidprimaria="+datovalorid);
			  
			  
			   if(cellIndex==5)
				 {
					
					  if(datovalor_tipoinfo=="pdf")
			       			myLayout.cells("b").attachURL(datovalor_urlinfo);
			  		  if(datovalor_tipoinfo=="jpg")
			      			 myLayout.cells("b").attachURL("obt_vistaimgdocum.php?envidprimaria="+datovalorid);
				   
				 }
				if(cellIndex==6)
				 {
					 myLayout.cells("b").attachURL("obtencion_formficha.php?envidprimaria="+datovalorid);
				 }
				if(cellIndex==7)
				 {
					 
					 document.location.href="obt_validardocs.php?envidprimaria="+datovalorid;
				 }
			   
			   
			  }
			  
/////////////////////////////////////////////////////////////////////////////			  
              function format_a(name, value) 
			    {
			if (name == "link") return "<div class='simple_link'><a href='#' style='text-decoration: none;' onclick='myFunctionllamarexe()' ><br/><table width='170' ><tr><td><font color='#a1a9c1' size='2' >Hacer Click para Ingresar a Scanner >>></font></td><td> <img src='imgs/btnscanner.png' width='54' height='50' /></td></tr></table>&nbsp;</a></div>";
		      	}

   	
	
  ///////////fin metodo onload()
	}
	
</script>
</head>
<body onLoad="doOnLoad();">
<?php   if(isset($_SESSION['varses_grup_codigo'])!=""){  
$mensjprincip="Grupo@: ".$_SESSION['varses_grup_codigo'];
 } else { ?>
<script>funcion_creaciongrupo();</script>
<?php } ?>
<div id="zombarraprogresiva"></div>
<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>
</body>
</html>
