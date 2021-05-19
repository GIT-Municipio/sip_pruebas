<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<style type="text/css"> 

#zombarraprogresiva {
	position:absolute;
	left:412px;
	top:153px;
	width:226px;
	height:231px;
	z-index:1000;
	background-image:url(imgs/loading.gif);
}	

    </style>
</head>

<body>
<div id="zombarraprogresiva"></div>

<?php
require_once('../../conexion.php');


$sqlus="select ref_imagen,url_anexo_txt,cadena_exec from tbl_archivos_scanimgs_txt where estadoload=0";
$result=pg_query($conn, $sqlus);


for($i=0;$i<pg_num_rows($result);$i++)
{
	$vernocadenaexec=pg_fetch_result($result,$i,"cadena_exec");
     $test = popen($vernocadenaexec,'r'); 
}


echo "<script>document.location.href='obtencionscan.php';</script>";
	
?>
</body>
</html>