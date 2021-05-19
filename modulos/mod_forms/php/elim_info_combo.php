<?php

require_once('../../../clases/conexion.php');

$datoinsertilas="delete from plantillas.".$_GET['pontabla']." where id='".$_GET["retidobj"]."';";
	$consulta = pg_query($conn,$datoinsertilas);

echo "<script>document.location.href='../app_tipo_combo.php?pontabla=".$_GET["pontabla"]."&varitabcmpid=".$_GET["varitabcmpid"]."&varclaveuntramusu=".$_GET["varclaveuntramusu"]."'</script>";

?>