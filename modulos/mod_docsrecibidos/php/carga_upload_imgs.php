<?php
require_once('../../../clases/conexion.php');
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
// full path for silverlight
if (@$_REQUEST["action"] == "get_script_path") {
	$url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["REQUEST_URI"]) . "/dhtmlxform_item_upload.php";
	print_r($url);
	die();
}

/*

HTML5/FLASH MODE

(MODE will detected on client side automaticaly. Working mode will passed to server as GET param "mode")

response format

if upload was good, you need to specify state=true and name - will passed in form.send() as serverName param
{state: 'true', name: 'filename'}

*/

if (@$_REQUEST["mode"] == "html5" || @$_REQUEST["mode"] == "flash") {
	$filename = $_FILES["file"]["name"];
	$filename = str_replace(".pdf", "_test.pdf", $filename);

	move_uploaded_file($_FILES["file"]["tmp_name"], "../../../../sip_bodega/archciuventanilla/" . $filename);
	header("Content-Type: text/json");
	print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
	////////////////////////////////para insertar lo que se registro
	$resultado = strpos($filename, ".pdf");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".pdf", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".PDF");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".PDF", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}


	$resultado = strpos($filename, ".docx");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".docx", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".DOCX");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".DOCX", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}

	$resultado = strpos($filename, ".xls");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".xls", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".XLS");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".XLS", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_interno,origen_codcedula,anex_responsable)  VALUES (0, '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_GET["vercodigotramitext"] . "','" . $_SESSION["tempoanex_mvpr"] . "','ANEXO_TECNICO',1,'" . $_GET["vartxtciudcedula"] . "','" . $_GET["ponnombresrespon"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".jpg");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".jpg", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".JPG");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".JPG", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".jpeg");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".jpeg", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".png");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".png", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".PNG");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".PNG", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}
	$resultado = strpos($filename, ".zip");
	if ($resultado !== FALSE) {
		$nombredecapa = str_replace(".zip", "", $filename);
		$sqlanex = "INSERT INTO tbli_esq_plant_formunico_anexo(ref_formunic, nombre_anexo, url_anexo,validado,origen_codbarrasexp, usu_respons_edit, codigo_tramite, ref_docsinternos, anex_estado, anex_ventanilla, anex_asistencia,origen_codcedula)  VALUES ('" . $_SESSION["tempoanex_mvpr"] . "', '" . $nombredecapa . "', '" . $filename . "',1,'" . $_SESSION["tempoanex_codbarras"] . "','" . $_SESSION["sesusuario_cedula"] . "','" . $_SESSION["tempoanex_codtramite"] . "',0,'INGRESO','" . $_SESSION["tempoanex_verventan"] . "','" . $_SESSION["tempoanex_verasist"] . "','" . $_SESSION["tempoanex_ciudcedula"] . "');";
		$resulverifax = pg_query($conn, $sqlanex);

		$sqlanex = "UPDATE tbli_esq_plant_formunico  SET  anexos=anexos||'" . $filename . ";' , img_anexoficio='imgs/btninfo_anexook.png'  WHERE id='" . $_SESSION["tempoanex_mvpr"] . "';";
		$resulverifax = pg_query($conn, $sqlanex);
	}


	///////////////////////////////////////////////////////

}

/*

HTML4 MODE

response format:

to cancel uploading
{state: 'cancelled'}

if upload was good, you need to specify state=true, name - will passed in form.send() as serverName param, size - filesize to update in list
{state: 'true', name: 'filename', size: 1234}

*/

if (@$_REQUEST["mode"] == "html4") {
	header("Content-Type: text/html");
	if (@$_REQUEST["action"] == "cancel") {
		print_r("{state:'cancelled'}");
	} else {
		$filename = $_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], "../../../../sip_bodega/archciuventanilla/" . $filename);
		print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', size:" . $_FILES["file"]["size"]/*filesize("../../sip_bodega/archciuventanilla/".$filename)*/ . ", extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
	}
}

/* SILVERLIGHT MODE */
/*
{state: true, name: 'filename', size: 1234}
*/

if (@$_REQUEST["mode"] == "sl" && isset($_REQUEST["fileSize"]) && isset($_REQUEST["fileName"]) && isset($_REQUEST["fileKey"])) {

	// available params
	// $_REQUEST["fileName"], $_REQUEST["fileSize"], $_REQUEST["fileKey"] are available here

	// each file got temporary 12-chars length key
	// due some inner silverlight limitations, there will another request to check if file transferred and saved corrrectly
	// key matched to regex below

	preg_match("/^[a-z0-9]{12}$/", $_REQUEST["fileKey"], $p);

	if (@$p[0] === $_REQUEST["fileKey"]) {

		// generate temp name for saving
		$temp_name = "../../../../sip_bodega/archciuventanilla/" . $p[0] . "_data";

		// if action=="getUploadStatus" - that means file transfer was done and silverlight is wondering if php/orhet_server_side
		// got and saved file correctly or not, filekey same for both requests

		if (@$_REQUEST["action"] != "getUploadStatus") {
			// file is coming, save under temp name

			$postData = file_get_contents("php://input");
			if (strlen($postData) == $_REQUEST["fileSize"]) {
				file_put_contents($temp_name, $postData);
			}

			// no needs to output something
		} else {
			// second "check" request is coming

			$state = "false";
			if (file_exists($temp_name)) {
				rename($temp_name, "../../../../sip_bodega/archciuventanilla/" . $_REQUEST["fileName"]);
				$state = "true";
			}


			$state = "true"; // just for tests

			// print upload state
			// state: true/false (w/o any quotes)
			// name: server name/id
			header("Content-Type: text/json");
			print_r('{state: ' . $state . ', name: "' . str_replace('"', '\\"', $_REQUEST["fileName"]) . '"}');
		}
	}
}
