<?php


require_once('../../clases/conexion.php');

$totalfil=$_GET["vafil"];
if($totalfil!=0)
{
session_start();
//-------------------------------
header("Refresh: 1210");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 1200; //20min.

	//Calculamos tiempo de vida inactivo.
	$vida_session = time() - $_SESSION['tiempo'];

	//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
	if ($vida_session > $inactivo) {
		//Removemos sesión.
		session_unset();
		//Destruimos sesión.
		session_destroy();
		//Redirigimos pagina.
		header("location: http://localhost/sip_pruebas/404/404.html");
		exit();
	}
}
$_SESSION['tiempo'] = time();
//---------------------
		
/*
$sql = "UPDATE public.tbl_archivos_procesados    SET   est_validado=0, est_activo=0, est_eliminado=1,  est_enprestamo=0, est_oficina=0, est_general=0, est_pasivo=0, est_historico=0, est_digital=0, 
       est_novedades=0, est_conmetadatos=0, est_conservacion=0,img_eliminado='imgs/btninfo_eliminar.png',img_recuperar='imgs/btninfo_recuperar.png'  WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

$sql = "UPDATE public.tbl_archivos_procesados    SET   est_validado=0, est_activo=0, est_eliminado=1,  est_enprestamo=0, est_oficina=0, est_general=0, est_pasivo=0, est_historico=0, est_digital=0, 
       est_novedades=0, est_conmetadatos=0, est_conservacion=0,img_eliminado='imgs/btninfo_eliminar.png',img_recuperar='imgs/btninfo_recuperar.png'  WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);
*/


$queryinternsol =	"select parent_id FROM tbl_archivos_procesados   WHERE id='".$_GET["vafil"]."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumgrupocon=pg_fetch_result($resultinsolint,0,0);

 $query =	"insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where id='".$_GET["vafil"]."');DELETE FROM tbl_archivos_procesados  WHERE id='".$_GET["vafil"]."';";
    ///////////actualizo contador
 $query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$vernumgrupocon."') where id='".$vernumgrupocon."';";
 /////////////////////////////////////
// echo $query;
$res = pg_query($conn, $query);



}

echo "<script>document.location.href='obtencionscan.php'</script>";

?>