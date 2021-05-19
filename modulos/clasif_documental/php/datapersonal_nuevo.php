<?php

require_once('config.php');




/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/
$nombreprocesotxt="";

$_REQUEST[requisitos]=0;

if($_REQUEST[ref_id_proceso]=="")
{
  $_REQUEST[ref_id_proceso]=0;
}
else
{
$parconsul="SELECT id, nombre_proceso   FROM tble_proc_proceso WHERE id='".$_REQUEST[ref_id_proceso]."'";		
$resultcons=pg_query($conn, $parconsul);
$nombreprocesotxt=pg_fetch_result($resultcons,0,'nombre_proceso');
}

	  

if($_REQUEST[cod_clase]!="")
{
	$parconsulnum="SELECT max(cast(cod_grupo as int)) as numgrupo  FROM tbli_esq_plant_form_cuadro_clasif WHERE cod_clase='".$_REQUEST[cod_clase]."'";		
$resultconsnum=pg_query($conn, $parconsulnum);
$varnumgrupo=pg_fetch_result($resultconsnum,0,'numgrupo')+1;
	

 echo $parainresar="INSERT INTO tbli_esq_plant_form_cuadro_clasif(cod_clase, cod_tipo, cod_grupo, detalle, requisitos, ref_id_proceso, anio_actual, numer_inicial, numer_final,nom_proceso)
    VALUES ('".$_REQUEST[cod_clase]."', '1', '".$varnumgrupo."', '".$_REQUEST[detalle]."', '".$_REQUEST[requisitos]."', '".$_REQUEST[ref_id_proceso]."', '".$_REQUEST[anio_actual]."', '".$_REQUEST[numer_inicial]."', '99999', '".$nombreprocesotxt."');";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>