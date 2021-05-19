<?php

require_once '../../clases/conexion.php';

  $datosql="select *from tbli_esq_plant_form_plantilla where id='".$_POST["ponref_plantilla"]."'";
 $consulta = pg_query($conn,$datosql);
 $ponertabla=pg_fetch_result($consulta,0,'nombre_tablabdd');

    $datosql="update  plantillas.".$ponertabla." set ".$_POST["varitabcmpid"]."='".$_POST[$_POST["varitabcmpid"]]."'  where id='".$_POST["varclaveuntramusu"]."' ";
 $consulta = pg_query($conn,$datosql);
/*
echo "app_tipo_mapaubic_vista.php?ponref_plantilla=".$_POST["ponref_plantilla"]."&varitabcmpid=".$_POST["varitabcmpid"]."&varclaveuntramusu=".$_POST["varclaveuntramusu"];
*/

   echo "<script>
     document.location.href='app_tipo_mapaubic_vista.php?ponref_plantilla=".$_POST["ponref_plantilla"]."&varitabcmpid=".$_POST["varitabcmpid"]."&varclaveuntramusu=".$_POST["varclaveuntramusu"]."';
      </script>";
	  
	  

?>