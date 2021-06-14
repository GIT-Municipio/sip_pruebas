<?php

require_once('../../../conexion.php');

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

/////////////////PARAMETROS DE INSERCION
$directoriobodega="../../../siasys_bodega/";
//////////////////////////////////////////
$sqlbod = "SELECT enlaceurl FROM public.dato_bodega where id='".$_SESSION["varses_grup_bodega"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_bodega=pg_fetch_result($ressbod,0,0);
$sqlbod = "SELECT enlaceurl FROM public.dato_estanteria where id='".$_SESSION["varses_grup_estanteria"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_estanter=pg_fetch_result($ressbod,0,0);
$sqlbod = "SELECT enlaceurl FROM public.dato_nivel where id='".$_SESSION["varses_grup_nivel"]."'";
$ressbod = pg_query($conn, $sqlbod);
$cedenaurl_nivel=pg_fetch_result($ressbod,0,0);

$cadenaurl_comp=$directoriobodega.$cedenaurl_bodega.$cedenaurl_estanter.$cedenaurl_nivel;


// full path for silverlight
if (@$_REQUEST["action"] == "get_script_path") {
	$url = "http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["REQUEST_URI"])."/dhtmlxform_item_upload.php";
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
	move_uploaded_file($_FILES["file"]["tmp_name"],"../".$cadenaurl_comp.$filename);
	header("Content-Type: text/json");
	print_r("{state: true, name:'".str_replace("'","\\'",$filename)."', extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
	////////////////////////////////para insertar lo que se registro
	
///////////////////////////////////////////////////////////////////////////	
$cadenaurl_xbase=$cadenaurl_comp.$filename;

///////////////////////////////////////////////////////////////////////////	
////////////////////////// PARA JPG //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////	
$resultado = strpos($filename, ".jpg");
	if($resultado !== FALSE)
	{
$nombredecapa = str_replace(".jpg", "", $filename); 
///////////////////////////////////////////////////////////////////////////	
////////////////////////// INSERCION PROCESO    ///////////////////////////
///////////////////////////////////////////////////////////////////////////
/*
$sqlusauxdep="SELECT count(*) as numcontcat FROM tbl_archivos_procesados where  id='".$_SESSION["varestaticmyid"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$varverexisdtid=pg_fetch_result($resultcodauc,0,0);
if($varverexisdtid==0)
{
$sqlanex = "INSERT INTO tbl_archivos_procesados(grupo_codbarras_tramite,usu_respons_edit,param_departamento, param_cod_categoria, param_categoria,  param_bodega, param_estanteria,param_nivel,doc_url_info,doc_tipo_info,param_cod_subcategoria,param_subcategoria)  VALUES ('".$_SESSION["varses_grup_codigo"]."','".$_SESSION["vermientuscedula"]."','".$_SESSION["varses_grup_departid"]."','".$_SESSION["varses_grup_categid"]."','".$_SESSION["varses_grup_categ"]."','".$_SESSION["varses_grup_bodega"]."','".$_SESSION["varses_grup_estanteria"]."','".$_SESSION["varses_grup_nivel"]."','".$cadenaurl_xbase."','jpg','".$_SESSION["varses_grup_subcategid"]."','".$_SESSION["varses_grup_subcategnom"]."');";
$resulverifax = pg_query($conn, $sqlanex);

$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$_SESSION["varestaticmyid"]=pg_fetch_result($resultcodauc,0,'codultim');
}
*/
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN INSERCION PROCESO    //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

$resultaocrtxt="";
$sqlusinsertimgitem="INSERT INTO public.tbl_archivos_scanimgs(nombrearch,origen_codbarrasexp, nombre_anexo, url_anexo_local,gparam_cod_categoria,gparam_nom_categoria,gparam_departamento,gparam_contenido,ref_archprocesados,gusu_respons_edit)  VALUES ('".$nombredecapa."','".$_SESSION["varses_grup_codigo"]."','nombre anexo', '".$cadenaurl_xbase."', '".$_SESSION["varses_grup_categid"]."', '".$_SESSION["varses_grup_categ"]."', '".$_SESSION["varses_grup_departid"]."','".$resultaocrtxt."','".$_SESSION["varestaticmyid"]."','".$_SESSION["vermientuscedula"]."')";
$resultcodauc=pg_query($conn, $sqlusinsertimgitem);
/////////////////////////
$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_scanimgs where  gusu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$idimagensubida=pg_fetch_result($resultcodauc,0,'codultim');

///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN INSERCION IMAGEN    //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

/////////////////////////////////RECONOCIMIENTO DE CARACTERES
$nombredeimgorig = str_replace("../../../", "D:/xampp/htdocs/", $cadenaurl_xbase); 
$nombredeimgtxt = str_replace(".jpg", "", $nombredeimgorig); 

$nombredeimgtxt = str_replace($nombredecapa, $idimagensubida, $nombredeimgtxt); 
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  CREACION DEL BAT   //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////
$cadenamia="D:/xampp/htdocs/sysbat/".$idimagensubida.".bat";
$myfile = fopen($cadenamia, "w") or die("Unable to open file!");
$txt = "cd C:/Program Files (x86)/Tesseract-OCR/ \n";
fwrite($myfile, $txt);
$txt = "tesseract.exe ".$nombredeimgorig." ".$nombredeimgtxt." \n";
fwrite($myfile, $txt);
fclose($myfile);
//$test = popen($cadenamia,'r');  
$cadenfinal=$nombredeimgtxt.'.txt';
$tamanarchiv="";//filesize($nombredeimgtxt);
$sqlusinsertimgitem="INSERT INTO public.tbl_archivos_scanimgs_txt(nombrearch, url_anexo_img, url_anexo_txt , cadena_exec, ref_imagen, tamanio)  VALUES ('".$nombredecapa."','".$nombredeimgorig."','".$cadenfinal."','".$cadenamia."', '".$idimagensubida."','".$tamanarchiv."' );";
$resultcodauc=pg_query($conn, $sqlusinsertimgitem);
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN DE CREACION DEL BAT   //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

}
//////////////////////******************************/////////////////////////////////////////////////////	
////////////////////////// FIN  PARA JPG //////////////////////////////////////	
/////////////////////////*************************/////////////////////////

///////////@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@///////////////	
////////////@@@@@@@@@@@@@@@@@@  PARA JPEG   @@@@@@@@@@@@///////////////////////	
///////////////////////////////////////////////////////////////////////////	
$resultado = strpos($filename, ".jpeg");
	if($resultado !== FALSE)
	{
$nombredecapa = str_replace(".jpeg", "", $filename); 
///////////////////////////////////////////////////////////////////////////	
////////////////////////// INSERCION PROCESO    ///////////////////////////
///////////////////////////////////////////////////////////////////////////
/*
$sqlusauxdep="SELECT count(*) as numcontcat FROM tbl_archivos_procesados where  id='".$_SESSION["varestaticmyid"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$varverexisdtid=pg_fetch_result($resultcodauc,0,0);
if($varverexisdtid==0)
{
$sqlanex = "INSERT INTO tbl_archivos_procesados(grupo_codbarras_tramite,usu_respons_edit,param_departamento, param_cod_categoria, param_categoria,  param_bodega, param_estanteria,param_nivel,doc_url_info,doc_tipo_info)  VALUES ('".$_SESSION["varses_grup_codigo"]."','".$_SESSION["vermientuscedula"]."','".$_SESSION["varses_grup_departid"]."','".$_SESSION["varses_grup_categid"]."','".$_SESSION["varses_grup_categ"]."','".$_SESSION["varses_grup_bodega"]."','".$_SESSION["varses_grup_estanteria"]."','".$_SESSION["varses_grup_nivel"]."','".$cadenaurl_xbase."','jpeg');";
$resulverifax = pg_query($conn, $sqlanex);

$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$_SESSION["varestaticmyid"]=pg_fetch_result($resultcodauc,0,'codultim');
}
*/
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN INSERCION PROCESO    //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

$resultaocrtxt="";
$sqlusinsertimgitem="INSERT INTO public.tbl_archivos_scanimgs(nombrearch,origen_codbarrasexp, nombre_anexo, url_anexo_local,gparam_cod_categoria,gparam_nom_categoria,gparam_departamento,gparam_contenido,ref_archprocesados,gusu_respons_edit)  VALUES ('".$nombredecapa."','".$_SESSION["varses_grup_codigo"]."','nombre anexo', '".$cadenaurl_xbase."', '".$_SESSION["varses_grup_categid"]."', '".$_SESSION["varses_grup_categ"]."', '".$_SESSION["varses_grup_departid"]."','".$resultaocrtxt."','".$_SESSION["varestaticmyid"]."','".$_SESSION["vermientuscedula"]."')";
$resultcodauc=pg_query($conn, $sqlusinsertimgitem);
/////////////////////////
$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_scanimgs where  gusu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$idimagensubida=pg_fetch_result($resultcodauc,0,'codultim');

///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN INSERCION IMAGEN    //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

/////////////////////////////////RECONOCIMIENTO DE CARACTERES
$nombredeimgorig = str_replace("../../../", "D:/xampp/htdocs/", $cadenaurl_xbase); 
$nombredeimgtxt = str_replace(".jpeg", "", $nombredeimgorig); 

$nombredeimgtxt = str_replace($nombredecapa, $idimagensubida, $nombredeimgtxt); 
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  CREACION DEL BAT   //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////
$cadenamia="D:/xampp/htdocs/sysbat/".$idimagensubida.".bat";
$myfile = fopen($cadenamia, "w") or die("Unable to open file!");
$txt = "cd C:/Program Files (x86)/Tesseract-OCR/ \n";
fwrite($myfile, $txt);
$txt = "tesseract.exe ".$nombredeimgorig." ".$nombredeimgtxt." \n";
fwrite($myfile, $txt);
fclose($myfile);
//$test = popen($cadenamia,'r');  
$cadenfinal=$nombredeimgtxt.'.txt';
$tamanarchiv="";//filesize($nombredeimgtxt);
$sqlusinsertimgitem="INSERT INTO public.tbl_archivos_scanimgs_txt(nombrearch, url_anexo_img, url_anexo_txt , cadena_exec, ref_imagen, tamanio)  VALUES ('".$nombredecapa."','".$nombredeimgorig."','".$cadenfinal."','".$cadenamia."', '".$idimagensubida."','".$tamanarchiv."' );";
$resultcodauc=pg_query($conn, $sqlusinsertimgitem);
///////////////////////////////////////////////////////////////////////////	
//////////////////////////  FIN DE CREACION DEL BAT   //////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////

}
///////////////@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@///////////////////////	
////////////////////////// FIN  PARA jpeg /////////////////////////////////	
///////////@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@///////////////	




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
		 move_uploaded_file($_FILES["file"]["tmp_name"], "../".$cadenaurl_comp.$filename);
		print_r("{state: true, name:'".str_replace("'","\\'",$filename)."', size:".$_FILES["file"]["size"]/*filesize("../".$cadenaurl_comp.$filename)*/.", extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
		
		
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
		$temp_name = "../".$cadenaurl_comp.$p[0]."_data";
		
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
				rename($temp_name, "../".$cadenaurl_comp.$_REQUEST["fileName"]);
				$state = "true";
			}
			
			
			$state = "true"; // just for tests
			
			// print upload state
			// state: true/false (w/o any quotes)
			// name: server name/id
			header("Content-Type: text/json");
			print_r('{state: '.$state.', name: "'.str_replace('"','\\"',$_REQUEST["fileName"]).'"}');
		}
	}
}

?>
