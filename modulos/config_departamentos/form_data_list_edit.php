<?php


$devuvarid= 0;
$devuvarnom= "";
$devuvartelf= "";
$devuvarmail= "";
$devuvarrespon= 0;
$devuvarasisten= 0;
$devuvaraparent= 0;
$devarparencodig = 0;


$latabla='tblb_org_departamento';

require_once('../../clases/conexion.php');

if($_GET["envionodoprin"]!="")
 $sql = "SELECT  * from ".$latabla." where id='".$_GET["envionodoprin"]."' ";
else
 $sql = "SELECT  * from ".$latabla;

$resul = pg_query($conn, $sql);
/////CUANDO SE TENGA DATOS PARA ACTUALIZAR
//$_GET[opt]='nuevo';
if($_GET['opt']=='nuevo')
	$numerdatos=0;
else
	$numerdatos=pg_num_rows($resul);
//para realizar un nuevo
/////////////////////
if($numerdatos!=0)
{
$devuvarid= pg_fetch_result($resul,0,"id");
$devuvarcodigo_dep= pg_fetch_result($resul,0,"codigo_dep");
$devuvarcodigo_unif= pg_fetch_result($resul,0,"codigo_unif");

$devuvarnom= pg_fetch_result($resul,0,"nombre_departamento");
$devuvartelf= pg_fetch_result($resul,0,"telf_extension");
$devuvarmail= pg_fetch_result($resul,0,"email");
$devuvarrespon= pg_fetch_result($resul,0,"ced_responsable");
$devuvarasisten= pg_fetch_result($resul,0,"ced_asistente");
$devuvaraparent= pg_fetch_result($resul,0,"parent_id");

$devuvarnomresp= pg_fetch_result($resul,0,"nom_responsable");
$devuvarnomasist= pg_fetch_result($resul,0,"nom_asistente");

if($devuvaraparent!=0)
{
$sqlins = "SELECT  codigo_dep from tblb_org_departamento where id='".$devuvaraparent."'";
$resulinsgad = pg_query($conn, $sqlins);
$devarparencodig = pg_fetch_result($resul,0,"codigo_dep");
}

}



