<?php
	
$opcampobusq = $_POST['idrefcampo'];	

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('CONSULTA','CONSULTA',$dbstr);

if(isset($_POST["idemp"]))
  if($_POST["idemp"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
 $sql = "select emp.IDEMPLEA,emp.CEDULA,emp.NOMBRES,emp.APELLIDOS,emp.SEXO,emp.DIRECCION,emp.TELEFONO, dep.IDDEPART as cod_departamento,dep.NOMBRE as departamento, emp.FECINGRESO as fecha_ingreso, emp.FECNACIMIENTO as fecha_nacimiento  from rc05_empleado emp, rc04_departamento dep WHERE emp.IDDEPART=dep.IDDEPART and ".$opcampobusq." = '".$_POST["idemp"]."'  and rownum <= 5 ";

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

echo $results["NOMBRES"][0].'@'.$results["APELLIDOS"][0];


}
else echo "Ingresar datos";
?>