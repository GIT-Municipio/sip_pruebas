<?php

require_once('../../conexion.php');



$latabla='data_prestamos';  /////son clave
$elsubcamponombre='nombrecapa';    ////campos importantes   ///son clave
$elidprinorder='id';     ///////////////son claves
//$elsubcampoenlace='ref_idmenuwebp';     ///////////////son claves
$nombremodulotabla='CATALOGO GEOGRAFICO';

 //$sql = "select idcapageo, nombremenu, label, geometria,idcodcatalogo from vercapasgeograficas;";
$sql = "SELECT id, solic_cedula, solic_nombres, solic_cargo, solic_depart, solic_jefatura, solic_dias, solic_fecha_desde, solic_fecha_hasta, solic_horas, solic_hora_desde, solic_hora_hasta,img_estado FROM public.data_prestamos;";

$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

$elsubcampoenlace="";
$numerdedatos="";

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

$sqlfeh = "select now()";
$resfeh = pg_query($conn, $sqlfeh);
$varfechactual=pg_fetch_result($resfeh,0,0);


?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../gap/componentes/codebase/dhtmlx.css"/>
	<script src="../gap/componentes/codebase/dhtmlx.js"></script>
    <script src="../gap/componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    
    <script type="text/javascript">
	
	function imprimirmap()
  {
	   if ((navigator.appName == "Netscape")) { window.print() ; 
        } 
        else { 
            var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
            document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
        } 
  };
	
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
	
	function creaciondelmapa()
	{
		var resulsol = prompt ("Ingrese el Nombre del Mapa Tematico","MAPA TEMATICO");
		if (resulsol == null)
			 alert("No se creo el Mapa");
		else
		     document.location.href='crearmapatematico.php?envnommp='+resulsol+' ';
	       
	}
	
	function previsualdelmapa()
	{
	var miPopimpresionxgrf;
	miPopimpresionxgrf = window.open("../../index.phtml","mostrarmapawindgrafaux","width=1000,height=600,scrollbars=no,left=400");
	miPopimpresionxgrf.focus();
	}
	
	function consultarmetadato()
	{
		var midcapgeo=document.getElementById("poneridgeocap").value;
			//alert(midcapgeo);
		if(midcapgeo!="")
		{
			var miPopupadminmetadatos;
			miPopupadminmetadatos = window.open("../gis_cat_datometadato/presentametadato.php?laopt=1&micapageoid="+midcapgeo,"mostrarmapawindconfig","width=650,height=530,scrollbars=no");
			miPopupadminmetadatos.focus();
		}
		else
				alert("Seleccione una capa");
	
	}
	
	function consultartabla()
	{
		var midcapgeo=document.getElementById("poneridgeocap").value;
			//alert(midcapgeo);
		if(midcapgeo!="")
		{
			var miPopupadminmetadatos;
			miPopupadminmetadatos = window.open("../gis_mostratablas/tabla_ini.php?laopt=1&micapageoid="+midcapgeo,"mostrargeotabla","width=700,height=500,scrollbars=no");
			miPopupadminmetadatos.focus();
		}
		else
				alert("Seleccione una capa");
	
	}
	
	function consultarestilos()
	{
		var midcapgeo=document.getElementById("poneridgeocap").value;
			//alert(midcapgeo);
		if(midcapgeo!="")
		{
			var miPopupadminmetadatos;
			miPopupadminmetadatos = window.open("capageo_propiedades.php?laopt=1&micapageoid="+midcapgeo,"mostrarmapawindconfig","width=600,height=540,scrollbars=no");
			miPopupadminmetadatos.focus();
		}
		else
				alert("Seleccione una capa");
	}

     function consulmapeoindicad()
	{
		var midcapgeo=document.getElementById("poneridgeocap").value;
			//alert(midcapgeo);
		if(midcapgeo!="")
		{
			var miPopupadminmetadatos;
			miPopupadminmetadatos = window.open("../gis_cat_datometadato/presentametadato.php?laopt=1&micapageoid="+midcapgeo,"mostrarmapawindconfig","width=650,height=530,scrollbars=no");
			miPopupadminmetadatos.focus();
		}
		else
				alert("Seleccione una capa");
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
			/*font-family: verdana, arial, helvetica, sans-serif;*/
           
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
		
#menutopsupervis{
width:100%;background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255));border: 1px solid #a4bed4; height:29px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;text-decoration: none;  	
	}

