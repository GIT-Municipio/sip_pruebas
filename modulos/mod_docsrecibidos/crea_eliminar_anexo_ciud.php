<?php


require_once('../../clases/conexion.php');

$totalfil=$_GET["vafil"];
if($totalfil!=0)
{

$sql = "delete from  tbli_esq_plant_formunico_anexo WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

}
// echo "<script>window.opener.location.reload(true);</script>";
/*
echo "<script>parent.document.location.href='arb_grupos.php'</script>";
*/
?>