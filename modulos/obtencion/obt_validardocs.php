<?php
require_once('../../conexion.php');

$sqlus="UPDATE public.tbl_archivos_procesados   SET est_procesado=0,  est_validado=1  WHERE id='".$_GET["envidprimaria"]."'";
$result=pg_query($conn, $sqlus);
echo "<script>document.location.href='obtencionscan.php';</script>";
		
?>