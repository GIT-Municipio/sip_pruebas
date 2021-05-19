<?php

require_once('config.php');

if($_REQUEST[ref_data_padre]=="")
$_REQUEST[ref_data_padre]=0;


if($_REQUEST[nombre]!="")
{

$parainresar="INSERT INTO data_departamento_direccion(
             nombre, director, email, telf_extension, telf_personal, objetivo, 
            ref_data_padre, ref_institucion, activo)
    VALUES ('".$_REQUEST[nombre]."', '".$_REQUEST[director]."', '".$_REQUEST[email]."', '".$_REQUEST[telf_extension]."','".$_REQUEST[telf_personal]."','".$_REQUEST[objetivo]."', 
            '".$_REQUEST[ref_data_padre]."', '".$_REQUEST[ref_institucion]."', true);";

	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>