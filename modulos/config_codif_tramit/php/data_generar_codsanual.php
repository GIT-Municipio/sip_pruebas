<?php

require_once('config.php');

if($_REQUEST[anio_actual]!="")
{

 $parainresar="select count(*) from tbli_esq_plant_form_cuadro_clasif where  anio_actual='".$_REQUEST[anio_actual]."';";		
$result=pg_query($conn, $parainresar);
$vertotal=pg_fetch_result($result,0,0);
if($vertotal==0)
{
$parainresar="UPDATE public.tbli_esq_plant_formato_numeracion  SET  activo=0, est_eliminado=1;";		
$result=pg_query($conn, $parainresar);

$parainresar="select date_part('year',now()) as anio;";		
$result=pg_query($conn, $parainresar);
$verfecha=pg_fetch_result($result,0,0);
if($_REQUEST[anio_actual]>=$verfecha)
{
  $parainresar="INSERT INTO public.tbli_esq_plant_formato_numeracion(cod_depart,cod_jefatura,anio_actual,cod_tipo_doc, ref_id_departam,ref_descrip_depar) (SELECT substring(codigo_unif for 3),codigo_dep, '".$_REQUEST[anio_actual]."', 'M', id,nombre_departamento FROM public.tblb_org_departamento order by id);";
$result=pg_query($conn, $parainresar);
}
}

}

?>