<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
<title>Documento sin título</title>
</head>

<body>
<?php
	
$opcampobusq = $_POST['idrefcampo'];	

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('CONSULTA','CONSULTA',$dbstr);

if(isset($_POST["idemp"]))
  if($_POST["idemp"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
 $sql = "select CIU,CEDULA,CLAVE,NOMBRE,DIRECCION,AVALUO_REAL,TERRENO,TIENECONSTRUCCION from V_URBANORUSTICO where ".$opcampobusq." = '".$_POST["idemp"]."'";

$res = oci_parse($conn,$sql);
oci_execute($res);
$numerfilas = oci_fetch_all($res,$results);
$numercampos = oci_num_fields($res);

//echo '<input type="hidden" name="pontxtciu" id="pontxtciu" value="'.$results["CIU"][0].'" >';
//echo '<input type="hidden" name="pontxtced" id="pontxtced" value="'.$results["CEDULA"][0].'" >';
//echo '<input type="hidden" name="pontxtclav" id="pontxtclav" value="'.$results["CLAVE"][0].'" >';
//echo '<input type="text" name="pontxtnom" id="pontxtnom" value="'.$results["NOMBRE"][0].'" >';			
//////////consulta basica
//$valorciufijo=$results["CIU"][0]; 

echo $results["NOMBRE"][0];


}
else echo "Ingresar datos";
?>
</body>
</html>