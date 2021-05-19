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

  ///////funcion para quitatr espacios y tildes/////////////////
function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
  /*  $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $string
    );*/
	
	 //$string=str_replace (" ", "_",$string);
	 $string=str_replace ("(", "",$string);
	 $string=str_replace (")", "",$string);
	 $string=str_replace (":", "",$string);
	 $string=str_replace ("'", "",$string);
	 $string=str_replace ("»", "",$string);
	 $string=str_replace ("§", "",$string);
	 $string=str_replace ("-_", "",$string);
	 $string=str_replace ("_-", "",$string);
	 $string=str_replace ("_.", "",$string);
	 $string=str_replace ("._.", "",$string);
	 $string=str_replace ("~", "",$string);
	 $string=str_replace ("__", "",$string);
	 $string=str_replace ("{", "",$string);
	 $string=str_replace ("<>", "",$string);
	 $string=str_replace ("<", "",$string);
	 $string=str_replace (">", "",$string);
	 $string=str_replace ("«", "",$string);
	 $string=str_replace ("®", "",$string);
	 $string=str_replace (".", " ",$string);
	 
	 
    return $string;
	
};


$sqlus="select ref_imagen,url_anexo_txt,cadena_exec from tbl_archivos_scanimgs_txt where estadoload=0";
$result=pg_query($conn, $sqlus);

/* 
for($i=0;$i<pg_num_rows($result);$i++)
{
	$vernocadenaexec=pg_fetch_result($result,$i,"cadena_exec");
     $test = popen($vernocadenaexec,'r'); 
}
*/

for($i=0;$i<pg_num_rows($result);$i++)
{

$vernomardatoid=pg_fetch_result($result,$i,"ref_imagen");
$vernomarchiv=pg_fetch_result($result,$i,"url_anexo_txt");

if (file_exists($vernomarchiv)) {
	
$open = fopen($vernomarchiv,'r');
 
while (!feof($open)) 
{
	$getTextLine = fgets($open);
	
	$datosaneado=sanear_string($getTextLine);
	if($datosaneado!=" ")
	{
	if(strlen($datosaneado)>3)
		{
	$sqlusinterno="INSERT INTO public.tbl_archivos_scanimgs_txtempo(nombreinfo,ref_imagen) values(' ".$datosaneado." ','".$vernomardatoid."')";
     $resultatxtint=pg_query($conn, $sqlusinterno);
		}
	}

}

$sqlusintatcux="update tbl_archivos_scanimgs_txt set estadoload=1 where ref_imagen='".$vernomardatoid."';";
$resultactufx=pg_query($conn, $sqlusintatcux);
 
fclose($open);
}

}


$sqlusinterno="DELETE FROM public.tbl_archivos_scanimgs_txtempo;";
$resultatxtint=pg_query($conn, $sqlusinterno);



	 
echo "<script>document.location.href='obtencionscan.php';</script>";
	
?>
</body>
</html>