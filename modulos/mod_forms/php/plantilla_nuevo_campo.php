<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/
//$_REQUEST[requisitos]=0;
$paraconsverif="select count(*) from tbli_esq_plant_form_plantilla_campos where upper(campo_nombre)=upper('".$_REQUEST[campo_nombre]."') ";
$resultverf=pg_query($conn, $paraconsverif);
$verifexist=pg_fetch_result($resultverf,0,0);
if($verifexist==0)
{


if($_REQUEST[ref_plantilla]!="")
{

	 $paraconsverif="select titulo_grupo from tbli_esq_plant_form_plantilla_grupo where id='".$_REQUEST[ref_grupo]."' and ref_plantilla='".$_REQUEST[ref_plantilla]."'";
$resultverf=pg_query($conn, $paraconsverif);
$verifexistgrupo=pg_fetch_result($resultverf,0,0);


  $parainresar="INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$_REQUEST[ref_plantilla]."', '".$_REQUEST[ref_grupo]."', '".$_REQUEST[ref_tcamp]."', '".$_REQUEST[campo_nombre]."','".$verifexistgrupo."',1);";
			

//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);


$paraconmos="select id from tbli_esq_plant_form_plantilla_campos where campo_nombre='".$_REQUEST[campo_nombre]."' and ref_plantilla='".$_REQUEST[ref_plantilla]."' ";
$resultvemos=pg_query($conn, $paraconmos);
$veringrescampoid=pg_fetch_result($resultvemos,0,0);

echo $_REQUEST[ref_tcamp].'#'.$veringrescampoid;

}

}
else
{
	echo "error";
}


?>