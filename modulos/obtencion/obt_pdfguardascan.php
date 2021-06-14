<?php

require_once('../../conexion.php');
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

//$nombredecapa = str_replace(".pdf", "", $filename); 
//////////tratamiento a la cadena
$nombreddocumscan = str_replace("[", "", $_GET['envdatscanea']); 
$nombreddocumscan = str_replace("]", "", $nombreddocumscan);
$nombreddocumscan = str_replace('"', "", $nombreddocumscan);


$sqlanex = "INSERT INTO tbl_archivos_procesados(grupo_codbarras_tramite,usu_respons_edit,param_departamento, param_cod_categoria, param_categoria,  param_bodega, param_estanteria,param_nivel)  VALUES ('".$_SESSION["varses_grup_codigo"]."','".$_SESSION["vermientuscedula"]."','".$_SESSION["varses_grup_departid"]."','".$_SESSION["varses_grup_categid"]."','".$_SESSION["varses_grup_categ"]."','".$_SESSION["varses_grup_bodega"]."','".$_SESSION["varses_grup_estanteria"]."','".$_SESSION["varses_grup_nivel"]."' );";

$resulverifax = pg_query($conn, $sqlanex);



//////////////----------------------------PROCESAMIENTO DE LOS DATOS
$sqlanex = "select max(id) from  tbl_archivos_procesados where usu_respons_edit='".$_SESSION["vermientuscedula"]."'";
$resulverifax = pg_query($conn, $sqlanex);
$cadobteneridinse=pg_fetch_result($resulverifax,0,0);
$sqlanex = "select form_cod_barras from  tbl_archivos_procesados where id='".$cadobteneridinse."'";
$resulverifax = pg_query($conn, $sqlanex);
$cadobtenecodibarra=pg_fetch_result($resulverifax,0,0);

 $frevare = substr($nombreddocumscan, -27);  
 $paracambiotxt = str_replace(".pdf", "", $frevare); 
 $cadenacambiada = str_replace($paracambiotxt, $cadobtenecodibarra, $nombreddocumscan);
$nombreddocuoriginal=$nombreddocumscan;
$nombreddocumscan = str_replace("D:/ms4w/Apache/htdocs/siasys/siasys_bodega","../../siasys_bodega", $cadenacambiada);

 $sqlanex = "update tbl_archivos_procesados set doc_url_info='".$nombreddocumscan."',doc_tipo_info='pdf' where id='".$cadobteneridinse."'";
$resulverifax = pg_query($conn, $sqlanex);

// $nombreddocuoriginal;
// $cadenacambiada;

rename($nombreddocuoriginal, $cadenacambiada);



echo "<script>document.location.href='obtencionscan.php';</script>";


?>