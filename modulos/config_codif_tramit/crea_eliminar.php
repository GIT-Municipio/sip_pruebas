<?php


require_once('../../clases/conexion.php');

$totalfil=$_GET["vafil"];
if($totalfil!=0)
{
session_start();
		

$sql = "DELETE FROM tbli_esq_plant_form_configcodift WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

/////////////////////////////////////
/*
$sql = "select  codi_refid  from public.tbli_esq_plant_formunico_docsinternos     WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);
$codigrefre=pg_fetch_result($res,0,0);
*/
////actualizo el tramite
/*
$sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_eliminado.png', ultimonivel='true' WHERE id='".$codigrefre."';";
$resfre = pg_query($conn, $sqlaactfre);
*/
}

echo "<script>document.location.href='lista_data.php'</script>";

?>