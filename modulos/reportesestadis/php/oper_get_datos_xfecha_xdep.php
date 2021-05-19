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
if($_GET['princonsulfre']!="")
$sql = $_GET['princonsulfre'];// "SELECT  ".$_GET[enviocampos]." from ".$_GET[mitabla];
else
$sql = "SELECT  ROW_NUMBER () OVER (ORDER BY nombre_departamento) as id,nombre_departamento,count(*) as total_archivos FROM public.tbl_archivos_scanimgs img,data_departamento_direccion dep where img.gparam_departamento=dep.id and est_eliminado=0  and date(fecha)=date('".$_GET['enviofechacons']."')   group by nombre_departamento order by nombre_departamento;";
$res = pg_query($conn, $sql);

$datocampos=$_GET['enviocampos'];
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