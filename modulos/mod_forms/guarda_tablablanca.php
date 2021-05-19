<?php

session_start();
		
require_once('../../clases/conexion.php');


$loscampos=$_POST['txtnumcolumnas'];
$lasfilas=$_POST['txtnumfilas'];
$cambiodatostabla="tabla_plant".$_POST['txtcodigplant']."_".$_POST['txtcodigcampo'];

$secuenciacreacion="create table plantillas.tabla_plant".$_POST['txtcodigplant']."_".$_POST['txtcodigcampo']." ( ref_plantillausu int DEFAULT 0, id serial primary key,  ";

		for($m=0;$m<($loscampos);$m++)
			{
				if($m==($loscampos)-1)
					$secuenciacreacion.="campo_".$m." text null";
				else
					 $secuenciacreacion.="campo_".$m." text null,";
			//////inserto campos
			$insercmpsver="INSERT INTO tbli_esq_plant_form_plantilla_cmpcolumns( campo_creado, ref_elementcampo)   VALUES ('campo_".$m."', '".$_POST['txtcodigcampo']."');";
			$coresinse = pg_query($conn,$insercmpsver);
			//////////////////////////////////////////////
			}
		 $secuenciacreacion.=");";
		

$consulta = pg_query($conn,$secuenciacreacion);
$lasfilas=$_POST["txtnumfilas"];
 for($i=0;$i<($lasfilas);$i++)
 {
	$datoinsertilas="INSERT INTO plantillas.tabla_plant".$_POST['txtcodigplant']."_".$_POST['txtcodigcampo']." (id)  VALUES (default);";
	$consulta = pg_query($conn,$datoinsertilas);
 }

$updateaplics="UPDATE public.tbli_esq_plant_form_plantilla_campos SET nombre_tablacmp='".$cambiodatostabla."'  WHERE id='".$_POST['txtcodigcampo']."';";
pg_query($conn, $updateaplics);


 echo "<script>
     document.location.href='actualizo_columnas.php?varitab=$cambiodatostabla&varitabcmpid=".$_POST['txtcodigcampo']."';
      </script>";

?>