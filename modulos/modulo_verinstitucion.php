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
$latabla='tblb_org_institucion';


require_once('../clases/conexion.php');

//require_once('../conexion.php');
$numerdedatos=0;
$sql = "SELECT  cedula_ruc,provincia,canton from ".$latabla;
$resul = pg_query($conn, $sql);
$numerdatos=pg_num_rows($resul);
if($numerdatos!=0)
{
 $devuelveidprin= pg_fetch_result($resul,0,0);
$devuelveidprov= pg_fetch_result($resul,0,1);
$devuelveidcan= pg_fetch_result($resul,0,2);
$_SESSION["rucinstituciontxtid"]=$devuelveidprin;
}

/////////////////para los departamentos
$latabladepart='tblb_org_departamento';  /////son clave
$elsubcamponombre='nombre_departamento';    ////campos importantes   ///son clave
$elidprinorder='id';     ///////////////son claves
$elsubcampoenlace='parent_id';     ///////////////son claves
$elsubcampoenlacenro='7';

$sql = "SELECT  id, nombre_departamento, telf_extension, nom_responsable, email, telf_personal, objetivo, parent_id from ".$latabladepart." order by id";
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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../componentes/codebase/dhtmlx.css"/>
	<script src="../componentes/codebase/dhtmlx.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijRV_pwtxTxIXMD4NMdVn02aknb6NJYI"   type="text/javascript"></script>
    
    	<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
/*			background-color: #dce7fa;*/
			background-color: #dce7fa;
			overflow: hidden;
			font-family: verdana, arial, helvetica, sans-serif;
		}
		


#menuinferiordiv:hover{
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


#menuinferiordiv{
background-color:#ecf2ff;
background:linear-gradient(#c8dbf9,#94abcb);
box-shadow: 3px 3px 10px #000;
border-radius: 10px;
font-family:inherit;
font-size: 10px;
font-weight: bold;
text-transform: none;
width: 70px;
}


#menusuperiordiv:hover{
background-color:#ecf2ff;
background:linear-gradient(#fffad0,#f3c767);
box-shadow: 3px 3px 10px #6489ba;
border-radius: 10px;
font-family:inherit;
font-size: 10px;
/*font-weight: bold;*/
text-transform: none;
width: 35px;
height: 60px;
}


