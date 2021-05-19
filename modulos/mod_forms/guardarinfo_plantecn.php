<?php
require_once '../../clases/conexion.php';


function reemplazarInfo($textorig,$varcedul,$varnom,$varapel,$varevento)
{
$reemplazartxt=str_replace("[CEDULA]",$varcedul,$textorig);
$reemplazartxt=str_replace("[NOMBRES]",$varnom,$reemplazartxt);
$reemplazartxt=str_replace("[APELLIDOS]",$varapel,$reemplazartxt);
$reemplazartxt=str_replace("[EVENTO]",$varevento,$reemplazartxt);

return $reemplazartxt;
}

///////////////codigi de la plantilla
$darmeid=$_POST["mivaridplantillaesq"];
$sqlquer="select nombre_tablabdd,nombre_tabla_anexos from tbli_esq_plant_form_plantilla where  id = '".$darmeid."'";
$consulcamplans=pg_query($conn,$sqlquer);
$darmetabla= pg_fetch_result($consulcamplans,0,0); 
$darmtablanexos= pg_fetch_result($consulcamplans,0,1);

$sqlquer="select campo_creado,ref_tcamp from tbli_esq_plant_form_plantilla_campos where  ref_plantilla = '".$darmeid."'";
$consulcamps=pg_query($conn,$sqlquer);
$vertamancpm=pg_num_rows($consulcamps);



 $query = "UPDATE plantillas.".$darmetabla." SET estadodoc='ATENDIDO',";
	 
	 for($i=0;$i<$vertamancpm;$i++)
	 {
		 
			
	    if($i==$vertamancpm-1)
		{
			
		  if(pg_fetch_result($consulcamps,$i,'ref_tcamp')==11)
		  {
			 $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".reemplazarInfo($_POST[pg_fetch_result($consulcamps,$i,'campo_creado')],$_POST["campo_1"],$_POST["campo_2"],$_POST["campo_3"],$_POST["campo_7"])."'";  
		  }
		  else
		  if(pg_fetch_result($consulcamps,$i,'ref_tcamp')!=10) 
	      $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".$_POST[pg_fetch_result($consulcamps,$i,'campo_creado')]."'"; 
		}
	    else
		{	
		if(pg_fetch_result($consulcamps,$i,'ref_tcamp')==11)
		  {
			   $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".reemplazarInfo($_POST[pg_fetch_result($consulcamps,$i,'campo_creado')],$_POST["campo_1"],$_POST["campo_2"],$_POST["campo_3"],$_POST["campo_7"])."',";
		  }
		  else
		  if(pg_fetch_result($consulcamps,$i,'ref_tcamp')!=10) 
	      $query .= pg_fetch_result($consulcamps,$i,'campo_creado')."='".$_POST[pg_fetch_result($consulcamps,$i,'campo_creado')]."',"; 
		}
		
		
		
	 }
	
	$query = trim($query, ',');
	
	 $query .= "    WHERE id='".$_POST["mivarplancodtramite"]."'";
	
	$resulcretodo = pg_query($conn, $query);
 //echo $query;
/////////////////////////UPDATE A LOS VALORES POR DEFECTO//

echo "<script>alert('La informacion se guardo correctamente');document.location.href='form_tec.php?rp=".$darmeid."&varclaveuntramusu=".$_POST["mivarplancodtramite"]."&pontblanexo=".$darmtablanexos."'</script>";


?>