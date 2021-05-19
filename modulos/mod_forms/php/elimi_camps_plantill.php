<?php

require_once('../../../clases/conexion.php');


$datoiconidp="select campo_creado from tbli_esq_plant_form_plantilla_campos where id='".$_GET["vafil"]."' and ref_plantilla='".$_GET["varidplatycmps"]."';";
	$consulta = pg_query($conn,$datoiconidp);
$mitabcampo_creado=pg_fetch_result($consulta,0,'campo_creado');

////////////////////////////////////////////////////////////////////////
$datoinsertilas="delete from tbli_esq_plant_form_plantilla_campos where id='".$_GET["vafil"]."' and ref_plantilla='".$_GET["varidplatycmps"]."';";
$consulta = pg_query($conn,$datoinsertilas);



echo "<script>document.location.href='../plantilla_form_vistacampos.php?varidplatycmps=".$_GET["varidplatycmps"]."'</script>";

?>