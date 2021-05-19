<?php

require_once '../../clases/conexion.php';

if($_POST["selecmicamp"]!="")
{
   $actualcampos="delete from tbli_esq_plant_form_plantilla_cmpcolumns   WHERE ref_elementcampo='".$_POST["varitabcmpid"]."' and campo_creado='".$_POST["selecmicamp"]."'";
 $resactual = pg_query($conn,$actualcampos);
   $actualcampos="alter table plantillas.".$_POST["varitab"]." drop column ".$_POST["selecmicamp"]." ";
 $resactual = pg_query($conn,$actualcampos);
  
}

   echo "<script>
     document.location.href='app_tipo_tabla.php?pontabla=".$_POST["varitab"]."&varitabcmpid=".$_POST["varitabcmpid"]."&varclaveuntramusu=".$_POST["varclaveuntramusu"]."';
      </script>";

?>