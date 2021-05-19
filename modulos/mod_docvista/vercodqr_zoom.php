<?php
require_once('../../clases/conexion.php');
include('phpqrcode/qrlib.php');
session_start();

 $sql = "SELECT inst_ruc, inst_nombre, inst_logo, inst_email,  inst_logo_docs, inst_bannersup_docs, inst_bannerinf_docs, inst_fondomarcaguaborr_docs, inst_fondomarcaguaorig_docs, inst_mensaje_slogan_docs FROM public.institucion where inst_ruc='1060000420001';";
$resxpres = pg_query($conn, $sql);
$darmecodgestrdms=pg_fetch_result($resxpres,0,0);

  $sql = "SELECT *
  FROM public.tbli_esq_plant_formunico where id='".$_GET["mvpr"]."'  ;";
$resxpresdocum = pg_query($conn, $sql);


$sqlvercoqr = "SELECT * FROM tbli_esq_plant_form_configqr where activo=1";
$resxpresqr = pg_query($conn, $sqlvercoqr);
for($g=0;$g<pg_num_rows($resxpresqr);$g++)
{
	 $content.= pg_fetch_result($resxpresqr,$g,"descripcion").": ".pg_fetch_result($resxpresdocum,0,pg_fetch_result($resxpresqr,$g,"campo"))."\n";
}


 QRcode::png($content,"../../../sip_bodega/codqr/".pg_fetch_result($resxpresdocum,0,"form_cod_barras")."_comp_qr.png",QR_ECLEVEL_L,10,2);

$verimgqrdado = "../../../sip_bodega/codqr/".pg_fetch_result($resxpresdocum,0,"form_cod_barras")."_comp_qr.png";
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mostrar Codigo QR</title>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" >
<br/>
<table width="156" border="0" align="center">
  <tr>
    <td width="146"><img src="<?php echo $verimgqrdado; ?>" width="150" height="150" border="0"></td>
  </tr>
</table>
</body>
</html>