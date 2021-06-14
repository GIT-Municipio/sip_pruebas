<?php

session_start();
//-------------------------------
header("Refresh: 1210");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 1200; //20min.

	//Calculamos tiempo de vida inactivo.
	$vida_session = time() - $_SESSION['tiempo'];

	//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
	if ($vida_session > $inactivo) {
		//Removemos sesión.
		session_unset();
		//Destruimos sesión.
		session_destroy();
		//Redirigimos pagina.
		header("location: http://localhost/sip_pruebas/404/404.html");
		exit();
	}
}
$_SESSION['tiempo'] = time();
//---------------------
		
require_once('../../clases/conexion.php');

/*
 $cambiodatostabla="combo_plant".$_GET['varidplantilla']."_".$_GET['varidenvcmp'];

 $secuenciacreacion="create table plantillas.combo_plant".$_GET['varidplantilla']."_".$_GET['varidenvcmp']." (  id serial primary key, item_nom text ); ";
$consulta = pg_query($conn,$secuenciacreacion);

$lasfilas=5;
 for($i=0;$i<($lasfilas);$i++)
 {
	$datoinsertilas="INSERT INTO plantillas.combo_plant".$_GET['varidplantilla']."_".$_GET['varidenvcmp']." (id)  VALUES (default);";
	$consulta = pg_query($conn,$datoinsertilas);
 }

 $updateaplics="UPDATE public.tbli_esq_plant_form_plantilla_campos SET nombre_combocmp='".$cambiodatostabla."'  WHERE id='".$_GET['varidenvcmp']."';";
pg_query($conn, $updateaplics);
*/
$paraconmos="select nombre_tablabdd from tbli_esq_plant_form_plantilla where id='".$_GET["varidplantilla"]."'  ";
$resultvemos=pg_query($conn, $paraconmos);
$vernombretabla=pg_fetch_result($resultvemos,0,0);


$paraconmos="select campo_creado from tbli_esq_plant_form_plantilla_campos where id='".$_GET["varidenvcmp"]."'  ";
$resultvemos=pg_query($conn, $paraconmos);
$vernombrecampoupdate=pg_fetch_result($resultvemos,0,0);


echo "<script>
     document.location.href='app_tipo_textolarg.php?vcodigplantillavar=".$_GET["varidplantilla"]."&vnombretabplantilla=".$vernombretabla."&vnombrecampo=".$vernombrecampoupdate."';
      </script>";

?>