<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/


if($_REQUEST[anio]!="")
{

 echo $parainresar="select count(*) from tbli_esq_plant_form_configqr where  anio='".$_REQUEST[anio]."' and campo='".$_REQUEST[campo]."';";		
$result=pg_query($conn, $parainresar);
$vertotal=pg_fetch_result($result,0,0);
if($vertotal==0)
{
 echo $parainresar="INSERT INTO tbli_esq_plant_form_configqr(campo,descripcion,anio)
    VALUES ('".$_REQUEST[campo]."', '".$_REQUEST[descripcion]."', '".$_REQUEST[anio]."');";
$result=pg_query($conn, $parainresar);
}

}

?>