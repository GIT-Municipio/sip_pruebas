<?php
//error_reporting(E_ALL ^ E_NOTICE);
//conexion de la base de datos
require_once('../../../conexion.php');
//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 
//start output of data
echo '<rows id="0">';
//seleccion de la tabla
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
//if($_GET["mitabla"]!="")
if($_SESSION['vermientuscedula']!="")
$sql = "SELECT  ".$_GET["enviocampos"]." from ".$_GET["mitabla"]." where usu_respons_edit='".$_SESSION['vermientuscedula']."' and grupo_codbarras_tramite='".$_SESSION['varses_grup_codigo']."' and est_validado=0 and est_eliminado=0 and est_dardebaja=0 and cod_iden_grupo=0  order by id";
else
$sql = "SELECT  ".$_GET["enviocampos"]." from ".$_GET["mitabla"]." order by id ";


$res = pg_query($conn, $sql);


$datocampos=$_GET["enviocampos"];
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