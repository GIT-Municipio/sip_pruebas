<?php
require_once('../../clases/conexion.php');
include('phpqrcode/qrlib.php');
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

 $sql = "SELECT inst_ruc, inst_nombre, inst_logo, inst_email,  inst_logo_docs, inst_bannersup_docs, inst_bannerinf_docs, inst_fondomarcaguaborr_docs, inst_fondomarcaguaorig_docs, inst_mensaje_slogan_docs FROM public.institucion where inst_ruc='1060000420001';";
$resxpres = pg_query($conn, $sql);
$darmecodgestrdms=pg_fetch_result($resxpres,0,0);

  $sql = "SELECT * FROM public.tbli_esq_plant_formunico where id='".$_GET["mvpr"]."'  ;";
$resxpresdocum = pg_query($conn, $sql);

$dargestrdmsfecha=pg_fetch_result($resxpresdocum,0,'fecha');
$dargestrdmsbrras=pg_fetch_result($resxpresdocum,0,'form_cod_barras');
$dargestrdmscedul=pg_fetch_result($resxpresdocum,0,'cedula');
$dargestrdmsnoms=pg_fetch_result($resxpresdocum,0,'ciud_nombres');
$dargestrdmsapels=pg_fetch_result($resxpresdocum,0,'ciud_apellidos');
$dargestrdmsolicit=pg_fetch_result($resxpresdocum,0,'form_asunto');


$dargestrdmsolciudomi=pg_fetch_result($resxpresdocum,0,'ciud_domicilio');
$dargestrdmsolciutelf=pg_fetch_result($resxpresdocum,0,'ciud_telefono');

$dargesolicitfuncnom=pg_fetch_result($resxpresdocum,0,'sumillado_a_responsables');
$dargesolicitfuncdep=pg_fetch_result($resxpresdocum,0,'sumillado_a_departamentos');
/////////////////otros parametros
$varorigen_tipodoc=pg_fetch_result($resxpresdocum,0,'origen_tipo_doc');
$varorigen_tipo_tramite=pg_fetch_result($resxpresdocum,0,'origen_tipo_tramite');
//$varimg_respuesta_estado=pg_fetch_result($resxpresdocum,0,'img_respuesta_estado');
//$varimg_bandera_tatencion=pg_fetch_result($resxpresdocum,0,'img_bandera_tatencion');

$varcodigo_documento=pg_fetch_result($resxpresdocum,0,'codigo_tramite');

$varcedresponventanil=pg_fetch_result($resxpresdocum,0,'usu_respons_edit');

$varmostrespventan="";
///////////////////CONSULTO RESPONSABLE
$sqlciudadverint = "SELECT * FROM public.tblu_migra_usuarios where usua_cedula='".$varcedresponventanil."';";
$verciudaencontr = pg_query($conn, $sqlciudadverint);
$varmostrespventan=" Nombres: ".pg_fetch_result($verciudaencontr,0,'usua_nomb')." ".pg_fetch_result($verciudaencontr,0,'usua_apellido')." Telefono: ".pg_fetch_result($verciudaencontr,0,'usua_telefono')." Email: ".pg_fetch_result($verciudaencontr,0,'usua_email');

///////////////////////consultor ciudadano
/*
$sqlciudadver = "SELECT count(*) FROM public.tbli_esq_plant_formunico_docsinternos where codi_barras='".$dargestrdmsbrras."' and  origen_cargo='CIUDADANO' ;";
$resverciudadanox = pg_query($conn, $sqlciudadver);
$varexisteciud=pg_fetch_result($resverciudadanox,0,0);
$varmostrarciudadan="";
if($varexisteciud >  1)
{
$sqlciudadverint = "SELECT origen_cedul,origen_nombres,origen_ciud_domicilio,origen_ciud_telefono,origen_ciud_email FROM public.tbli_esq_plant_formunico_docsinternos where codi_barras='".$dargestrdmsbrras."' and  origen_cargo='CIUDADANO' ;";
$verciudaencontr = pg_query($conn, $sqlciudadverint);
$varmostrarciudadan="Cédula: ".pg_fetch_result($verciudaencontr,0,'origen_cedul')." Nombres: ".pg_fetch_result($verciudaencontr,0,'origen_nombres')." Direccion: ".pg_fetch_result($verciudaencontr,0,'origen_ciud_domicilio')." Telefono: ".pg_fetch_result($verciudaencontr,0,'origen_ciud_telefono')." Email: ".pg_fetch_result($verciudaencontr,0,'origen_ciud_email');
}
*/
/////////////////////////////FIN DE CONSULTAR CIUDADANO

