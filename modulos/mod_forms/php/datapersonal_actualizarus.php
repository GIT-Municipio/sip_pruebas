<?php

require_once('config.php');

$casosvarop1=0;
$casosvarop2=0;
$casosvarop3=0;

if($_REQUEST['ced_responsable']!="")
{	
$paracons="select usua_nomb || ' ' || usua_apellido from tblu_migra_usuarios where usua_cedula='".$_REQUEST['ced_responsable']."' ";
$result=pg_query($conn, $paracons);
$nombresresp=pg_fetch_result($result,0,0);
$casosvarop1=1;
}
if($_REQUEST['ced_asistente']!="")
{	
$paracons="select usua_nomb || ' ' || usua_apellido from tblu_migra_usuarios where usua_cedula='".$_REQUEST['ced_asistente']."' ";
$result=pg_query($conn, $paracons);
$nombresasis=pg_fetch_result($result,0,0);
$casosvarop2=1;
}

if($_REQUEST['ref_id_proceso']!="")
{	
$paracons="select nombre_proceso from tble_proc_proceso where id='".$_REQUEST['ref_id_proceso']."' ";
$result=pg_query($conn, $paracons);
$nombresproceso=pg_fetch_result($result,0,0);
$casosvarop3=1;
}

 $parainresar="UPDATE public.tbli_esq_plant_form_cuadro_clasif SET cod_clase='".$_REQUEST['cod_clase']."', cod_tipo='".$_REQUEST['cod_tipo']."', cod_grupo='".$_REQUEST['cod_grupo']."', ";
 
if($casosvarop1==1)
{
$parainresar.=" ced_responsable='".$_REQUEST['ced_responsable']."', ";
$parainresar.=" nom_responsable='".$nombresresp."', ";
}
if($casosvarop2==1)
{
$parainresar.=" ced_asistente='".$_REQUEST['ced_asistente']."', ";
$parainresar.=" nom_asistente='".$nombresasis."', ";
}
 
if($casosvarop3==1)
{
$parainresar.=" ref_id_proceso='".$_REQUEST['ref_id_proceso']."', ";
$parainresar.=" nom_proceso='".$nombresproceso."', ";
}

$parainresar.=" detalle='".$_REQUEST['detalle']."' WHERE  id='".$_REQUEST['id']."';";
//echo $parainresar;			
$result=pg_query($conn, $parainresar);


?>