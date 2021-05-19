<!DOCTYPE html>
<html>
<head>
	<title>Datos geo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/fonts/font_roboto/roboto.css"/>
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/dhtmlx.css"/>
	<script src="../../dhtmlx51/codebase/dhtmlx.js"></script>
	<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #ebebeb;*/
			overflow: hidden;
		}
		
		div.gridbox table.obj td {

font-family:Arial;
font-size:11px;
}

		.dhtmlxGrid_selection {
			-moz-opacity: 0.5;
			filter: alpha(opacity = 50);
			background-color:#83abeb;
			opacity:0.5;
		}
		
		div.dhxform_item_label_left.button_save div.dhxform_btn_txt {
			background-image: url(imgs/acepload.png);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
			height: 100px;
		}
		div.dhxform_item_label_left.button_cancel div.dhxform_btn_txt {
			background-image: url(../../images/menus//cancel.gif);
			background-repeat: no-repeat;
			background-position: 0px 3px;
			padding-left: 22px;
			margin: 0px 15px 0px 12px;
		}
		
		#menutopsupervis{
width:100%;background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255));border: 1px solid #a4bed4; height:29px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;text-decoration: none;  	
	}
		
	</style>
	<script>
		var myLayout, myGrid, myForm, myMenuContex, myGridhist;
		
		function doOnLoad() {
			
			////////////inicializando
			myLayout = new dhtmlXLayoutObject({
				parent: document.body,
				//parent: "layoutObj",
				pattern: "2E",
				cells: [{id: "a", text: "Cargar Documento(s) Escaneados >>> ", width: 460, height: 180   },{id: "b", text: "Visualizar Informacion"   }]
	
			});
			
			 
	//myLayout.cells("a").collapse();	
	 
	  
			//////////////elementos
formData = [
  {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 120},
	{type: "fieldset", label: "Anexos: ",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 300, list:[		
					//{type: "newcolumn"},
		{type: "template", label: "Imagen", name: "imagenicon",inputWidth: 140, value: ""},
		{type: "upload", name: "myFiles", inputWidth: 260,   offsetTop: 0, url: "php/carga_upload_img_campo.php?varidplantilla=<?php echo $_GET["varidplantilla"];?>&varidenvcampo=<?php echo $_GET["varidenvcmp"];?>", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_img_campo.php"},
]},

	{type:"newcolumn"},
{type: "button", value: "ACEPTAR >>", name: "send", offsetLeft: 10,offsetTop: 10,  width: 120,   className: "button_save"}			

			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onUploadComplete",function(count){
				//alert("todo bien");
				var data2 = myForm.getItemValue("myFiles");
				var datoitem=data2['myFiles_r_0'];
				//alert(data2['myFiles_r_0']);
				
			   myLayout.cells("b").attachURL("../../../sip_bodega/archformularios/"+datoitem);
			});
			
			////////////////////eventos boton
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "cancel") 
				{
					document.location.href="lista_data_departamentos.php";
				}
				
				if (id == "send") 
					{
						
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Imagen agregada correctamente!!",
						    callback: function() {
								
								
								document.location.href="plantilla_form_campos_crear.php?varidplatycmps=<?php echo $_GET["varidplantilla"]; ?>";
								//window.close();
							
							 }
							});
							
					}
			});
			///////////////////////////////////////////////////////////////////////////////
			//myForm.setSkin("Skyblue");
			 myLayout.cells("b").attachURL("../../../sip_bodega/archformularios/"+datovaloranex);
			//////////////////elemnto mapa vista
		//	myLayout.cells("b").attachURL("../zgis_mapsver/verobjetogeo.php");
			
		}
	</script>
    <link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue_blue/dhtmlx.css"/>
</head>
<body onload="doOnLoad();">

<div id="layoutObj" style="position: relative; margin-top: 6px; margin-left: 10px; width: 99%; height: 93%; " ></div>
<div id="gridbox"></div>	
</body>
</html>