<?php
require_once('../../conexion.php');

$mensaje="";

        // $sqlus="SELECT * FROM public.tbl_grupo_archivos where  id='1';";
		 $sqlus="SELECT * FROM public.tbl_grupo_archivos where  id='".$_REQUEST["itemiselecid"]."';";
		$result=pg_query($conn, $sqlus);
		
		session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
		///////////////////////seleccionar departamento
		$_SESSION['varses_grup_codigo']=pg_fetch_result($result,0,"grup_cod_barras");
		$_SESSION['varses_grup_nombregrup']= pg_fetch_result($result,0,"grup_nombre"); 
		///////////////////////seleccionar departamento
		$sqlus="SELECT nombre_departamento FROM data_departamento_direccion where  id='".pg_fetch_result($result,0,"gparam_departamento")."';";
		$resultdep=pg_query($conn, $sqlus);
		$_SESSION['varses_grup_depart']=pg_fetch_result($resultdep,0,0);
		$_SESSION['varses_grup_departid']=pg_fetch_result($result,0,"gparam_departamento");
		///////////////////////seleccionar departamento
		$sqlus="SELECT nombre FROM dato_categoria where  id='".pg_fetch_result($result,0,"gparam_cod_categoria")."';";
		$resultcat=pg_query($conn, $sqlus);
		$_SESSION['varses_grup_categ']=pg_fetch_result($resultcat,0,0);
		$_SESSION['varses_grup_categid']=pg_fetch_result($result,0,"gparam_cod_categoria");
		///////////////////////////////////////////////
		$_SESSION['varses_grup_bodega']=pg_fetch_result($result,0,"gparam_bodega");
		$_SESSION['varses_grup_estanteria']=pg_fetch_result($result,0,"gparam_estanteria");
		$_SESSION['varses_grup_nivel']=pg_fetch_result($result,0,"gparam_nivel");

		$_SESSION['varses_grup_avisogrupo']="Grupo Activo: ".pg_fetch_result($result,0,"grup_nombre");
		
		echo $mensaje="ok@".pg_fetch_result($result,0,"grup_nombre")."@".$_SESSION['varses_grup_categ'];



?>