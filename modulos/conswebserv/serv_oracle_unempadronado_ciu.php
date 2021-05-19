<?php
	
$opcampobusq = $_POST['idrefcampo'];	

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('CONSULTA','CONSULTA',$dbstr,"WE8ISO8859P15");

if(isset($_POST["idemp"]))
  if($_POST["idemp"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
 $sql = "SELECT gen01codi,gen01ruc,gen01nom,gen01ape,gen01com,gen01dir,gen01telf,gen01email,gen01fnac,gen01disca  FROM gen01  WHERE gen01cont = 'O'  and ".$opcampobusq." = '".$_POST["idemp"]."'  and rownum <= 5 ";

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

echo utf8_encode($results["GEN01CODI"][0].'#'.$results["GEN01RUC"][0].'#'.$results["GEN01APE"][0].'#'.$results["GEN01NOM"][0].'#'.$results["GEN01DIR"][0].'#'.$results["GEN01TELF"][0].'#'.$results["GEN01EMAIL"][0]);


}
else echo "Ingresar datos";
?>