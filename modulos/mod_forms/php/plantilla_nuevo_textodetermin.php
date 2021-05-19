<?php

require_once('config.php');


 $paraconmos="update tbli_esq_plant_form_plantilla_campos  set valorx_defecto='".$_POST['informacioncontenido']."'  where campo_creado='".$_POST['nombrecampodeplantilla']."'  and ref_plantilla='".$_POST['ref_plantilla']."'";
$resultvemos=pg_query($conn, $paraconmos);


echo "<script>
     document.location.href='../form_presenta_plantilla.php?varidplanty=".$_POST['ref_plantilla']."&varclaveuntramusu=0';
      </script>";
	  
?>