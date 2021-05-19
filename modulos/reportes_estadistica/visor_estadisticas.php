<?php
require_once('../../clases/conexion.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
   
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    
    <!-- nuevos estilos -->
    
	<script  src="codebase/dhtmlxgridcell.js"></script>	

<style type="text/css"> 

html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #dce7fa;
			overflow: hidden;
			/*font-family: verdana, arial, helvetica, sans-serif;*/
           
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

    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar;
	
function cambiargraf(infobj,infograf)
{
	//alert("hola"+infobj + infograf );
	myLayout.cells("a").attachURL("grafica_graficadorinfo.php?xvarenvist="+infobj+"&xvarentipgraf="+infograf);
}
		
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2U",
	cells: [
	         {id: "a", text: "Grafica Estadistica" },{id: "b", text: "Tipo Grafica" , width: 111 }
		   ] 
    });
	
			//myLayout.cells("a").hideHeader();
			
			//myLayout.cells("d").collapse();
			//myLayout.cells("d").showHeader();
			//myLayout.cells("d").hideHeader();
			myLayout.cells("b").attachObject("menugraficasest");
			myLayout.cells("a").attachURL("grafica_graficadorinfo.php?xvarenvist=<?php echo $_GET["xvarenvist"]; ?>&xvarentipgraf=<?php echo $_GET["xvarentipgraf"]; ?>");	
	
  ///////////fin metodo onload()
	}
	
</script>
</head>
<body onLoad="doOnLoad();">

<div id="menugraficasest" style="background-color:#DCE7FA; height:100% ">
  <table width="102" border="0" align="right">
  <tr>
    <td width="46"><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','barH');" ><img  src="../../componentes/common/48/tipog_barH.png" name="btngrafic" width="48" height="48" id="btngrafic"></a></td>
    <td width="46"><a  href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','pie');" ><img id="btngrafic" src="../../componentes/common/48/tipog_pie.png" width="48" height="48"></a></td>
  </tr>
  <tr>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','spline');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_sinu.png" width="48" height="48"></a></td>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','area');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_area.png" width="48" height="48"></a></td>
  </tr>
  <tr>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','bar');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_barV.png" width="48" height="48"></a></td>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','donut');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_dona.png" width="48" height="48"></a></td>
  </tr>
  <tr>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','scatter');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_puntos.png" width="48" height="48"></a></td>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','radar');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_radar.png" width="48" height="48"></a></td>
  </tr>
  <tr>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','pie3D');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_pie3D.png" width="48" height="48"></a></td>
    <td><a href="#" onClick="javascript:cambiargraf('<?php echo $_GET["xvarenvist"]; ?>','line');" ><img id="btngrafic"  src="../../componentes/common/48/tipog_line.png" width="48" height="48"></a></td>
  </tr>
</table>
</div>

</body>
</html>
