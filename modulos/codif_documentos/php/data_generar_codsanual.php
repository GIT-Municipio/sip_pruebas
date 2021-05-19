<?php

require_once('config.php');

if($_REQUEST[anio_actual]!="")
{

 $parainresar="select count(*) from tbli_esq_plant_formato_numeracion where  anio_actual='".$_REQUEST[anio_actual]."';";		
$result=pg_query($conn, $parainresar);
$vertotal=pg_fetch_result($result,0,0);
if($vertotal==0)
{

$parainresar="select date_part('year',now()) as anio;";		
$result=pg_query($conn, $parainresar);
$verfecha=pg_fetch_result($result,0,0);
if($_REQUEST[anio_actual]>=$verfecha)
{
$parainresaractunum="UPDATE public.tbli_esq_plant_formato_numeracion  SET  activo=0, est_eliminado=1;";		
$resultactunum=pg_query($conn, $parainresaractunum);

$paratiposdoc="SELECT codigo_doc,tipo   FROM public.tbli_esq_plant_formunico_tipodoc where activo=1;";		
$resulttips=pg_query($conn, $paratiposdoc);

for($ih=0;$ih<pg_num_rows($resulttips);$ih++)
{
  $parainresar="INSERT INTO public.tbli_esq_plant_formato_numeracion(cod_depart,cod_jefatura,anio_actual,cod_tipo_doc,cod_tipo_nomdoc,ref_id_departam,ref_descrip_depar) (SELECT substring(codigo_unif for 3),codigo_dep, '".$_REQUEST[anio_actual]."', '".pg_fetch_result($resulttips,$ih,0)."', '".pg_fetch_result($resulttips,$ih,1)."', id,nombre_departamento FROM public.tblb_org_departamento order by id);";
$result=pg_query($conn, $parainresar);
}

echo "ok";

}
else
    echo "error1";

}
else
   echo "error2";

}

?>