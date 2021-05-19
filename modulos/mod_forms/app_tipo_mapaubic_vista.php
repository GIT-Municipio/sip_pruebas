<?php
require_once '../../clases/conexion.php';

 $datosql="select *from tbli_esq_plant_form_plantilla where id='".$_GET["ponref_plantilla"]."'";
 $consulta = pg_query($conn,$datosql);
 $ponertabla=pg_fetch_result($consulta,0,'nombre_tablabdd');
 
$datosql="SELECT ".$_GET['varitabcmpid']."  FROM plantillas.".$ponertabla." where id='".$_GET["varclaveuntramusu"]."'";
$consulta = pg_query($conn,$datosql);
 $misrcoordenfijas=pg_fetch_result($consulta,0,0);
$miscoordvector=explode(";",$misrcoordenfijas);
 $miscoordcontador=count($miscoordvector);
 if($miscoordcontador>=2)
     $misrcoordenfijas=$miscoordvector[0];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Mapa Ruteo</title>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijRV_pwtxTxIXMD4NMdVn02aknb6NJYI"   type="text/javascript"></script>

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="lib_jquery/componentmapas/jquery.gmap.js"></script>
        
       <link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
        <link href='http://fonts.googleapis.com/css?family=Lato:bolditalic' rel='stylesheet' type='text/css'>
        
        
        
        
	   <script src="codebase/dhtmlx.js"></script>

        <script type="text/javascript">

            var sbObj;
            var rendererOptions = {
                draggable: true
            };

            var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
            ;
            var directionsService = new google.maps.DirectionsService();
            var map;

            var australia = new google.maps.LatLng(<?php if($misrcoordenfijas!="") echo $misrcoordenfijas; else "0.349854, -78.118396";?>);

            function initialize() {

                var myOptions = {
                    zoom: 7,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center: australia
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById("directionsPanel"));

                google.maps.event.addListener(directionsDisplay, 'directions_changed', function () {
                    computeTotalDistance(directionsDisplay.directions);
					
					/////origen
						var coordInilat=directionsDisplay.directions.routes[0].legs[0].start_location.lat();
						var coordInilng=directionsDisplay.directions.routes[0].legs[0].start_location.lng();
						/////destino
						var coordFinlat=directionsDisplay.directions.routes[0].legs[0].end_location.lat();
						var coordFinlng=directionsDisplay.directions.routes[0].legs[0].end_location.lng();
						//////recopilo
						document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value=coordInilat +"," + coordInilng + ";"+coordFinlat +"," + coordFinlng;
						////fin
                });
				
				
				
				 var icongenini = {
    				url: "imgs/markini.png", // url
   					 scaledSize: new google.maps.Size(20, 30), // scaled size
    				origin: new google.maps.Point(0,0), // origin
    				anchor: new google.maps.Point(0, 0) // anchor
				};

				 var icongenfin = {
    				url: "imgs/markfin.png", // url
    				scaledSize: new google.maps.Size(20, 30), // scaled size
    				origin: new google.maps.Point(0,0), // origin
    				anchor: new google.maps.Point(0, 0) // anchor
				};

				 <?php if($miscoordcontador>=2) { 
				 for($i=0;$i<$miscoordcontador;$i++){
				 ?>
               addMarker(new google.maps.LatLng(<?php echo $miscoordvector[$i]; ?>), "Imbabura Province, Ecuador", icongenini,"Imbabura Province, Ecuador",0);
			   <?php 
				 }
			   } else { ?>
			    addMarker(new google.maps.LatLng(<?php echo $misrcoordenfijas; ?>), "Imbabura Province, Ecuador", icongenini,"Imbabura Province, Ecuador",0);
			    <?php } ?>
			  
			  
			  <?php if($miscoordcontador>=2) { ?>
               calcRoute();
			   <?php } ?>
				
            }
			
			function addMarker(latlng, myTitle,icono,descrip,estad){ 
       marker = new google.maps.Marker({
            position: latlng,
            icon: icono,
            map: map,
            optimized:false, 
            title: myTitle,
        });
		
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(marker.getPosition());
		map.fitBounds(bounds);
		map.setCenter(bounds.getCenter()); 
		map.setZoom(13); 

        marker.infowindow = new google.maps.InfoWindow({
            content: '<p>'+descrip +'<br>' +latlng+'</p>'
        });
        //add click event
        google.maps.event.addListener(marker, 'click', function(){
            this.infowindow.open(map,this);
        });
		
		if( estad == 1)
		{
		   marker.infowindow.open(map,marker);
		}
    }




            function calcRoute() {
				
				
                var request = {
                    origin: "Cotacachi, Imbabura",
                    destination: "Quiroga, Imbabura",
                    // waypoints:[{location: "antonio ante, imbabura"}, {location: "pimampiro, imbabura"}, {location: "otavalo, imbabura"}],     
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
						/////origen
						var coordInilat=directionsDisplay.directions.routes[0].legs[0].start_location.lat();
						var coordInilng=directionsDisplay.directions.routes[0].legs[0].start_location.lng();
						/////destino
						var coordFinlat=directionsDisplay.directions.routes[0].legs[0].end_location.lat();
						var coordFinlng=directionsDisplay.directions.routes[0].legs[0].end_location.lng();
						//////recopilo
						document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value=coordInilat +"," + coordInilng + ";"+coordFinlat +"," + coordFinlng;
						
                    }
                });

            }
			
			///////////////////////
			 function calcRutaMisLugares(lugarini,lugarfin) {
				
				
                var request = {
                    origin: lugarini+", Imbabura",
                    destination: lugarfin+", Imbabura",
                    // waypoints:[{location: "antonio ante, imbabura"}, {location: "pimampiro, imbabura"}, {location: "otavalo, imbabura"}],     
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
						
						/////origen
						var coordInilat=directionsDisplay.directions.routes[0].legs[0].start_location.lat();
						var coordInilng=directionsDisplay.directions.routes[0].legs[0].start_location.lng();
						/////destino
						var coordFinlat=directionsDisplay.directions.routes[0].legs[0].end_location.lat();
						var coordFinlng=directionsDisplay.directions.routes[0].legs[0].end_location.lng();
						//////recopilo
						document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value=coordInilat +"," + coordInilng + ";"+coordFinlat +"," + coordFinlng;
						////////////////fin	
                    }
                });
            }
			////////////////////////

            function computeTotalDistance(result) {
                var total = 0;
                var myroute = result.routes[0];

                for (i = 0; i < myroute.legs.length; i++) {
                    total += myroute.legs[i].distance.value;
                }
                total = total / 1000.
                document.getElementById("total").innerHTML = total + " km";
                
            }
			/*
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
			*/
			/////////////////////buscar lugares
			 var geocoder = new google.maps.Geocoder();
			 
	function buscarLugares(txtbusq) {     
			var address = txtbusq;
			geocoder.geocode( { 'address': address}, function(results, status) {       

	if (status == google.maps.GeocoderStatus.OK) 
	{         
			map.setCenter(results[0].geometry.location);         

			var image = 'imgs/map_marker.gif'; 

			var marker = new google.maps.Marker({             
				map: map,  
				icon: image,         
				position: results[0].geometry.location         
			}); 
			
          //sbObj.setText( marker.getPosition().lat() +";" + marker.getPosition().lng());
		  document.getElementById("<?php echo $_GET['varitabcmpid']; ?>").value=marker.getPosition().lat() +"," + marker.getPosition().lng();
		  
		  //////////////acercar el zzom al lugar
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(marker.getPosition());
		map.fitBounds(bounds);
		map.setCenter(bounds.getCenter()); 
		map.setZoom(13); 
      
	} else {         
		alert("Geocode was not successful for the following reason: " + status);       
	}     
});   

}


