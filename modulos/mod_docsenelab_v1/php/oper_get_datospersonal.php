<?php
//error_reporting(E_ALL ^ E_NOTICE);
//conexion de la base de datos


require_once('../../../clases/conexion.php');

//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 
//start output of data
echo '<rows id="0">';
//seleccion de la tabla
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

if($_GET[princonsulfre]!="")
$sql = $_GET[princonsulfre];// "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla];
else
{
	if($_GET[envcodidepart]!="")
$sql = "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla]." where  usu_activo=1 and  codigo_depengen='".$_GET[envcodidepart]."' and usua_cedula <> '".$_SESSION['vermientuscedula']."' ";
else
$sql = "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla]." where  usu_activo=1 ";

}
$res = pg_query($conn, $sql);

$datocampos=$_GET[enviocampos];
$vectorcampo=explode(",",$datocampos);
if($res){
		for($i=0;$i<pg_num_rows($res);$i++)
		{
		echo ("<row id='".pg_fetch_result($res,$i,0)."'>");
		for($col=0;$col<count($vectorcampo);$col++)
		{
			    echo ("<cell><![CDATA[".pg_fetch_result($res,$i,$col)."]]></cell>");			
		}
		 echo ("</row>");
	}///fin de while
}else{
//error occurs
echo pg_result_error().": ".pg_last_error()." at ".__LINE__." line in ".__FILE__." file<br>";
}
echo '</rows>';
?>