<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');

/////////////////CONSULTO LA TABLA
 $sqlconstab = "SELECT plan.id,plan.nombre_tablabdd,contin.nom_responsable,contin.ref_nom_depart,contin.detalle from tbli_esq_plant_form_plantilla plan,tbli_esq_plant_form_cuadro_clasif contin where plan.ref_clasif_doc=contin.id and   plan.id='".$_GET['varidplanty']."' order by id";
$resconstab = pg_query($conn, $sqlconstab);
$darmetablaext= "plantillas.".pg_fetch_result($resconstab,0,'nombre_tablabdd');
$dargesolicitfuncnom=pg_fetch_result($resconstab,0,'nom_responsable');
$dargesolicitfuncdep=pg_fetch_result($resconstab,0,'ref_nom_depart');
$dargesnombreproceso=pg_fetch_result($resconstab,0,'detalle');

 $sql = "SELECT id, fecha, fecha_atencion, cod_tramite_tempo, cod_traminterno,codi_barras, codigo_tramite, ciu_cedula, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6  FROM ".$darmetablaext." where id='".$_GET["varclaveuntramusu"]."'  ;";
$resxpresdocum = pg_query($conn, $sql);

$dargestrdmsfecha=pg_fetch_result($resxpresdocum,0,'fecha');
$dargestrdmsbrras=pg_fetch_result($resxpresdocum,0,'cod_tramite_tempo');
$dargestrdmscedul=pg_fetch_result($resxpresdocum,0,'campo_1');
$dargestrdmsnoms=pg_fetch_result($resxpresdocum,0,'campo_2');
$dargestrdmsapels=pg_fetch_result($resxpresdocum,0,'campo_3');
$dargestrdmsolciutelf=pg_fetch_result($resxpresdocum,0,'campo_4');
$dargestrdmsolciuemail=pg_fetch_result($resxpresdocum,0,'campo_5');
$dargestrdmsolciudomi=pg_fetch_result($resxpresdocum,0,'campo_6');
//$dargestrdmsolicit=pg_fetch_result($resxpresdocum,0,'origen_form_asunto');




$content="SERVICIOS WEB\n GAD MUNICIPAL DE COTACACHI \n Codigo: ".$dargestrdmsbrras."\n Cedula: ".$dargestrdmscedul."\n Nombres: ".$dargestrdmsnoms.' '.$dargestrdmsapels.'\n Solicitud: '.$dargesnombreproceso;

QRcode::png($content,"../../../sip_bodega/codqr/"."plantilla_".$_GET['varidplanty']."_comp_qr.png",QR_ECLEVEL_L,10,2);
$verimgqrdado = "../../../sip_bodega/codqr/"."plantilla_".$_GET['varidplanty']."_comp_qr.png";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Impresion Solicitud</title>
<style>
 @page { size: auto; margin: 5mm; } 
</style>
<script>
window.print();
</script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="90%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="17%"><img src="../../imgs/logos/logo_cotac2019.png" width="54" height="101" /></td>
        <td width="53%" align="center"><table width="100%" border="0">
          <tr>
            <td align="center"><b>MUNICIPIO DE COTACACHI</b></td>
          </tr>
          <tr>
            <td align="center"><b><?php echo $dargesnombreproceso; ?></b></td>
          </tr>
          <tr>
            <td align="center">Solicitud Electrónica</td>
          </tr>
        </table></td>
        <td width="30%" align="right"><table width="200" border="0">
          <tr>
              <td align="center"><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" /></td>
            </tr>
            <tr>
              <td align="center"><?php echo $dargestrdmsbrras; ?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="60"><b>Fecha:</b></td>
        <td width="517">Cotacachi,  <?php echo $dargestrdmsfecha; ?></td>
      </tr>
      <tr>
        <td><b>Dirigido_a:</b></td>
        <td><?php echo $dargesolicitfuncnom.' <br/> '.$dargesolicitfuncdep;?>&nbsp;</td>
      </tr>
      <tr>
        <td><b>Cedula:</b></td>
        <td><?php echo $dargestrdmscedul; ?></td>
      </tr>
      <tr>
        <td><b>Nombres:</b></td>
        <td><?php echo $dargestrdmsnoms.' '.$dargestrdmsapels; ?></td>
      </tr>
      <tr>
        <td><b>Domicilio:</b></td>
        <td><?php echo $dargestrdmsolciudomi; ?></td>
      </tr>
      <tr>
        <td><b>Telefono:</b></td>
        <td><?php echo $dargestrdmsolciutelf; ?></td>
      </tr>
      <tr>
        <td><b>Email:</b></td>
        <td><?php echo $dargestrdmsolciuemail; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>De mi Consideracion,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Solicitar de la manera mas comedida el tramite de: <?php echo $dargesnombreproceso; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Atentamente,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="200" border="0" align="center">
      <tr>
        <td>_______________________</td>
      </tr>
      <tr>
        <td align="center"><?php echo $dargestrdmsnoms." ".$dargestrdmsapels; ?></td>
      </tr>
      <tr>
        <td align="center">C.I:<?php echo $dargestrdmscedul; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>