<?php
require_once('../../clases/conexion.php');
/////////////////verificar
$paraconsfre="select nombre_tabla_anexos from tbli_esq_plant_form_plantilla where id='".$_GET["varidplanty"]."' ";
$resultfrec=pg_query($conn, $paraconsfre);
$nombrestablanex=pg_fetch_result($resultfrec,0,0);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>

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
		
    .estilolog {
		background-image:url(imgs/fondolog.png);
	}

div.tab_portafolio {
			/*color: red;*/
			color: blue;
			background-image:url(imgs/icon_portafolio.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_reportes {
			color: blue;
			background-image:url(imgs/tag_orange.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}



div.tab_recibidos {
			/*color: blue;*/
			background-image:url(imgs/icon_recibidos.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_nuevos {
			/*color: blue;*/
			background-image:url(imgs/icon_nuevodoc.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enedicion {
			/*color: blue;*/
			background-image:url(imgs/icon_enedicion.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enviados {
			/*color: blue;*/
			background-image:url(imgs/icon_enviados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_reasignados {
			/*color: blue;*/
			background-image:url(imgs/icon_reasignados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_informados {
			/*color: blue;*/
			background-image:url(imgs/icon_informados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_archivados {
			/*color: blue;*/
			background-image:url(imgs/icon_archivado.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_eliminados {
			/*color: blue;*/
			background-image:url(imgs/icon_elimmsj.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_perspermisos {
			/*color: blue;*/
			background-image:url(imgs/permisosusu.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
		
div.tab_estadist {
			/*color: blue;*/
			background-image:url(imgs/acepload.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}		

    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar,mygrid_itemd;
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "1C",
	cells: [
	         {id: "a", text: "Datos", height: 150 }
		   ] 
    });
	
	//myLayout.cells("a").hideHeader();
	//myLayout.cells("a").collapse();
	myTabbar = myLayout.cells("a").attachTabbar({
				tabs: [
					 { id: "a1", text: "VISTA FORMULARIO USUARIO EXTERNO", active: true },
					 { id: "a2", text: "ANEXOS DEL USUARIO" },
					 
				]
			});
	
	myTabbar.tabs("a1").attachURL("form_vistausu.php?rp=<?php echo $_GET['varidplanty']; ?>&varclaveuntramusu=<?php echo $_GET['varclaveuntramusu']; ?>");
	myTabbar.tabs("a2").attachURL("form_pubanex.php?mvpr=<?php echo $_GET['varidplanty']; ?>&varclaveuntramusu=<?php echo $_GET['varclaveuntramusu']; ?>&pontblanexo=<?php echo $nombrestablanex; ?>");
	//////////////////////////////////////////////////////////////////////
  ///////////fin metodo onload()
  
	}
	
</script>
</head>
<body onLoad="doOnLoad();">
</body>
</html>
