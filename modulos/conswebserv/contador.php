<?php require ("class_cabildo.php");
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
<title>Documento sin título</title>

<link href="styles/contador.css" rel="stylesheet" type="text/css" />


</head>
<?php


$ip = $_SERVER['REMOTE_ADDR'];   

$dia = date("l"); 
$mes = date("M"); 
$anio = date("Y");





$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and mes like '%".$mes."%' and dia like '%".$dia."%' and anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$d=0;
while($row = oci_fetch_array ($Q))
{
$d = $d +1;

}






$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and mes like '%".$mes."%' and  anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$m=0;
while($row = oci_fetch_array ($Q))
{
$m = $m +1;

}





$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$a=0;
while($row = oci_fetch_array ($Q))
{
$a = $a +1;

}


$sql="SELECT * FROM contador"; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$t=0;
while($row = oci_fetch_array ($Q))
{
$t = $t +1;

}


$sql = 'insert into  CONTADOR ( id , ip ,  dia, mes, anio) values    
								   ( :vid , :vip, :vdia, :vmes, :vanio ) ' ;
												
			
					$stid =  $miconexion->prepara_insertar( $sql);
					$sec =  $miconexion->_secuencia('SE_CONTADOR_WEB');
					
					 oci_bind_by_name ( $stid ,  ':vid' ,$sec ); 
					 oci_bind_by_name ( $stid ,  ':vip' ,$ip); 	
					 oci_bind_by_name ( $stid , ':vdia' ,$dia);
					  oci_bind_by_name ( $stid , ':vmes' ,$mes); 	 
					  oci_bind_by_name ( $stid , ':vanio' ,$anio); 	 	
					
					$miconexion->inserta($stid);


	
?>

<table width="200" border="1" align="center" class="">
  <tr>
    <th scope="col" align="center" >IP</th>
    <th scope="col" align="center">DIA</th>
    <th scope="col" align="center">MES</th>
    <th scope="col" align="center">AÑO</th>
  </tr>
  <tr>
    <td align="center"><?php echo $ip; ?></td>
    <td align="center"><?php echo $d;  ?></td>
    <td align="center"><?php echo $m; ?></td>
    <td align="center"><?php echo $a; ?></td>
  </tr>
</table>

<table width="200" border="1" align="center">
  <tr>
    <th scope="col" align="center">TOTAL VISITAS</th>
  </tr>
  <tr>
    <td align="center"><?PHP  echo $t;?></td>
  </tr>
</table>

<body>
</body>
</html>