/*
$sqlcqr = "SELECT id, campo, descripcion FROM public.tbli_esq_plant_form_configqr where activo=1;";
$resconfigqr = pg_query($conn, $sqlcqr);
$content ="";
for($i=0;$i<pg_num_rows($resconfigqr);$i++)
{
	$content .=  pg_fetch_result($resconfigqr,$i,2).": ".pg_fetch_result($resultcitem,0,pg_fetch_result($resconfigqr,$i,1))."\n";
}
*/

$sqlvercoqr = "SELECT * FROM tbli_esq_plant_form_configqr where activo=1";
$resxpresqr = pg_query($conn, $sqlvercoqr);
for($g=0;$g<pg_num_rows($resxpresqr);$g++)
{
	 $content.= pg_fetch_result($resxpresqr,$g,"descripcion").": ".pg_fetch_result($resxpresdocum,0,pg_fetch_result($resxpresqr,$g,"campo"))."\n";
}

/*
 $content = "TRAMITE Nro: ".pg_fetch_result($resxpresdocum,0,"form_cod_barras")."\n CEDULA: ".pg_fetch_result($resxpresdocum,0,"cedula")."\n NOMBRES: ".pg_fetch_result($resxpresdocum,0,"ciud_nombres").' '.pg_fetch_result($resxpresdocum,0,"ciud_apellidos")."\n TRAMITE: ".pg_fetch_result($resxpresdocum,0,"origen_tipo_tramite")."\n DOCUMENTO: ".pg_fetch_result($resxpresdocum,0,"origen_tipo_doc")."\n DETALLE: ".pg_fetch_result($resxpresdocum,0,"sumillado_a_departamentos")."\n ESTADO: ".pg_fetch_result($resxpresdocum,0,"estadodoc");
*/
 
 QRcode::png($content,"../../../sip_bodega/codqr/".pg_fetch_result($resxpresdocum,0,"form_cod_barras")."_comp_qr.png",QR_ECLEVEL_L,10,2);

$verimgqrdado = "../../../sip_bodega/codqr/".pg_fetch_result($resxpresdocum,0,"form_cod_barras")."_comp_qr.png";
	
