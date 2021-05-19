<?php

require_once('config.php');



if($_REQUEST[cedula_ruc]!="")
{

$parainresar="INSERT INTO tblb_org_institucion(
            cedula_ruc, nombre, imglogo, provincia, canton, parroquia, calle_principal, 
            calle_interseccion, referencia_cercana, autoridad_nombre, 
            autoridad_cargo, autoridad_cedula, autoridad_represlegal, autoridad_cedula_represlegal, 
            delegado_cedula, delegado_nombre, delegado_cargo, delegado_nrodocumento_delegacion, 
            delegado_fecha_resolucion, vision, mision)
    VALUES ('".$_REQUEST[cedula_ruc]."','".$_REQUEST[nombre]."','".$_REQUEST[imglogo]."','".$_REQUEST[provincia]."','".$_REQUEST[canton]."','".$_REQUEST[parroquia]."','".$_REQUEST[calle_principal]."','".$_REQUEST[calle_interseccion]."','".$_REQUEST[referencia_cercana]."','".$_REQUEST[autoridad_nombre]."','".$_REQUEST[autoridad_cargo]."','".$_REQUEST[autoridad_cedula]."','".$_REQUEST[autoridad_represlegal]."','".$_REQUEST[autoridad_cedula_represlegal]."','".$_REQUEST[delegado_cedula]."','".$_REQUEST[delegado_nombre]."','".$_REQUEST[delegado_cargo]."','".$_REQUEST[delegado_nrodocumento_delegacion]."','".$_REQUEST[delegado_fecha_resolucion]."','".$_REQUEST[vision]."','".$_REQUEST[mision]."');";
	

	
//	$parainresar="INSERT INTO data_institucion(cedula_ruc)  VALUES ('04015');";
			
$result=pg_query($conn, $parainresar);

}

?>