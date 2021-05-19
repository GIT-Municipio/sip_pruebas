<?php
   // $latabla='carto_fa_ecuador_parroquial';
	
	require_once('config.php');
	
	
	$sql = "SELECT column_name FROM information_schema.columns WHERE  table_name='tbli_esq_plant_form_cuadro_clasif' and column_name not in('id','fecha','observacion','requisitos','numer_inicial','numer_final','total_docs','activo','est_eliminado','total_docs','ced_responsable','nom_responsable','ced_asistente','nom_asistente','nom_proceso','img_btn_verequisit','img_btn_mostrarequis','img_btn_selecciona','img_btn_configura','img_btn_eliminar','estado_creanew','numer_actual_seq','atencion_tiempo_dias','vigencia_tiempo_dias','nivel');";
	

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