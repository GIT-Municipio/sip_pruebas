<meta charset='utf-8'>
<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');
session_start();
$idtramite = $_GET['mvpr'];
$plantilla = $_GET['plantilla'];
$sql = "UPDATE tbli_esq_plant_formunico_docsinternos SET est_respuesta_recibido='0'
where id='" . $idtramite . "'";
$res = pg_query($conn, $sql);
echo "<script>window.close(true);</script>";
?>
