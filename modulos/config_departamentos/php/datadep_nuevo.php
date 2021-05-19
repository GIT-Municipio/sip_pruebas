<?php

require_once('config.php');

$casosvarop1=0;
$casosvarop2=0;

if($_REQUEST['ced_responsable']!="")
{	
$paracons="select usua_nomb || ' ' || usua_apellido from tblu_migra_usuarios where usua_cedula='".$_REQUEST['ced_responsable']."' ";
$result=pg_query($conn, $paracons);
$nombresresp=pg_fetch_result($result,0,0);
$casosvarop1=1;
}
if($_REQUEST['ced_asistente']!="")
{	
$paracons="select usua_nomb || ' ' || usua_apellido from tblu_migra_usuarios where usua_cedula='".$_REQUEST['ced_asistente']."' ";
$result=pg_query($conn, $paracons);
$nombresasis=pg_fetch_result($result,0,0);
$casosvarop2=1;
}



if($_REQUEST['parent_id']=="")
$_REQUEST['parent_id']=0;


if($_REQUEST['nombre_departamento']!="")
{
if($_REQUEST['id']=="0")
{
$parainresar="INSERT INTO tblb_org_departamento(codigo_dep,codigo_unif,nombre_departamento, email, parent_id,telf_extension,";
if($casosvarop1==1)	
$parainresar.="ced_responsable,nom_responsable,"; 
if($casosvarop2==1)	
$parainresar.="ced_asistente,nom_asistente,"; 
			 
$parainresar.=" estado_depart) VALUES ('".$_REQUEST['codigo_dep']."','".$_REQUEST['codigo_unif']."','".$_REQUEST['nombre_departamento']."', '".$_REQUEST['email']."','".$_REQUEST['parent_id']."','".$_REQUEST['telf_extension']."', ";

if($casosvarop1==1)
{
$parainresar.="'".$_REQUEST['ced_responsable']."',  '".$nombresresp."' , ";
}
if($casosvarop2==1)
{
$parainresar.="'".$_REQUEST['ced_asistente']."',  '".$nombresasis."' , ";
}
$parainresar.=" true);";	
	
}
else
{
echo $parainresar="UPDATE public.tblb_org_departamento  SET codigo_dep='".$_REQUEST['codigo_dep']."',codigo_unif='".$_REQUEST['codigo_unif']."', nombre_departamento='".$_REQUEST['nombre_departamento']."', email='".$_REQUEST['email']."', telf_extension='".$_REQUEST['telf_extension']."', parent_id='".$_REQUEST['parent_id']."', ";

if($casosvarop1==1)
{
$parainresar.=" ced_responsable='".$_REQUEST['ced_responsable']."', ";
$parainresar.=" nom_responsable='".$nombresresp."', ";
}
if($casosvarop2==1)
{
$parainresar.=" ced_asistente='".$_REQUEST['ced_asistente']."', ";
$parainresar.=" nom_asistente='".$nombresasis."', ";
}
 
$parainresar.=" estado_depart=true WHERE  id='".$_REQUEST['id']."';";



}
	
//echo $parainresar;		
$result=pg_query($conn, $parainresar);

}


/////////-------------------------actualizo variables///////////////////////
$sql = "SELECT  id,codigo_dep,codigo_unif from tblb_org_departamento where nombre_departamento='".$_REQUEST['nombre_departamento']."'";
$resul = pg_query($conn, $sql);
$devolidepart= pg_fetch_result($resul,0,"codigo_unif");
$mivect=explode("-",$devolidepart);
$eldepartprincip=$mivect[0];
$varidepartamento= pg_fetch_result($resul,0,"id");


$parainresar="UPDATE public.tblu_migra_usuarios    SET codigo_depengen='".$eldepartprincip."', codigo_subdepen='".$devolidepart."',  cod_depenid='".$varidepartamento."'  WHERE usua_cedula='".$_REQUEST['ced_responsable']."' and cod_depenid=0";	
$result=pg_query($conn, $parainresar);

$parainresar="UPDATE public.tblu_migra_usuarios    SET codigo_depengen='".$eldepartprincip."', codigo_subdepen='".$devolidepart."',  cod_depenid='".$varidepartamento."'  WHERE usua_cedula='".$_REQUEST['ced_asistente']."' and cod_depenid=0";	
$result=pg_query($conn, $parainresar);

?>