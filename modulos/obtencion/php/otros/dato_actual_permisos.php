<?php

require_once('config.php');

$sqlfre="INSERT INTO public.tbli_esq_plant_formunico_th_permisos(solic_cedula, solic_nombres, solic_cargo, solic_depart, solic_jefatura, solic_dias, solic_fecha_desde, solic_fecha_hasta, solic_horas, solic_hora_desde, solic_hora_hasta)    VALUES ('".$_REQUEST['solic_cedula']."','".$_REQUEST['solic_nombres']."' ,'".$_REQUEST['solic_cargo']."' ,'".$_REQUEST['solic_depart']."' ,'".$_REQUEST['solic_jefatura']."' ,'".$_REQUEST['solic_dias']."' ,'".$_REQUEST['solic_fecha_desde']."' ,'".$_REQUEST['solic_fecha_hasta']."' ,'".$_REQUEST['solic_horas']."' ,'".$_REQUEST['solic_hora_desde']."' ,'".$_REQUEST['solic_hora_hasta']."' );";

$result=pg_query($conn, $sqlfre);

echo $sqlfre;


?>