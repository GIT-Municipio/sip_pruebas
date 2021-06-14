<?php

require_once('../clases/conexion.php');

$sqluscont = "SELECT count(*) FROM public.tblu_migra_usuarios where  usua_login='" . $_REQUEST["login"] . "' and usua_pasw=md5('" . $_REQUEST["pwd"] . "');";
$resulcontt = pg_query($conn, $sqluscont);
$verfiexist = pg_fetch_result($resulcontt, 0, 0);

if ($verfiexist != 0) {

	$sqluscontses = "SELECT usu_sesionactiva FROM public.tblu_migra_usuarios where  usua_login='" . $_REQUEST["login"] . "' and usua_pasw=md5('" . $_REQUEST["pwd"] . "');";
	$resulcontses = pg_query($conn, $sqluscontses);
	$verifsession = pg_fetch_result($resulcontses, 0, 0);
	

		$sqlus = "SELECT * FROM public.tblu_migra_usuarios where  usua_login='" . $_REQUEST["login"] . "' and usua_pasw=md5('" . $_REQUEST["pwd"] . "');";
		$result = pg_query($conn, $sqlus);

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

		$_SESSION['sesusuario_idprinusu'] = pg_fetch_result($result, 0, "id");
		$_SESSION['sesusuario_cedula'] = pg_fetch_result($result, 0, "usua_cedula");
		
		$datnom = pg_fetch_result($result, 0, "usua_nomb");
		$datapel = pg_fetch_result($result, 0, "usua_apellido");
		$_SESSION['sesusuario_nomcompletos'] = $datnom . " " . $datapel;
		$_SESSION['sesusuario_nombres'] = $datnom;
		$_SESSION['sesusuario_apellidos'] = $datapel;

		$_SESSION['sesusuario_cargousu'] = pg_fetch_result($result, 0, "usua_cargo"); //////
		$_SESSION['sesusuario_nomdepartameusu'] = pg_fetch_result($result, 0, "usua_dependencia"); //////
		$_SESSION['sesusuario_emailusu'] = pg_fetch_result($result, 0, "usua_email");
		$_SESSION['sesusuario_usutipo_rol'] = pg_fetch_result($result, 0, "usu_tiporol"); //////
		$_SESSION['sesusuario_codigodepartamasig'] = pg_fetch_result($result, 0, "codigo_depengen"); //////
		$_SESSION['sesusuario_sumilla'] = pg_fetch_result($result, 0, "usua_sumilla"); ////
		$_SESSION["sesusuario_foto"] = pg_fetch_result($result, 0, "usu_foto");
		$_SESSION["sesusuario_asisdepart"] = pg_fetch_result($result, 0, "usu_asistenciadepart");
		$_SESSION["sesusuario_usu_ventanilla"] = pg_fetch_result($result, 0, "usu_ventanilla");
		$_SESSION["sesusuario_usu_admin"] = pg_fetch_result($result, 0, "usu_admin");
		$_SESSION["sesusuario_dependencia"] = pg_fetch_result($result, 0, "cod_depenid");
		$_SESSION["sesusuario_externo"] = pg_fetch_result($result, 0, "ultima_ip_acceso");
		////////////////////// CONFIG INSTITUCION
		$sqlins = "SELECT  nombre_titulo,nombre_subtitulo,imglogo,imgfondo from tblb_org_institucion ";
		$resulinsgad = pg_query($conn, $sqlins);
		$_SESSION['sesinstit_nom_titulo'] = pg_fetch_result($resulinsgad, 0, "nombre_titulo");
		$_SESSION['sesinstit_nom_subtitulo'] = pg_fetch_result($resulinsgad, 0, "nombre_subtitulo");
		$_SESSION['sesinstit_imglogo'] = pg_fetch_result($resulinsgad, 0, "imglogo");
		$_SESSION['sesinstit_imgfondo'] = pg_fetch_result($resulinsgad, 0, "imgfondo");

		$sqlups = "update tblu_migra_usuarios set usu_sesionactiva=1 where  usua_login='" . $_REQUEST["login"] . "' and usua_pasw=md5('" . $_REQUEST["pwd"] . "');";
		$result = pg_query($conn, $sqlups);

		$status = "bien";
	
} else
	$status = "error";

header("Content-Type: text/plain");
$status = $status;
//$status = (@$_REQUEST["login"]=="admin"&&@$_REQUEST["pwd"]=="admin" ? "entro":"fallo");
print_r($status);

//print_r($_REQUEST);
?>