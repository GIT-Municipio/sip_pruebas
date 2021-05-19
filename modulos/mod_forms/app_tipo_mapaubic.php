<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
	<script src="codebase/dhtmlx.js"></script>
    <script type="text/javascript">
	
	function abreventanatablagrafaux(pagina)
	{
	var miPopupmapaobjtabauxgrf;
	miPopupmapaobjtabauxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopupmapaobjtabauxgrf.focus();
	}
	
	function abrevenimpresion(pagina)
	{
	var miPopimpresionxgrf;
	miPopimpresionxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopimpresionxgrf.focus();
	}
	
	
	function agregarcolumnas(variab,tab,idapli)
	{
		var nombrecol = prompt("Ingrese Nombre de Columna", "NuevaColumna");
		if (nombrecol != null)
	      document.location.href="php/add_column.php?miproy="+variab+"&nomcolumn="+nombrecol+"&mitabla="+tab+"&laidapli="+idapli;	
	}
	
	function eliminarcolumnas(variab,tab,idapli)
	{
		var nombrecol = prompt("Ingrese Nombre de Columna", "EliminoColumna");
		if (nombrecol != null)
	      document.location.href="php/elim_column.php?miproy="+variab+"&nomcolumn="+nombrecol+"&mitabla="+tab+"&laidapli="+idapli;	
	}
	
	function agregarcoordenadas(variab,tab,idapli)
	{
		//var nombrecol = prompt("Ingrese Nombre de Columna", "EliminoColumna");
		//if (nombrecol != null)
	      document.location.href="php/add_coordenadas.php?miproy="+variab+"&mitabla="+tab+"&laidapli="+idapli;	
	}
	
	
	function vertablanormal(variab,tab,idapli)
	{
		//var nombrecol = prompt("Ingrese Nombre de Columna", "EliminoColumna");
		//if (nombrecol != null)
	      document.location.href="app_tipo_tabla.php?pontabla="+idapli;	
	}
	
	</script>
    
<style type="text/css">    
html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
  a:link { 
    /*color: #FF0000;*/
	color: #036;
    font-family: Arial;
    font-size: 12px;
  }
  a:active { 
    /*color: #0000FF;*/
    font-family: Arial;
    font-size: 12px;
  }
  a:visited { 
   /*color: #800080;*/
    color: #033;
    font-family: Arial;
    font-size: 12px;
  }
  
  div#layoutObj {
			position: relative;
			margin-top: 0px;
			margin-left: 0px;
			width: 100%;
			height: 350px;
		}
</style>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijRV_pwtxTxIXMD4NMdVn02aknb6NJYI"   type="text/javascript"></script>
<script>

    var myLayout, GMaps, mygrid, myDataProcessor, Marker;
	var NY = {lat: 0.3000390654369439, lng: -78.26437010137943};
	
	var neighborhoods = [
  {lat: 0.3000390654369439, lng: -78.26437010137943},
  {lat: 0.846558, lng: -78.171374}
];

var markers = [];
var image = '../imagenes/icon_gmap1.png';
var elidgridfila;
	
	function doOnLoad() {
		
			myLayout = new dhtmlXLayoutObject({
				//parent: "layoutObj",
				parent: document.body,
				pattern: "2E",
				cells: [{id: "a", text: "Informacion Georeferenciada"},{id: "b", text: "Mapa Tematico" , height: 30   }]
			});
			
			myLayout.cells("b").hideHeader();
			myLayout.cells("b").attachObject("mostrarcoordenadasgmap");	
			
			var customparams = {
    				center: new google.maps.LatLng(NY.lat, NY.lng),
    				zoom: 11,
    				//disableDefaultUI: true,
    				mapTypeId: google.maps.MapTypeId.ROADMAP,
					
   			 };
			 
			 
			GMaps = myLayout.cells("a").attachMap(customparams);
			
			mostrarpuntos();
			function mostrarpuntos() {
				  limpiarpuntos();
					  for (var i = 0; i < neighborhoods.length; i++) {
						    agregarpuntos(neighborhoods[i], i * 200);
				  		}
				}

			function agregarpuntos(position, timeout) {
			  window.setTimeout(function() {
			    markers.push(new google.maps.Marker({
			      position: position,
			      map: GMaps,
				  icon: image,
			      animation: google.maps.Animation.DROP
			    }));
				}, timeout);
			}
			
			function limpiarpuntos() {
				  for (var i = 0; i < markers.length; i++) {
				    markers[i].setMap(null);
				  }
			  markers = [];
			  
			}
			
            //////////////agregar el punto que va a brindar las coordenadas
			 Marker = new google.maps.Marker({
				position: new google.maps.LatLng(NY.lat, NY.lng),
				title: "Posicion",
				map: GMaps,
				draggable:true,
				animation: google.maps.Animation.BOUNCE
			});
			
			  document.getElementById("coord_lat").innerHTML  = Marker.getPosition().lat();
    		  document.getElementById("coord_lng").innerHTML =  Marker.getPosition().lng();
			  document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value = document.getElementById("coord_lat").innerHTML + ";" + document.getElementById("coord_lng").innerHTML;
			
			google.maps.event.addListener(Marker, 'drag', function (event) {
    			document.getElementById("coord_lat").innerHTML  = this.getPosition().lat();
    			document.getElementById("coord_lng").innerHTML =  this.getPosition().lng();
				 
			});
			
			google.maps.event.addListener(Marker, 'dragend', function (event) {
    			document.getElementById("coord_lat").innerHTML  = this.getPosition().lat();
    			document.getElementById("coord_lng").innerHTML =  this.getPosition().lng();
				document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value = document.getElementById("coord_lat").innerHTML + ";" + document.getElementById("coord_lng").innerHTML;
			});

			
//////////////////////////////////////////////////////////
}


</script>

</head>
<body onLoad="doOnLoad();">

<div id="mostrarcoordenadasgmap">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" bgcolor="#dde1e9"><div style="font-size:10px">Longitud: <div id="coord_lng"></div></div></td>
    <td width="100%" bgcolor="#dde1e9"><div style="font-size:10px">Latitud: <div id="coord_lat"></div></div></td>
    <td width="100%" bgcolor="#dde1e9">
    <form id="formcoords" name="formcoords" method="post" action="actual_coordenadas.php">
    
    <input name='ponref_plantilla' type='hidden' id='ponref_plantilla' value='<?php echo $_GET['ponref_plantilla']; ?>'  />
    <input name='varitabcmpid' type='hidden' id='varitabcmpid' value='<?php echo $_GET['varitabcmpid']; ?>'  />
    
    <input name='varclaveuntramusu' type='hidden' id='varclaveuntramusu' value='<?php echo $_GET['varclaveuntramusu']; ?>'  />
    
    <input name='<?php echo $_GET['varitabcmpid']; ?>' type='hidden' id='<?php echo $_GET['varitabcmpid']; ?>' value=''  />
    <input type="submit" name="btnenviar" id="btnenviar" value="FIJAR COORDENADAS" style="color:#000;width:202px;height:40px; font-size:14px" />
    </form>
    </td>
  </tr>
</table>
</div>


</body>
</html>