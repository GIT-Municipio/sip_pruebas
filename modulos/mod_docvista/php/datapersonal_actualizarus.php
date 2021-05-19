<?php

require_once('config.php');

	
/*	  
$inicialescalc=substr($_REQUEST['nombres'], 0, 1);  
$inicialescalc.=substr($_REQUEST['apellidos'], 0, 1);  
*/
/*
$valormot1=0;
if($_REQUEST['usu_activo'])
$valormot1=1;
*/


if($_REQUEST['cedula']!="")
{

if($_REQUEST['clave']=="")
{
/* 
$parainresar="update tblu_migra_usuarios set usu_foto='".$_REQUEST['imagenicon']."',  usua_cedula='".$_REQUEST['cedula']."', usua_apellido='".$_REQUEST['apellidos']."', usua_nomb='".$_REQUEST['nombres']."', usua_login='".$_REQUEST['usuario']."', usua_email='".$_REQUEST['email']."',  usua_telefono='".$_REQUEST['telefono']."',  usu_activo='".$valormot1."' where id='".$_REQUEST['id']."';";
*/
  $parainresar="update tblu_migra_usuarios set usu_foto='".$_REQUEST['imagenicon']."',  usua_cedula='".$_REQUEST['cedula']."', usua_apellido='".$_REQUEST['apellidos']."', usua_nomb='".$_REQUEST['nombres']."', usua_login='".$_REQUEST['usuario']."', usua_email='".$_REQUEST['email']."',  usua_telefono='".$_REQUEST['telefono']."' where id='".$_REQUEST['id']."';";
}
else
{
 $parainresar="update tblu_migra_usuarios set usu_foto='".$_REQUEST['imagenicon']."',  usua_cedula='".$_REQUEST['cedula']."', usua_apellido='".$_REQUEST['apellidos']."', usua_nomb='".$_REQUEST['nombres']."', usua_pasw=md5('".$_REQUEST['clave']."') ,  usua_login='".$_REQUEST['usuario']."', usua_email='".$_REQUEST['email']."',  usua_telefono='".$_REQUEST['telefono']."' where id='".$_REQUEST['id']."';";
}
			
$result=pg_query($conn, $parainresar);

}

?>