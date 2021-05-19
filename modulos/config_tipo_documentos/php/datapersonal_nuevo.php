<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/


if($_REQUEST[tipo]!="")
{
 $parainresar="INSERT INTO tbli_esq_plant_formunico_tipodoc(codigo_doc,tipo)     VALUES ('".$_REQUEST[codigo_doc]."', '".$_REQUEST[tipo]."');";
$result=pg_query($conn, $parainresar);


}

?>