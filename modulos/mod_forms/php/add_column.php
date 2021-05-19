<?php


require_once('../../../clases/conexion.php');

$selenum="SELECT  MAX(CAST(substring(campo_creado from 7 for 7) AS INTEGER))  FROM public.tbli_esq_plant_form_plantilla_cmpcolumns WHERE ref_elementcampo='".$_GET["varitabcmpid"]."';";
$res = pg_query($conn, $selenum);
$ponernuevcamp='campo_'.(pg_fetch_result($res,0,0)+1);

 $sql = "ALTER TABLE plantillas.".$_GET['pontabla']." ADD COLUMN ".$ponernuevcamp." text;";
$res = pg_query($conn, $sql);


$inscampoelem="INSERT INTO tbli_esq_plant_form_plantilla_cmpcolumns( campo_creado,campo_nombre,  ref_elementcampo)  VALUES ( '".$ponernuevcamp."','".$_GET["nomcolumn"]."', '".$_GET["varitabcmpid"]."');";
$consulta = pg_query($conn,$inscampoelem);

echo "<script>document.location.href='../app_tipo_tabla.php?pontabla=".$_GET["pontabla"]."&varitabcmpid=".$_GET["varitabcmpid"]."&varclaveuntramusu=".$_GET["varclaveuntramusu"]."'</script>";

?>