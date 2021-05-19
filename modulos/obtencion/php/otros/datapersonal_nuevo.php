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
             tipo_usuario, imagenicon, iniciales_nombres, cedula, apellidos, 
            nombres, sexo, estado_civil, email, nacionalidad, direccion, 
            coord_direccion, telf_celular, fecha_suscripcion, usuario, clave, 
            estado)
    VALUES ('".$_REQUEST[tipo_usuario]."', '".$_REQUEST[imagenicon]."', '".$inicialescalc."', '".$_REQUEST[cedula]."', '".$_REQUEST[apellidos]."', '".$_REQUEST[nombres]."', '".$_REQUEST[sexo]."', '".$_REQUEST[estado_civil]."', '".$_REQUEST[email]."', '".$_REQUEST[nacionalidad]."', '".$_REQUEST[direccion]."', '".$_REQUEST[coord_direccion]."', '".$_REQUEST[telf_celular]."', NOW(), '".$_REQUEST[usuario]."', '".$_REQUEST[clave]."', true);";

			
$result=pg_query($conn, $parainresar);

}

?>