div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(imgs/acepload.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
			/*height: 100px;*/
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../../images/menus//cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
			
</style>
<script>
	//carga de informacion
	var myLayout, myTabbar, mygrid, myForm;

function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Formulario de Permisos",  height: 360  },{id: "b", text: "Mis Permisos..."  } ]
				
			});
	
	///////////////////////////////////////////////FORMULARIOS
	formData = [
  {type: "settings", position: "label-left", labelWidth: 90, inputWidth: 120},
	{type: "fieldset", label: "Datos Personales: ",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 600, list:[		
					//{type: "newcolumn"},
		  {type: "input", label: "Fecha", name: "fecha", width: 150, readonly: "true", value: "<?php echo $varfechactual; ?>"},
		  {type:"newcolumn"},
		  {type: "input", label: "Cedula", offsetLeft: 15, width: 150,   name: "solic_cedula", value: "<?php echo $_SESSION['vermientuscedula']; ?>"},
		  {type:"newcolumn"},
		  {type: "input", label: "Nombres",  width: 150,  name: "solic_nombres", value: "<?php echo $_SESSION['vermientnomusu']; ?>"},
		  {type:"newcolumn"},
		  {type: "input", label: "Cargo", offsetLeft: 15, width: 150,  name: "solic_cargo", value: "<?php echo $_SESSION['vermientnomcargousu']; ?>"},
		  {type:"newcolumn"},
		  {type: "input", label: "Departamento",  width: 150, name: "solic_depart", value: "<?php echo "Dirección de Planificación"; ?>"},
		  {type:"newcolumn"},
		  {type: "input", label: "Jefatura", offsetLeft: 15, width: 150,  name: "solic_jefatura", value: "<?php echo $_SESSION['vermientnomdepartameusu']; ?>"},

		  ]},
		
		{type: "fieldset", label: "Tiempo: ",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 600, list:[		
		 
		  {type: "calendar", dateFormat: "%Y-%m-%d",  width: 70, name: "solic_fecha_desde",  label: "Fecha Desde", value:"<?php echo $varfechactual; ?>", enableTime: true, calendarPosition: "right"},
		   {type:"newcolumn"},
		  {type: "calendar", dateFormat: "%Y-%m-%d", offsetLeft: 15, width: 70, name: "solic_fecha_hasta", label: "Fecha Hasta", value:"<?php echo $varfechactual; ?>", enableTime: true, calendarPosition: "right"},
		   {type:"newcolumn"},
		    {type: "input", label: "Dias", offsetLeft: 15, width: 70, name: "solic_dias", value: "0"},
		   {type:"newcolumn"},
		  {type: "calendar", dateFormat: "%H:%i",  width: 70, name: "solic_hora_desde", label: "Hora Desde", value:"<?php echo $varfechactual; ?>", enableTime: true, calendarPosition: "right"},
		  {type:"newcolumn"},
		  {type: "calendar", dateFormat: "%H:%i", offsetLeft: 15, width: 70, name: "solic_hora_hasta", label: "Hora Hasta", value:"<?php echo $varfechactual; ?>", enableTime: true, calendarPosition: "right"},
		  {type:"newcolumn"},
		   {type: "input", label: "Horas", offsetLeft: 15, width: 70, name: "solic_horas", value: "0"},
		  {type:"newcolumn"},
	
]},
{type: "fieldset", label: "Adjuntar Archivos Justificacion: ",  offsetLeft: 5, offsetRight: 5,  offsetTop: 0, inputWidth: 600, list:[
{type: "upload", name: "myFiles", inputWidth: 310,   offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
]},
{type:"newcolumn"},
{type: "fieldset", label: "Motivo: ",  offsetLeft: 5, offsetRight: 5,  offsetTop: 0, inputWidth: 560, list:[		
					//{type: "newcolumn"},
		   {type: "checkbox", name: "motiv_enfer_iess",   labelWidth: 200, label: "Enfermedad(Adjuntar Certif. IESS)"},
		   {type: "checkbox", name: "motiv_fallecim_familiar", labelWidth: 200,  label: "Fallecimiento de familiar"},
		   {type: "checkbox", name: "motiv_tramite_institut", labelWidth: 200,  label: "Tramites Institucionales"},
		   {type: "checkbox", name: "motiv_asunpers_cargvacacion",labelWidth: 200,   label: "Asuntos personales(cargo a vacacion)"},
		   {type: "checkbox", name: "motiv_reposic_diaslab", labelWidth: 200,  label: "Reposicion de dias laborados extras"},
		   {type: "checkbox", name: "motiv_calamidad_domest", labelWidth: 200,  label: "Calamidad domestica"},
	       {type: "checkbox", name: "motiv_otros", labelWidth: 200,  label: "Otros"},
		   {type: "newcolumn"},
		   {type: "editor", name: "txtelasuntoresp", label: "", inputWidth: 280, inputHeight: 228, value: "Describa o Explique el Motivo"},
		   
		   {type:"newcolumn"},
{type: "button", value: ">>>  ACEPTAR <<<", name: "send", offsetLeft: 200,offsetTop: 20,  width: 160,   className: "button_save"}
		
]},

				
			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onChange", function(name,value,is_checked){
				/*if(name=='solic_fecha_hasta')
				{
				      devuelvediasentrefechas();
				}*/
				
			});
			
			myForm.attachEvent("onUploadComplete",function(count){
				//alert("todo bien");
			    myGrid.load("php/get_xusuario_peticion.php?mitabla=<?php echo "tbli_esq_plant_formunico_th_permisos"; ?>&enviocampos=<?php echo "solic_cedula, solic_nombres, solic_cargo, solic_depart, solic_jefatura, solic_dias, solic_fecha_desde, solic_fecha_hasta, solic_horas, solic_hora_desde, solic_hora_hasta"; ?>&envioclientid=<?php echo $_GET["mvpr"]; ?>");
			});
			
			////////////////////eventos boton
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "cancel") 
				{
					document.location.href="form_permisos.php";
				}
				
				if (id == "send") 
					{
						 myForm.send("php/dato_actual_permisos.php", function(loader, response){
						            
									dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Su permiso a sido emitido!!",
						    		callback: function() {
								        myLayout.cells("a").collapse();	
										 mygrid.loadXML("php/get_xusuario_peticion.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>");	//used just
							
									}
									});
					      });
							
							
					}
			});
			///////////////////////////////////////FIN DE FORMULARIOS
	 //carga de informacion///////////////////
                    mygrid = new dhtmlXGridObject('gridbox');
                    mygrid = myLayout.cells("b").attachGrid();   ////codigo para poner la grilla
                   mygrid.setImagePath("../gap/componentes/codebase/imgs/");
                    mygrid.setHeader("<?php echo $camposver; ?>");
                  //  mygrid.attachHeader("<?php echo $filtrocampos; ?>");
                  //  mygrid.setInitWidths("<?php echo $tamcamposver; ?>");
				  mygrid.setInitWidths("50,100,100,100,100,100,100,100,100,100,100,100");

                    mygrid.setColAlign("<?php echo $posicamposver; ?>");
                    //mygrid.setColTypes("<?php echo $tipocamposver; ?>");
					mygrid.setColTypes("dyn,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,img");


                   // mygrid.setSkin("dhx_skyblue");
                    mygrid.setColSorting("<?php echo $tipcamposorden; ?>");
                    mygrid.init();
                    mygrid.loadXML("php/get_xusuario_peticion.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>");	//used just
                    mygrid.enableEditEvents(false, false, false);
	
	
   /////////////////////////////////////
	}
</script>

</head>
<body onLoad="doOnLoad();">
<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>
</body>
</html>