<meta charset='utf-8'>
<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');
require_once('../../dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$_SESSION["varidplanty"] = "999";
$sqlconstab = "SELECT plan.id,plan.nombre_tablabdd,contin.nom_responsable,contin.ref_nom_depart,contin.detalle from tbli_esq_plant_form_plantilla plan,tbli_esq_plant_form_cuadro_clasif contin where plan.ref_clasif_doc=contin.id and plan.id='999' order by id";
$resconstab = pg_query($conn, $sqlconstab);
$darmetablaext = "plantillas." . pg_fetch_result($resconstab, 0, 'nombre_tablabdd');
$vari = $_GET["varclaveuntramusu"];
$plant = $_GET["plantilla"];
$numero = strlen($plant);
$plantilla = "999";
$departamento = $_SESSION['varidplanty'];
$dargesolicitfuncnom = pg_fetch_result($resconstab, 0, 'nom_responsable');

$cedremiten = $_GET['cedularemitente'];
$ced = $_GET['remitenteseleccionado'];
// echo "<script type='text/javascript'>alert('$cedremiten');</script>";

// echo "<script type='text/javascript'>alert('$ced');</script>";

// if($cedremiten==$ced)
//   $ced = true;
// else 
//   $ced = false;
$elaborado = '';
if (($cedremiten != $ced) && $ced != null) {
  $idtramite = $_GET["idtramite"];
  $sql = "SELECT codigo_documento, origen_cedul, origen_nombres, origen_cargo, 
	origen_departament, codigo_tramite
	FROM tbli_esq_plant_formunico_docsinternos 
	where id='" . $idtramite . "'";
  $res = pg_query($conn, $sql);
  $codigotramite = pg_fetch_result($res, 0, 'codigo_tramite');
  $origennombres = pg_fetch_result($res, 0, 'origen_nombres');
  $origencargo = pg_fetch_result($res, 0, 'origen_cargo');
  $elaborado = $origennombres . '<br>' . $origencargo;
  $ced = pg_fetch_result($res, 0, 'origen_cedul');
}

$dargesolicitfuncdep = pg_fetch_result($resconstab, 0, 'ref_nom_depart');
$dargesnombreproceso = pg_fetch_result($resconstab, 0, 'detalle');

$sql = "SELECT id, fecha, fecha_atencion, cod_tramite_tempo, cod_traminterno,codi_barras, codigo_tramite, ciu_cedula, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_9  FROM " . $darmetablaext . " where id='" . $_GET["varclaveuntramusu"] . "'  ;";
$resxpresdocum = pg_query($conn, $sql);

$arrayMeses = array(
  'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
);
$fecha = strftime("Cotacachi, %d de " . $arrayMeses[date('m') - 1] . " de %Y");
$dargestrdmsbrras = pg_fetch_result($resxpresdocum, 0, 'cod_tramite_tempo');
$dargestrdmscedul = pg_fetch_result($resxpresdocum, 0, 'campo_1');
$dargestrdmsnoms = pg_fetch_result($resxpresdocum, 0, 'campo_2');
$dargestrdmsapels = pg_fetch_result($resxpresdocum, 0, 'campo_3');
$dargestrdmsolciutelf = pg_fetch_result($resxpresdocum, 0, 'campo_4');
$dargestrdmsolciuemail = pg_fetch_result($resxpresdocum, 0, 'campo_5');
$dargestrdmsolciudomi = pg_fetch_result($resxpresdocum, 0, 'campo_6');
$vistobueno = pg_fetch_result($resxpresdocum, 0, 'campo_9');

if ($vistobueno != null) {
  $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $vistobueno . "';";
  $result = pg_query($conn, $sqlus);
  $nombre_vb = pg_fetch_result($result, 0, "usua_nomb");
  $apellido_vb = pg_fetch_result($result, 0, "usua_apellido");
  $cargo_vb = pg_fetch_result($result, 0, "usua_cargo");
  $abr_vb = pg_fetch_result($result, 0, "usua_abr_titulo");
  $nombrevb = $nombre_vb . ' ' . $apellido_vb;
  $vistobueno = $abr_vb . '. ' . $nombrevb . '<br>' . $cargo_vb;
}

//$dargestrdmsolicit=pg_fetch_result($resxpresdocum,0,'origen_form_asunto');
$area = $_GET['area'];
$cargo = $_GET['cargo'];
// $correos = $_GET['correos'];
$correos =  $_COOKIE['correos'];
$txtasunto = $_GET['txtasunto'];
// $txtdescripcion = $_GET['txtdescripcion'];
$txtdescripcion = $dargestrdmsolciuemail;
$txtdescripcion = urldecode($txtdescripcion);
$txtdescripcion = str_replace('<p style="text-align:justify;">', '', $txtdescripcion);
$txtdescripcion = str_replace('<p>', '', $txtdescripcion);
$txtdescripcion = str_replace('</p>', '<br><br>', $txtdescripcion);
$numerotramite = $_GET['numerotramite'];
$tipodocumento = $_GET['tipodocumento'];
// echo "<script type='text/javascript'>alert('$tipodocumento');</script>";
$nombresRemitente = $_GET['nombresremitente'];
/////////////////////////////////////////////////////////////////////////////
//////////////////////DECODIFICAR XML DESTINATARIOS SELECCIONADOS////////////
/////////////////////////////////////////////////////////////////////////////

$xml = new SimpleXMLElement($correos);
$i = 0;
$j = 0;
foreach ($xml->row as $element) {
  foreach ($element as $key => $val) {
    $datos[$i][$j] = $val;
    $j++;
  }
  $i++;
  $j = 0;
}
$longitud = count($datos);
$band1 = 0;
$band2 = 0;
for ($cont = 0; $cont < $longitud; $cont++) {
  $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $datos[$cont][0] . "';";
  $result = pg_query($conn, $sqlus);
  $nombre_temp = pg_fetch_result($result, 0, "usua_nomb");
  $apellido_temp = pg_fetch_result($result, 0, "usua_apellido");
  $cargo_temp = pg_fetch_result($result, 0, "usua_cargo");
  $departamento_temp = pg_fetch_result($result, 0, "usu_departamento");
  $abr_temp = pg_fetch_result($result, 0, "usua_abr_titulo");
  if ($datos[$cont][1] == "PARA") {
    $correosPara[$band1][0] = $datos[$cont][1];
    $correosPara[$band1][1] = $nombre_temp . ' ' . $apellido_temp;
    $correosPara[$band1][2] = $cargo_temp;
    $correosPara[$band1][3] = $departamento_temp;
    $correosPara[$band1][7] = $abr_temp;
    $band1++;
  }
  if ($datos[$cont][1] == "COPIA") {
    $correosCopia[$band2][0] = $datos[$cont][1];
    $correosCopia[$band2][1] = $nombre_temp . ' ' . $apellido_temp;
    $correosCopia[$band2][2] = $cargo_temp;
    $correosCopia[$band2][3] = $departamento_temp;
    $correosCopia[$band2][7] = $abr_temp;
    $band2++;
  }
}
///////////////////////////////////////////
///////////////Actualizar//////////////////
///////////////////////////////////////////
$darmeid = "999";
$sqlquer = "select nombre_tablabdd,nombre_tabla_anexos from tbli_esq_plant_form_plantilla where  id = '" . $darmeid . "'";
$consulcamplans = pg_query($conn, $sqlquer);
$darmetabla = pg_fetch_result($consulcamplans, 0, 0);
$darmtablanexos = pg_fetch_result($consulcamplans, 0, 1);
$sqlquer = "select campo_creado,ref_tcamp from tbli_esq_plant_form_plantilla_campos where  ref_plantilla = '" . $darmeid . "'";
$consulcamps = pg_query($conn, $sqlquer);
$vertamancpm = pg_num_rows($consulcamps);
$query = "UPDATE plantillas." . $darmetabla . " SET estadodoc='PENDIENTE', campo_0='0', campo_1='1', campo_2='2', campo_3='3', campo_4='4', campo_5='5'";
$query = trim($query, ',');
$query .= "    WHERE id='" . $_GET["varclaveuntramusu"] . "'";
// $resulcretodo = pg_query($conn, $query);
///////////////////////////////////////////
// echo "<script>document.location.href="."'../mod_docsenelab/guardarventanilla_memo.php?varidplanty=999&varclaveuntramusu=".$vari."'</script>";
///////////////////////////////////////////

$content = "SERVICIOS WEB\n GAD MUNICIPAL DE COTACACHI \n Codigo: " .  $numerotramite . "\n Cedula: " . $_GET['cedularemitente'] . "\n Nombres: " . $_GET['nombresremitente'] . ' ' . $dargestrdmsapels . "\n Solicitud: " . $dargesnombreproceso;

QRcode::png($content, "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png", QR_ECLEVEL_L, 10, 2);
$verimgqrdado = "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png";

$sqlus = "SELECT usua_abr_titulo, usua_nomb, usua_apellido FROM public.tblu_migra_usuarios where  usua_cedula='" . $_GET['cedularemitente'] . "';";
$result = pg_query($conn, $sqlus);
$abr = pg_fetch_result($result, 0, "usua_abr_titulo");
$nombres = pg_fetch_result($result, 0, "usua_nomb");
$apellidos = pg_fetch_result($result, 0, "usua_apellido");

?>
<?php ob_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Impresion Solicitud</title>
  <style>
    @page {
      margin: 180px 50px 90px;
    }

    */ #header {
      position: fixed;
      left: 0px;
      top: -200px;
      right: 0px;
      height: 60px;
      background-color: orange;
      text-align: center;
    }

    footer {
      position: fixed;
      left: -60px;
      bottom: -110px;
      right: 0px;
      height: 150px;
      background-color: white;
    }

    footer .page:after {
      /* page-break-before: always; */
      /* content: counter(page, upper-roman); */
    }
  </style>
  <script>
    window.print();
  </script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">

  <div id="header">
    <?php if ($numero > 1) : ?>
      <p> <img src="../../imgs/logos/header.jpg" width="800" /></p>
    <?php else : ?>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    <?php endif; ?>
  </div>
  <footer>
    <?php if ($numero > 1) : ?>
      <div id="container" style="position: relative;">
        <img src="../../imgs/logos/footer.jpg" width="770" />
        <img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" style="right: 0px; bottom: -100px; position: absolute;" />
      </div>
    <?php else : ?>
      <div id="container" style="position: relative;">
        <img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" style="right: 0px; bottom: -100px; position: absolute;" />
      </div>
    <?php endif; ?>
  </footer>
  <div id="content" style="top: -50px; position: relative;">
    <table width="90%" border="0" align="center">
      <tr>
        <td>
          <table width="100%" border="0">
            <tr>
              <td width="4%" align="left"></td>
              <td align="center"><b style="text-transform: uppercase;"><?php echo $area; ?> </b></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="4%" align="left"></td>
              <td align="right" style="font-size: 14px;"><b>TRÁMITE N°:<?php echo ' ' . $numerotramite ?></b></td>
            </tr>
            <tr>
              <td width="4%" align="left"></td>
              <td align="right" style="font-size: 14px;"><b><?php echo $tipodocumento . ' N°: ' ?></b><?php echo $dargestrdmsbrras; ?></td>
            </tr>
            <tr>
              <td width="4%" align="left"></td>
              <td align="right" style="font-size: 14px;"><?php echo $fecha ?></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table width="90%" border="0">
      <tr>
        <td width="10%" align="left"></td>
        <td width="10%" style="font-size: 14px; LINE-HEIGHT:22px; vertical-align: top;"><b>PARA:</b></td>
        <td style="font-size: 14px; LINE-HEIGHT:1px;">
          <?php
          foreach ($correosPara as $row) {
          ?>
            <p style="font-size: 14px; LINE-HEIGHT:1px;"><?php echo $row[7] . '. ' . $row[1]; ?>
              <br><br><br><br><br><br><br><br><br><strong style="text-transform: uppercase;LINE-HEIGHT:9px;"><?php echo $row[2]; ?></p>
          <?php
          }
          ?>
        </td>
      </tr>
      <?php
      if ($correosCopia != null && count($correosCopia) > 0) {
      ?>
        <tr>
          <td width="10%" align="left"></td>
          <td width="10%" style="font-size: 14px; LINE-HEIGHT:22px; vertical-align: top;"><b>COPIA:</b></td>
          <td style="font-size: 14px; LINE-HEIGHT:1px;">
            <?php
            foreach ($correosCopia as $row) {
            ?>
              <p style="font-size: 14px; LINE-HEIGHT:1px;"><?php echo $row[7] . ' ' . $row[1]; ?>
                <br><br><br><br><br><br><br><br><br><strong style="text-transform: uppercase;LINE-HEIGHT:9px;"><?php echo $row[2]; ?></p>
            <?php
            }
            ?>
          </td>
        </tr>
      <?php
      }
      ?>

      <tr>
        <td width="10%" align="left"></td>
        <td width="10%" style="vertical-align: top; font-size: 14px;"><b>ASUNTO:</b></td>
        <td style="vertical-align: top; font-size: 14px;"><?php echo $txtasunto ?></td>
      </tr>

    </table>
    <br>
    <div style="width:83%; text-align:justify; margin-left: 60px; LINE-HEIGHT:20px;">
      <?php echo $txtdescripcion; ?>
    </div>
    <div style="width:83%; margin-left: 60px;">
      Atentamente,
      <br>
      <br>
      <br>
      <table border="0" align="left">
        <tr>
          <td width="400px">
            <p style="font-size: 14px; "><?php echo $abr . '. ' . $nombres . ' ' . $apellidos; ?></p>
            <b style="text-transform: uppercase;font-size: 12px;LINE-HEIGHT:10px;"><?php echo $cargo; ?></b>
          </td>
          <td width="200px">
            <?php
            if ($vistobueno != null) {
            ?>
              <p style="text-transform: uppercase;font-size: 9px;"><?php echo $vistobueno; ?><br>Visto bueno</p>
            <?php
            }
            ?>
          </td>
        </tr>
      </table>

      <?php
      if ($elaborado) {
      ?>
        <br>
        <br>
        <br>
        <p style="font-size: 8px;">Elaborado por: <br><?php echo $elaborado; ?></p>
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>
<?php

$html = ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->setPaper('A4');
//$dompdf->setPaper('A4', 'landscape');
$dompdf->load_html($html);
$dompdf->render();
//For view
$dompdf->stream($dargestrdmsbrras . ".pdf", array("Attachment" => false));
?>