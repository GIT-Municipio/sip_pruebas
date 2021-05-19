<?php

require_once '../../clases/conexion.php';

   $datosql="select *from plantillas.".$_POST["varitab"];
 $consulta = pg_query($conn,$datosql);
// echo pg_num_fields($consulta);
  
 for($i=1;$i<pg_num_fields($consulta);$i++)
  {
	  if(pg_field_name($consulta,$i)!='id')
	  {
		  $valcheq=0;
		  if($_POST["cheq".pg_field_name($consulta,$i)]=='on')
		  $valcheq=1;
		  
 $actualcampos="UPDATE tbli_esq_plant_form_plantilla_cmpcolumns SET  campo_nombre='".$_POST[pg_field_name($consulta,$i)]."',  campo_tipo='".$_POST["combo".pg_field_name($consulta,$i)]."',campo_tamanio='".$_POST["tam".pg_field_name($consulta,$i)]."',campo_bloqueo='".$valcheq."'  WHERE ref_elementcampo='".$_POST["varitabcmpid"]."' and campo_creado='".pg_field_name($consulta,$i)."'";
 $resactual = pg_query($conn,$actualcampos);
	  }
  }
  

   echo "<script>
     document.location.href='app_tipo_tabla.php?pontabla=".$_POST["varitab"]."&varitabcmpid=".$_POST["varitabcmpid"]."&varclaveuntramusu=".$_POST["varclaveuntramusu"]."';
      </script>";

?>