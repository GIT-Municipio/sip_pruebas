<?php
	
$opcampos = explode(",", $_POST['refcamporel']);	
$camprimariovar = $opcampos[0];
$totalmiscampos= count($opcampos);

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('GESTORSP','GESTORSP',$dbstr);

if(isset($_POST["txtcedula"]))
  if($_POST["txtcedula"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
echo  $sql = "UPDATE gen01
   SET gen01ruc='".$_POST["txtcedula"]."', gen01nom='".$_POST["txtnombres"]."', gen01ape='".$_POST["txtapellidos"]."', gen01dir='".$_POST["txtdireccion"]."', gen01telf='".$_POST["txttelefono"]."',  gen01email='".$_POST["txtmail"]."'  WHERE gen01codi=".$_POST["txtciu"]." and gen01cont = 'O'";
  
$res = oci_parse($conn,$sql);
//oci_free_statement($res);
$result = oci_execute($res, OCI_COMMIT_ON_SUCCESS);
if (!$result) {
  echo oci_error();   
}
//oci_close($conn);
//$numerfilas = oci_fetch_all($res,$results);
//$numercampos = oci_num_fields($res);
   }

?>
