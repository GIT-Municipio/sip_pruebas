<?php

require_once('config.php');



if($_REQUEST[cedula_ruc]!="")
{

 $paraupdate="UPDATE public.tblb_org_institucion  SET cedula_ruc='".$_REQUEST[cedula_ruc]."',nombre='".$_REQUEST[nombre]."',imglogo='".$_REQUEST[imglogo]."',provincia='".$_REQUEST[provincia]."',canton='".$_REQUEST[canton]."',parroquia='".$_REQUEST[parroquia]."',calle_principal='".$_REQUEST[calle_principal]."',calle_interseccion='".$_REQUEST[calle_interseccion]."', referencia_cercana='".$_REQUEST[referencia_cercana]."',autoridad_nombre='".$_REQUEST[autoridad_nombre]."',autoridad_cargo='".$_REQUEST[autoridad_cargo]."',autoridad_cedula='".$_REQUEST[autoridad_cedula]."',autoridad_represlegal='".$_REQUEST[autoridad_represlegal]."',autoridad_cedula_represlegal='".$_REQUEST[autoridad_cedula_represlegal]."',delegado_cedula='".$_REQUEST[delegado_cedula]."',delegado_nombre='".$_REQUEST[delegado_nombre]."',delegado_cargo='".$_REQUEST[delegado_cargo]."',delegado_nrodocumento_delegacion='".$_REQUEST[delegado_nrodocumento_delegacion]."',delegado_fecha_resolucion='".$_REQUEST[delegado_fecha_resolucion]."',mision='".$_REQUEST[mision]."',actualizociusbdd='".$_REQUEST[actualizociusbdd]."'  WHERE id='".$_REQUEST[id]."';";


$result=pg_query($conn, $paraupdate);

}

?>