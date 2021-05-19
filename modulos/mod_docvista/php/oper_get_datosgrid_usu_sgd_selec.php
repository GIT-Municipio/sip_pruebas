<?php
//error_reporting(E_ALL ^ E_NOTICE);
//conexion de la base de datos


require_once('config.php');

//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may be different in your case
echo('<?xml version="1.0" encoding="utf-8"?>'); 
//start output of data
echo '<rows id="0">';
//seleccion de la tabla
session_start();

if($_GET[princonsulfre]!="")
$sql = $_GET[princonsulfre];// "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla];
else
{
	if($_GET[enviusurespons]!="")
$sql = "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla]." where destino_cedul='".$_GET[enviusurespons]."' and selec_tempoitem=1  ";
else
$sql = "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla]."  ";


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