<?php
  	require_once('config.php');
	
	
	$sql = "SELECT id, nombre_proceso   FROM public.tble_proc_proceso order by id;";
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
	    echo "<option value='".pg_fetch_result($resulprovs,$im,0)."'>".pg_fetch_result($resulprovs,$im,1)."</option>";
	  }

	echo	"</complete>";
	/////////////////////////////////////////////

}


?>