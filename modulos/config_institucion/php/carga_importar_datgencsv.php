<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
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
$cambiodatostabla=$_GET[tabenv];
////////////////////////cargar archivo csv en base
require_once('../../../clases/conexion.php');
$filename=$_FILES["urltabla"]["tmp_name"];
//echo $ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
// $cambiodatostabla=sanear_string($_POST[nombretxt]);
$paramver=1;
$numerocamposfield=0;
 if($_FILES["urltabla"]["size"] > 0)
 {
        $file = fopen($filename, "r");
		$elrowmas=0;
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
			 if($elrowmas>0)
			 {
				 ////////////////////////OBJETIVOS//////////////
	          if($cambiodatostabla=="data_modusuarios")
			  {
				  $query="select id from data_departamento_direccion where nombre='".mb_convert_encoding ($emapData[3], "UTF-8", "ISO-8859-1" )."'";
		 		$datafredep=pg_query($conn, $query);
				$nombredatos=pg_fetch_result($datafredep,0,0);
			  
				  
		$query="INSERT INTO data_modusuarios( nombres, titulo, cargo,ref_departamento, data_tipo_activusuarios,tipo_usuario)   VALUES ('".mb_convert_encoding ($emapData[0], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[1], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[2], "UTF-8", "ISO-8859-1" )."','".$nombredatos."','1','3');";
		
		 		pg_query($conn, $query);
			  }
	          ////////////////////////OBJETIVOS//////////////
	          if($cambiodatostabla=="data_objetivos")
			  {
		$query="INSERT INTO data_objetivos( descripcion, ref_tipo, ref_institucion)   VALUES ('".mb_convert_encoding ($emapData[0], "UTF-8", "ISO-8859-1" )."', '".$_POST[selectdatostipobj]."', '".$_SESSION["rucinstituciontxtid"]."');";
		
		 		pg_query($conn, $query);
			  }
	          ////////////////////////PROGRAMAS//////////////			  
			if($cambiodatostabla=="data_programas")
			  {
		$query="INSERT INTO data_programas( descripcion, ref_tipo, ref_institucion)   VALUES ('".mb_convert_encoding ($emapData[0], "UTF-8", "ISO-8859-1" )."', '".$_POST[selectdatostipobj]."', '".$_SESSION["rucinstituciontxtid"]."');";
		
				 pg_query($conn, $query);
			  }
			    ////////////////////////PROYECTOS//////////////			  
			if($cambiodatostabla=="pac_data_proyectos")
			  {
				  //echo $emapData[0];
				 if($elrowmas>4)
				 { 
				 if($emapData[0] !="" )
				      {
						  if($emapData[4]!="")
						  {
	  	$query="INSERT INTO pac_data_proyectos( anio, partida_presupuestaria, codigo_cpc, tipo_compra, proyecto_descripcion, cantidad, unidad, costo_unitario, cuatrimestre_1, cuatrimestre_2, cuatrimestre_3, ref_depart_requirente )   VALUES ('".mb_convert_encoding ($emapData[0], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[1], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[2], "UTF-8", "ISO-8859-1" )."','".mb_convert_encoding ($emapData[3], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[4], "UTF-8", "ISO-8859-1" )."', '".mb_convert_encoding ($emapData[5], "UTF-8", "ISO-8859-1" )."' , '".mb_convert_encoding ($emapData[6], "UTF-8", "ISO-8859-1" )."','".mb_convert_encoding ($emapData[7], "UTF-8", "ISO-8859-1" )."','".mb_convert_encoding ($emapData[8], "UTF-8", "ISO-8859-1" )."','".mb_convert_encoding ($emapData[9], "UTF-8", "ISO-8859-1" )."','".mb_convert_encoding ($emapData[10], "UTF-8", "ISO-8859-1" )."','".$_POST[selectdatostipobjarea]."');";
		

	  
			   pg_query($conn, $query);
			   
						  }
				     }
				 }
			  }
		      //////////////////////////////////////////
			   ////////////////////////departamentos//////////////
	          if($cambiodatostabla=="data_departamento_direccion")
			  {
		$query="INSERT INTO data_departamento_direccion( nombre,  ref_institucion)   VALUES ('".mb_convert_encoding ($emapData[0], "UTF-8", "ISO-8859-1" )."', '".$_SESSION["rucinstituciontxtid"]."');";
		
		 		pg_query($conn, $query);
			  }
	          ////////////////////////PROGRAMAS//////////////	
          
			//////////fin de insercion de datos/////////
			}
		$elrowmas++;  ///aumenta datos
         }
      fclose($file);
      echo "Se actualizo correctamente";
	  /////////////////////regresar a la pagina
	   if($cambiodatostabla=="data_objetivos")
			  echo "<script>document.location.href='../lista_data_objetivos.php';</script>";
	    if($cambiodatostabla=="data_programas")
			  echo "<script>document.location.href='../lista_data_programas.php';</script>";
	   if($cambiodatostabla=="pac_data_proyectos")
		{
			if($_GET[enviver]=='pacproy')
			  echo "<script>document.location.href='../lista_data_pac_proys_general.php';</script>"; 
			else
			  echo "<script>document.location.href='../lista_data_proyectos_general.php';</script>"; 
		}
	     if($cambiodatostabla=="data_departamento_direccion")
			  echo "<script>document.location.href='../lista_data_departamentos.php';</script>";
	   if($cambiodatostabla=="data_modusuarios") 
   			  echo "<script>document.location.href='../lista_data_personaltenico.php';</script>";

 }
 else
 {
    echo "El Archivo no es el correcto";
 }

?>
</body>
</html>