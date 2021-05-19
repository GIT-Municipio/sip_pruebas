<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/


if($_REQUEST[cod_instit]!="")
{

echo $parainresar="select count(*) from tbli_esq_plant_formato_numeracion where  anio_actual='".$_REQUEST[anio_actual]."' and cod_tipo_doc='".$_REQUEST[cod_tipo_doc]."';";		
$result=pg_query($conn, $parainresar);
$vertotal=pg_fetch_result($result,0,0);
if($vertotal==0)
{
	
	 $paradepart="SELECT id, (SELECT substring(codigo_unif for 3)) as cod_depart,codigo_dep as cod_jef, nombre_departamento  FROM public.tblb_org_departamento where  id='".$_REQUEST[ref_id_departam]."';";		
$resultdetpart=pg_query($conn, $paradepart);
$varcodifid=pg_fetch_result($resultdetpart,0,'id');
$varcod_depart=pg_fetch_result($resultdetpart,0,'cod_depart');
$varcod_jef=pg_fetch_result($resultdetpart,0,'cod_jef');
$varnombre_departamento=pg_fetch_result($resultdetpart,0,'nombre_departamento');
	
	
	
	
 echo $parainresar="INSERT INTO tbli_esq_plant_formato_numeracion(cod_instit,ref_id_departam,anio_actual,numer_inicial,cod_tipo_doc,cod_depart, cod_jefatura,ref_descrip_depar)
    VALUES ('".$_REQUEST[cod_instit]."', '".$_REQUEST[ref_id_departam]."', '".$_REQUEST[anio_actual]."', '".$_REQUEST[numer_inicial]."', '".$_REQUEST[cod_tipo_doc]."','".$varcod_depart."','".$varcod_jef."','".$varnombre_departamento."');";
$result=pg_query($conn, $parainresar);
}

}

?>