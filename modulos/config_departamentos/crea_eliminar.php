<?php


require_once('../../clases/conexion.php');

$totalfil=$_GET["vafil"];
if($totalfil!=0)
{
session_start();
		
$sql = "UPDATE tblb_org_departamento    SET   estado_depart=false  WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

}

echo "<script>document.location.href='arb_data.php'</script>";

?>