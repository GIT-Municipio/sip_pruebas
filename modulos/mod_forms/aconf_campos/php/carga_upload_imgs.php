<?php
require_once('../../clases/conexion.php');
session_start();
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
	move_uploaded_file($_FILES["file"]["tmp_name"],"../../shpfiles/".$filename);
	header("Content-Type: text/json");
	print_r("{state: true, name:'".str_replace("'","\\'",$filename)."', extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
	////////////////////////////////para insertar lo que se registro
	$resultado = strpos($filename, ".shp");
	if($resultado !== FALSE)
	{
		$resultado = strpos($filename, ".shp.");
		if($resultado === FALSE)
	    {
	  /////seleccionar el nombre de la entidad
	  $nombredecapa = str_replace(".shp", "", $filename);
	  /////////////////////separa el catalogo
	  
	  $vectdats = explode("_", $nombredecapa);
	  $vectdatsigm=$vectdats[0];
	  
	  if(count($vectdats)==1)
	         $vectdatsigm="0";
	  else
	  {
	    if(strlen($vectdatsigm)>2)
		     $vectdatsigm="0";
	  }
	  
	$sql = "INSERT INTO public.web_tempo_geo( nombre_archivo, nombre_capa, dir_shapefile, ref_cod_proyecto, ref_desc_proyecto,fecha,ref_catobj_igm)  VALUES ( '".$filename."','".$nombredecapa."', '"."../shpfiles/".$nombredecapa."', '".$_SESSION["guardo_idproyectogen"]."', '".$_SESSION["guardo_nomproyectogen"]."',  now(),'".$vectdatsigm."');";
$resul = pg_query($conn, $sql);

	   }


	}
////////////////////////////////fin de insercion

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
		 move_uploaded_file($_FILES["file"]["tmp_name"], "../../shpfiles/".$filename);
		print_r("{state: true, name:'".str_replace("'","\\'",$filename)."', size:".$_FILES["file"]["size"]/*filesize("../../shpfiles/".$filename)*/.", extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
		
		
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
		$temp_name = "../../shpfiles/".$p[0]."_data";
		
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
				rename($temp_name, "../../shpfiles/".$_REQUEST["fileName"]);
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
