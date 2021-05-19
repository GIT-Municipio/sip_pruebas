<?php
  	require_once('config.php');
	
	
	$sql = "select geo.idcapageo, nomesquema||'.'||nombrecapa as layergeo from cat_menucatalogo cat, cat_catalogogeografico geo where cat.idcapageo=geo.idcapageo and idmenucatalogo='".$_GET[envioidcatalogx]."' ";
	
	$resulprovs = pg_query($conn, $sql);
	$tabalretorngeo=pg_fetch_result($resulprovs,0,1);
	
	$sql = "select *from ".$tabalretorngeo."  ;";
	
	$resulprovs = pg_query($conn, $sql);
	
    $numerdatos = pg_num_fields($resulprovs);
	
	

header("Content-Type: text/xml");

if ($_REQUEST["t"] == "select") {
	//////////provincial, cantonal o parroquial//////////
	
	echo '<?xml version="1.0" encoding="utf-8"?>'.'<data>';
	for($im=0;$im<$numerdatos;$im++)
	  {
		echo '<item value="'.pg_field_name($resulprovs,$im).'" label="'.pg_field_name($resulprovs,$im).'"/>';
	  }
	echo	'</data>';
	
}

if ($_REQUEST["t"] == "combo") {
	//////////provincial, cantonal o parroquial//////////
	
	echo '<?xml version="1.0" encoding="utf-8"?>'.'<complete>';
	
	
	  for($im=0;$im<$numerdatos;$im++)
	  {
	    echo "<option value='".pg_field_name($resulprovs,$im)."'>".pg_field_name($resulprovs,$im)."</option>";
	  }

	echo	"</complete>";
	/////////////////////////////////////////////

}


?>