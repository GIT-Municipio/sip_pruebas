<?php

require_once('../../../clases/conexion.php');


////////////////////////////////////////////////////////////////////////
$datoinsertilas="delete from tbli_esq_plant_form_plantilla_grupo where id='".$_GET["vafil"]."' and ref_plantilla='".$_GET["varidplanty"]."';";
$consulta = pg_query($conn,$datoinsertilas);



echo "<script>document.location.href='../plantilla_form_vistagrupos.php?varidplanty=".$_GET["varidplanty"]."'</script>";

?>