#menusuperiordiv{
background-color:#ecf2ff;
background:linear-gradient(#d3e7ff,#ddebff);
box-shadow: 3px 3px 10px #6489ba;
border-radius: 10px;
font-family:inherit;
font-size: 10px;
/*font-weight: bold;*/
text-transform: none;
width: 35px;
height: 60px;
}

	</style>
	<script>
		var myLayout, myAcc, myForm, formData, myForm1, myForm2, myForm3, myForm4, myForm5, GMaps;
	    
		function abrirPopMetainsti()
		{
             document.location.href="config_institucion/form_data_institucion.php";
		};
	
	
	
		function doOnLoad() {
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				//parent: "layoutObj",
				pattern: "3L",
				cells: [{id: "a", text: "Sistema de Informacion Provincial", width: 370, height: 140   },{id: "b", text: "PROYECTOS"  },{id: "c", text: "DEPARTAMENTOS"} ]
				
			});
			
			
			myAcc = myLayout.cells("a").attachAccordion({
				icons_path: "../componentes/common/icons/",
				items: [
					{ id: "a1", text: "Institucion", icon: "misionvision.png" },
					{ id: "a2", text: "Ubicacion", icon: "ubicaciontbn.png" },
					{ id: "a3", text: "Datos Autoridad", icon: "usuarioautor.png" },
					{ id: "a4", text: "Datos Institucion", icon: "usuarioautordelegado.png" },
					{ id: "a5", text: "Datos Autoridad", icon: "misionvision.png" }
				]
			});
			
           ///////////////////////////datos
			formDatagenral = [
				{type: "settings", position: "label-left", labelWidth: 145, inputWidth: 180},
				{type: "block", inputWidth: "auto", offsetTop: 12, list: [
					{type: "template", label: "RUC:", name: "cedula_ruc", value: "p_ponedato"},
					{type: "template", label: "NOMBRE:", name: "nombre", value: "p_ponedato"},
					{type: "template", label: "PROVINCIA:", name: "provincia", value: "p_ponedato"},
					/*{type: "template", label: "LOGO:",name: "imglogo", value: "p_ponedato"},*/
					{type: "image", name: "imglogo", label: "LOGO:", imageWidth: 126, imageHeight: 126, url: "config_institucion/php/type_image/dhxform_image.php"},
					{type: "template", name: "link", label: "", value: "dhtmlx.com",    format:format_imgmetadato},
				//	{type: "button", value: "Guardar", name: "send", offsetLeft: 70, offsetTop: 14}
				]}
			];
			
			formDataubicacion = [
				{type: "settings", position: "label-left", labelWidth: 145, inputWidth: 180},
				{type: "block", inputWidth: "auto", offsetTop: 12, list: [
					{type: "template", label: "CANTON:", name: "canton", value: "p_ponedato"},
					{type: "template", label: "PARROQUIA:", name: "parroquia", value: "p_ponedato"},
					{type: "template", label: "CALLE PRINCIPAL:", name: "calle_principal", value: "p_ponedato"},
				{type: "template", label: "CALLE INTERSECCION:", name: "calle_interseccion", value: "p_ponedato"},
					{type: "template", label: "REFERENCIA CERCANA:", name: "referencia_cercana", value: "p_ponedato"},
					//{type: "button", value: "Guardar", name: "send",  offsetLeft: 70, offsetTop: 14}
				]}
			];
			
			formDataautoridad = [
				{type: "settings", position: "label-left", labelWidth: 145, inputWidth: 180},
				{type: "block", inputWidth: "auto", offsetTop: 12, list: [
					{type: "template", label: "NOMBRE:", name: "autoridad_nombre", value: "p_ponedato"},
					{type: "template", label: "CARGO:", name: "autoridad_cargo", value: "p_ponedato"},
					{type: "template", label: "CEDULA:", name: "autoridad_cedula", value: "p_ponedato"},
					{type: "template", label: "REPRESENTANTE LEGAL:", name: "autoridad_represlegal", value: "p_ponedato"},
					{type: "template", label: "CEDULA REPRESENTANTE:", name: "autoridad_cedula_represlegal",  value: "p_ponedato"},
					//{type: "button", value: "Guardar", name: "send",  offsetLeft: 70, offsetTop: 14}
				]}
			];
			
			formDatadelegado = [
				{type: "settings", position: "label-left", labelWidth: 145, inputWidth: 180},
				{type: "block", inputWidth: "auto", offsetTop: 12, list: [
					{type: "template", label: "CEDULA:", name: "delegado_cedula", value: "p_ponedato"},
					{type: "template", label: "NOMBRE:", name: "delegado_nombre", value: "p_ponedato"},
					{type: "template", label: "CARGO:", name: "delegado_cargo", value: "p_ponedato"},
					{type: "template", label: "DOCUMENTO DELEGACION:", name: "delegado_nrodocumento_delegacion", value: "p_ponedato"},
					{type: "template", dateFormat: "%Y-%m-%d", label: "FECHA DELEGACION:", name: "delegado_fecha_resolucion", value: "2011-06-20", enableTime: false, calendarPosition: "right"},
				//	{type: "button", value: "Guardar", name: "send",  offsetLeft: 70, offsetTop: 14}
				]}
			];

			formDatamisionvision = [
				{type: "settings", position: "label-left", labelWidth: 145, inputWidth: 180},
				{type: "block", inputWidth: "auto", offsetTop: 12, list: [
					{type: "template", label: "VISION", name: "vision", value: "p_ponedato"},
					{type: "template", label: "MISION", name: "mision", value: "p_ponedato"},
					//{type: "button", value: "Guardar", name: "send",  offsetLeft: 70, offsetTop: 14}
				]}
			];
			
						
			myForm1 = myAcc.cells("a1").attachForm(formDatagenral);
			myForm2 = myAcc.cells("a2").attachForm(formDataubicacion);
			myForm3 = myAcc.cells("a3").attachForm(formDataautoridad);
			myForm4 = myAcc.cells("a4").attachForm(formDatadelegado);
			myForm5 = myAcc.cells("a5").attachForm(formDatamisionvision);
			
			
			<?php 
			if($devuelveidprin!="")
			{
			    echo 'myForm1.load("config_institucion/php/datainstitucion.php?id='.$devuelveidprin.'");';
			    echo 'myForm2.load("config_institucion/php/datainstitucion.php?id='.$devuelveidprin.'");';
			    echo 'myForm3.load("config_institucion/php/datainstitucion.php?id='.$devuelveidprin.'");';
			    echo 'myForm4.load("config_institucion/php/datainstitucion.php?id='.$devuelveidprin.'");';
			    echo 'myForm5.load("config_institucion/php/datainstitucion.php?id='.$devuelveidprin.'");';
			}
			else
			{
			    echo 'myForm1.load("config_institucion/php/datainstitucion.php");';
			    echo 'myForm2.load("config_institucion/php/datainstitucion.php");';
			    echo 'myForm3.load("config_institucion/php/datainstitucion.php");';
			    echo 'myForm4.load("config_institucion/php/datainstitucion.php");';
			    echo 'myForm5.load("config_institucion/php/datainstitucion.php");';
			}			
			?>

			/*
			myForm1.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "send") 
				{
					myForm1.save();
					dhtmlx.alert({
								title:"Mensaje!",
								//type:"alert-error",
								text:"Se guardo con exito"
							});
				}
			});
			*/
			
			
			
			//////////////////////////////////final
			///////////////////////////////////////SIGUIENTE VENTANA
			myTabbar = myLayout.cells("b").attachTabbar({
				tabs: [
					{ id: "tab1", text: "Ubicacion Geografica", active: true },
					//{ id: "tab2", text: "Proyectos Archivados" }
				]
			});
			
			
			var customparams = {
    		center: new google.maps.LatLng(0.349854, -78.118396),
    		zoom: 10,
   				 //disableDefaultUI: true,
   			 mapTypeId: google.maps.MapTypeId.ROADMAP
    		};
			
			
			GMaps = myTabbar.tabs("tab1").attachMap();
			///////////////////////////////////// localizacion de datos
			var geocoder = new google.maps.Geocoder();
            geocoder.geocode( { 'address': 'Cotacachi, Imbabura'}, function(results, status) {
            GMaps.setCenter(results[0].geometry.location);
                  var marker = new google.maps.Marker({
                      position: results[0].geometry.location,
                      title:"dhtmlx Mailing Address"
                  });
                  marker.setMap(GMaps);
                  var infowindow = new google.maps.InfoWindow({
                      content: '<b>GAD Municipal Santa Ana de Cotacachi</b>'
                  });
                  infowindow.open(GMaps,marker);
   			 });
			/////////////////////////////////////
			//myForm8 = myTabbar.cells("tab1").attachForm(formDatagenral);
			
			////////////////////////////ULTIMA VENTANA/////////////////////
			tree = myLayout.cells("c").attachTree();
			tree.setSkin('dhx_skyblue');
			tree.setImagePath("../componentes/codebase/imgs/dhxtree_skyblue/");
            tree.enableDragAndDrop(true);
            //tree.enableItemEditor(true);
			tree.loadXML("config_departamentos/php/oper_get_arbol_depart.php?mitabla=<?php echo $latabladepart;?>&minombredato=<?php echo $elsubcamponombre ;?>&elidprincipal=<?php echo $elidprinorder ;?>&ref_parent_padre=<?php echo $elsubcampoenlace ;?>");
            ////metodos para guardar en el arbol
        	myDataProcessortree = new dataProcessor("config_departamentos/php/oper_update_arbol_depart.php?mitabla=<?php echo $latabladepart;?>&minombredato=<?php echo $elsubcamponombre ;?>&elidprincipal=<?php echo $elidprinorder ;?>&ref_parent_padre=<?php echo $elsubcampoenlace ;?>");
        	//add after-update event handler
			/*myDataProcessor.attachEvent("onAfterUpdate",function(nodeId,cType,newId){
				doLog("Item was "+cType+"ed. Item id is " + newId)
			});*/

			myDataProcessor.init(tree);
			/*
			myTree.setSkin('dhx_skyblue');
			myTree.setImagePath("../../../codebase/imgs/dhxtree_skyblue/");
            myTree.enableDragAndDrop(true);
            myTree.enableItemEditor(true);
			myTree.loadXML("php/get.php?mitabla=<?php echo $latabladepart; ?>&enviocampos=<?php echo $camposver; ?>");
			*/
			 function format_imgmetadato(name, value) 
			    {
			if (name == "link") return "<div class='simple_link'><a href='#' style='text-decoration: none;' onclick='abrirPopMetainsti()' ><br/><table width='70' ><tr><td> <img src='../componentes/common/48/confisystem.png' width='64' height='60' /><font  color='#FF0000'>Actualizar</font></td></tr></table>&nbsp;</a></div>";
		      	}
/////////////////////////////////////////////////////////////////
		}
	</script>
</head>
<body onLoad="doOnLoad();">
</body>
</html>