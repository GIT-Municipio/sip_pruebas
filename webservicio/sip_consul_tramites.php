<?php require ("../../class_cabildo.php");
global $miconexion;
$miconexion = new DB_mysql ; 
global $miconexion;
$ip =  $miconexion->xml_ip();
$base =  $miconexion->xml_base();
$user =  $miconexion->xml_user();
$psw =  $miconexion->xml_psw();




$conexion = $miconexion->conectar($base,$ip,$user,$psw); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Gestion Financiera - Administrativa</title>
<link href="enlinea_visor.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: 427px;
	top: 13px;
}
#apDiv2 {
	position:absolute;
	width:627px;
	height:115px;
	z-index:2;
	left: 3px;
	top: 160px;
}

.texto
{
	font-size:18px;
}

.btnbuscarinfo
{
	
background-image:url(../img/btnbuscar.png);
width: 76px;
height: 76px;
text-align:inherit;
color:#FFF;
}


.btnbuscarinfolimpiar
{
	
background-image:url(..//img/btnfiltrar.png);
width: 76px;
height: 76px;
color:#FFF;
}


</style>

<script>
function windowo(ref) 
{ 
  var sfeatures = ""; // 
window.open(ref,"Cuenta","width=550,height=450,scrollbars=yes,sfeatures"); 
} 
</script>

<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-image: url();
	background-repeat: no-repeat;
	background-color: #F2F2F2;
	font-size:18px;
}
.Estilo1 {
	color: #000066;
	font-style: italic;
}
</style>
</head>
<body>
<form name="form1" action="sip_consul_tramites.php" method="post">
<div style="background-color:#689de9">
<table width="960" height="5" border="0" align="center" cellpadding="1" cellspacing="2">
<tr>
  <td width="639" valign="middle"><label class="texto">Seleccione el Criterio de búsqueda:  </label><input id="ciu"   checked="checked" name="radios" type="radio"  value="ciu" /><label class="texto">CIU </label><input id="iden"  name="radios" type="radio" value="idn" /><label class="texto">Identificacion </label> </label><input id="nombre" name="radios" type="radio" value="nom" /><label class="texto">Nombre</label></td>
  <td width="311">&nbsp;</td>
</tr>
</table>
<span id="sprycheckbox1"><span class="checkboxRequiredMsg">Realice una selección.</span></span>
<hr />
</div>

<table width="960"   height="5" border="0" align="center" cellpadding="2" cellspacing="3">

<tr>
  <td width="249" align="right" valign="middle" class="texto"><label >Ingrese la información:</label></td>
  <td width="395" align="center" valign="middle"  class="detalle_grid99">
    
  <input name="datos" type="text" size="40" style="width:400px;height:40px;font-size:18px" />
  <label> Resultados</label><?php 
global $miconexion;
$num = array(100,10,5);
$numr = array('>10',10,5);
$miconexion->_combof('tipo',$num,$numr,3,'imput'); ?></td>
  <td width="292"><input name="enviar" type="submit" id="enviar" class="btnbuscarinfo" value="Buscar" /><input name="borrar" value="Limpiar" type="reset" class="btnbuscarinfolimpiar"  onClick="window.location.href=window.location.href"/>
    
    
    
</tr>
</table>



</form>
<br />

<?php



