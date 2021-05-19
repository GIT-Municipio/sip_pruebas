<?php

require_once('config.php');

	if($_REQUEST[data_tipo_activusuarios]==true)
	  $_REQUEST[data_tipo_activusuarios]=1;
	  else
      $_REQUEST[data_tipo_activusuarios]=2;

$inicialescalc=substr($_REQUEST[nombres], 0, 1);  
$inicialescalc.=substr($_REQUEST[apellidos], 0, 1);  


if($_REQUEST[cedula]!="")
{

echo $parainresar="INSERT INTO data_modusuarios(
              cedula, nombres, apellidos, cargo, titulo, email, 
            telefono, usuario, clave, biografia, tipo_usuario, ref_departamento, 
            data_tipo_activusuarios, iniciales_nombres)
    VALUES ('".$_REQUEST[cedula]."', '".$_REQUEST[nombres]."', '".$_REQUEST[apellidos]."', '".$_REQUEST[cargo]."', '".$_REQUEST[titulo]."', '".$_REQUEST[email]."', '".$_REQUEST[telefono]."', '".$_REQUEST[usuario]."', md5('".$_REQUEST[clave]."'), '".$_REQUEST[biografia]."', '1', '1', '1', '".$inicialescalc."');";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>