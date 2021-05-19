<?php


$valortextocomp="";



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
<script src="../../componentes/codebase/dhtmlx.js"></script>
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
</style>
<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor, mygrid;
	
	
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "1C",
	cells: [{id: "a", text: "Formulario de Creacion de Datos"   } ]
				
			});
			
	//myLayout.cells("a").hideHeader();	
	//myLayout.cells("b").hideHeader();		
	//myLayout.cells("c").hideHeader();		
	//myLayout.cells("b").attachObject("layoutmenuizq");		
	//myLayout.cells("b").attachObject("layoutmenusuperderecha");	
	////////////////////////EMPIEZA EL FORMULARIO
	formData = [
				{type: "settings", position: "label-left", labelWidth: 100, inputWidth: "auto"},
				
				{type: "fieldset", label: "Configurar Texto",  offsetLeft: 5, offsetRight: 5, offsetTop: 5, inputWidth: 330, list:[
				
					{type: "hidden", label: "Plantilla", width: 210, name: "ref_plantilla", value: "<?php echo $_GET["vcodigplantillavar"]; ?>" },
					{type: "hidden", label: "Plantilla", width: 210, name: "nombretablaplantillas", value: "<?php echo $_GET["vnombretabplantilla"]; ?>" },
					{type: "hidden", label: "Plantilla", width: 210, name: "nombrecampodeplantilla", value: "<?php echo $_GET["vnombrecampo"]; ?>" },
						
				{type: "editor", label: "", name: "valorxdefecto",  inputWidth: 560, inputHeight: 270, value: "<?php echo $valortextocomp; ?>"},			
				
				 {type: "button", value: ">>  Guardar Informacion <<", name: "send", offsetLeft: 5, offsetTop: 0, width: 160, className: "button_save"},			
	//{type:"newcolumn"},
    // {type: "button", value: ">>>  Cancelar <<<", name: "cancel", offsetLeft: 10,  width: 100, className: "button_cancel"}			

		
				]},
			//{type:"newcolumn"},
				
			
			];

			myForm = myLayout.cells("a").attachForm(formData);
			/////////////////////////////////////TERMINA EL FORMULARIO
			myForm.attachEvent("onButtonClick", function(id){
				
				if (id == "cancel") 
				{
					document.location.href="lista_form_principal.php";
				}
				
				if (id == "send") 
					{
						myForm.send("php/plantilla_nuevo_textolarg.php", function(loader, response){
						    
							//alert(response);
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se Registro con exito!!",
						    callback: function() { document.location.href="plantilla_form_campos_crear.php?varidplatycmps=<?php echo $_GET["vcodigplantillavar"]; ?>"; }
							});
							
							
							/////////////////////////////////
					      });
							
					}
			});
		/////////////////////////////////////////
		///////////////////////
		
	
	
	}
	
</script>

</head>

<body onLoad="doOnLoad();">
</body>
</html>