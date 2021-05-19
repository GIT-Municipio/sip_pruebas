<?php
session_start();
$latabla='tblu_migra_usuarios';
$devuelveidprin=$_SESSION["ses_usuariosesid"];

require_once('../../clases/conexion.php');

$sql = "SELECT  * from ".$latabla;
$resul = pg_query($conn, $sql);
/////CUANDO SE TENGA DATOS PARA ACTUALIZAR
//$_GET['opt']='nuevo';
if(isset($_GET['opt'])=='nuevo')
	$numerdatos=0;
else
	$numerdatos=pg_num_rows($resul);
//para realizar un nuevo
/////////////////////
if($numerdatos!=0)
{
$devuelveidprin= pg_fetch_result($resul,0,0);
$devuelveidprov= pg_fetch_result($resul,0,1);
$devuelveidcan= pg_fetch_result($resul,0,2);
}
/*
$sqlins = "SELECT  cedula_ruc from data_institucion ";
$resulinsgad = pg_query($conn, $sqlins);
$numerdatinst=pg_num_rows($resulinsgad);
if($numerdatinst!=0)
{
$devuelveidprinst= pg_fetch_result($resulinsgad,0,0);
}
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Institucion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
        <script src="../../lib_jquery/jquery.easyaudioeffects.1.0.0.min.js"></script>
    <script src="../../lib_jquery/jquery-1.12.2.min.js"></script>
     <script src="php/connector/dhtmlxdataprocessor.js"></script>
      <style type="text/css"> 

	html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #ebebeb;*/
			overflow: hidden;
			/*font-size: 10px;*/
		}
		
	      div#simpleLog {
			width: 500px;
		/*	height: 300px;*/
			font-family: Tahoma;
			font-size: 11px;
			overflow: auto;
			/*margin-top: 10px;*/
		}
		
		div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(../../componentes/common/imgs/guardar.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../../componentes/common/imgs/cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		
		div#datosfisl{
			height: 500px;
			}
		
	</style>
	<script>
		var myForm, formData, myPop, logObj;
		var myIds;
		var dp;
		function doOnLoad() {
			formData = [
				{type: "settings", position: "label-left", labelWidth: 110, inputWidth: "auto"},
			{type: "fieldset", label: "Clasificacion Documental - Generador de Codigos",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 380, list:[
					{type: "hidden", label: "id", width: 195, name: "id", value: ""},
							
			//{type: "calendar", label: "Año Actual", dateFormat: "%Y", width: 195,  name: "anio_actual", value: "", required: true},
			{type: "input", label: "Año Actual", width: 195,  name: "anio_actual", value: "", required: true, validate: "NotEmpty,ValidNumeric"},
			//{type: "input", label: "Codigo Inicial", width: 195,  name: "numer_inicial", value: "" },
			//{type: "input", label: "Codigo Final", width: 195,  name: "numer_final", value: ""},

{type:"newcolumn"},
		{type: "button", value: ">>>  Generar <<<", name: "send", offsetLeft: 10,  width: 100, className: "button_save"},			
		{type:"newcolumn"},
        {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 10,  width: 100, className: "button_cancel"}			

				]},
			];
			
			myForm = new dhtmlXForm("myForm", formData);
			////////////eventos formularios
			
			
            /*
			myForm.attachEvent("onFileAdd",function(realName){
				//logEvent("<b>onFileAdd</b>, real name: "+realName);
				myForm.setItemValue("imglogo", "../galeriaimgs/"+realName);
			});
			myForm.attachEvent("onUploadFile",function(realName, serverName){
				//logEvent("<b>onUploadFile</b>, real name: "+realName+", server name: "+serverName);
			});
			myForm.attachEvent("onUploadComplete",function(count){
				//logEvent("<b>onUploadComplete</b> "+count+" file"+(count>1?"s were":" was")+" uploaded");
			});
			myForm.attachEvent("onUploadFail",function(realName){
				//logEvent("<b>onUploadFail</b>, file: "+realName);
			});
			
			myForm.attachEvent("onChange", function(name, value){
				
				//logEvent("onChange, item name '"+name+"', value '"+value.toString()+"'<br>");
				if(name=="provincia")
				myForm.reloadOptions("canton", "php/options_canton.php?t=combo&niv="+value.toString());
				if(name=="canton")
				myForm.reloadOptions("parroquia", "php/options_parroquia.php?t=combo&niv="+value.toString());
				
			});
			*/
			/*myForm.attachEvent("onChange", function(){
				console.log(arguments)
			});
			*/
			<?php 
			/*
			if($devuelveidprin!="")
			    echo 'myForm.load("php/datapersonal.php?id='.$devuelveidprin.'")';
			else
			    echo 'myForm.load("php/datapersonal.php")';
			*/
			?>
			
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				
				
				if (id == "cancel") 
				{
					document.location.href="lista_data.php";
				}
				
				if (id == "send") 
					{
						
						 myForm.send("php/data_generar_codsanual.php", function(loader, response){
						    //alert(response);
							
							if(response=='error1')
							dhtmlx.alert({ title:"Mensaje",type:"confirm-error",text:"El Año debe ser mayor!!..."}); 
							if(response=='error2')
							dhtmlx.alert({ title:"Mensaje",type:"confirm-error",text:"Ya existen registros con el año ingresado"}); 
							
							if(response=='ok')
							{
								dhtmlx.alert({
								title:"Mensaje!",
						  		//  type:"confirm",
						    	text: "Se Registro con exito!!",
						    	callback: function() { document.location.href="lista_data.php"; }
								});
							}
							/////////////////////////////////
					      });
					
						
						 /*dhtmlx.alert({
								title:"Mensaje!",
								//type:"alert-error",
								text:"Se guardo con exito"
							});
							*/
							
							
					}
			});
			
			//////////////////////////mostrar ayuda popup
		/*	myPop = new dhtmlXPopup({ form: myForm, id: ["cedula_ruc","nombre","imglogo","provincia","canton","parroquia","calle_principal","calle_interseccion","numero_predio","referencia_cercana","autoridad_nombre","autoridad_cargo","autoridad_cedula","autoridad_represlegal","autoridad_cedula_represlegal","delegado_cedula","delegado_nombre","delegado_cargo","delegado_nrodocumento_delegacion","delegado_fecha_resolucion","vision","mision"]  });
			myPop.attachHTML("Por favor ingrese el dato");
			*/


			
			myIds = {
			"cedula": "Cedula del Usuario",
			"nombres": "Nombres Completos",
			"apellidos": "Apellidos",
			"cargo": "Cargo que tiene en la Institucion",
			"titulo": "Titulo Profesional",
			"email": "Email para contactar",
			"telefono": "Telefono fijo o celular",
		    };
			
			
			myForm.attachEvent("onFocus", function(name){
					if (!myIds[name]) return;
					if (!myPop) {
						var id2 = [];
						for (var a in myIds) id2.push(a);
						myPop = new dhtmlXPopup({form: myForm, id: id2});
					}
					myPop.attachHTML("<div style='margin: 5px 10px;'>"+myIds[name]+"</div>");
					myPop.show(name);
				});
				
			myForm.attachEvent("onBlur", function(id,value){
				window.setTimeout(function(){
					if ((id+value||"") == itemId) myPop.hide();
				},1);
			});
			
			myForm.attachEvent("onKeyUp",function(inp,ev,id,value){
				if (id=='nombre') {
					inp.value=inp.value.toUpperCase();
				}
			});
			
			
			///////////////para valiacion de errores
			var text = "";
			myForm.attachEvent("onBeforeValidate", function() {
       			 text = "";
		       		return true;
		    });
			
		    myForm.attachEvent("onValidateError", function(obj, value, res) {
		        //text += obj.name + " : " + res + "\n";
				text += obj + " : " + value + "<br>";
				
				
		    });
		    myForm.attachEvent("onAfterValidate", function() {
        		if (text);
			   //  alert(text);
			   dhtmlx.message("Los siguientes campos deben ser validados: <br>"+text);
		    });
			///////////////////////////fin de popup
			
			dp = new dataProcessor("php/datapersonal.php");
			dp.init(myForm);
		}
		
		function logEvent(t) {
			if (!logObj) logObj = document.getElementById("simpleLog");
			logObj.innerHTML += t;
		}
		
	</script>
</head>
<body onload="doOnLoad();">
<form id="realForm" method="POST" enctype="multipart/form-data"  >
<table width="200" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
</form>
 <div id="simpleLog"></div>
 
 
<script>
    jQuery(document).ready(function (){
var audioArray = document.getElementsByClassName('songs');
var i = 0;
audioArray[i].play();
for (i = 0; i < audioArray.length - 1; ++i) {
    audioArray[i].addEventListener('ended', function(e){
        var currentSong = e.target;
        var next = $(currentSong).nextAll('audio');
        if (next.length) $(next[0]).trigger('play');
    });
}
});
</script>


  
  
</body>
</html>
