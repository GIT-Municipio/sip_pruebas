<?php
  	require_once('config.php');
	
	
	$sql = "select id,descripcion from cat_mapas_capa_tipo_estilo";
	
	$resulprovs = pg_query($conn, $sql);
    $numerdatos = pg_num_rows($resulprovs);
	
	

header("Content-Type: text/xml");

if ($_REQUEST["t"] == "select") {
	//////////provincial, cantonal o parroquial//////////
	
	echo '<?xml version="1.0" encoding="utf-8"?>'.'<data>';
	for($im=0;$im<$numerdatos;$im++)
	  {
		echo '<item value="'.pg_fetch_result($resulprovs,$im,0).'" label="'.pg_fetch_result($resulprovs,$im,1).'"/>';
	  }
	echo	'</data>';
	
}

if ($_REQUEST["t"] == "combo") {
	//////////provincial, cantonal o parroquial//////////
	
	echo '<?xml version="1.0" encoding="utf-8"?>'.'<complete>';
	
	
	  for($im=0;$im<$numerdatos;$im++)
	  {
		  if (pg_fetch_result($resulprovs,$im,0)==1)
	        echo "<option value='".pg_fetch_result($resulprovs,$im,0)."' selected='1'>".pg_fetch_result($resulprovs,$im,1)."</option>";
	      else
			echo "<option value='".pg_fetch_result($resulprovs,$im,0)."'>".pg_fetch_result($resulprovs,$im,1)."</option>";
	  }

	echo	"</complete>";
	/////////////////////////////////////////////

}


?>