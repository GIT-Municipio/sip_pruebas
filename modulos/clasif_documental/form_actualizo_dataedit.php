<?php

session_start();

$latabla='tbli_esq_plant_form_cuadro_clasif';
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

$varelidusu= pg_fetch_result($resul,0,"id");

$varcod_clase= pg_fetch_result($resul,0,"cod_clase");
$varcod_tipo= pg_fetch_result($resul,0,"cod_tipo");
$varcod_grupo= pg_fetch_result($resul,0,"cod_grupo");
$vardetalle= pg_fetch_result($resul,0,"detalle");

$devuvarrespon= pg_fetch_result($resul,0,"ced_responsable");
$devuvarasisten= pg_fetch_result($resul,0,"ced_asistente");
$devuvarnomresp= pg_fetch_result($resul,0,"nom_responsable");
$devuvarnomasist= pg_fetch_result($resul,0,"nom_asistente");
$devuvarproceso= pg_fetch_result($resul,0,"nom_proceso");

$devuvarprocesoidprm= pg_fetch_result($resul,0,"ref_id_proceso");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
     <script src="php/connector/dhtmlxdataprocessor.js"></script>
      <style type="text/css"> 

	html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
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
			
			myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Formulario",  height: 260   },{id: "b", text: "Requisitos"  } ]
				
			});
			
			
			<?php if($_GET['varmosrequs']==1) { ?>
	                 myLayout.cells("a").collapse();	
	  <?php } ?>
			
			
			formData = [
				{type: "settings", position: "label-left", labelWidth: 80, inputWidth: "auto"},
					
    {type: "fieldset", label: "Detalle",  offsetLeft: 0, offsetRight: 5, offsetTop: 0, inputWidth: 400, list:[
	
	{type: "hidden", label: "id", width: 195, name: "id", value: "<?php if($varelidusu!="") echo $varelidusu; ?>"},
					//{type: "combo", label: "Tipo Usuario", name: "tipo_usuario", value: "0", width: 195, filtering: true, connector: "../parametros/options_tipo_usuario.php?t=combo"},
					{type: "input", label: "Clase",position: "label-right", width: 30, name: "cod_clase", value: "<?php if($varcod_clase!="") echo $varcod_clase; ?>", required: true },
					{type:"newcolumn"},
					{type: "input", label: "Tipo",position: "label-right", width: 30, name: "cod_tipo", value: "<?php if($varcod_tipo!="") echo $varcod_tipo; ?>", required: true, validate: "NotEmpty" },
					{type:"newcolumn"},
					{type: "input", label: "Grupo",position: "label-right", width: 30, name: "cod_grupo", value: "<?php if($varcod_grupo!="") echo $varcod_grupo; ?>", required: true, validate: "NotEmpty" },
					{type:"newcolumn"},
					{type: "input", label: "Detalle", width: 260, name: "detalle", value: "<?php if($vardetalle!="") echo $vardetalle; ?>", required: true, validate: "NotEmpty" },
					

				
					{type: "combo", label: "Responsable 1", name: "ced_responsable", value: "",  width: 260, filtering: true, connector: "php/options_personal_tipoadmin.php?t=combo"},
				
					
					
					{type: "combo", label: "Responsable 2", name: "ced_asistente", value: "", width: 260, filtering: true, connector: "php/options_personal_tipoasis.php?t=combo"},
				
					
					
					<?php if(strlen($devuvarproceso)>3) { ?>
					{type: "input", label: "Proceso", width: 260,  name: "nom_proceso", readonly : "true", value: "<?php echo $devuvarproceso; ?>"},
					<?php } else { ?>
					{type: "combo", label: "Proceso", name: "ref_id_proceso", value: "", width: 260, filtering: true, connector: "php/options_proceso.php?t=combo"},
					<?php } ?>
					
					

]},

{type:"newcolumn"},
		{type: "button", value: ">>>  Guardar <<<", name: "send", offsetLeft: 10,  width: 100, className: "button_save"},
		{type:"newcolumn"},
        {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 10,  width: 100, className: "button_cancel"}				

				
			];
			
			//myForm = new dhtmlXForm("myForm", formData);
			myForm = myLayout.cells("a").attachForm(formData);
			
			////////////eventos formularios
           
			myForm.attachEvent("onFileAdd",function(realName){
				//logEvent("<b>onFileAdd</b>, real name: "+realName);
				myForm.setItemValue("imagenicon", "../galeriaimgs/"+realName);
			});
			
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				
				
				if (id == "cancel") 
				{
					document.location.href="form_actualizo_data.php?valorusuid=<?php echo $_GET['valorusuid']; ?>";
				}
				
				if (id == "send") 
					{
					
					  
						 myForm.send("php/datapersonal_actualizarus.php", function(loader, response){
						 //  alert(response);
						   
						  
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",  
						    callback: function() { document.location.href="form_actualizo_data.php?valorusuid=<?php echo $_GET['valorusuid']; ?>"; }
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
			
			
			////////////////////////////////////////requisitosç
	mygrid = myLayout.cells("b").attachGrid();
	mygrid.setImagePath("../../dhtmlx51/codebase/imgs/");
	mygrid.setHeader("ID,ID,DETALLE,ACTIVO");
	//mygrid.attachHeader("#text_filter,#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("1,50,200,75");
	mygrid.setColAlign("left,left,left,left");
	mygrid.setColTypes("txt,txt,txt,ch");
	mygrid.setColSorting("int,str,str,str");	
	mygrid.init();
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",1);
    mygrid.loadXML("php/oper_get_datosgrid_xdep.php?mitabla=tblh_cr_catalogo_requisitos&enviocampos=id,codigo_requis,descripcion_requisito,activo&envioidepart=<?php echo $devuvarprocesoidprm; ?>");	
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,true,false);
 
 
   myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=tblh_cr_catalogo_requisitos&enviocampos=id,codigo_requis,descripcion_requisito,activo"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida

   myDataProcessor.attachEvent("onAfterUpdate",function(){ 
   
   //dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
    })
	///////////////////////////////////////////////////////////////////
			
			
			
			
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
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
 </form>
 <div id="simpleLog"></div>
</body>
</html>
