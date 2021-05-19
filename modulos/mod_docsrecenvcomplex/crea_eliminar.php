<?php


require_once('../../clases/conexion.php');

$totalfil=$_POST["Idenv"];
if($totalfil!=0)
{

$sql = "delete from  tbli_esq_plant_formunico_docsinternos WHERE id='".$_POST["Idenv"]."'";
$res = pg_query($conn, $sql);

}

/*
echo "<script>parent.document.location.href='arb_grupos.php'</script>";
*/
?>