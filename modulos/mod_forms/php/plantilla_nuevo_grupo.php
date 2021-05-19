<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/
//$_REQUEST[requisitos]=0;

if($_REQUEST[titulo_grupo]!="")
{
   if($_REQUEST[titulo]!="")
  $parainresar="INSERT INTO tbli_esq_plant_form_plantilla_grupo(titulo_grupo, titulo,ref_plantilla,publico,mostrar_titulo)
    VALUES (upper('".$_REQUEST[titulo_grupo]."'), '".$_REQUEST[titulo]."', '".$_REQUEST[ref_plantilla]."',1,1);";
	else
	$parainresar="INSERT INTO tbli_esq_plant_form_plantilla_grupo(titulo_grupo, titulo,ref_plantilla,publico)
    VALUES (upper('".$_REQUEST[titulo_grupo]."'), '".$_REQUEST[titulo]."', '".$_REQUEST[ref_plantilla]."',1);";
			
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>