$sqlins = "SELECT  cedula_ruc from tblb_org_institucion ";
$resulinsgad = pg_query($conn, $sqlins);
$numerdatinst=pg_num_rows($resulinsgad);
if($numerdatinst!=0)
{
$devuelveidprinst= pg_fetch_result($resulinsgad,0,0);
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
	  
	  
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #dce7fa;
			overflow: hidden;
			font-family: verdana, arial, helvetica, sans-serif;
           
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
	cells: [{id: "a", text: "Formulario",  height: 260   },{id: "b", text: "Personal Asignado"  } ]
				
			});
			
			<?php if($_GET['opt']=='nuevo') { ?>
			myLayout.cells("b").collapse();
			<?php } ?>
			
			
			formData = [
				{type: "settings", position: "label-left", labelWidth: 110, inputWidth: "auto"},
			{type: "fieldset", label: "Crear Nuevo Departamento",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 430, list:[
					{type: "hidden", label: "id", width: 240, name: "id", value: "<?php echo $devuvarid; ?>"},
					{type: "input", label: "Cod. Dep.", width: 50, name: "codigo_dep", value: "<?php echo $devuvarcodigo_dep; ?>" , required: true},
					{type:"newcolumn"},
					{type: "input", label: "Cod. Jef.", offsetLeft: 20, width: 80, name: "codigo_unif", value: "<?php if($devarparencodig==0) echo $devuvarcodigo_unif; else echo $devarparencodig; ?>" , required: true},
					{type:"newcolumn"},
					{type: "input", label: "Nombre", width: 240, name: "nombre_departamento", value: "<?php echo $devuvarnom; ?>" , required: true},
					{type: "input", label: "Telf_extension", width: 240,  name: "telf_extension", value: "<?php echo $devuvartelf; ?>"},
					//{type: "input", label: "email", width: 240,  name: "email", value: "<?php echo $devuvarmail; ?>"},
					
					
					{type: "combo", label: "Responsable", name: "ced_responsable", value: "",  width: 240, filtering: true, connector: "php/options_personal.php?t=combo"},
					
					
					
					{type: "combo", label: "Asistente", name: "ced_asistente", value: "", width: 240, filtering: true, connector: "php/options_personal.php?t=combo"},
					
					
					//{type: "input", label: "Telf_Personal", width: 195,  name: "telf_personal", value: ""},
					<?php if($_GET['opt']=='nuevo') {?>
					{type: "hidden", label: "Enlace", width: 195,  name: "parent_id", value: "<?php if($_GET["envionodoprin"]!="") echo $_GET["envionodoprin"]; else echo "0"; ?>"},
					<?php } else { if($devuvaraparent!="") {?>
					{type: "hidden", label: "Enlace", width: 195,  name: "parent_id", value: "<?php echo $devuvaraparent; ?>"},
					<?php } else { ?>
					{type: "hidden", label: "Enlace", width: 195,  name: "parent_id", value: "0"},
//{type: "combo", label: "Enlace", name: "parent_id", value: "0", width: 195, filtering: true, connector: "php/options_departamentos.php?t=combo"},
					<?php } } ?>

					//{type: "hidden", label: "ref_institucion", width: 195,  name: "ref_institucion", value: "<?php if($numerdatinst!=0) echo $devuelveidprinst; ?>"},
					//{type: "checkbox", label: "Activo", width: 195,  name: "activo", value: "", checked: true},
					//{type: "editor", label: "Objetivo",  inputWidth: 210, inputHeight: 80,  name: "objetivo", value: ""},
{type:"newcolumn"},
		{type: "button", value: ">>>  Guardar <<<", name: "send", offsetLeft: 10,  width: 100, className: "button_save"},			
	/*	{type:"newcolumn"},
        {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 10,  width: 100, className: "button_cancel"}			
*/
				]},
			];
			
			myForm = myLayout.cells("a").attachForm(formData);
			
			////////////eventos formularios
			
			
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				
				if (id == "cancel") 
				{
					document.location.href="lista_data_departamentos.php";
				}
				
				if (id == "send") 
					{
						
						 myForm.send("php/datadep_nuevo.php", function(loader, response){
						  alert(response);
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { parent.document.location.href="arb_data.php"; }
							});
							////////////////////////////////////////
					      });
					
							
					}
			});
			
			//////////////////////////mostrar ayuda popup
		/*	myPop = new dhtmlXPopup({ form: myForm, id: ["cedula_ruc","nombre","imglogo","provincia","canton","parroquia","calle_principal","calle_interseccion","numero_predio","referencia_cercana","autoridad_nombre","autoridad_cargo","autoridad_cedula","autoridad_represlegal","autoridad_cedula_represlegal","delegado_cedula","delegado_nombre","delegado_cargo","delegado_nrodocumento_delegacion","delegado_fecha_resolucion","vision","mision"]  });
			myPop.attachHTML("Por favor ingrese el dato");
			*/


			
			myIds = {
			"nombre": "Nombre del Departamento",
			"director": "Director encargado",
			"email": "correo electronico del Director",
			"telf_extension": "Extension de la Oficina",
			"telf_personal": "Telefono Personal del Director",
			"objetivo": "Calle Principal",
			"ref_data_padre": "Este Item en caso de ser Subdireccion<p>Dejar en blanco si es Direccion principal</p>",
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
				
				if (id=='codigo_dep') {
					var auxcaden=myForm.getItemValue('codigo_unif');
					var posiencnum= auxcaden.indexOf("-");
					if(posiencnum>1)
					{
						var substrcade=auxcaden.substr(0,posiencnum);
						myForm.setItemValue("codigo_unif",substrcade);
					}
					
					myForm.setItemValue("codigo_unif", myForm.getItemValue('codigo_unif')+'-'+myForm.getItemValue('codigo_dep'));
				}
				
			});
			
			myForm.attachEvent("onKeyUp",function(inp,ev,id,value){
				if (id=='nombre_departamento') {
					inp.value=inp.value.toUpperCase();
				}
				if (id=='codigo_dep') {
					inp.value=inp.value.toUpperCase();
				}
				
			});
			///////////////////////////fin de popup
			
	mygrid = myLayout.cells("b").attachGrid();
	mygrid.setImagePath("../../dhtmlx51/codebase/imgs/");
	mygrid.setHeader("ID,CEDULA,NOMBRE,APELLIDO,CARGO");
	//mygrid.attachHeader("#text_filter,#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("1,85,100,100,100");
	mygrid.setColAlign("left,left,left,left,left");
	mygrid.setColTypes("txt,txt,txt,txt,txt");
	//mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("int,str,str,str,str");	
	///////////////////////inicio seteo numeros///////////////////////////////
		////////////////////////fin seteo numeros/////////////////////////////////
	mygrid.init();
	////////////////////////////FINAL//////////////
	mygrid.makeSearch("searchFilter",1);
    mygrid.loadXML("php/oper_get_datosgrid_xdep.php?mitabla=tblu_migra_usuarios&enviocampos=id,usua_cedula,usua_nomb,usua_apellido,usua_cargo&envioidepart=<?php echo $_GET["envionodoprin"]; ?>");	
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,true,false);
 
 
   myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=tblu_migra_usuarios&enviocampos=id,usua_cedula,usua_nomb,usua_apellido"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	//myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
//============================================================================================
///////////mensajes de salida

   myDataProcessor.attachEvent("onAfterUpdate",function(){ 
   
   //dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
    })


			
		}
		
		
		
	</script>
</head>
<body onload="doOnLoad();">
<form id="realForm" method="POST" enctype="multipart/form-data"  >
<table width="415" border="0" align="center">
  <tr>
    <td><div id="myForm" align="left"></div></td>
  </tr>
</table>
 </form>
 <div id="simpleLog"></div>
</body>
</html>
