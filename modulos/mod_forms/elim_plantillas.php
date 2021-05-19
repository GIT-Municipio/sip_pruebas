<?php

require_once '../../clases/conexion.php';

if($_GET["vafil"]!="")
{
  echo $actualcampos="delete from tbli_esq_plant_form_plantilla   WHERE id='".$_GET["vafil"]."' ";
 $resactual = pg_query($conn,$actualcampos);
 
}

   echo "<script>
     document.location.href='plantilla_lista_vistaplantillas.php';
      </script>";

?>