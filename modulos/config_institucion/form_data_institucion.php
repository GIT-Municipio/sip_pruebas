<?php
$latabla='tblb_org_institucion';

require_once('../../clases/conexion.php');

$sql = "SELECT  id,cedula_ruc,nombre,imglogo,provincia,canton,parroquia,calle_principal,calle_interseccion, referencia_cercana,autoridad_nombre,autoridad_cargo,autoridad_cedula,autoridad_represlegal,autoridad_cedula_represlegal,delegado_cedula,delegado_nombre,delegado_cargo,delegado_nrodocumento_delegacion,delegado_fecha_resolucion,mision,actualizociusbdd from ".$latabla." where id=1; ";
$resul = pg_query($conn, $sql);
$numerdatos=pg_num_rows($resul);

if($numerdatos!=0)
{
$var_id= pg_fetch_result($resul,0,'id');
$var_cedula_ruc= pg_fetch_result($resul,0,'cedula_ruc');
$var_nombre= pg_fetch_result($resul,0,'nombre');
$var_provincia= pg_fetch_result($resul,0,'provincia');
$var_canton= pg_fetch_result($resul,0,'canton');
$var_parroquia= pg_fetch_result($resul,0,'parroquia');
$var_calle_principal= pg_fetch_result($resul,0,'calle_principal');
$var_calle_interseccion= pg_fetch_result($resul,0,'calle_interseccion');
$var_referencia_cercana= pg_fetch_result($resul,0,'referencia_cercana');
$var_autoridad_nombre= pg_fetch_result($resul,0,'autoridad_nombre');
$var_autoridad_cargo= pg_fetch_result($resul,0,'autoridad_cargo');
$var_autoridad_cedula= pg_fetch_result($resul,0,'autoridad_cedula');
$var_autoridad_represlegal= pg_fetch_result($resul,0,'autoridad_represlegal');
$var_autoridad_cedula_represlegal= pg_fetch_result($resul,0,'autoridad_cedula_represlegal');
$var_delegado_cedula= pg_fetch_result($resul,0,'delegado_cedula');
$var_delegado_nombre= pg_fetch_result($resul,0,'delegado_nombre');
$var_delegado_cargo= pg_fetch_result($resul,0,'delegado_cargo');
$var_delegado_nrodocumento_delegacion= pg_fetch_result($resul,0,'delegado_nrodocumento_delegacion');
$var_delegado_fecha_resolucion= pg_fetch_result($resul,0,'delegado_fecha_resolucion');
$var_mision= pg_fetch_result($resul,0,'mision');
$var_actualizociusbdd= pg_fetch_result($resul,0,'actualizociusbdd');

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Institucion</title>
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
				{type: "fieldset", label: "Institucion",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 380, list:[
				     {type: "hidden", label: "Id", width: 195,  name: "id", value: "<?php echo $var_id; ?>"},
					{type: "input", label: "Cedula/RUC", width: 195, name: "cedula_ruc", value: "<?php echo $var_cedula_ruc; ?>", required: true, validate: "NotEmpty"},
					{type: "input", label: "Nombre", width: 195,  name: "nombre", value: "<?php echo $var_nombre; ?>"},
					//{type: "input", label: "Provincia", name: "provincia", value: ""},
					//{type: "select", label: "Provincia", name: "provincia", connector: "php/options_provincia.php?t=select"},
                     {type: "fieldset", label: "Ubicacion",  offsetLeft: 0, offsetRight: 0, labelWidth: 100, inputWidth: 320, list:[
					//{type: "combo", label: "Provincia", name: "provincia", width: 145, filtering: true, connector: "../parametros/options_provincia.php?t=combo"},
				// {type: "combo", label: "Canton", name: "canton", width: 145, filtering: true, connector: "../parametros/options_canton.php?t=combo"},
				//	{type: "combo", label: "Parroquia", name: "parroquia", width: 145, filtering: true, connector: "../parametros/options_parroquia.php?t=combo"},
				   {type: "input", label: "Provincia", name: "provincia", value: "<?php echo $var_provincia; ?>"},
				   {type: "input", label: "Canton", name: "canton", value: "<?php echo $var_canton; ?>"},
				   {type: "input", label: "Parroquia", name: "parroquia", value: "<?php echo $var_parroquia; ?>"},
				   
					{type: "input", label: "Calle Principal", name: "calle_principal", value: "<?php echo $var_calle_principal; ?>"},
					{type: "input", label: "Calle Interseccion", name: "calle_interseccion", value: "<?php echo $var_calle_interseccion; ?>"},
					{type: "input", label: "Referencia Cercana", name: "referencia_cercana", value: "<?php echo $var_referencia_cercana; ?>"}
				]},
				 {type: "template", label: "Logo", name: "imglogo",inputWidth: 140, value: ""},
					{type: "upload", name: "myFiles", inputWidth: 310,  offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
				
				]},
				{type:"newcolumn"},
				{type: "fieldset", label: "Autoridad", offsetLeft: 5, offsetRight: 5, inputWidth: 325, list:[
					{type: "input", label: "Nombre", name: "autoridad_nombre", value: "<?php echo $var_autoridad_nombre; ?>"},
					{type: "input", label: "Cargo", name: "autoridad_cargo", value: "<?php echo $var_autoridad_cargo; ?>"},
					{type: "input", label: "Cedula", name: "autoridad_cedula", value: "<?php echo $var_autoridad_cedula; ?>"},
					{type: "input", label: "Representante Legal", name: "autoridad_represlegal", value: "<?php echo $var_autoridad_represlegal; ?>"},
					{type: "input", label: "Cedula Representante Legal", name: "autoridad_cedula_represlegal", value: "<?php echo $var_autoridad_cedula_represlegal; ?>"},
					]},
				{type:"newcolumn"},
				{type: "fieldset", label: "Mision", offsetLeft: 5, offsetRight: 5, inputWidth: 200, list:[
					{type: "editor", label: "Redactar la Misión:", name: "mision",  inputWidth: 200, inputHeight: 134, value: "<?php echo $var_mision; ?>"},					
				]},

				
					{type:"newcolumn"},
				{type: "fieldset", label: "Delegado", offsetLeft: 5, offsetRight: 5, inputWidth: 325, list:[
					{type: "input", label: "Cedula", name: "delegado_cedula", value: "<?php echo $var_delegado_cedula; ?>"},
					{type: "input", label: "Nombre", name: "delegado_nombre", value: "<?php echo $var_delegado_nombre; ?>"},
					{type: "input", label: "Cargo", name: "delegado_cargo", value: "<?php echo $var_delegado_cargo; ?>"},
					{type: "input", label: "Nro. Documento Delegación", name: "delegado_nrodocumento_delegacion", value: "<?php echo $var_delegado_nrodocumento_delegacion; ?>"},
				{type: "calendar", dateFormat: "%Y-%m-%d", label: "Fecha Delegación", name: "delegado_fecha_resolucion", value: "2011-06-20", enableTime: false, calendarPosition: "right"},
					//{type: "template", label: ".", name: "espacio", value: ""},
				]},
				{type:"newcolumn"},
				{type: "fieldset", label: "Actualizar BDD ",offsetLeft: 5, offsetRight: 5, inputWidth: 200, list:[
					//{type: "editor", label: "Redactar la Visión", name: "vision",  inputWidth: 200, inputHeight: 90, value: ""},            
					
					<?php if($var_actualizociusbdd==1) {?>
					{type: "checkbox", label: "<br/>Click en caso de Actualizar los ciudadanos en la base de Cabildo<br/><br/><br/>", name: "actualizocheck" , checked: true},
					<?php } else { ?>
					{type: "checkbox", label: "<br/>Click en caso de Actualizar los ciudadanos en la base de Cabildo<br/><br/><br/>", name: "actualizocheck" },
					<?php } ?>
					
					{type: "hidden", label: "actualizociusbdd", name: "actualizociusbdd", value: "<?php echo $var_actualizociusbdd; ?>"},
					
					
					{type: "button", value: ">>>  >  Guardar  < <<<", name: "send",  width: 150, className: "button_save"}
				]},
				
			];
			
			myForm = new dhtmlXForm("myForm", formData);
			/*
			myForm.attachEvent("onOptionsLoaded", function(name){
				myForm.checkItem("actualizociusbdd",true);
			});
			*/
			////////////eventos formularios
			/*myForm.attachEvent("onOptionsLoaded", function(name){
				logEvent("onOptionsLoaded, item name '"+name+"'<br>");
			});*/
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
			
			myForm.attachEvent("onChange", function(name,value,is_checked){
				//logEvent("onChange, item name '"+name+"', value '"+value+"', is checked '"+(is_checked?"true":"false")+"'<br>");
				if(is_checked)
				myForm.setItemValue("actualizociusbdd", 1);
				else
				myForm.setItemValue("actualizociusbdd", 0);

			});
			
			/*
			myForm.attachEvent("onChange", function(name, value){
				alert(name);
				alert(value);
				//logEvent("onChange, item name '"+name+"', value '"+value.toString()+"'<br>");
				if(name=="provincia")
				myForm.reloadOptions("canton", "../parametros/options_canton.php?t=combo&niv="+value.toString());
				if(name=="canton")
				myForm.reloadOptions("parroquia", "../parametros/options_parroquia.php?t=combo&niv="+value.toString());
				
			});*/
			
			/*myForm.attachEvent("onChange", function(){
				console.log(arguments)
			});
			*/
			
			
			
			
			
			myForm.attachEvent("onButtonClick", function(id){
				if (id == "send") 
					{
						
						  myForm.send("php/datainstitucion_update.php", function(loader, response){
						    //alert(response);
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { document.location.href="../modulo_verinstitucion.php"; }
							});
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
			"cedula_ruc": "Ingrese El RUC de la Institucion",
			"nombre": "Ingrese el nombre completo",
			"imglogo": "Seleccionar un logo",
			"provincia": "Provincia a la que pertenece",
			"canton": "Canton a la que pertenece",
			"parroquia": "Parroquia a la que pertenece",
			"calle_principal": "Calle Principal",
			"calle_interseccion": "Calle de Interseccion",
			"numero_predio": "Numero de casa o predio",
			"referencia_cercana": "Especifique una Referencia mas cercana",
			"autoridad_nombre": "Nombre de la Autoridad Principal",
			"autoridad_cargo": "Cargo de la Autoridad (PREFECTO/A)",
			"autoridad_cedula": "Cedula de la autoridad ",
			"autoridad_represlegal": "Representante Legal",
			"autoridad_cedula_represlegal": "Cedula del Representante Legal",
			"delegado_cedula": "Cedula del Delegado",
			"delegado_nombre": "Nombre del Delegado",
			"delegado_cargo": "Cargo del Delegado",
			"delegado_nrodocumento_delegacion": "Numero del Documento de Resolucion de la Delegacion",
			//"delegado_fecha_resolucion": "Provincia a la que pertenece",
			"vision": "Vision de la Institucion",
			"mision": "Mision de la Institucion"
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
			///////////////////////////fin de popup
			
			dp = new dataProcessor("php/datainstitucion.php");
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
<table width="1024" border="0" align="center">
  <tr>
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
 </form>
 <div id="simpleLog"></div>
</body>
</html>
