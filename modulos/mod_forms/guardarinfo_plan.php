<?php
require_once '../../clases/conexion.php';
///////////////codigi de la plantilla
$darmeid=$_POST["mivaridplantillaesq"];
$sqlquer="select nombre_tablabdd,nombre_tabla_anexos from tbli_esq_plant_form_plantilla where  id = '".$darmeid."'";
$consulcamplans=pg_query($conn,$sqlquer);
$darmetabla= pg_fetch_result($consulcamplans,0,0); 
$darmtablanexos= pg_fetch_result($consulcamplans,0,1);

$sqlquer="select campo_creado,ref_tcamp from tbli_esq_plant_form_plantilla_campos where  ref_plantilla = '".$darmeid."'";
$consulcamps=pg_query($conn,$sqlquer);
$vertamancpm=pg_num_rows($consulcamps);


 $query = "UPDATE plantillas.".$darmetabla." SET ";
	 
	 for($i=0;$i<$vertamancpm;$i++)
	 {
	    if($i==$vertamancpm-1)
		{
	      $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".$_POST[pg_fetch_result($consulcamps,$i,'campo_creado')]."'"; 
		}
	    else
		{	
	      $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".$_POST[pg_fetch_result($consulcamps,$i,'campo_creado')]."',"; 
		}
	 }
	 
	 $query .= ", estadodoc='PRUEBAS' WHERE id='".$_POST["mivarplancodtramite"]."'";
	
	$resulcretodo = pg_query($conn, $query);
//echo $cadeninsert;
/////////////////////////UPDATE A LOS VALORES POR DEFECTO//

echo "<script>document.location.href='form_anexos.php?mvpr=".$darmeid."&varclaveuntramusu=".$_POST["mivarplancodtramite"]."&pontblanexo=".$darmtablanexos."'</script>";


?>