</script>
<script type="text/javascript">

        	function doOnLoad() {
		    initialize();
			myLayout = new dhtmlXLayoutObject({
				//parent: "layoutObj",
				parent: document.body,
				pattern: "2U",
				cells: [{id: "a", text: "Mapa" },{id: "b", text: "Informacion de Ruta", width: 300 }]
			});
			
			//myLayout.cells("a").hideHeader();
			myLayout.cells("b").collapse();
			
			myLayout.cells("a").attachObject("map_canvas");	
			myLayout.cells("b").attachObject("directionsPanel");	
			
			sbObj = myLayout.attachStatusBar({text:"<form id='formcoords' name='formcoords' method='post' action='actual_coordenadas.php'><input name='ponref_plantilla' type='hidden' id='ponref_plantilla' value='<?php echo $_GET['ponref_plantilla']; ?>'  /><input name='varitabcmpid' type='hidden' id='varitabcmpid' value='<?php echo $_GET['varitabcmpid']; ?>'  /><input name='varclaveuntramusu' type='hidden' id='varclaveuntramusu' value='<?php echo $_GET['varclaveuntramusu']; ?>'  /><input name='<?php echo $_GET['varitabcmpid']; ?>' type='hidden' id='<?php echo $_GET['varitabcmpid']; ?>' value=''  /><input type='submit' name='btnenviar' id='btnenviar' value='FIJAR COORDENADAS' style='color:#000;width:202px;height:40px; font-size:14px' /></form>"});
			
			menusuptools = myLayout.cells("a").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				//xml: "xml/barbtns_gmaps.xml",
								
			});
			
			opts = [
           ['id1', 'obj', 'Imantag', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id2', 'obj', 'Cuellaje', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id3', 'obj', 'Apuela', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id4', 'obj', 'Garcia Moreno', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id5', 'obj', 'Peñaherrera', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id6', 'obj', 'Plaza Gutierrez', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id7', 'obj', 'Vacas Galindo', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id8', 'obj', 'Quiroga', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id9', 'obj', 'Cotacachi', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id10', 'obj', 'Ibarra', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id11', 'obj', 'Antonio Ante', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
	        ['id12', 'obj', 'Otavalo', 'itmcampo.png'],
		['sep01', 'sep', '', ''],
	        ['id12', 'obj', 'Pimampiro', 'itmcampo.png'],
		['sep01', 'sep', '', ''],
	        ['id12', 'obj', 'Urcuqui', 'itmcampo.png'],
        ['sep01', 'sep', '', ''],
		    //['sep01', 'sep', '', '']
	];
	
	menusuptools.addText("textolabel", 1, "Ingrese Ubicación: ");
	menusuptools.addInput("ingrestextvalor",2,"Cotacachi, Imbabura",120);
	menusuptools.addButton("btn_busquedapto", 3, "Aplicar busqueda", "buscardep.png");
	menusuptools.addText("textolabel", 4, "  ");
	menusuptools.addText("textolabel", 5, "Seleccione Ruta: ");
	menusuptools.addButtonSelect("btnselcampodesde", 6, "Seleccionar Desde...", opts, "itmcampo.png", "itmcampo.png",null, null, null, "select");
	menusuptools.addButtonSelect("btnselcampohasta", 7, "Seleccionar Hasta...", opts, "itmcampo.png", "itmcampo.png",null, null, null, "select");
	menusuptools.addButton("btn_busquedaruta", 8, "Buscar Ruta", "buscardep.png");

			
			menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="btn_busquedapto")
			{
				var selvarinfo=menusuptools.getValue("ingrestextvalor");
				//alert(selvarinfo);
				buscarLugares(selvarinfo);
			}
			if(id=="btn_busquedaruta")
			{
				var selvarinfoini=menusuptools.getItemText("btnselcampodesde");
				var selvarinfofin=menusuptools.getItemText("btnselcampohasta");
				calcRutaMisLugares(selvarinfoini,selvarinfofin);
			}
			

		});
			
//////////////////////////////////////////////////////////
}
</script>

<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
		.map{
   
    width: 100%;
    height: 100%;
    border: 1px solid #000;
    margin-bottom: 0px;
	border-top:1px solid #999;
	border-left:1px solid #999;
	border-right:1px solid #fff;
	border-bottom:1px solid #fff;
}
	</style>
    </head>

<body onload="doOnLoad()">

<div id="map_canvas" class="map">
              <p>Mapa Imbabura.</p>
</div>
<div id="directionsPanel" style="width:100%;height:100%; overflow:scroll">
              <p>Total Distancia: <span id="total"></span></p>
</div>

    </body>
</html>
