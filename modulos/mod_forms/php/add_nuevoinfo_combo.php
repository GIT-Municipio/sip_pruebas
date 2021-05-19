<?php

require_once('../../../clases/conexion.php');

$datoinsertilas="INSERT INTO plantillas.".$_GET['pontabla']." (id)  VALUES (default);";
	$consulta = pg_query($conn,$datoinsertilas);

echo "<script>document.location.href='../app_tipo_combo.php?pontabla=".$_GET["pontabla"]."&varitabcmpid=".$_GET["varitabcmpid"]."&varclaveuntramusu=0'</script>";

?>