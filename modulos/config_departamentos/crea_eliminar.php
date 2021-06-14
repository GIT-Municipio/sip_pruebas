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
		
$sql = "UPDATE tblb_org_departamento    SET   estado_depart=false  WHERE id='".$_GET["vafil"]."'";
$res = pg_query($conn, $sql);

}

echo "<script>document.location.href='arb_data.php'</script>";

?>