<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/
$_REQUEST[requisitos]=0;

if($_REQUEST[cod_clase]!="")
{

 echo $parainresar="INSERT INTO tbli_esq_plant_form_cuadro_clasif(cod_clase, cod_tipo, cod_grupo, detalle, requisitos, ref_id_proceso, anio_actual, numer_inicial, numer_final)
    VALUES ('".$_REQUEST[cod_clase]."', '".$_REQUEST[cod_tipo]."', '".$_REQUEST[cod_grupo]."', '".$_REQUEST[detalle]."', '".$_REQUEST[requisitos]."', '".$_REQUEST[ref_id_proceso]."', '".$_REQUEST[anio_actual]."', '".$_REQUEST[numer_inicial]."', '".$_REQUEST[numer_final]."');";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>