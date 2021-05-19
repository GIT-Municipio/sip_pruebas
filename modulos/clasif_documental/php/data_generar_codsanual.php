<?php

require_once('config.php');

if($_REQUEST[anio_actual]!="")
{

 $parainresar="select count(*) from tbli_esq_plant_form_cuadro_clasif where  anio_actual='".$_REQUEST[anio_actual]."';";		
$result=pg_query($conn, $parainresar);
$vertotal=pg_fetch_result($result,0,0);
if($vertotal==0)
{


$parainresar="select date_part('year',now()) as anio;";		
$result=pg_query($conn, $parainresar);
$verfecha=pg_fetch_result($result,0,0);
if($_REQUEST[anio_actual]>=$verfecha)
{

$parainresaractante="UPDATE public.tbli_esq_plant_form_cuadro_clasif  SET  activo=0, est_eliminado=1;";		
$resultantes=pg_query($conn, $parainresaractante);

  $parainresar="INSERT INTO tbli_esq_plant_form_cuadro_clasif(cod_clase, cod_tipo, cod_grupo, detalle, requisitos, ref_id_proceso, anio_actual, numer_inicial, numer_final)
    (select cod_clase, cod_tipo, cod_grupo, detalle, requisitos, ref_id_proceso, ".$_REQUEST[anio_actual].", numer_inicial, numer_final from tbli_esq_plant_form_cuadro_clasif);";
$result=pg_query($conn, $parainresar);

echo "ok";

}
else
    echo "error1";
}
else
   echo "error2";

}

?>