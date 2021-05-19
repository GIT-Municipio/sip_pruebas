<?php

require_once('config.php');

	if($_REQUEST[data_tipo_activusuarios]==true)
	  $_REQUEST[data_tipo_activusuarios]=1;
	  else
      $_REQUEST[data_tipo_activusuarios]=2;

$inicialescalc=substr($_REQUEST[nombres], 0, 1);  
$inicialescalc.=substr($_REQUEST[apellidos], 0, 1);  

$sql = "SELECT  id,codigo_dep,codigo_unif from tblb_org_departamento where nombre_departamento='".$_REQUEST[usu_departamento]."'";
$resul = pg_query($conn, $sql);
$devolidepart= pg_fetch_result($resul,0,"codigo_unif");
$mivect=explode("-",$devolidepart);
$eldepartprincip=$mivect[0];


$sql = "SELECT  id from tblb_org_roles where rol='".$_REQUEST[usu_tiporol_nombre]."'";
$resul = pg_query($conn, $sql);
$devolirole= pg_fetch_result($resul,0,"id");

$sqlcont = "SELECT  count(*) from tblu_migra_usuarios where usua_cedula='".$_REQUEST[cedula]."'";
$resulc = pg_query($conn, $sqlcont);
$vercontusus= pg_fetch_result($resulc,0,0);

if($vercontusus==0)
{
if($_REQUEST[cedula]!="")
{

echo $parainresar="INSERT INTO tblu_migra_usuarios(
              usua_cedula, usua_nomb, usua_apellido, usua_cargo, usua_titulo, usua_email, 
            usua_telefono, usua_login, usua_pasw, usu_biografia, usu_tiporol, codigo_depengen,codigo_subdepen, 
            usu_departamento, usua_sumilla,usua_direccion,usu_tiporol_nombre)
    VALUES ('".$_REQUEST[cedula]."', '".$_REQUEST[nombres]."', '".$_REQUEST[apellidos]."', '".$_REQUEST[cargo]."', '".$_REQUEST[titulo]."', '".$_REQUEST[email]."', '".$_REQUEST[telefono]."', '".$_REQUEST[usuario]."', md5('".$_REQUEST[clave]."'), '".$_REQUEST[biografia]."', '".$devolirole."', '".$eldepartprincip."', '".$devolidepart."', '".$_REQUEST[usu_departamento]."', '".$inicialescalc."', '".$_REQUEST[usua_direccion]."','".$_REQUEST[usu_tiporol_nombre]."');";
			


	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}
}

?>