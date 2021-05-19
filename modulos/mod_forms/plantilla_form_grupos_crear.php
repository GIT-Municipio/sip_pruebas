<?php
require_once('../../clases/conexion.php');

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/dhtmlx.css"/>
	<script src="../../dhtmlx51/codebase/dhtmlx.js"></script>
    <script src="../../dhtmlx51/codebase/ext/dhtmlxgrid_group.js"></script>
       <script type="text/javascript" src="../../extjs421/examples/shared/include-ext.js"></script>
    
<script type="text/javascript" src="../../extjs421/examples/shared/examples.js"></script><!-- EXAMPLES -->
    
    
    
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
width: 60px;
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
width: 50px;
margin-top: 2px;
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
</style>
<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor, mygrid;
	
	
	function format_b(name, value) {
			// to access form instance from format function
			// you cann use the following method:
			// var form = this.getForm();
			return "<div class='simple_link'><a href='javascript:void(0);' onclick='showPopup(0);'>"+value+"</a></div>";
		}
		
	function guardarinfo(varrefid)
	{
		//alert(varrefid);
		   if(varrefid==0)
		   {
			    myForm.send("php/dato_nuevo.php", function(loader, response){
						   
				dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { 
							///////esto es para salirse del iframe local q lo contiene
							//document.location.href="lista_form_grid_actual.php";
							////es para salirse a la raiz parent.location.href
							parent.location.href="principal.php";
							
							 }
							});
						   
			    });
		    }
			else
			{
           	myForm.send("php/dato_actual.php", function(loader, response){
						  dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { 
							///////esto es para salirse del iframe local q lo contiene
							//document.location.href="lista_form_grid_actual.php";
							////es para salirse a la raiz parent.location.href
							parent.location.href="principal.php";
							
							 }
							});
				});
			}
		
		    
	};
	
	
	function eliminarinfo(varrefid)
	{
		 Ext.Msg.confirm('Eliminar?', 'Desea Eliminar el Dato?',
                                function(choice) {
                                    if(choice === 'yes') {
		//alert(varrefid);
		   if(varrefid!=0)
		   {
			    myForm.send("php/dato_eliminar.php", function(loader, response){
						   
				dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "¡¡"+response,
						    callback: function() { 
							///////esto es para salirse del iframe local q lo contiene
							//document.location.href="lista_form_grid_actual.php";
							////es para salirse a la raiz parent.location.href
							parent.location.href="principal.php";
							
							 }
							});
						   
			    });
		    }
			else 
			{
				
			dhtmlx.alert({
								title:"Mensaje!",
								type:"alert-error",
								text:"Es necesario seleccionar el Nodo"
							});
							
								
			}
/////////////////////////////////////////////////////	    
				}});
			/////////////////////////////////
	}	
		
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Formulario de Creacion de Datos", height: 135   },{id: "b", text: "FORMULARIO" , width: 80 } ]
				
			});
			
	//myLayout.cells("a").hideHeader();	
	myLayout.cells("b").hideHeader();		
	//myLayout.cells("c").hideHeader();		
	//myLayout.cells("b").attachObject("layoutmenuizq");		
	//myLayout.cells("b").attachObject("layoutmenusuperderecha");	
	////////////////////////EMPIEZA EL FORMULARIO
	formData = [
				{type: "settings", position: "label-left", labelWidth: 100, inputWidth: "auto"},
				
			{type: "fieldset", label: "Agregar Nuevo Grupo",  offsetLeft: 5, offsetRight: 5, offsetTop: 5, inputWidth: 510, list:[
					{type: "hidden", label: "ref_plantilla:", width: 210, name: "ref_plantilla", value: "<?php echo $_GET["varidplanty"]; ?>"},	
					{type: "input", label: "Nombre Grupo:", width: 210, name: "titulo_grupo", value: "", required: true, validate: "NotEmpty" },

					{type: "input", label: "Titulo Adicional:", width: 210, name: "titulo", value: "" },
					//{type:"newcolumn"},
					//{type: "input", label: "Valor_Defecto", width: 60, name: "valorx_defecto", value: "", required: true, validate: "NotEmpty" },
				
					
					
{type:"newcolumn"},
	 {type: "button", value: ">>  Agregar Grupo <<", name: "send", offsetLeft: 5, offsetTop: 0, width: 140, className: "button_save"},			
	//{type:"newcolumn"},
   			

				]},
				{type:"newcolumn"},
				 {type: "button", value: ">>>  Aceptar <<<", name: "cancel", offsetLeft: 50,  width: 100, className: "button_cancel"}
			];

			myForm = myLayout.cells("a").attachForm(formData);
			/////////////////////////////////////TERMINA EL FORMULARIO
			myForm.attachEvent("onButtonClick", function(id){
				
				if (id == "cancel") 
				{
					document.location.href="plantilla_lista_campos.php?varidplatycmps=<?php echo $_GET["varidplanty"]; ?>";
				}
				
				if (id == "send") 
					{
						
					 myForm.send("php/plantilla_nuevo_grupo.php", function(loader, response){
						    //alert(response);
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se Registro con exito!!",
						    callback: function() { document.location.href="plantilla_form_grupos_crear.php?varidplanty=<?php echo $_GET["varidplanty"]; ?>"; }
							});
							/////////////////////////////////
					      });
					
							
					}
			});
			////////////////////////////////////////////////FIN PROCESOS FORMULARIO
	<?php if(isset($_GET["varidplanty"]) != NULL) {    ?>
	myLayout.cells("b").attachURL("plantilla_form_vistagrupos.php?varidplanty=<?php echo $_GET["varidplanty"]; ?>");
	<?php } else {    ?>
	myLayout.cells("b").attachURL("plantilla_form_vistagrupos.php");
	<?php }    ?>
	
	
	
	}
	
</script>
<link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue_blue/dhtmlx.css"/>
</head>
<body onLoad="doOnLoad();">


</body>
</html>