if(isset($_POST['enviar']))
{




	
if(($_POST['radios'])== 'ciu' and $_POST['datos'] != "")
{
	$sqlcon = "SELECT gen01.gen01nom||' '||gen01.gen01ape as nombre from  gen01 where gen01.gen01codi = ".$_POST['datos'];
	@ $stid = $miconexion->consulta($sqlcon);
  @$row = oci_fetch_array($stid, OCI_ASSOC);
  
  try
  {
	  $sqlrun = "SELECT gen01ruc from  gen01 where gen01codi = ".$_POST['datos'];
	 @$stidrun = $miconexion->consulta($sqlrun);
  @$rowrun = oci_fetch_array($stidrun, OCI_ASSOC);
  if($row['NOMBRE'] == "" or $rowrun['GEN01RUC'] == "ELIMINADO")
  {
	  $a = "<script>alert('No existe resultados para la busqueda') </script>";
	 throw new Exception($a);
  }
  

	
	?>
    
<table width="960" align="center" class="texto">
<tr>
<td width="120" align="right">Contribuyente: </td>
<td width="250" align="left" valign="middle" class="detalle_grid"><?php 
global $miconexion;
$sqlcon = "SELECT gen01.gen01nom||' '||gen01.gen01ape as nombre from  gen01 where gen01.gen01codi = ".$_POST['datos'];
 @$miconexion->consulta($sqlcon);  
 @$miconexion->detalle_maestro_dato('2','black','Arial');
 

 
 ?></td>
<td width="120" align="right">Nro. Identificacion: </td>
<td width="250" class="detalle_grid"><?php 
global $miconexion;
 @$miconexion->consulta("SELECT gen01ruc from  gen01 where gen01.gen01codi = ".$_POST['datos']);  
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
<td width="96">&nbsp;</td>
<td width="96">&nbsp;</td>
</tr>
<tr>
  <td align="right">Nro. CIU: </td>
  <td class="detalle_grid"><?php 
global $miconexion;
 @$miconexion->consulta("SELECT gen01codi from  gen01 where gen01.gen01codi = ".$_POST['datos']);  
 @$miconexion->detalle_maestro_dato('2','black','Arial');?></td>
  <td align="right">Direccion: </td>
  <td class="detalle_grid"><?php 
global $miconexion;
 @$miconexion->consulta("SELECT gen01dir from  gen01 where gen01.gen01codi = ".$_POST['datos']);  
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
<p class="Estilo1">Valores vigentes a la fecha, sujetos a ajuste por Intereses, Multas, Coactivas y Recargos. </p>
<hr />
    <?php
	
	global $miconexion;
 $sql_deuda ="SELECT sum(emision) + sum(val_abonos) + sum(interes) + sum(coactiva) + sum(recargo) - sum(descuento) as TOTAL from web_deudas where ciu = ".$_POST['datos']; 
  $stid_deuda = $miconexion->consulta($sql_deuda);
  $row_deuda = oci_fetch_array($stid_deuda, OCI_ASSOC);
	
	if($row_deuda['TOTAL'] != "")
	{
   global $miconexion;
   $sqlc = "SELECT e.emi03des as impuesto, NROEMISION AS TITULO,  W.ANIO, W.MES, 
   W.CLAVE AS REFERENCIA, TO_CHAR(W.FOBL,'DD/MM/RRRR') AS FECHA,W.EMISION, W.VAL_ABONOS as abonos, 
   W.INTERES, W.COACTIVA, W.RECARGO, 
   W.DESCUENTO, emision + val_abonos + interes + coactiva + recargo - descuento as TOTAL FROM  WEB_DEUDAS w,emi03 e where e.emi03codi = w.imp and w.CIU =".$_POST['datos']." AND rownum between 1 and ".$_POST['tipo']." ORDER BY ANIO DESC";
	@$miconexion->consulta($sqlc);
	@$miconexion->query_popup_tamaño('web_deuda_cuenta_titulo.php?','TITULO','_blank'); 


 ?> 
<table width="960" align="center"> 
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="114" align="center" valign="middle"    class="mensaje_datos"><font size="3" >Total Deuda</font></td>
<td>
 <?php 
global $miconexion;
 @$miconexion->consulta("SELECT sum(emision) + sum(val_abonos) + sum(interes) + sum(coactiva) + sum(recargo) - sum(descuento) from web_deudas where ciu = ".$_POST['datos']);  
 @$miconexion->detalle_maestro_font('+2','blue','Arial');
	}
	
	
	elseif(@$row_deuda['TOTAL'] == "")
	{
		?>

<TABLE   align="center" cellpadding="3" cellspacing="3" class="mensaje_datos" >

<TR>
  <TD>Felicitaciones, Usted no tiene ninguna deuda pendiente</font></TD>
</TR>
</TABLE>
	
  <?php
	}
 
 }
catch(Exception $e) {
print $e->getMessage();
}
 }

 

 ?> 
</td>
<td></td>
</tr>
</table>
<!--Busqueda por cedula-->


<?php
if(($_POST['radios'])== 'idn')
{
	
	
	
global $miconexion;
 $sql4 = "SELECT gen01codi, gen01ruc from  gen01 where gen01ruc = '".$_POST['datos']."'"; 
  $stid = $miconexion->consulta($sql4);
  $row = oci_fetch_array($stid, OCI_ASSOC);
$ciuss =  $row['GEN01CODI'];


global $miconexion;
@$sqlcon = "SELECT gen01.gen01nom||' '||gen01.gen01ape as nombre from  gen01 where gen01.gen01codi = ".$ciuss;
	 @$stid = $miconexion->consulta($sqlcon);
  @$row1 = oci_fetch_array($stid, OCI_ASSOC);

  try
  {
  if($row1['NOMBRE'] == "")
  {
	  $a = "<script>alert('No existe resultados para la busqueda') </script>";
	 throw new Exception($a);
  }

 
 ?> 
	
	
    
<table width="960" align="center" class="texto" align="">
<tr>
  <td width="123" align="right" class="texto">Contribuyente: </td>
  <td width="260" class="detalle_grid"><?php 

global $miconexion; 
 $miconexion->consulta("SELECT gen01.gen01nom||' '||gen01.gen01ape from  gen01 where gen01.gen01codi =".$ciuss); 
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
  <td width="120" align="right">Nro. Identificacion: </td>
  <td width="260" class="detalle_grid"><?php 
global $miconexion;
 $miconexion->consulta("SELECT gen01ruc from  gen01 where gen01.gen01codi = ".$ciuss);  
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
  <td width="74">&nbsp;</td>
  <td width="95">&nbsp;</td>
</tr>
<tr>
  <td align="right" class="texto">Nro. CIU: </td>
  <td class="detalle_grid"><?php 
global $miconexion;
 $miconexion->consulta("SELECT gen01codi from  gen01 where gen01.gen01codi = ".$ciuss);  
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
  <td align="right">Direccion: </td>
  <td class="detalle_grid"><?php 
global $miconexion;
 $miconexion->consulta("SELECT gen01dir from  gen01 where gen01.gen01codi = ".$ciuss);  
 @$miconexion->detalle_maestro_dato('2','black','Arial'); ?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
</table>
<hr />
    <?php
	
	global $miconexion;
 $sql_deudaid ="SELECT sum(emision) + sum(val_abonos) + sum(interes) + sum(coactiva) + sum(recargo) - sum(descuento) as TOTAL from web_deudas where ciu = ".$ciuss; 
  $stid_deudaid = $miconexion->consulta($sql_deudaid);
  $row_deudaid = oci_fetch_array($stid_deudaid, OCI_ASSOC);
	
	if(@$row_deudaid['TOTAL'] != "")
	{	
   global $miconexion;
   $sqlc = "SELECT e.emi03des as impuesto,NROEMISION AS TITULO, W.ANIO, W.MES, 
   W.CLAVE AS REFERENCIA,to_char(W.FOBL,'dd/mm/rrrr') AS FECHA, W.EMISION, W.VAL_ABONOS as abonos, 
   W.INTERES, W.COACTIVA, W.RECARGO, 
   W.DESCUENTO, emision + val_abonos + interes + coactiva + recargo - descuento as TOTAL FROM  WEB_DEUDAS w,emi03 e where e.emi03codi = w.imp and w.CIU =".$ciuss."AND rownum between 1 and ".$_POST['tipo']." ORDER BY ANIO";
	@$miconexion->consulta($sqlc);
	@$miconexion->query_popup_tamaño('web_deuda_cuenta_titulo.php?','TITULO','_blank'); 

 ?> 

<table width="960" align="center"> 
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="114"    class="mensaje_datos"><font size="3" >Total deuda:</font></td>
<td align="left">
 <?php
global $miconexion;
 @$miconexion->consulta("SELECT sum(emision) + sum(val_abonos) + sum(interes) + sum(coactiva) + sum(recargo) - sum(descuento) from web_deudas where ciu = ".$ciuss);  
 @$miconexion->detalle_maestro_font('+2','blue','Arial'); 
?>
</td>
</tr>
</table>

<?php 
	}

	elseif(@$row_deudaid['TOTAL']== "")
	{
		?>
	<TABLE align="center" cellpadding="3" cellspacing="3" class="mensaje_datos">

<TR> 
<TD></TD>
<TD> </TD> 
</TR>
<TR>
<TD></TD>
<TD>Felicitaciones, Usted no tiene ninguna deuda pendiente</font></TD> 
</TR>
</TABLE>        
        <?php
	}
	
 }
catch(Exception $e) {
print $e->getMessage();
}
 }

 ?> 


<?php
if($_POST['radios'] == 'nom' and $_POST['datos'] != "")
{
	
	global $miconexion;
@$sqlcon = "SELECT gen01codi as ciu, gen01ruc as Identificacion, gen01com as nombres, gen01dir as direccion from gen01 where gen01com like '".strtoupper($_POST['datos'])."%'";

 
  @$stid = $miconexion->consulta($sqlcon);
  @$row1 = oci_fetch_array($stid, OCI_ASSOC);

  try
  {
  if($row1['CIU'] == "")
  {
	  $a = "<script>alert('No existe resultados para la busqueda') </script>";
	 throw new Exception($a);
  }
	global $miconexion;
   $sqln = "SELECT gen01codi as ciu, gen01ruc as Identificacion, gen01com as nombres, gen01dir as direccion from gen01 where gen01com like '".strtoupper($_POST['datos'])."%' and gen01ruc != 'ELIMINADO' and rownum between 1 and ".$_POST['tipo']." order by nombres";
	@$miconexion->consulta($sqln);
	@$miconexion->query_view('web_deuda_cuenta_nombre.php?','CIU'); 
	
	}
catch(Exception $e) {
print $e->getMessage();
}
}

 }

 
?>
<script type="text/javascript">
<!--
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
//-->
</script>
</body>
</html>