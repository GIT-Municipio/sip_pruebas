<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.</title>
<style type="text/css">
body {
	background-color: #333333;
}

@media print {
  @page { margin: 0; margin-top: 20px;  }
 /* body { margin: 1.6cm; }*/
}

td img { 
  margin-top: 30px; 
}

</style>
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
<table width="100%" border="0" >
<?php

require_once('../../conexion.php');

$sqluslistimgs="select url_anexo_local from tbl_archivos_scanimgs where ref_archprocesados='".$_GET["envidprimaria"]."'   order by nombrearch ";
$resultcoim=pg_query($conn, $sqluslistimgs);
$tamnum=pg_num_rows($resultcoim);
for($im=0;$im<$tamnum;$im++)
{
	
	//echo '<tr><td>&nbsp;</td></tr>';
	if(pg_fetch_result($resultcoim,$im,0)!="")
	{
	echo '<tr>
    <td align="center"><img src="'.pg_fetch_result($resultcoim,$im,0).'" width="690" height="960" /></td>
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
<tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td height="54">&nbsp;</td>
  </tr>
</table>

</body>
</html>