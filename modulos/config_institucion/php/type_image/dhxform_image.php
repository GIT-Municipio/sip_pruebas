<?php

@session_start();
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
$idd = session_id();

// this part is for loading image into item
if (@$_REQUEST["action"] == "loadImage") {
	
	// default image
	
	$latabla='data_institucion';
	require_once('../../../clases/conexion.php');

	$sql = "SELECT  cedula_ruc,provincia,canton,imglogo from ".$latabla;
	$resul = pg_query($conn, $sql);
	$numerdatos=pg_num_rows($resul);
	if($numerdatos!=0)
	{
		$devuelveidprin= pg_fetch_result($resul,0,0);
		$devuelveidprov= pg_fetch_result($resul,0,1);
		$devuelveidcan= pg_fetch_result($resul,0,2);
		$devuelveidimglogo= pg_fetch_result($resul,0,3);
	}
	
	$i = "../../".$devuelveidimglogo;
	
	// check if requested image exists
	if (file_exists("uploaded/".$idd)) $i = "uploaded/".$idd;
	
	// output image
	header("Content-Type: image/jpg");
	print_r(file_get_contents($i));
	die();
	
}

// this part is for uploading the new one
if (@$_REQUEST["action"] == "uploadImage") {
	
	@unlink("uploaded/".$idd);
	
	$filename = time();
	move_uploaded_file($_FILES["file"]["tmp_name"], "uploaded/".$idd);
	
	header("Content-Type: text/html; charset=utf-8");
	print_r("{state: true, itemId: '".@$_REQUEST["itemId"]."', itemValue: '".str_replace("'","\\'",$filename)."'}");
	
}

?>