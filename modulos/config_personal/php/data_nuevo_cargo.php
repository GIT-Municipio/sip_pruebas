<?php

require_once('config.php');
/*
	if($_REQUEST[data_tipo_activusuarios]==true)
	  $_REQUEST[data_tipo_activusuarios]=1;
	  else
      $_REQUEST[data_tipo_activusuarios]=2;
*/


if($_REQUEST[cargo_puesto]!="")
{
echo $parainresar="INSERT INTO tblc_th_catalogo_cargo(cargo_puesto, regimen, actividad_principal) VALUES ('".$_REQUEST[cargo_puesto]."', '".$_REQUEST[regimen]."', '".$_REQUEST[actividad_principal]."');";
			
	
$result=pg_query($conn, $parainresar);

}

?>