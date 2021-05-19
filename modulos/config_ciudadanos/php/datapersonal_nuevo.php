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

echo $parainresar="INSERT INTO tbli_esq_plant_ciudadano(
              ciu_cedula, ciu_nombre, ciu_apellido, ciu_direccion,  ciu_email, 
            ciu_telefono, ciu_login, ciu_pasw, ciu_biografia)
    VALUES ('".$_REQUEST[cedula]."', '".$_REQUEST[nombres]."', '".$_REQUEST[apellidos]."', '".$_REQUEST[ciu_direccion]."', '".$_REQUEST[email]."', '".$_REQUEST[telefono]."', '".$_REQUEST[usuario]."', md5('".$_REQUEST[clave]."'), '".$_REQUEST[biografia]."');";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>