<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Codigos</title>
<SCRIPT language="javascript"> 
    function imprimir() { 
        if ((navigator.appName == "Netscape")) { window.print() ; 
        } 
        else { 
            var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
            document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
        } 
    } 
</SCRIPT> 
</head>

<body onload="imprimir()">
<?php

require_once('../../conexion.php');
require_once('phpbarcode/barcode.inc.php'); 

$sqlusauxdep="SELECT grup_cod_barras,grup_cod_qr FROM tbl_grupo_archivos";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$numtam=pg_num_rows($resultcodauc);	

echo '<table width="390" border="1" border="1" cellpadding="0" cellspacing="0">';	
for($fic=0;$fic<$numtam;)
{
	echo '<tr>';
	
	for($col=0; $col<4; $col++) {
	echo '<td width="186">';
	if($fic<$numtam)
	  {
	///////////////////////////
	echo '<table width="182" border="0"><tr><td width="50"><img src="'.pg_fetch_result($resultcodauc,$fic,'grup_cod_qr').'" width="50" height="50" border="0"></td>';
	echo	'<td width="116"><img src="'; 
  			new barCodeGenrator(pg_fetch_result($resultcodauc,$fic,'grup_cod_barras'),1,pg_fetch_result($resultcodauc,$fic,'grup_cod_barras').'_barcode.png', 120, 60, true);
			echo pg_fetch_result($resultcodauc,$fic,'grup_cod_barras').'_barcode.png';
			
	echo '" width="120" height="60" border="0"></td></tr></table>';
	//////////////////////////////////
	  $fic++;
	  }
	  else
	     echo "&nbsp;";
	  
	echo '</td>';
	 }
	
	echo '</tr>';
}
		
echo '</table>';
?>
</body>
</html>