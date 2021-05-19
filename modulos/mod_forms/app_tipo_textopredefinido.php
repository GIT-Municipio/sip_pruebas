<?php

require_once('../../clases/conexion.php');

$paraconmos="select valorx_defecto from tbli_esq_plant_form_plantilla_campos where id='".$_GET["vidcampousado"]."'  ";
$resultvemos=pg_query($conn, $paraconmos);
if(pg_fetch_result($resultvemos,0,0)!="")
$verponertextvalor=pg_fetch_result($resultvemos,0,0);
else
$verponertextvalor='Descripcion del Texto';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Texto Avanzado</title>

<style type="text/css">    

		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #dce7fa;
			overflow: hidden;
			font-family: verdana, arial, helvetica, sans-serif;
           
		}
</style>
</head>

<body onLoad="doOnLoad();">
<div id="contenidodelmemo">

<form action="php/plantilla_nuevo_textodetermin.php" method="post"> 
<?php 
    
    include("fckeditor/fckeditor.php") ; 
    $oFCKeditor = new FCKeditor('informacioncontenido') ;
    $oFCKeditor->BasePath = 'fckeditor/';
	///$oFCKeditor->ToolbarSet = 'Basic';    ///EN CASO DE QUE SE NECESITE UN EDITOR SOLO BASICO CASO CONTRARIO DEJAMOSDESACTIVADO
	$oFCKeditor->Value = $verponertextvalor;     ////sirve para asginar los datos que sale de la base de datos
	//$oFCKeditor->Value = pg_fetch_result($restxtmem,0,0);  
	
    $oFCKeditor->Width  = '100%' ;
    $oFCKeditor->Height = '320' ;
    $oFCKeditor->Create() ;
	
		
?> 

<input type="hidden" id="ref_plantilla" name="ref_plantilla" value="<?php  if(isset($_GET["vcodigplantillavar"])) echo $_GET["vcodigplantillavar"]; ?>" />
<input type="hidden" id="nombretablaplantillas" name="nombretablaplantillas" value="<?php  if(isset($_GET["vnombretabplantilla"])) echo $_GET["vnombretabplantilla"]; ?>" />
<input type="hidden" id="nombrecampodeplantilla" name="nombrecampodeplantilla" value="<?php  if(isset($_GET["vnombrecampo"])) echo $_GET["vnombrecampo"]; ?>" />
<input type="hidden" id="varclaveuntramusu" name="varclaveuntramusu" value="<?php echo $_GET["varclaveuntramusu"] ?>" />
<div align="center">
<table width="100%" border="0">
  <tr>
  <td align="center"><input type="submit" style="width: 200px; height: 50px;" class="menulatdivinfer" value=">> GUARDAR <<"></td>
  </tr>
</table>
 </div>
</form> 
</div>
</body>
</html>