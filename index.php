<?php
session_start();
require_once('clases/conexion.php');

$sqlins = "SELECT  nombre_titulo,nombre_subtitulo,imglogo,imgfondo from tblb_org_institucion ";
$resulinsgad = pg_query($conn, $sqlins);
$_SESSION['sesinstit_nom_titulo']=pg_fetch_result($resulinsgad,0,"nombre_titulo");
$_SESSION['sesinstit_nom_subtitulo']=pg_fetch_result($resulinsgad,0,"nombre_subtitulo");
$_SESSION['sesinstit_imglogo']=pg_fetch_result($resulinsgad,0,"imglogo");
$_SESSION['sesinstit_imgfondo']=pg_fetch_result($resulinsgad,0,"imgfondo");	

if(isset($_SESSION['sesusuario_idprinusu'])=="")
{
echo "<script>window.open('log/index.php','_parent');</script>"; 	
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   
     <link rel="stylesheet" type="text/css" href="dhtmlx51/codebase/dhtmlx.css"/>
     <!--
     <link rel="stylesheet" type="text/css" href="dhtmlx51/skins/web/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx51/skins/terrace/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx51/skins/skyblue/dhtmlx.css"/>
	<link rel="stylesheet" type="text/css" href="dhtmlx51/codebase/dhtmlx.css"/>
    -->
	<script src="dhtmlx51/codebase/dhtmlx.js"></script>
    <!--
	<link rel="stylesheet" type="text/css" href="componentes/codebase/dhtmlx.css"/>
	<script src="componentes/codebase/dhtmlx.js"></script>
    -->
<link rel="stylesheet" type="text/css" href="componentes/codebase/dhtmlx.css"/>
    

	<style>
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
    font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bolder;
	color: #086478;
	cursor: pointer;
	text-decoration: none;
	text-indent: 3pt;
  }
  a:active { 
    font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bolder;
	color: #030;
	cursor: pointer;
	text-decoration: none;
	text-indent: 3pt;
  }
  a:visited { 
   /*color: #800080;*/
    font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bolder;
	color: #086478;
	cursor: pointer;
	text-decoration: none;
	text-indent: 3pt;
  }
  
  .class_elitemrib {
			background-color:#2493e9;
		}
		/*
	.dhtmlxribbon_dhx_skyblue .dhxrb_background_area{
		height:115px; background-image:url(imgs/fondos/fondomenuprin.png);
	}
     */

	</style>
	<script>
	var myLayout, myRibbon, myTabbar;
	/////////////////////BANDEJAS 
	function cambiar_bandejarecibidos()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=1");
	}
	function cambiar_bandejaenviados()
	{
		//alert("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=2");
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsenviados/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=2");
	}
	function cambiar_bandejareasignados()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsenviados/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=3");
	}
	
	function cambiar_bandejarenelaboracion()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsenviados/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=4");
	}
	function cambiar_bandejarennoevniados()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsenviados/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=5");
	}
	function cambiar_bandejareninformados()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=6");
	}
	function cambiar_bandejarenarchivados()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=7");
	}
	function cambiar_bandejareliminados()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docsrecenvcomplex/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&mibtnopcionbandeja=8");
	}
	
	
	function cambiar_busquedaavanz()
	{
		myLayout.cells("c").setText("Lista de Ciudadanos");
		myLayout.cells("c").showHeader();
		myLayout.cells("c").attachURL("modulos/mod_docbusqgen/listagestion.php");
	}
	
	
	/////////////////////////////cambiar la contraseña
		function cambiardatosperson(varidentrap)
		{
			myLayout.cells("c").setText("Actualizar Usuario");
			myLayout.cells("c").showHeader();
			myLayout.cells("c").attachURL("modulos/config_personal/actualizo_misdatos.php?valorusuid="+varidentrap);
		}
		//////////////////////////////////////////////////////////////
		function busquedainfogen()
		{
		
		var selvarcampo=document.getElementById('listcamposbusq').value;
		if(selvarcampo!="999")
		{
		var selvarinfo=document.getElementById('searchFilter').value;
		//alert("hola");
		//alert(selvarcampo);
		//alert(selvarinfo);
		myLayout.cells("c").attachURL("modulos/parametros/mi_busquedgen_docums_imgs.php?envopcfech=0&envcampobus="+selvarcampo+"&envinfobus="+selvarinfo);


		}
		else
		alert("Seleccionar Criterio para buscar");
}
		
  ///////////////////////////////////////////////////////////////
		function doOnLoad() {
			myLayout = new dhtmlXLayoutObject({
				//parent: "layoutObj",
				parent: document.body,
				pattern: "3T",
				
				cells: [{id: "a", text: "Sistema de Gestión Documental", height: 166   },{id: "b", text: "Menu Principal" , width: 210 },{id: "c", text: "."}]
				
			});
			
			//////////////MENU SUPERIOR
			myLayout.cells("a").hideHeader();
			cambiar_bandejarecibidos();
			/////////////MENU LATERAL
			var externo = "<?php echo $_SESSION['sesusuario_externo'] ?>";
			if(externo == '1' )
			{
				myRibbonmencreardoc = myLayout.cells("b").attachRibbon({
				icons_path: "imgs/",
				items: [
					{
						id: "block_1", type:'block', text:' ',   text_pos: 'top', list:[
							{id: "opendoc_interno", type:'button', text:'Documento', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id: "opendoc_externo", type:'button', text:'Documento externo', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id : "text_1", type:"text", text:"<span style='color:#ddebff'>...........</span>"}
						]
					}
			  	 ]
				});
			}
			else if(externo == '2' ){
				myRibbonmencreardoc = myLayout.cells("b").attachRibbon({
				icons_path: "imgs/",
				items: [
					{
						id: "block_1", type:'block', text:' ',   text_pos: 'top', list:[
							{id: "opendoc_interno", type:'button', text:'Documento', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id: "openform_externo", type:'button', text:'Trámite', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id : "text_1", type:"text", text:"<span style='color:#ddebff'>...........</span>"}
						]
					}
			  	 ]
				});
			}
			else if(externo == '3' ){
				myRibbonmencreardoc = myLayout.cells("b").attachRibbon({
				icons_path: "imgs/",
				items: [
					{
						id: "block_1", type:'block', text:' ',   text_pos: 'top', list:[
							{id: "opendoc_interno", type:'button', text:'Documento', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id: "openform_compras", type:'button', text:'Proceso Compras', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id : "text_1", type:"text", text:"<span style='color:#ddebff'>...........</span>"}
						]
					}
			  	 ]
				});
			}
			else{
				myRibbonmencreardoc = myLayout.cells("b").attachRibbon({
				icons_path: "imgs/",
				items: [
					{
						id: "block_1", type:'block', text:' ',   text_pos: 'top', list:[
							{id : "text_1", type:"text", text:"<span style='color:#ddebff'>...........</span>"},
							{id: "opendoc_interno", type:'button', text:'Documento', isbig: true, img: "iconos/btn_nuevodoc.png"},
							{id : "text_1", type:"text", text:"<span style='color:#ddebff'>...........</span>"}
						]
					}
			 	  ]
			});
			}					
			myRibbonmencreardoc.attachEvent("onClick", function(id){
				 if(id=="opendoc_interno")
				 {				
					dhxWins = new dhtmlXWindows();
	 				w1 = dhxWins.createWindow("w1", 230, 10, 950, 630);
	 				w1.setText("Nuevo Documento");
	 				w1.button("minmax").disable();
	 				w1.attachURL("modulos/mod_docsenelab/nuevo_doc.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
	 				w1.setModal(true);  ////sirve para bloquear la pantalla para quitar simplemente se pone false		
				 }
				 if(id=="opendoc_externo")
				 {					
					dhxWins = new dhtmlXWindows();
	 				w1 = dhxWins.createWindow("w1", 230, 10, 950, 630);
	 				w1.setText("Nuevo Formulario Secretaría");
	 				w1.button("minmax").disable();
	 				w1.attachURL("modulos/mod_docsenelab/nuevo_doc_externo.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
	 				w1.setModal(true);  ////sirve para bloquear la pantalla para quitar simplemente se pone false
		
				 }
				 if(id=="openform_externo")
				 {					
					dhxWins = new dhtmlXWindows();
	 				w1 = dhxWins.createWindow("w1", 230, 10, 950, 630);
	 				w1.setText("Nuevo Formulario Planificación");
	 				w1.button("minmax").disable();
	 				w1.attachURL("modulos/mod_docsenelab/nuevo_form_externo.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
	 				w1.setModal(true);  ////sirve para bloquear la pantalla para quitar simplemente se pone false
				 }
				  if(id=="openform_compras")
				 {					
					dhxWins = new dhtmlXWindows();
	 				w1 = dhxWins.createWindow("w1", 230, 10, 950, 430);
	 				w1.setText("Nuevo Formulario Compras Públicas");
	 				w1.button("minmax").disable();
	 				w1.attachURL("modulos/mod_docsenelab/nuevo_form_compras.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
	 				w1.setModal(true);  ////sirve para bloquear la pantalla para quitar simplemente se pone false
				 }
			});			


			myAcc = myLayout.cells("b").attachAccordion({
				//parent: "accObj",
				//skin: "web",
				items: [
					{id: "a1", text: "BANDEJAS"},
					{id: "a2", text: "BANDEJA ARCHIVO"},
					{id: "a3", text: "REPORTES"}
				]
			});
		
			myAcc.cells("a1").attachObject("menuusuario_bandejas");			
			myAcc.cells("a2").attachObject("menuusuario_otrasbandejas");			
			myAcc.cells("a3").attachObject("menuusuario_busquedas");	
	
	        myLayout.cells("b").showHeader();
			//myLayout.cells("b").hideHeader();
			//myLayout.cells("b").attachObject("layoutsuperior");
			//myLayout.cells("d").collapse();
			//myLayout.cells("d").showHeader();
			//myLayout.cells("d").hideHeader();
			myLayout.cells("c").hideHeader();
			/*
			<?php if($_SESSION["configmodusesion"]=="openmod_recibidos") { ?>
			myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
			<?php  } ?>
			
			<?php if($_SESSION["configmodusesion"]=="openmod_ventanilla") { ?>
			myLayout.cells("b").collapse();
			myLayout.cells("c").attachURL("modulos/mod_ventanilla/principal.php");	
			<?php  } ?>
			*/
			<?php ///if($_SESSION['sesusuario_usutipo_rol']==3) { ?>
			<?php if(($_SESSION['sesusuario_usu_ventanilla']==1) or ($_SESSION['sesusuario_asisdepart']==1)) { ?>
			// myLayout.cells("b").collapse();
			myLayout.cells("c").attachURL("modulos/mod_ventanilla/principal.php");
            <?php  } else { ?>
			myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
			<?php  } ?>
		    cambiar_bandejarecibidos();
			
			myRibbon = myLayout.cells("a").attachRibbon({
				//skin : "dhx_skyblue",    ////dhx_terrace    dhx_web dhx_skyblue
				icons_path: "componentes/common/",
				<?php if($_SESSION['sesusuario_usu_admin']==1) { ?>
				           
				
				          <?php if($_SESSION['sesusuario_cargousu']=="adminsystem") { ?>
							json: "componentes/common/data_tabs_principal_menu.json",
							<?php } else { ?>
							json: "componentes/common/data_tabs_principal_menu_admin.json",
							<?php } ?>
				
				<?php } else { ?>
				
				
				         <?php if(($_SESSION['sesusuario_usu_ventanilla']==1) or ($_SESSION['sesusuario_asisdepart']==1)) { ?>
							json: "componentes/common/data_tabs_principal_ventanilla.json",
						<?php } else { ?>
							json: "componentes/common/data_tabs_principal_tecnico.json",
						<?php } ?>
				
				               
				<?php } ?>
				//align: "right",
				
				onload: function() {
					/////sirve para poner la foto del usuario
					//myRibbon.setItemImage("open_sessusu1", "<?php if(isset($_SESSION["sesusuario_foto"])!="") echo  "../../modulos/".$_SESSION["sesusuario_foto"];  else "componentes/common/48/sinfoto.png" ?>");
					////sirve para poner la descripcion
				myRibbon.setItemText("open_sessusu1", "<?php if(isset($_SESSION["sesusuario_cedula"])) echo $_SESSION["sesusuario_cedula"]; else "Usuario"; ?>");
					////////////////////////////para fechas REGISTRO
					calendarInput = myRibbon.getInput("opentxt_fechabusq");
		     		myCalendar = new dhtmlXCalendarObject(calendarInput);
					myCalendar.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("opentxt_fechabusq", myCalendar.getFormatedDate());
					////////////////////////////para fechas desde
					calendarInputdesde = myRibbon.getInput("opentxt_fechabusqini");
		     		myCalendardesde = new dhtmlXCalendarObject(calendarInputdesde);
					myCalendardesde.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("opentxt_fechabusqini", myCalendardesde.getFormatedDate());
					////////////////////////////para fechas hasta
					calendarInputhasta = myRibbon.getInput("opentxt_fechabusqfin");
		     		myCalendarhasta = new dhtmlXCalendarObject(calendarInputhasta);
					myCalendarhasta.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("opentxt_fechabusqfin", myCalendarhasta.getFormatedDate());
					
					////////////////////////////para fechas EMISION
					calendarInputemi = myRibbon.getInput("open_busq4");
		     		myCalendaremi = new dhtmlXCalendarObject(calendarInputemi);
					myCalendaremi.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("open_busq4", myCalendaremi.getFormatedDate());
					////////////////////////////para fechas desde
					calendarInputemidesde = myRibbon.getInput("open_busq5ini");
		     		myCalendaremidesde = new dhtmlXCalendarObject(calendarInputemidesde);
					myCalendaremidesde.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("open_busq5ini", myCalendaremidesde.getFormatedDate());
					////////////////////////////para fechas hasta
					calendarInputemihasta = myRibbon.getInput("open_busq5fin");
		     		myCalendaremihasta = new dhtmlXCalendarObject(calendarInputemihasta);
					myCalendaremihasta.setDateFormat("%Y-%m-%d");
					myRibbon.setValue("open_busq5fin", myCalendaremihasta.getFormatedDate());
					
					//myRibbon.disable("opentxt_fechabusq");
			 
				}
				
				
			});
			
			
			myRibbon.attachEvent("onClick", function(id){
				////var selvarinfo=myRibbon.getValue("open_busq2");
				//////////////////MENU PRINCIPAL
				
				
				if(id=="openprin_usermiperfil")
				myLayout.cells("c").attachURL("modulos/config_personal/actualizo_misdatos.php?valorusuid=<?php if(isset($_SESSION["sesusuario_idprinusu"])) echo $_SESSION["sesusuario_idprinusu"]; else "1"; ?>");
				
				if(id=="openprin_usermiayuda")
				myLayout.cells("c").attachURL("manuales/MANUAL_GESTOR_DOCUMENTAL.pdf");
				
				if(id=="openprin_usermisalir")
				window.location.href = "log/salir.php";
				
				if(id=="openprin_usermifoto")
				myLayout.cells("c").attachURL("modulos/config_personal/actualizo_misdatos.php?valorusuid=<?php if(isset($_SESSION["sesusuario_idprinusu"])) echo $_SESSION["sesusuario_idprinusu"]; else "1"; ?>");
				
                ////////////MENU INSTITUCIONAL
				if(id=="open_inst1")
				myLayout.cells("c").attachURL("modulos/modulo_verinstitucion.php");
				
				if(id=="open_inst2")
				myLayout.cells("c").attachURL("modulos/config_institucion/form_data_institucion.php");
				
				if(id=="open_inst3")
				myLayout.cells("c").attachURL("modulos/config_institucion/form_data_institucion_autoridad.php");
				
				if(id=="open_inst4")
				myLayout.cells("c").attachURL("modulos/config_institucion/form_data_institucion_delegado.php");
				
				if(id=="open_departamen1")
				myLayout.cells("c").attachURL("modulos/config_departamentos/arb_data.php");
				
				if(id=="open_personal1")
				myLayout.cells("c").attachURL("modulos/config_personal/lista_data.php");
				
				if(id=="open_personal2")
				myLayout.cells("c").attachURL("modulos/config_personal/lista_data_tipo_personaltitulo.php");
				
				if(id=="open_personal3")
				myLayout.cells("c").attachURL("modulos/config_personal/lista_data_tipousuario.php");
				
				if(id=="open_personal4")
				myLayout.cells("c").attachURL("modulos/config_personal/lista_data_tipocargo.php");
				
				if(id=="open_usuexternciud1")
				myLayout.cells("c").attachURL("modulos/config_ciudadanos/lista_data.php");
				
				if(id=="open_gesdocums1")
				myLayout.cells("c").attachURL("modulos/clasif_documental/lista_data.php");
				
				if(id=="open_gesdocums2")
				myLayout.cells("c").attachURL("modulos/codif_documentos/lista_data.php");
				
				if(id=="open_gesdocums3")
				myLayout.cells("c").attachURL("modulos/config_tipo_documentos/lista_data.php");
				
				if(id=="open_gesdocums4")
				myLayout.cells("c").attachURL("modulos/config_codif_tramit/lista_data.php");
				
				if(id=="open_gesdocums5")
				myLayout.cells("c").attachURL("modulos/config_codsqr/lista_data.php");
				
				
				/////////////////////////////REPORTES ESTADISTICOS
				if(id=="open_report1")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("c").attachURL("modulos/reportes_estadistica/visor_estadisticas.php?xvarenvist=vista_estad_documentosingresados&xvarentipgraf=radar");
				}
				if(id=="open_report2")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("c").attachURL("http://www.cotacachienlinea.gob.ec/geodatabase/index.phtml?fxmp=15");
				}
				if(id=="open_report9")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("c").attachURL("modulos/reportesestadis/mi_reportes.php");	
				}
				if(id=="open_report3")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/reportes_estadistica/visor_estadisticas.php?xvarenvist=vista_estad_tipotramites&xvarentipgraf=pie");
				}
				if(id=="open_report4")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/reportes_estadistica/visor_estadisticas.php?xvarenvist=vista_estad_xdepartamentos&xvarentipgraf=pie");
				}
				if(id=="open_report5")
				{
					//myLayout.cells("c").setText("Tipos de Documentos");
					//myLayout.cells("c").showHeader();
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/reportes_estadistica/grafica_reporteatencion.php?xvarenvist=vista_estad_xdepartamentos&xvarentipgraf=pie");
				}
				////////////////////////////////////////OPCIONES PRINCIPALES
				
				if(id=="openprin_userventanilla")
				{
					//myLayout.cells("c").showHeader();
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_ventanilla/principal.php");	
				}
				
				if(id=="openprin_btn1")
				{
					//myLayout.cells("c").showHeader();
					//document.location.href="index.php";
					// myLayout.cells("b").expand();
					//myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php");	
					myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
				}
				if(id=="openprin_ocultamenu")
				{
					
					myLayout.cells("a").collapse();
					myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>");
			
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_ventanilla/principal.php");	
					
					
				}
				/////////////SECCION PARA BUSQUEDAS
				if(id=="openprin_btn2")
				{
					
					var selvarfecha=myRibbon.getValue("opentxt_fechabusq");
					//alert(selvarfecha);
					// myLayout.cells("b").expand();
					myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&consulvarfecha="+selvarfecha);
				}
				if(id=="openprin_btn3")
				{
					
					var selvarfechaini=myRibbon.getValue("opentxt_fechabusqini");
					var selvarfechafin=myRibbon.getValue("opentxt_fechabusqfin");
					//alert(selvarfechaini + " > " + selvarfechafin);
					// myLayout.cells("b").expand();
					myLayout.cells("c").attachURL("modulos/mod_docsrecibidos/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&consulvarfechaini="+selvarfechaini+"&consulvarfechafin="+selvarfechafin);
				}
				if(id=="openprin_btn4")
				{
					
					var selvarnomcampo=myRibbon.getValue("combocampos");
					var selvarbusinfo=myRibbon.getValue("open_busqxcamp");
					//alert( selvarnomcampo + " > " + selvarbusinfo);
					
					
					
					myLayout.cells("c").attachURL("modulos/mod_docbusqgen/listagestion.php?retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&consulvarcampo="+selvarnomcampo+"&consulvarinfo="+selvarbusinfo);
					
				
					
					
					
				}
				
				if(id=="gestioforms_item1")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_campos.php")
				}
				if(id=="gestioforms_item2")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_grupos.php")
				}
				if(id=="gestioforms_item3")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_vistaplantillas.php")
				}
				if(id=="gestioforms_item4")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_crear.php?opt=nuevo")
				}
				if(id=="gestioforms_item5")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_vistaplantillas_crear.php")
				}
				if(id=="gestioforms_item6")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_vformsenlinea.php")
				}
				if(id=="openprin_usventformulars")
				{
					myLayout.cells("b").collapse();
					myLayout.cells("c").attachURL("modulos/mod_forms/plantilla_lista_vformsenlinea.php")
				}
				
				

				
				////////////////////////////////////////////////////////////
				});		
				
				 sb =  myLayout.cells("a").attachStatusBar();
    			 sb.setText("<?php  echo "Usuario: (Serv.) ".$_SESSION['sesusuario_nomcompletos']." / Area: ".$_SESSION['sesusuario_nomdepartameusu']." / Puesto: ".$_SESSION['sesusuario_cargousu'];   ?>");	
				
				
