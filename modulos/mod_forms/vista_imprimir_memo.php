<meta charset='utf-8'>
<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');
require_once('../../dompdf/autoload.inc.php');

use Dompdf\Dompdf;

///////////////////////////////////////////////
require '../../mailer/src/Exception.php';
require '../../mailer/src/PHPMailer.php';
require '../../mailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';
$mail = new PHPMailer(true);


// $html = ob_get_clean();
// $dompdf = new DOMPDF();
// $dompdf->setPaper('A4', 'portrait');
// //$dompdf->setPaper('A4', 'landscape');
// $dompdf->load_html($html);
// $dompdf->render();
// //For view
// $dompdf->stream("",array("Attachment" => false));
// for download
//$dompdf->stream("sample.pdf");

$idtramite = $_GET['mvpr'];
$plantilla = $_GET['plantilla'];
if ($plantilla == "true")
  $n = strlen($plantilla);
else
  $n = 0;
$sql = "SELECT codigo_documento, origen_cedul, origen_nombres, origen_cargo, origen_departament
FROM tbli_esq_plant_formunico_docsinternos 
where id='" . $idtramite . "'";
$res = pg_query($conn, $sql);
$codigodocumento = pg_fetch_result($res, 0, 'codigo_documento');
$cedularemitente = pg_fetch_result($res, 0, 'origen_cedul');
$cargoremitente = pg_fetch_result($res, 0, 'origen_cargo');
$departamentoremitente = pg_fetch_result($res, 0, 'origen_departament');

$_SESSION["varidplanty"] = "999";
$sqlconstab = "SELECT plan.id,plan.nombre_tablabdd,contin.nom_responsable,contin.ref_nom_depart,
contin.detalle from tbli_esq_plant_form_plantilla plan,tbli_esq_plant_form_cuadro_clasif contin 
where plan.ref_clasif_doc=contin.id and plan.id='999' order by id";
$resconstab = pg_query($conn, $sqlconstab);
$darmetablaext = "plantillas." . pg_fetch_result($resconstab, 0, 'nombre_tablabdd');
$vari = $_GET["varclaveuntramusu"];
$plantilla = "999";
$departamento = $_SESSION['varidplanty'];
$dargesolicitfuncnom = pg_fetch_result($resconstab, 0, 'nom_responsable');

$dargesolicitfuncdep = pg_fetch_result($resconstab, 0, 'ref_nom_depart');
$dargesnombreproceso = pg_fetch_result($resconstab, 0, 'detalle');

$sql = "SELECT id, fecha, fecha_atencion, cod_tramite_tempo, cod_traminterno,codi_barras, codigo_tramite,
ciu_cedula, campo_0, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_7, campo_8, campo_9  FROM " . $darmetablaext . " 
where cod_tramite_tempo='" . $codigodocumento . "'  ;";
$resxpresdocum = pg_query($conn, $sql);

$nombresremitente = pg_fetch_result($resxpresdocum, 0, 'campo_0');
$cargoremitente = pg_fetch_result($resxpresdocum, 0, 'campo_1');
$arearemitente = pg_fetch_result($resxpresdocum, 0, 'campo_2');
$asunto = pg_fetch_result($resxpresdocum, 0, 'campo_3');
$correos = pg_fetch_result($resxpresdocum, 0, 'campo_4');
$descripcion = pg_fetch_result($resxpresdocum, 0, 'campo_5');
$descripcion = urldecode($descripcion);
$descripcion = str_replace('<p style="text-align:justify;">', '', $descripcion);
$descripcion = str_replace('<p>', '', $descripcion);
$descripcion = str_replace('</p>', '<br><br>', $descripcion);
$descripcion = str_replace('<span style="color:black;">', '', $descripcion);
$descripcion = str_replace('</span>', '', $descripcion);
$descripcion = str_replace('<br data-cke-filler="true">', '', $descripcion);
$numerotramite = pg_fetch_result($resxpresdocum, 0, 'codigo_tramite');
$tipodocumento = pg_fetch_result($resxpresdocum, 0, 'campo_6');
$fecha = pg_fetch_result($resxpresdocum, 0, 'campo_7');
$cedulaelaborado = pg_fetch_result($resxpresdocum, 0, 'campo_8');
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


if ($cedulaelaborado) {
  $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $cedulaelaborado . "';";
  $result = pg_query($conn, $sqlus);
  $titulo_elaborado = pg_fetch_result($result, 0, "usua_abr_titulo");
  $nombre_elaborado = pg_fetch_result($result, 0, "usua_nomb");
  $apellido_elaborado = pg_fetch_result($result, 0, "usua_apellido");
  $cargo_elaborado = pg_fetch_result($result, 0, "usua_cargo");
  $departamento_elaborado = pg_fetch_result($result, 0, "usu_departamento");
}
/////////////////////////////////////////////////////////////////////////////
//////////////////////DECODIFICAR XML DESTINATARIOS SELECCIONADOS////////////
/////////////////////////////////////////////////////////////////////////////
if ($correos != null || $correos != '') {
  $correos = urldecode($correos);
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
      $correosPara[$band1][0] = $datos[$cont][0];
      $correosPara[$band1][1] = $nombre_temp . ' ' . $apellido_temp;
      $correosPara[$band1][2] = $cargo_temp;
      $correosPara[$band1][3] = $departamento_temp;
      $correosPara[$band1][7] = $abr_temp . '.';
      $band1++;
    }
    if ($datos[$cont][1] == "COPIA") {
      $correosCopia[$band2][0] = $datos[$cont][0];
      $correosCopia[$band2][1] = $nombre_temp . ' ' . $apellido_temp;
      $correosCopia[$band2][2] = $cargo_temp;
      $correosCopia[$band2][3] = $departamento_temp;
      $correosCopia[$band2][7] = $abr_temp . '.';
      $band2++;
    }
  }
}
$content = "SERVICIOS WEB\n GAD MUNICIPAL DE COTACACHI \n Número tramite: " . $numerotramite . "\n Código documento: " . $codigodocumento . "\n Cedula: " . $cedularemitente . "\n Nombres: " . $nombresremitente . ' ' . $dargestrdmsapels . "\n Solicitud: " . $dargesnombreproceso;

