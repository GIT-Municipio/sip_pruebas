<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	background-color: #333333;
}
</style>
</head>

<body>
<table width="200" border="1">
<?php

require_once('../../conexion.php');

$sqluslistimgs="select url_anexo_local from tbl_archivos_scanimgs where ref_archprocesados='".$_GET["envidprimaria"]."'";
$resultcoim=pg_query($conn, $sqluslistimgs);
$tamnum=pg_num_rows($resultcoim);
for($im=0;$im<$tamnum;$im++)
{
	if(pg_fetch_result($resultcoim,$im,0)!="")
	{
	echo '<tr>
    <td><img src="'.pg_fetch_result($resultcoim,$im,0).'" width="497" height="704" /></td>
  </tr>';
	}
	else
	{
	echo '<tr>
    <td>&nbsp;</td>
  </tr>';
	}
}


?>



</table>

</body>
</html>