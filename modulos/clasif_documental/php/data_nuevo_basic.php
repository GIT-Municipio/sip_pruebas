<?php

require_once('config.php');

if(!$_REQUEST[ref_id_proceso])
  $_REQUEST[ref_id_proceso]=0;


if($_REQUEST[cod_clase]!="")
{

 echo $parainresar="INSERT INTO tbli_esq_plant_form_cuadro_clasif(cod_clase, cod_tipo, cod_grupo, detalle,  ref_id_proceso,estado_creanew )
    VALUES ('".$_REQUEST[cod_clase]."', '".$_REQUEST[cod_tipo]."', '".$_REQUEST[cod_grupo]."', upper('".$_REQUEST[detalle]."'), '".$_REQUEST[ref_id_proceso]."',1);";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>