QRcode::png($content, "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png", QR_ECLEVEL_L, 10, 2);
$verimgqrdado = "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png";
?>
<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Impresion Solicitud</title>

  </style>
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
      
      text-align: center;
    }

    footer {
      position: fixed;
      left: -60px;
      bottom: -110px;
      right: 0px;
      height: 150px;
     
    }

    footer .page:after {
      /* page-break-before: always; */
      /* content: counter(page, upper-roman); */
    }
  </style>
  <!-- <script>
    window.print();
  </script> -->
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">

  <div id="header">
    <?php if ($n > 1) { ?>
      <p> <img src="../../imgs/logos/header.jpg" width="800" /></p>
    <?php } else { ?>
      <p> <img src="../../imgs/logos/header.jpg" style=" opacity: 0;" width="800" /></p>
    <?php } ?>
  </div>
  <footer>
    <?php if ($n > 1) { ?>
      <div id="container" style="position: relative;">
        <img src="../../imgs/logos/footer.jpg" width="770" />
        <img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" style="right: 0px; bottom: -100px; position: absolute;" />
      </div>
    <?php } else {?>
      <div id="container" style="position: relative;">
        <img src="../../imgs/logos/footer.jpg" width="770" style=" opacity: 0;"  />
        <img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" style="right: 0px; bottom: -100px; position: absolute;" />
      </div>
    <?php } ?>
  </footer>
  <div id="content" style="top: -50px; position: relative;">
    <table width="90%" border="0" align="center">
      <tr>
        <td>
          <table width="100%" border="0">
            <tr>
              <td width="4%" align="left"></td>
              <td align="center"><b style="text-transform: uppercase;"><?php echo $departamentoremitente; ?> </b></td>
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
              <td align="right" style="font-size: 14px;"><b><?php echo $tipodocumento . ' N°: ' ?></b><?php echo $codigodocumento; ?></td>
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
            <p style="font-size: 14px; LINE-HEIGHT:1px;"><?php echo $row[7] . ' ' . $row[1]; ?>
              <br><br><br><br><br><br><br><br><br><strong style="text-transform: uppercase;LINE-HEIGHT:9px;"><?php echo $row[2]; ?></strong></p>
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
                <br><br><br><br><br><br><br><br><br><strong style="text-transform: uppercase;LINE-HEIGHT:9px;"><?php echo $row[2]; ?></strong></p>
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
        <td style="vertical-align: top; font-size: 14px;"><?php echo $asunto ?></td>
      </tr>

    </table>
    <br>
    <div style="width:83%; text-align:justify; margin-left: 60px; LINE-HEIGHT:20px;">
      <?php echo $descripcion; ?>
    </div>
    <div style="width:83%; margin-left: 60px;">
      Atentamente,
      <br>
      <br>
      <br>
      <table border="0" align="left">
        <tr>
          <td width="400px">
            <p style="font-size: 14px; "><?php echo $nombresremitente; ?></p>
            <b style="text-transform: uppercase;font-size: 12px; LINE-HEIGHT:10px;"><?php echo $cargoremitente; ?></b>
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
      if ($cedulaelaborado) {
      ?>
        <br>
        <br>
        <br>
        <p style="font-size: 8px;">Elaborado por: <br><?php echo $titulo_elaborado . ' ' . $nombre_elaborado . ' ' . $apellido_elaborado; ?><br><?php echo $cargo_elaborado; ?></p>
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
$dompdf->stream($codigodocumento . ".pdf", array("Attachment" => false));



// try {
//   //Server settings
//   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
//   $mail->isSMTP();                                            // Send using SMTP
//   $mail->Host       = 'srvmail.cotacachi.gob.ec';                    // Set the SMTP server to send through
//   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//   $mail->Username   = 'critian.delgado@cotacachi.gob.ec';                     // SMTP username
//   $mail->Password   = 'emelec2012';                               // SMTP password
//   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//   $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//   //Recipients
//   $mail->setFrom('cristian.delgado@cotacachi.gob.ec', 'Gestión Documental');
//   $mail->addAddress('bayardo.guerrero@cotacachi.gob.ec', 'Bayardo Guerrero');     // Add a recipient
//   $mail->addAddress('cristian.delgado@cotacachi.gob.ec');               // Name is optional
//   // $mail->addReplyTo('info@example.com', 'Information');
//   // $mail->addCC('cc@example.com');
//   // $mail->addBCC('bcc@example.com');

//   // Attachments
//   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

//   // Content
//   $mail->isHTML(true);                                  // Set email format to HTML
//   $mail->Subject = 'Test notificaciones';
//   $mail->Body    = 'Esto es uan prueba de envió de correos <b>Perfecto!</b>';
//   $mail->AltBody = 'No reponder a este correo de prueba';

//   $mail->send();
//   echo 'Message ha sido enviado';
// } catch (Exception $e) {

//   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
?>