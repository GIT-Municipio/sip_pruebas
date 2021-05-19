<?php

require_once('config.php');
/*
if($_REQUEST[requisitos]==true)
	  $_REQUEST[requisitos]=1;
else
      $_REQUEST[requisitos]=0;
*/
//$_REQUEST[requisitos]=0;

$paraconsverif="select count(*) from tbli_esq_plant_form_plantilla where upper(nombre_plantilla)=upper('".$_REQUEST[nombre_plantilla]."') ";
$resultverf=pg_query($conn, $paraconsverif);
$verifexist=pg_fetch_result($resultverf,0,0);
if($verifexist==0)
{

if($_REQUEST[nombre_plantilla]!="")
{

  $parainresar="INSERT INTO tbli_esq_plant_form_plantilla(ref_docum, nombre_plantilla, descripcion, tipo_info, ref_clasif_doc)
    VALUES ('".$_REQUEST[ref_docum]."', '".$_REQUEST[nombre_plantilla]."', '".$_REQUEST[descripcion]."', '".$_REQUEST[tipo_info]."', '".$_REQUEST[ref_clasif_doc]."');";
					
$result=pg_query($conn, $parainresar);

 $paraconmos="select id from tbli_esq_plant_form_plantilla where upper(nombre_plantilla)=upper('".$_REQUEST[nombre_plantilla]."') ";
$resultvemos=pg_query($conn, $paraconmos);
$veringresid=pg_fetch_result($resultvemos,0,0);
/////////////////////ingreso grupo por defecto
$parainresargr="INSERT INTO tbli_esq_plant_form_plantilla_grupo(titulo_grupo, caracteristicas,ref_plantilla,publico)
    VALUES ('DATOS PERSONALES', '', '".$veringresid."',1);";
$resultgr=pg_query($conn, $parainresargr);
////////////////////////ingreso campos por defecto
 $paraconmos="select id from tbli_esq_plant_form_plantilla_grupo where titulo_grupo='DATOS PERSONALES' and ref_plantilla='".$veringresid."' ";
$resultvemos=pg_query($conn, $paraconmos);
$veringresgrupoid=pg_fetch_result($resultvemos,0,0);


$paraconsvtitulgr="select titulo_grupo from tbli_esq_plant_form_plantilla_grupo where id='".$veringresgrupoid."' ";
$resulttitugr=pg_query($conn, $paraconsvtitulgr);
$verifexistgrupo=pg_fetch_result($resulttitugr,0,0);


$parainresarcmp="INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'CIU','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'CEDULA','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'NOMBRES','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'APELLIDOS','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'TELEFONO','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'EMAIL','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'DIRECCION','".$verifexistgrupo."',1);INSERT INTO tbli_esq_plant_form_plantilla_campos(ref_plantilla, ref_grupo,ref_tcamp,campo_nombre,ref_nombregrupo,publico)
    VALUES ('".$veringresid."', '".$veringresgrupoid."', '1', 'TITULO_FORMULARIO','".$verifexistgrupo."',1);";
$resultcmp=pg_query($conn, $parainresarcmp);

echo $veringresid;

}


}
else
{
	echo "error";
}

?>