<meta charset='utf-8'>
<?php
include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');

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

$elaborado = '';
if ($_GET["borrador"]) {
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
}

$dargesolicitfuncdep = pg_fetch_result($resconstab, 0, 'ref_nom_depart');
$dargesnombreproceso = pg_fetch_result($resconstab, 0, 'detalle');

$sql = "SELECT id, fecha, fecha_atencion, cod_tramite_tempo, cod_traminterno,codi_barras, codigo_tramite, ciu_cedula, campo_1, campo_2, campo_3, campo_4, campo_5, campo_6  FROM " . $darmetablaext . " where id='" . $_GET["varclaveuntramusu"] . "'  ;";
$resxpresdocum = pg_query($conn, $sql);

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$fecha = strftime("Cotacachi, %d de ".$arrayMeses[date('m')-1]." de %Y");
$dargestrdmsbrras = pg_fetch_result($resxpresdocum, 0, 'cod_tramite_tempo');
$dargestrdmscedul = pg_fetch_result($resxpresdocum, 0, 'campo_1');
$dargestrdmsnoms = pg_fetch_result($resxpresdocum, 0, 'campo_2');
$dargestrdmsapels = pg_fetch_result($resxpresdocum, 0, 'campo_3');
$dargestrdmsolciutelf = pg_fetch_result($resxpresdocum, 0, 'campo_4');
$dargestrdmsolciuemail = pg_fetch_result($resxpresdocum, 0, 'campo_5');
$dargestrdmsolciudomi = pg_fetch_result($resxpresdocum, 0, 'campo_6');
//$dargestrdmsolicit=pg_fetch_result($resxpresdocum,0,'origen_form_asunto');
$area = $_GET['area'];
$cargo = $_GET['cargo'];
// $correos = $_GET['correos'];
$correos=  $_COOKIE['correos'];
$txtasunto = $_GET['txtasunto'];
// $txtdescripcion = $_GET['txtdescripcion'];
$txtdescripcion = $dargestrdmsolciuemail;
$numerotramite = $_GET['numerotramite'];
$tipodocumento = $_GET['tipodocumento'];
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
	$abr_temp= pg_fetch_result($result, 0, "usua_abr_titulo");
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

$sqlus = "SELECT usua_abr_titulo FROM public.tblu_migra_usuarios where  usua_cedula='" . $_GET['cedularemitente'] . "';";
$result = pg_query($conn, $sqlus);
$abr= pg_fetch_result($result, 0, "usua_abr_titulo");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Impresion Solicitud</title>
  <style>
    @page {
      size: auto;
      margin: 5mm;
    }
    #footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 2.5rem;          
    }
    .blank_row
    {
      height: 5px !important; /* overwrites any other rules */
      background-color: #FFFFFF;
    }
  </style>
  <script>
     
    window.print();
   
  </script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
  <?php if($numero>1): ?>
      <p> <img src="../../imgs/logos/header.png" width="850" /></p>
    <?php else: ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>      
  <?php endif; ?>  
  <table width="90%" border="0" align="center">
    <tr>
      <td>
        <table width="100%" border="0">
          <tr>
            <td width="4%" align="left"></td>
            <td align="center"><b></b></td>
            <td width="5%" align="right"></td>
          </tr>
          <tr>
            <td width="4%" align="left"></td>
            <td align="center"><b style="text-transform: uppercase;"><?php echo $area; ?> </b></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="4%" align="left"></td>
            <td align="right" style="font-size: 14px;"><b>TRÁMITE N°:</b><?php echo ' '.$numerotramite ?></td>
          </tr>
          <tr>
            <td width="4%" align="left"></td>
            <td align="right" style="font-size: 12px;"><b><?php echo $tipodocumento . ' N°: ' ?></b><?php echo $dargestrdmsbrras; ?></td>
          </tr>
          <tr>
            <td width="4%" align="left"></td>
            <td align="right" style="font-size: 12px;"><?php echo $fecha; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="90%" border="0">
    <tr>
      <td width="10%" align="left"></td>
      <td width="10%" style="vertical-align: top;"><b>PARA:</b></td>
      <td>
        <table border="0">
          <?php
          foreach ($correosPara as $row) {
          ?>
            <tr>
              <td>
                <p style="text-transform: uppercase; font-size: 12px;"><?php echo $row[7].'. '.$row[1]; ?></p>
              </td>
            </tr>
            <tr>
              <td>
                <b style="text-transform: uppercase; font-size: 12px;"><?php echo $row[2]; ?></b>
              </td>
            </tr>
            <tr class="blank_row">
                <td colspan="3"></td>
            </tr>
          <?php
          }
          ?>
        </table>
      </td> 
    </tr>
    <?php
    if ($correosCopia != null && count($correosCopia)>0) {
    ?>
      <tr>
        <td width="10%" align="left"></td>
        <td width="10%" style="vertical-align: top;"><b>COPIA:</b></td>
        <td>
          <table border="0">
            <?php
            foreach ($correosCopia as $row) {
            ?>
              <tr>
                <td>
                  <p style="text-transform: uppercase; font-size: 12px;"><?php echo $row[7].'. '.$row[1]; ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <b style="text-transform: uppercase; font-size: 12px;"><?php echo $row[2]; ?></b>
                </td>
              </tr>
              <tr class="blank_row">
                <td colspan="3"></td>
              </tr>
            <?php
            }
            ?>
          </table>
        </td>
      </tr>
    <?php
    }
    ?>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="10%" align="left"></td>
      <td width="10%" style="vertical-align: top;"><b>ASUNTO:</b></td>
      <td style="vertical-align: top;"><?php echo ' ' . $txtasunto; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>

  <table width="83%" border="0" align="center">
    <tr>
      <td><?php echo $txtdescripcion; ?>&nbsp;</td>
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
      <td>_______________________</td>
    </tr>
    <tr>
      <td><b style="text-transform: uppercase;"><?php echo $abr . ' '  .$nombresRemitente ?></b></td>
    </tr>
    <tr>
      <td>
        <p style="text-transform: uppercase;"><?php echo $cargo; ?></p>
      </td>
    </tr>
    <?php
        if ($_GET["borrador"]) {
        ?>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <p style="font-size: 8px;">Elaborado por: <br><?php echo $elaborado; ?></p>
            </td>
          </tr>
        <?php
        }
        ?>
  </table>
</body>
<?php if($numero>1): ?>
  <footer align="left">
  <table width="100%" border="0" align="left">
    <tr>
      <td><img src="../../imgs/logos/footer.png" width="750" /></td>
      <td width="10%" align="left"><img src="<?php echo $verimgqrdado; ?>" width="100" height="100" border="0" /></td>
    </tr>
  </footer>
  <?php else: ?>
    <footer align="left">
  <table width="100%" border="0" align="left">
    <tr>
      <td></td>
      <td width="20%" align="left"><img src="<?php echo $verimgqrdado; ?>" width="100" height="100" border="0" /></td>
    </tr>
  </footer>
<?php endif; ?>
</html>