//////////////comprobar anexos de respuesta
$sqlanexresp="SELECT count(*)  FROM public.tbli_esq_plant_formunico_anexo where origen_codbarrasexp='".$_GET["varcodgenerado"]."' and anex_interno=1";
$resanexresp = pg_query($conn, $sqlanexresp);
$varnumdatosanexos=pg_fetch_result($resanexresp,0,0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <style type="text/css">    
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #dce7fa;*/
			/*overflow: hidden;*/
			/*font-family: verdana, arial, helvetica, sans-serif;*/
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
           
		}
		
	#layoutmenusuperderecha{
	background-color:#e7f1ff;
	width:100%;
	height: 100%;
	font-size: 11px;
	}
	
	div.tab_docsitems {
			/*color: blue;*/
			background-image:url(imgs/book.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
		
	div.tab_docsitemsciu {
			/*color: blue;*/
			background-image:url(imgs/user_add.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	div.tab_docsitemsinst {
			/*color: blue;*/
			background-image:url(imgs/btn_institucion.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	div.tab_docsitemstree {
			/*color: blue;*/
			background-image:url(imgs/btntreeseg.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	
			
	
</style>
<script>
	//carga de informacion
	var myLayout, myTabbar, mygrid;
	
	
function mostrarcodigoimpresion()
{
	window.open("../mod_ventanilla/service_imprimecods.php?micodappsc=<?php echo $_GET["varcodgenerado"]; ?>" , "ventanaimprim" , "width=700,height=500,scrollbars=NO");
	
}	
	
function mostrarcodigobarabig()
{
	//alert(varplantid);
	 var popupgeomap; 
    popupgeomap = window.open("vercodqr_zoom.php?mvpr=<?php echo $_GET["mvpr"]; ?>", "mostrafullmetad", "width=220,height=220,scrollbars=no");
    popupgeomap.focus();
	
}
	
function btn_elimarinfodoc()
	{
		 dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-error",
								text:"Confirma que desea Eliminar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="crea_eliminar_vista.php?vafil=<?php echo $_GET["mvpr"]; ?>";
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
	}	
	

function btn_archivarinfodoc()
	{
		dhtmlx.confirm({
								title:"Mensaje!",
								type:"confirm-warning",
								text:"Confirma que desea Archivar?",
								callback:function(result){
								if ( result )
						   			{
			                   			document.location.href="crea_archivar_vista.php?vafil=<?php echo $_GET["mvpr"]; ?>";
						  			 }
						   		else
						      			alert("Se cancelo la Operacion");
								}
							});
							
	}

function btn_reasignarinfodoc()
	{
		document.location.href="../../deparpersonal_reasign.php?vafil=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&varespuestusu=2";
	}
	
function btn_informarinfodoc()
	{
		document.location.href="../../deparpersonal.php?vafil=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&varespuestusu=3";
	}
	

function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Elementos Enviados..." , height: 80 } ,{id: "b", text: "Documentos Enviados..."  }  ]
				
			});
	
	    myLayout.cells("a").hideHeader();	
		//myLayout.cells("c").hideHeader();	
		//myLayout.cells("b").hideHeader();		
		myLayout.cells("a").attachObject("layoutmenusuperderecha");		
	  //  myLayout.cells("c").attachURL("arb_principal_codigos.php");
	   // myLayout.cells("b").attachObject("layoutinformatext");
	   
		myTabbar = myLayout.cells("b").attachTabbar({
				//parent: "accObj",
				tabs: [
					{id: "a1", text: "<div class='tab_docsitems'>-- INFORMACION --</div>" , active: true},
					{id: "a2", text: "<div class='tab_docsitemsciu'>-- ANEXOS DEL CIUDADANO  --</div>"},
					{id: "a3", text: "<div class='tab_docsitemstree'>-- RECORRIDO --</div>"},
					<?php if($varnumdatosanexos!=0) { ?>
					{id: "a4", text: "<div class='tab_docsitemsinst'>-- ANEXOS DE RESPUESTA  --</div>"},
					<?php } ?>
				]
			});
	
	
	myTabbar.tabs("a1").attachObject("layoutinformatext");			
	
	myTabbar.tabs("a2").attachURL("../mod_ventanilla/vistaform_anexos_ciud.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&verrmisfechas=<?php echo $_GET["verrmisfechas"]; ?>&vercodigotramitext=<?php echo $_GET["vercodigotramitext"]; ?>&vartxtciudcedula=<?php echo $_GET["vartxtciudcedula"]; ?>");
	
	myTabbar.tabs("a3").attachURL("../mod_docseguimtree/modtreeseguimext.php?enviocodid=<?php echo $_GET["mvpr"]; ?>");
	<?php if($varnumdatosanexos!=0) { ?>
    myTabbar.tabs("a4").attachURL("../mod_ventanilla/vistaform_anexos_instit.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>");
	<?php } ?>	
	 
   /////////////////////////////////////
	}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0"  onLoad="doOnLoad();">

<div id="layoutinformatext" style="background-color:#fff">
<table width="98%" border="0" align="center">
  
  <tr>
    <td bgcolor="#a6cbf7"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="28"><b>ID Tramite</b></td>
        <td  bgcolor="#e3e8ec"><?php echo $dargestrdmsbrras; ?>&nbsp;</td>
      </tr>
       <tr>
        <td height="28"><b>Codigo Documento</b></td>
        <td  bgcolor="#e3e8ec"><?php echo $varcodigo_documento; ?>&nbsp;</td>
      </tr>
      <tr>
        <td width="125" height="28"><b>Fecha:</b></td>
        <td width="461" bgcolor="#e3e8ec">Cotacachi,  <?php echo $dargestrdmsfecha; ?></td>
      </tr>
       <tr>
        <td height="28"><b>Ciudadano:</b></td>
        <td bgcolor="#e3e8ec">Cedula: <?php echo $dargestrdmscedul; ?> Nombre: <?php echo $dargestrdmsnoms; ?> Direccion: <?php echo $dargestrdmsolciudomi; ?> Telefono: <?php echo $dargestrdmsolciutelf; ?></td>
      </tr>
      
       <tr>
        <td height="28"><b>Responsable:</b></td>
        <td bgcolor="#e3e8ec"><?php echo $varmostrespventan;?>&nbsp;</td>
      </tr>
      
      <tr>
        <td height="28"><b>Para:</b></td>
        <td bgcolor="#e3e8ec"><?php echo $dargesolicitfuncnom.' - '.$dargesolicitfuncdep;?>&nbsp;</td>
      </tr>
     
      <tr>
        <td height="28"><b>Tipo Documento:</b></td>
        <td bgcolor="#e3e8ec"><?php echo $varorigen_tipodoc; ?></td>
      </tr>
      <tr>
        <td height="28"><b>Tipo de Tramite:</b></td>
        <td bgcolor="#e3e8ec"><?php echo $varorigen_tipo_tramite; ?></td>
      </tr>
      <tr>
        <td height="28"><b>Solicitud</b></td>
        <td  bgcolor="#e3e8ec"><?php echo $dargestrdmsolicit; ?>&nbsp;</td>
      </tr>
      <tr>
        <td height="28"><b>Estado</b></td>
        <td  bgcolor="#e3e8ec"><font color="#FF0000"><?php echo pg_fetch_result($resxpresdocum,0,"estadodoc"); ?></font>&nbsp;</td>
      </tr>
      
      <tr>
        <td height="28"><b>Respuesta</b></td>
        <td  bgcolor="#e3e8ec"><?php echo pg_fetch_result($resxpresdocum,0,"observacion"); ?>&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<div id="layoutmenusuperderecha" style="background-color:#ffffff">
<table width="100%" border="0">
      <tr>
        <td width="61%" height="85">
        
        <table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="25" height="60" align="center"><img src="imgs/menu_sup/esquinaizquierda.png" width="25" height="51"></td>
    <?php if($_SESSION['vermientipologusu']=="1" or $_SESSION['vermientipologusu']=="2" ) { ?>
    <td width="66" align="center"><a href="#" onClick="btn_elimarinfodoc()" ><img src="imgs/menu_sup/eliminar.gif" width="66" height="51"></a></td>
    <td width="66" align="center"><a href="#" onClick="btn_reasignarinfodoc()" ><img src="imgs/menu_sup/reasignar.gif" width="66" height="51"></a></td>
    <?php } ?>
    <td width="66" align="center"><a href="#" onClick="btn_archivarinfodoc()" ><img src="imgs/menu_sup/archivar.gif" width="66" height="51"></a></td>
    <td width="66" align="center"><a href="#" onClick="btn_informarinfodoc()" ><img src="imgs/menu_sup/informar.gif" width="66" height="51"></a></td>
    
    
    <td width="25" align="center"><img src="imgs/menu_sup/esquinaderecha.png" width="25" height="51"></td>
    <td width="437" align="center">&nbsp;</td>
  </tr>
  </table>
        
        
        </td>
        <td width="6%" align="center"><a href="#" onClick="mostrarcodigoimpresion();"><img src="imgs/btnimprimecods.png" width="50" height="50" /></a></td>
        <td width="16%" align="center"><a href="#" onClick="mostrarcodigobarabig();"><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0"></a>&nbsp;</td>
        <td width="17%" align="right"><?php
				
			require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator($dargestrdmsbrras,1,'barcode.gif', 180, 42, true);
  			echo '<img src="barcode.gif" width = "120" height="60" />'; 
		

	?></td>
    </tr>
      </table>
      
      





</div>

</body>
</html>