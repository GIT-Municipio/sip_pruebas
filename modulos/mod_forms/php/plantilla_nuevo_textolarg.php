<?php

require_once('config.php');


echo $paraconmos="update tbli_esq_plant_form_plantilla_campos  set valorx_defecto='".$_REQUEST[valorxdefecto]."'  where campo_creado='".$_REQUEST[nombrecampodeplantilla]."'  and ref_plantilla='".$_REQUEST[ref_plantilla]."'";
$resultvemos=pg_query($conn, $paraconmos);


?>