///////////////////////////////////////////////		
		}	
		
	</script>
    
   
    
</head>
<body onload="doOnLoad();" >

<div id="menuusuario_bandejas">

<table width="225" border="0">
   <!-- <tr>
     <td width="16"><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
     <td width="199"><a href="#" onClick="cambiar_bandejarenelaboracion()" >En Elaboracion</a></td>
   </tr> -->
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejarecibidos()" >Recibidos</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejaenviados()" >Enviados</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejareasignados()" >Reasignados</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejarenarchivados()" >Archivados</a></td>
  </tr>
</table>

</div>

<div id="menuusuario_otrasbandejas">

<table width="225" border="0">
 <tr>
    <td width="16"><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td width="199"><a href="#" onClick="cambiar_bandejarennoevniados()" >No Enviados</a></td>
  </tr>
   <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejareninformados()" >Informados</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejarenarchivados()" >Archivados</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="#" onClick="cambiar_bandejareliminados()" >Eliminados</a></td>
  </tr>
</table>

</div>

<div id="menuusuario_busquedas">

<table width="225" border="0">
 <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a  href="#"  onClick="cambiar_busquedaavanz()" >Busqueda Avanzada</a></td>
  </tr>
   <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="index.php" >Seguimiento Documentacion</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="index.php" >Carpetas Virtuales</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="index.php" >Reimpresion Documentos</a></td>
  </tr>
  <tr>
    <td><img src="imgs/iconos/itemmen.gif" width="16" height="16"></td>
    <td><a href="index.php" >Reportes</a></td>
  </tr>
</table>
</div>


</body>
</html>
s