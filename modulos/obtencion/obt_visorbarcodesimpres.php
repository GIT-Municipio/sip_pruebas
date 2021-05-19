<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div align="center">
<img  src="
<?php
session_start();

if(isset($_SESSION['varses_grup_codigo']))
			{
	        require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator($_SESSION['varses_grup_codigo'],1,$_SESSION['varses_grup_codigo'].'_barcode.png', 120, 60, true);
  			//echo '<img src="barcode.gif" width = "120" height="60" />';
			echo $_SESSION['varses_grup_codigo'].'_barcode.png';
			}
			
?>" width="120" height="80" border="0">
</div>
</body>
</html>