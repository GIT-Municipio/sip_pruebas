<?php
require_once('../../../conexion.php');
$sqlus="select nombre_clasif_documen from dato_tipo_documento  WHERE id='".$_GET["envolid"]."'";
$result=pg_query($conn, $sqlus);
$datoretornatext=pg_fetch_result($result,0,0);
echo $datoretornatext;	
?>