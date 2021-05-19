<?php

require_once('../../../conexion.php');

if($_REQUEST[ref_data_padre]=="")
$_REQUEST[ref_data_padre]=0;


if($_REQUEST[nombredato]!="")
{

echo $parainresar="INSERT INTO public.dato_categoria(nombre) VALUES (upper('".$_REQUEST[nombredato]."'));";

	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>