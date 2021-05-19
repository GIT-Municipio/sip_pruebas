<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <style type="text/css">    
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			/*background-color: #dce7fa;*/
			/*overflow: hidden;*/
			/*font-family: verdana, arial, helvetica, sans-serif;*/
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
           
		}
		
	#layoutmenusuperderecha{
	background-color:#e7f1ff;
	width:100%;
	height: 100%;
	font-size: 11px;
	}
	
	div.tab_docsitemsciu {
			/*color: blue;*/
			background-image:url(imgs/user_add.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	div.tab_docsitems {
			/*color: blue;*/
			background-image:url(imgs/btn_institucion.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
	
			
	
</style>
<script>
	//carga de informacion
var myLayout, myTabbar, mygrid;

function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "1C",
	cells: [{id: "a", text: "Elementos Enviados..."  }  ]
				
			});
	
	    myLayout.cells("a").hideHeader();	
		
	   
		myTabbar = myLayout.cells("a").attachTabbar({
				//parent: "accObj",
				tabs: [
					{id: "a1", text: "<div class='tab_docsitemsciu'>-- ANEXOS DEL CIUDADANO --</div>" , active: true},
					{id: "a2", text: "<div class='tab_docsitems'>-- ANEXOS DE RESPUESTA --</div>"},
				]
			});
	
	
	myTabbar.tabs("a1").attachURL("vistaform_anexos_ciud.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>&verrmisfechas=<?php echo $_GET["verrmisfechas"]; ?>&vercodigotramitext=<?php echo $_GET["vercodigotramitext"]; ?>&vartxtciudcedula=<?php echo $_GET["vartxtciudcedula"]; ?>");
	myTabbar.tabs("a2").attachURL("vistaform_anexos_instit.php?mvpr=<?php echo $_GET["mvpr"]; ?>&varcodgenerado=<?php echo $_GET["varcodgenerado"]; ?>");
	
	
		
	 
   /////////////////////////////////////
	}
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0"  onLoad="doOnLoad();">

</body>
</html>