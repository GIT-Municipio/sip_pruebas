<meta charset='utf-8'>
<?php
session_start();
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');
require_once('../../dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$_SESSION["varidplanty"] = "999";
$sqlconstab = "SELECT plan.id,plan.nombre_tablabdd,contin.nom_responsable,contin.ref_nom_depart,contin.detalle from tbli_esq_plant_form_plantilla plan,tbli_esq_plant_form_cuadro_clasif contin where plan.ref_clasif_doc=contin.id and plan.id='999' order by id";
$resconstab = pg_query($conn, $sqlconstab);
$darmetablaext = "plantillas." . pg_fetch_result($resconstab, 0, 'nombre_tablabdd');
// $vari = $_GET["varclaveuntramusu"];
$txtasunto = $_GET["txtasunto"];
// $txtdescripcion = $_GET["txtdescripcion"];
$txtdescripcion = $_POST['txtdescripcion'];
// $txtdescripcion = urldecode($txtdescripcion); 
$dependencia = $_GET['dependencia'];
$tipodocumento = $_GET["tipodocumento"];
$nombrespara = $_GET["nombrespara"];
$denominacionpara = $_GET["denominacionpara"];

$sqlex = "UPDATE public.tblu_migra_usuarios set usu_foto='" . $_POST['txtdescripcion'] . "' WHERE usua_cedula='" . $_GET['cedularemitente'] . "';";
// echo "<script type='text/javascript'>alert('$txtdescripcion');</script>";
$result = pg_query($conn, $sqlex);
$borrador = $_GET["borrador"];
$remitenteseleccionado = $_GET["remitenteseleccionado"];
$cedularemitente = $_GET["cedularemitente"];

$v = $_GET['vistobueno'];

if ($_GET['vistobueno'] != null) {
  $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $_GET['vistobueno'] . "';";
  $result = pg_query($conn, $sqlus);
  $nombre_vb = pg_fetch_result($result, 0, "usua_nomb");
  $apellido_vb = pg_fetch_result($result, 0, "usua_apellido");
  $cargo_vb = pg_fetch_result($result, 0, "usua_cargo");
  $abr_vb = pg_fetch_result($result, 0, "usua_abr_titulo");
  $nombrevb = $nombre_vb . ' ' . $apellido_vb;
  $vistobueno = $abr_vb . '. ' . $nombrevb . '<br>' . $cargo_vb;
}

$sqlus = "SELECT usua_abr_titulo, usua_dependencia FROM public.tblu_migra_usuarios where  usua_cedula='" . $_GET['cedularemitente'] . "';";
$result = pg_query($conn, $sqlus);
$abr = pg_fetch_result($result, 0, "usua_abr_titulo");
$area = pg_fetch_result($result, 0, "usua_dependencia");
$cargo = $_GET['cargo'];
$nombreremitente = $_GET['nombresremitente'];

$elaborado = '';
if ($_GET["borrador"]) {
  $idtramite = $_GET["idtramite"];
  $sql = "SELECT codigo_documento, origen_cedul, usuario_cedseguim,origen_nombres, origen_cargo, 
	origen_departament, codigo_tramite
	FROM tbli_esq_plant_formunico_docsinternos 
	where id='" . $idtramite . "'";
  $res = pg_query($conn, $sql);
  $codigotramite = pg_fetch_result($res, 0, 'codigo_tramite');
  $origennombres = pg_fetch_result($res, 0, 'origen_nombres');
  $origencargo = pg_fetch_result($res, 0, 'origen_cargo');
  $remitenteseleccionado = pg_fetch_result($res, 0, 'usuario_cedseguim');

  $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $remitenteseleccionado . "';";
  $result = pg_query($conn, $sqlus);
  $nombre_borrador1 = pg_fetch_result($result, 0, "usua_nomb");
  $apellido_borrador1 = pg_fetch_result($result, 0, "usua_apellido");
  $cargo_borrador1 = pg_fetch_result($result, 0, "usua_cargo");
  $abr_borrador1 = pg_fetch_result($result, 0, "usua_abr_titulo");
  $nombreremitente1 = $nombre_borrador1 . ' ' . $apellido_borrador1;
  $elaborado = $abr_borrador1 . '. ' . $nombreremitente1 . '<br>' . $cargo_borrador1;

  // echo "<script type='text/javascript'>alert('borrador');</script>";
  // echo "<script type='text/javascript'>alert('$remitenteseleccionado');</script>";
} else {

  if ($remitenteseleccionado != $cedularemitente) {
    $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
  FROM public.tblu_migra_usuarios where  usua_cedula='" . $remitenteseleccionado . "';";
    $result = pg_query($conn, $sqlus);
    $nombre_borrador = pg_fetch_result($result, 0, "usua_nomb");
    $apellido_borrador = pg_fetch_result($result, 0, "usua_apellido");
    $cargo_borrador = pg_fetch_result($result, 0, "usua_cargo");
    $abr_borrador = pg_fetch_result($result, 0, "usua_abr_titulo");
    $abr = $abr_borrador;
    $cargo = $cargo_borrador;
    $nombreremitente = $nombre_borrador . ' ' . $apellido_borrador;

    $sqlus = "SELECT usua_nomb, usua_apellido, usua_email, usua_abr_titulo, usua_cargo, usu_departamento 
    FROM public.tblu_migra_usuarios where  usua_cedula='" . $cedularemitente . "';";
    $result = pg_query($conn, $sqlus);
    $nombre_borrador1 = pg_fetch_result($result, 0, "usua_nomb");
    $apellido_borrador1 = pg_fetch_result($result, 0, "usua_apellido");
    $cargo_borrador1 = pg_fetch_result($result, 0, "usua_cargo");
    $abr_borrador1 = pg_fetch_result($result, 0, "usua_abr_titulo");
    $nombreremitente1 = $nombre_borrador1 . ' ' . $apellido_borrador1;
    $elaborado = $abr_borrador1 . '. ' . $nombreremitente1 . '<br>' . $cargo_borrador1;

    // echo "<script type='text/javascript'>alert('$remitenteseleccionado');</script>";
    //  echo "<script type='text/javascript'>alert('$cedularemitente');</script>";

  }
}



// $sqlnomenclatura = "SELECT id, nombre_departamento, img_fondo as nomenclatura, color_letra as anio, cast(color_fondo as int) as num, color_fondo as secuencial FROM tblb_org_departamento where id='" . $dependencia . "';";
// $rescodif = pg_query($conn, $sqlnomenclatura);
// $nomenclatura = pg_fetch_result($rescodif, 0, 'nomenclatura');
// $anio = pg_fetch_result($rescodif, 0, 'anio');
// $secuencial = pg_fetch_result($rescodif, 0, 'secuencial');
// $codigoDocumento = $nomenclatura . "-" . $anio . "-" . $secuencial . "-TEMP";
// $varauxnum = pg_fetch_result($rescodif, 0, 'num');

$plantilla = "999";
$departamento = $_SESSION['varidplanty'];
$dargesolicitfuncnom = pg_fetch_result($resconstab, 0, 'nom_responsable');

$dargesolicitfuncdep = pg_fetch_result($resconstab, 0, 'ref_nom_depart');
$dargesnombreproceso = pg_fetch_result($resconstab, 0, 'detalle');

// $area = $_GET['area'];

// echo "<script type='text/javascript'>alert('$area');</script>";

// $correos = $_POST['correosSeleccionados'];
$correos = $_COOKIE['correos'];

// echo "<script type='text/javascript'>alert('$correos');</script>";
$arrayMeses = array(
  'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
);
$fecha = strftime("Cotacachi, %d de " . $arrayMeses[date('m') - 1] . " de %Y");

/////////////////////////////////////////////////////////////////////////////
//////////////////////DECODIFICAR XML DESTINATARIOS SELECCIONADOS////////////
/////////////////////////////////////////////////////////////////////////////

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
///////////////////////////////////////////
///////////////////////////////////////////

$content = "SERVICIOS WEB\n GAD MUNICIPAL DE COTACACHI \n Codigo: " . '1000000000-TEMP' . "\n Cedula: " . $_GET['cedularemitente'] . "\n Nombres: " . $_GET['nombresremitente'] . "\n Solicitud: " . $dargesnombreproceso;

QRcode::png($content, "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png", QR_ECLEVEL_L, 10, 2);
$verimgqrdado = "../../../sip_bodega/codqr/" . "plantilla_" . $_GET['varidplanty'] . "_comp_qr.png";

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
      bottom: -100px;
      right: 0px;
      height: 150px;
      background-color: white;
    }

    footer .page:after {
      /* page-break-before: always; */
      /* content: counter(page, upper-roman); */
    }
  </style>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">

  <div id="header">
    <p> <img src="../../imgs/logos/header.jpg" width="800" /></p>
  </div>

  <footer>
    <div id="container" style="position: relative;">
      <img src="../../imgs/logos/footer.jpg" width="770" />
      <img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0" style="right: 0px; bottom: -100px; position: absolute;" />
    </div>
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
              <td align="right" style="font-size: 14px;"><b>TRÁMITE N°:</b><?php echo ' XXXXXX' ?></td>
            </tr>
            <tr>
              <td width="4%" align="left"></td>
              <td align="right" style="font-size: 14px;"><b><?php echo $tipodocumento . ' N°: XXXXXX' ?></b></td>
            </tr>
            <tr>
              <td width="4%" align="left"></td>
              <td align="right" style="font-size: 14px;"><?php echo $fecha; ?></td>
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
            <p style="font-size: 14px; LINE-HEIGHT:1px;"><?php echo $nombrespara; ?>
              <br><br><br><br><br><br><br><br><br><strong style="text-transform: uppercase;LINE-HEIGHT:9px;"><?php echo $denominacionpara ?></strong></p>         
        </td>
      </tr>
      <tr>
        <td width="10%" align="left"></td>
        <td width="10%" style="vertical-align: top;"><b>ASUNTO:</b></td>
        <td style="vertical-align: top;"><?php echo ' ' . $txtasunto; ?></td>
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
      <br>
      <table border="0" align="left">
        <tr>
          <td width="400px">
            <p style="font-size: 14px; "><?php echo $abr . '. ' . $nombreremitente; ?></p>
            <b style="text-transform: uppercase;font-size: 12px; LINE-HEIGHT:10px;"><?php echo $cargo; ?></b>
          </td>
          <td>
            <?php
            if ($_GET['vistobueno']) {
            ?>
              <p style="text-transform: uppercase;font-size: 10px;"><?php echo $vistobueno; ?><br>Visto bueno</p>
          </td>
        <?php
            }
        ?>
        </td>
        </tr>
      </table>

      <?php
      if ($cedularemitente != $remitenteseleccionado) {
      ?>
        <br>
        <br>
        <br>
        <p style="font-size: 8px;">Elaborado por: <br><?php echo $elaborado ?></p>
      <?php
      }
      ?>
    </div>
  </div>
  </div>
</body>

</html>
<?php

$html = ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->setPaper('A4');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($codigodocumento . ".pdf", array("Attachment" => false));
?>