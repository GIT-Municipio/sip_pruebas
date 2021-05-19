<?php
include('phpqrcode/qrlib.php');

require_once('../../clases/conexion.php');

session_start();

$verimgqrdado="";
$verfechaut="";
if(isset($_GET['micodappsc']))
{
 $sql = "select *  FROM tbli_esq_plant_formunico  where form_cod_barras='".$_GET['micodappsc']."'  order by id;";
$resultcitem = pg_query($conn, $sql);
//$verimgqrdado=pg_fetch_result($resultcitem,0,"form_cod_qr");

$sql = "select now() as fechactual";
$res = pg_query($conn, $sql);
$verfechaut=pg_fetch_result($res,0,"fechactual");

$sqlcqr = "SELECT id, campo, descripcion FROM public.tbli_esq_plant_form_configqr where activo=1;";
$resconfigqr = pg_query($conn, $sqlcqr);
$content ="";
for($i=0;$i<pg_num_rows($resconfigqr);$i++)
{
	$content .=  pg_fetch_result($resconfigqr,$i,2).": ".pg_fetch_result($resultcitem,0,pg_fetch_result($resconfigqr,$i,1))."\n";
}
 /*
 $content = "TRAMITE Nro: ".pg_fetch_result($resultcitem,0,"form_cod_barras")."\n CEDULA: ".pg_fetch_result($resultcitem,0,"cedula")."\n NOMBRES: ".pg_fetch_result($resultcitem,0,"ciud_nombres")."\n APELLIDOS: ".pg_fetch_result($resultcitem,0,"ciud_apellidos")."\n TRAMITE: ".pg_fetch_result($resultcitem,0,"origen_tipo_tramite")."\n DOCUMENTO: ".pg_fetch_result($resultcitem,0,"origen_tipo_doc")."\n UBICACION: ".pg_fetch_result($resultcitem,0,"origen_urbano_rural");
 */

QRcode::png($content,"../../../sip_bodega/codqr/".pg_fetch_result($resultcitem,0,"form_cod_barras")."_comp_qr.png",QR_ECLEVEL_L,10,2);

$verimgqrdado = "../../../sip_bodega/codqr/".pg_fetch_result($resultcitem,0,"form_cod_barras")."_comp_qr.png";
	

}
//echo $verimgqrdado;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.</title>
<style>
 @page { size: auto; margin: 5mm; } 
</style>
    
<script>
window.print();
</script>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>    
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td> 
  </tr>
     
               
  <tr>
    <td><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0"></td>
    <td><img  src="
<?php


if(isset($_GET['micodappsc']))
			{
			$direccionalmacenqrs="../../../sip_bodega/tempidbarra/".$_GET['micodappsc'].'_barcode.png';
	        require_once('phpbarcode/barcode.inc.php'); 
  			new barCodeGenrator($_GET['micodappsc'],1,$direccionalmacenqrs, 100, 40, true);
  			//echo '<img src="barcode.gif" width = "120" height="60" />';
			echo $direccionalmacenqrs;
			}
			
?>" width="100" height="70" border="0"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font size="2">Codigo:<?php echo pg_fetch_result($resultcitem,0,"codigo_tramite"); ?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font size="2">Fecha:<?php echo substr($verfechaut,0,19); ?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font size="2">www.cotacachi.gob.ec</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font size="2"><?php echo $_SESSION['sesusuario_sumilla']; ?></font></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>