<?php
require_once('../../conexion.php');


$sqlus="select ref_imagen,url_anexo_txt,cadena_exec from tbl_archivos_scanimgs_txt where estadoload=0";
$result=pg_query($conn, $sqlus);


for($i=0;$i<pg_num_rows($result);$i++)
{

$vernomardatoid=pg_fetch_result($result,$i,"ref_imagen");
$vernomarchiv=pg_fetch_result($result,$i,"url_anexo_txt");

if (file_exists($vernomarchiv)) {
	
$open = fopen($vernomarchiv,'r');
 
while (!feof($open)) 
{
	$getTextLine = fgets($open);
	
	$datosaneado=$getTextLine;
	if($datosaneado!=" ")
	{
	if(strlen($datosaneado)<3)
	{
		echo $sqlusinterno="update tbl_archivos_scanimgs_txt set estadoload=1 where estadoload=0 and ref_imagen='".$vernomardatoid."';";
$resultatxtint=pg_query($conn, $sqlusinterno);
	}
	}

}
 
fclose($open);
}

}

echo "<script>document.location.href='obtencionscan.php';</script>";
	
?>
