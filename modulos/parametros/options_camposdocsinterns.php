<?php
   // $latabla='carto_fa_ecuador_parroquial';
	
	require_once('config.php');
	
	
	$sql = "SELECT column_name FROM information_schema.columns WHERE  table_name='tbli_esq_plant_formunico_docsinternos' and column_name  in('codi_barras','origen_cedul','origen_nombres','origen_tipo_tramite','origen_tipodoc','origen_departament','respuesta_estado','codigo_tramite','origen_form_asunto');";
	

    $resulprovs = pg_query($conn, $sql);
    $numerdatos = pg_num_rows($resulprovs);

   // sleep(2);
	//$_REQUEST["t"] = "select";

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
	    echo "<option value='".pg_fetch_result($resulprovs,$im,0)."'>".pg_fetch_result($resulprovs,$im,0)."</option>";
	  }
	echo	"</complete>";
	/////////////////////////////////////////////

}


?>