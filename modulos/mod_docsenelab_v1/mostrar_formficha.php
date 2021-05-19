<?php



///////////////////////////////////////////////
include('phpqrcode/qrlib.php');

if(isset($_GET["envidprimaria"])!="")
{


	
require_once('../../conexion.php');

 $sqlconsitem="SELECT id, fecha_registro, grupo_codbarras_tramite, form_cod_barras, 
       param_subcategoria, fecha_modificacion, doc_fecha_conserv_emision, 
       doc_param_vigencia_anios, doc_fecha_conserv_final, doc_fecha_conserv_alerta_1, 
       doc_fecha_conserv_alerta_2, doc_numfolio, doc_titulo, doc_texto_contenido, 
       param_cod_tipo_docum, doc_responsable_emision, doc_url_info, 
       doc_tipo_info, param_tipo_conservacion, doc_novedades, doc_observacion, 
       doc_anexo, doc_estado, nombre_departamento, param_categoria, 
       param_tipo_documento, est_oficina, est_general, est_pasivo, est_historico, 
       est_digital, bodega, estanteria, nivel, revisado_por, aprobado_por, 
       est_novedades, est_conmetadatos, est_conservacion, usu_respons_edit, 
       img_verdocumento, img_configdocum, img_estado, img_exportdocumpdf, 
       img_imprimirdocum, img_dardebaja, img_enprestamo, img_anexo, 
       img_metadatos, img_novedades, img_reportes, img_eliminado, descripcion, 
       parent_id, total_docsproces, param_grupo,cod_iden_grupo
	   from vista_archivos_agrupados  WHERE id='".$_GET["envidprimaria"]."'";
$resultcitem=pg_query($conn, $sqlconsitem);

//$dat_varitem1=pg_fetch_result($resultcitem,0,0);
 $sqlupcategroris="SELECT  descripcion  FROM public.tbl_archivos_procesados where  parent_id='".$_GET["envidprimaria"]."' and cod_iden_grupo=2;";
	 $rescategs = pg_query($conn, $sqlupcategroris);
	 $listdecategorias="";
	 	for($im=0;$im<pg_num_rows($rescategs);$im++)
       {
		   $listdecategorias=$listdecategorias."\n".pg_fetch_result($rescategs,$im,"descripcion");
	   }

//////////////////actualizo codigos qr
  $content = "CODIGO: ".pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite")."\n GRUPO: ".pg_fetch_result($resultcitem,0,"descripcion")."\n DEPARTAMENTO: ".pg_fetch_result($resultcitem,0,"nombre_departamento")."\n BODEGA: ".pg_fetch_result($resultcitem,0,"bodega")."\n ESTANTERIA: ".pg_fetch_result($resultcitem,0,"estanteria")."\n NIVEL: ".pg_fetch_result($resultcitem,0,"nivel")."\n CATEGORIAS: ".$listdecategorias;

	QRcode::png($content,"imgqrs/".pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite")."_comp_qr.png",QR_ECLEVEL_L,10,2);
	$imgcodigo_qr_grupo = "imgqrs/".pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite")."_comp_qr.png";
	
     //////--------------------ACTUALIZACION
$sqlupfre="UPDATE public.tbl_grupo_archivos SET grup_descripcionqr='".$imgcodigo_qr_grupo."' "." WHERE grup_cod_barras='".pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite")."';";
	$res = pg_query($conn, $sqlupfre);
	
	QRcode::png($content,"imgqrs/".pg_fetch_result($resultcitem,0,"form_cod_barras")."_comp_qr.png",QR_ECLEVEL_L,10,2);
	$imgcodigo_qr_categ = "imgqrs/".pg_fetch_result($resultcitem,0,"form_cod_barras")."_comp_qr.png";
	
$sqlupfre="UPDATE public.tbl_archivos_procesados SET form_cod_qr='".$imgcodigo_qr_categ."' "." WHERE id='".$_GET["envidprimaria"]."';";
$res = pg_query($conn, $sqlupfre);
	



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

function mostrarcodigobarabig_grup(envidprimaria)
{
	//alert(varplantid);
	 var popupgeomap; 
    popupgeomap = window.open("obtvisor_qrsbarsimpres_grup.php?envidprimaria="+envidprimaria, "mostrafullmetad", "width=290,height=200,scrollbars=no");
    popupgeomap.focus();
	
}

function mostrarbarcodebig_categ(envidprimaria)
{
	//alert(varplantid);
	 var popupgeomap; 
    popupgeomap = window.open("obtvisor_qrsbarsimpres_categ.php?envidprimaria="+envidprimaria, "mostrafullmetad", "width=290,height=200,scrollbars=no");
    popupgeomap.focus();
	
}

function mostrar_docs_escaneados(envidprimaria)
{
 myLayout.cells("b").attachURL("../obtencion/obt_vistaimgdocum.php?envidprimaria="+envidprimaria);
}

function mostrar_ficha(envidprimaria)
{
    doOnLoad();
}

function mostrar_dardebaja(envidprimaria)
{
dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Dar de Baja?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="crea_dardebaja.php?vafil="+envidprimaria;
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
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
	         {id: "a", text: "Grupo" , width: 680, height: 95 },{id: "b", text: "Documento Activo#<?php echo $_GET["envidprimaria"]; ?>" }
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
	   {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 350, list:	[
	   //{type: "image", name: "photo", label: "", imageWidth: 50, imageHeight: 50, url: "images/menus/btn_loginusuario.png"},
	   {type:"newcolumn"},
	   //{type: "template", label: "", value: "Ingrese su Usuario y Clave: "},
	        {type: "hidden", label: "ID",  width: 170,  name: "id", value: "<?php if(isset($_GET["envidprimaria"])) echo $_GET["envidprimaria"]; ?>"},
		    {type: "input", label: "Titulo",  width: 170,  name: "doc_titulo", required: true, value: "<?php if(pg_fetch_result($resultcitem,0,"doc_titulo")!="") echo pg_fetch_result($resultcitem,0,"doc_titulo"); ?>"},
			
			
		
		
				
			<?php if(pg_fetch_result($resultcitem,0,"param_tipo_documento")=="") { ?>
			{type: "combo", label: "Tipo Documento", name: "param_tipo_documento",  width: 170, filtering: true, connector: "php/zoptions_tipodocum_text.php?t=combo" },
	
			
			<?php }else{ ?>
			
			{type: "input", label: "Tipo Doc",  width: 170,  name: "param_tipo_documento", value: "<?php  if(pg_fetch_result($resultcitem,0,"param_tipo_documento")!="") echo pg_fetch_result($resultcitem,0,"param_tipo_documento"); ?>"},
			<?php } ?>
			
			{type: "calendar", dateFormat: "%Y-%m-%d",  width: 170, name: "doc_fecha_conserv_emision",required: true, label: "Emision", value:"<?php  if(pg_fetch_result($resultcitem,0,"doc_fecha_conserv_emision")!="") echo pg_fetch_result($resultcitem,0,"doc_fecha_conserv_emision"); ?>", enableTime: true, calendarPosition: "right"},
			{type: "input", label: "Vigencia Años",  width: 170,  name: "doc_param_vigencia_anios", value: "<?php if(pg_fetch_result($resultcitem,0,"doc_param_vigencia_anios")!="") echo pg_fetch_result($resultcitem,0,"doc_param_vigencia_anios");  else echo "5";?>"},
			{type: "input", label: "Responsable Emision",  width: 170,  name: "doc_responsable_emision", value: "<?php  if(pg_fetch_result($resultcitem,0,"doc_responsable_emision")!="")  echo pg_fetch_result($resultcitem,0,"doc_responsable_emision"); ?>"},
			{type: "hidden", label: "Conservacion",  width: 170,  name: "param_tipo_conservacion", value: "<?php  if(pg_fetch_result($resultcitem,0,"param_tipo_conservacion")!="")  echo pg_fetch_result($resultcitem,0,"param_tipo_conservacion"); ?>"},
			
	   ]},
	   
	  
	   
			{type:"newcolumn"},
			  {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 190, list:	[
			 
			  
			    <?php if (pg_fetch_result($resultcitem,0,"doc_titulo")!="") {?>
				{type: "radio", name: "caret",  value: "est_oficina", label: "Archivo Oficina" <?php if(pg_fetch_result($resultcitem,0,"est_oficina")==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_general", label: "Archivo General"<?php if(pg_fetch_result($resultcitem,0,"est_general")==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_pasivo", label: "Archivo Pasivo"<?php if(pg_fetch_result($resultcitem,0,"est_pasivo")==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_historico", label: "Archivo Historico"<?php if(pg_fetch_result($resultcitem,0,"est_historico")==1) echo ", checked: true"; ?>},
				{type: "radio", name: "caret", value: "est_digital", label: "Archivo Digital"<?php if(pg_fetch_result($resultcitem,0,"est_digital")==1) echo ", checked: true"; ?>},
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
			  {type: "fieldset", label: "", className:"estilolog", offsetLeft: 5, offsetRight: 0, offsetTop: 5, inputWidth: 400, list:	[
			  
			 {type: "input", label: "Observacion",  width: 250,  name: "doc_observacion", value: "<?php echo pg_fetch_result($resultcitem,0,"doc_observacion"); ?>"}, 
			
			{type: "template", label: "", value: ""},
		{type: "button", value: ">>>  Guardar Informacion <<<", name: "send", offsetLeft: 5,  width: 170, className: "button_save"},			
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
										 document.location.href="mostrar_formficha.php?envidprimaria=<?php if(isset($_GET["envidprimaria"])) echo $_GET["envidprimaria"]; ?>";
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

<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>

<div id="encabezgrupoactivo"  style="font-size:9px;">

<table width="100%" border="0">
  <tr>
    <td>
      <a href="#" onClick="mostrarcodigobarabig_grup(<?php echo $_GET["envidprimaria"]; ?>);">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2"><font size="1" color="#006699">Codificacion Grupo</font></td>
          </tr>
          <tr>
            <td><img src="<?php  echo $imgcodigo_qr_grupo; ?>" width="50" height="50" border="0"></td>
            <td><img src="<?php 
	        if(pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite")!="")
			{
	        require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator(pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite"),1,pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite").'_barcode.png', 120, 60, true);
  			//echo '<img src="barcode.gif" width = "120" height="60" />';
			echo pg_fetch_result($resultcitem,0,"grupo_codbarras_tramite").'_barcode.png';
			}
	
	 ?>" width="120" height="60" border="0"></td>
          </tr>
  </table>
  </a>
      
      </td>
    
    <td>
      <a href="#" onClick="mostrarbarcodebig_categ(<?php echo $_GET["envidprimaria"]; ?>);">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2"><font size="1" color="#006699">Codificacion Categoria</font></td>
          </tr>
          <tr>
            <td><img src="<?php  echo $imgcodigo_qr_categ; ?>" width="50" height="50" border="0"></td>
            <td><img src="<?php 
	        if(pg_fetch_result($resultcitem,0,"form_cod_barras")!="")
			{
	        require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator(pg_fetch_result($resultcitem,0,"form_cod_barras"),1,pg_fetch_result($resultcitem,0,"form_cod_barras").'_barcode.png', 120, 60, true);
  			//echo '<img src="barcode.gif" width = "120" height="60" />';
			echo pg_fetch_result($resultcitem,0,"form_cod_barras").'_barcode.png';
			}
	
	 ?>" width="120" height="60" border="0"></td>
          </tr>
  </table>
  </a>
      
      </td>
    
    <td>
    <?php if(pg_fetch_result($resultcitem,0,"cod_iden_grupo")==0) { ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="8%"><a href="#" onClick="javascript:mostrar_ficha(<?php echo $_GET["envidprimaria"]; ?>);"><img src="imgs/btngrid_obt_verficha.png" width="80" height="30"></a></td>
          </tr>
        <tr>
          <td><a href="#" onClick="javascript:mostrar_docs_escaneados(<?php echo $_GET["envidprimaria"]; ?>);"><img src="imgs/btngrid_obt_vistadocs.png" width="80" height="30"></a></td>
          </tr>
        <tr>
          <td><a href="#" onClick="javascript:mostrar_dardebaja(<?php echo $_GET["envidprimaria"]; ?>);"><img src="imgs/btninfo_dardebaja.png" width="80" height="30"></a></td>
          </tr>
        </table> 
         <?php } else { echo "&nbsp;";} ?>
        
      </td>
  </tr>
  </table>

 


</div>

</body>
</html>
