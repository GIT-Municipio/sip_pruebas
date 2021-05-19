<?php

session_start();

$latabla='tblu_migra_usuarios';
$devuelveidprin="";

require_once('../../clases/conexion.php');

$sql = "SELECT  * from ".$latabla." where id='".$_GET["valorusuid"]."'";
$resul = pg_query($conn, $sql);
/////CUANDO SE TENGA DATOS PARA ACTUALIZAR
//$_GET[opt]='nuevo';
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
$devuelveidprin=$_GET['valorusuid'];
$devuelveemailusu= pg_fetch_result($resul,0,"usua_email");

$devuelveemailusu= pg_fetch_result($resul,0,"usua_email");


$varelidusu= pg_fetch_result($resul,0,"id");
$varcedula= pg_fetch_result($resul,0,"usua_cedula");
$varapellidos= pg_fetch_result($resul,0,"usua_apellido");
$varnombres= pg_fetch_result($resul,0,"usua_nomb");
$varloginuser= pg_fetch_result($resul,0,"usua_login");
/*$varsexo= pg_fetch_result($resul,0,"sexo");
$varestado_civil= pg_fetch_result($resul,0,"estado_civil");
$varnacionalidad= pg_fetch_result($resul,0,"nacionalidad");
$vardireccion= pg_fetch_result($resul,0,"direccion");
$vartelf_celular= pg_fetch_result($resul,0,"telf_celular");
*/
$vardireccion= pg_fetch_result($resul,0,"usua_email");
$vartelf_celular= pg_fetch_result($resul,0,"usua_telefono");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
     <script src="php/connector/dhtmlxdataprocessor.js"></script>
      <style>
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
			{type: "fieldset", label: "Mi Perfil",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 780, list:[
					{type: "hidden", label: "id", width: 195, name: "id", value: "<?php if($varelidusu!="") echo $varelidusu; ?>"},
    {type: "fieldset", label: "Usuario",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 360, list:[
					//{type: "combo", label: "Tipo Usuario", name: "tipo_usuario", value: "0", width: 195, filtering: true, connector: "../parametros/options_tipo_usuario.php?t=combo"},
					{type: "input", label: "Cedula", width: 195, name: "cedula", value: "<?php if($varcedula!="") echo $varcedula; ?>", required: true,readonly : "true" },
					{type: "input", label: "Nombres", width: 195, name: "nombres", value: "<?php if($varnombres!="") echo $varnombres; ?>", required: true, validate: "NotEmpty",readonly : "true" },
					{type: "input", label: "Apellidos", width: 195, name: "apellidos", value: "<?php if($varapellidos!="") echo $varapellidos; ?>", required: true, validate: "NotEmpty",readonly : "true" },
					{type: "input", label: "Usuario", width: 195, name: "usuario", value: "<?php if($varloginuser!="") echo $varloginuser; ?>", required: true, validate: "NotEmpty" },
					{type: "password", label: "Clave", width: 195, name: "clave", value: "" },
					/*
{type: "combo", label: "Sexo", name: "sexo", value: "<?php if($varsexo!="") echo $varsexo; ?>", width: 195, filtering: true, connector: "php/options_tipo_sexo.php?t=combo"  },
{type: "combo", label: "Estado Civil", name: "estado_civil", value: "<?php if($varestado_civil!="") echo $varestado_civil; ?>", width: 195, filtering: true, connector: "php/options_tipo_estadocivil.php?t=combo" },
{type: "input", label: "Email", width: 195,  name: "email", value: "<?php if($devuelveemailusu!="") echo $devuelveemailusu; ?>", validate:"ValidEmail",readonly : "true"},
{type: "combo", label: "Nacionalidad", name: "nacionalidad", value: "<?php if($varnacionalidad!="") echo $varnacionalidad; ?>", width: 195, filtering: true, connector: "php/options_tipo_nacionalidad.php?t=combo" },
					*/
					//{type: "input", label: "Coordenadas", width: 195, name: "coord_direccion", value: ""},
]},

//{type:"newcolumn"},

// {type: "fieldset", label: "Informacion Adicional",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 360, list:[

					
					//{type: "newcolumn"},
					//{type: "input", label: "Telefono Celular", width: 195,  name: "telefono", value: "<?php if($vartelf_celular!="") echo $vartelf_celular; ?>", validate:"[0-9]+", required: true, },
					//{type: "input", label: "Email", width: 195, name: "email", value: "<?php if($vardireccion!="") echo $vardireccion; ?>"},
					//{type: "input", label: "Usuario", width: 195,  name: "usuario", value: ""},
					//{type: "password", label: "Clave", width: 195,  name: "clave", value: ""},
					//{type: "checkbox", label: "Activo", width: 195,  name: "data_tipo_activusuarios", value: "", checked: true},
					//{type: "template", label: "Subir Foto", name: "imagenicon",inputWidth: 140, value: ""},
				//	{type: "upload", name: "myFiles", inputWidth: 310,  offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},

//]},

{type:"newcolumn"},
		{type: "button", value: ">>>  Guardar <<<", name: "send", offsetLeft: 10,  width: 100, className: "button_save"},			
		{type:"newcolumn"},
        {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 10,  width: 100, className: "button_cancel"}			

				]},
			];
			
			myForm = new dhtmlXForm("myForm", formData);
			////////////eventos formularios
           
			myForm.attachEvent("onFileAdd",function(realName){
				//logEvent("<b>onFileAdd</b>, real name: "+realName);
				myForm.setItemValue("imagenicon", "../galeriaimgs/"+realName);
			});
			
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				
				
				if (id == "cancel") 
				{
					parent.document.location.href="../../index.php";
				}
				
				if (id == "send") 
					{
					
					  
						 myForm.send("php/datapersonal_actualizarus.php", function(loader, response){
						  // alert(response);
						   
						  
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",  
						    callback: function() { parent.document.location.href="../../index.php"; }
							});
							
							
							
					      });
						  
						 
							
							
					}
			});
			
			//////////////////////////mostrar ayuda popup
		/*	myPop = new dhtmlXPopup({ form: myForm, id: ["cedula_ruc","nombre","imglogo","provincia","canton","parroquia","calle_principal","calle_interseccion","numero_predio","referencia_cercana","autoridad_nombre","autoridad_cargo","autoridad_cedula","autoridad_represlegal","autoridad_cedula_represlegal","delegado_cedula","delegado_nombre","delegado_cargo","delegado_nrodocumento_delegacion","delegado_fecha_resolucion","vision","mision"]  });
			myPop.attachHTML("Por favor ingrese el dato");
			*/


			/*
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
				*/
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
			/*
		    myForm.attachEvent("onAfterValidate", function() {
        		if (text);
			   //  alert(text);
			   dhtmlx.message("Los siguientes campos deben ser validados: <br>"+text);
		    });*/
			///////////////////////////fin de popup
			
			dp = new dataProcessor("php/data_actualusuario.php");
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
<table width="415" border="0" align="center">
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
  <tr>
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
 </form>
 <div id="simpleLog"></div>
</body>
</html>
