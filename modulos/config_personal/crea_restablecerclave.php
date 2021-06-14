<?php


require_once('../../clases/conexion.php');

$totalfil=$_GET["vafil"];
if($totalfil!=0)
{
session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
		

$sql = "UPDATE tblu_migra_usuarios    SET   usua_pasw=md5(usua_cedula) ,  usua_login=usua_cedula  WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

/////////////////////////////////////
/*
$sql = "select  codi_refid  from public.tbli_esq_plant_formunico_docsinternos     WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);
$codigrefre=pg_fetch_result($res,0,0);
*/
////actualizo el tramite
/*
$sqlaactfre ="UPDATE public.tbli_esq_plant_formunico SET  estado_gestor='imgs/btninfo_estado_eliminado.png', ultimonivel='true' WHERE id='".$codigrefre."';";
$resfre = pg_query($conn, $sqlaactfre);
*/
}

echo "<script>document.location.href='lista_data.php'</script>";

?>