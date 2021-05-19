<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
<title>Documento sin título</title>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="175" align="center">Información</td>
          <td width="25" align="right"><a href="#" onclick="javascript:cerrarConsultatab()"><img src="../../gap/imagenes/close.png" width="14" height="14" /></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>
<?php
	
$opcampos = explode(",", $_POST['refcamporel']);	
$camprimariovar = $opcampos[0];
$totalmiscampos= count($opcampos);

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
$conn = oci_connect('CONSULTA','CONSULTA',$dbstr);

if(isset($_POST["idemp"]))
  if($_POST["idemp"]!="")
  {
/////////////////////////////////////////////////////////CONSULTA PREDIAL
$sql = "select CIU,CEDULA,CLAVE,NOMBRE,DIRECCION,AVALUO_REAL,TERRENO,TIENECONSTRUCCION from V_URBANORUSTICO where ".$opcampos[1]." like '%".$_POST["idemp"]."%'  and rownum <= 5 ";

$res = oci_parse($conn,$sql);
oci_execute($res);
$numerfilas = oci_fetch_all($res,$results);
$numercampos = oci_num_fields($res);

////////////////CONOCER LAS DEUDAS EN VALOR
/*
$sqldeudas ="SELECT sum(emision) + sum(val_abonos) + sum(interes) + sum(coactiva) + sum(recargo) - sum(descuento) AS TOTAL_DEUDA from web_deudas where CIU = '".$results["CIU"][0]."'";

$restot = oci_parse($conn,$sqldeudas);
oci_execute($restot);
$numerfilastot = oci_fetch_all($restot,$resultstots);
$valor_totaldeuda=$resultstots["TOTAL_DEUDA"][0]; 
*/
//////////consulta basica
//$valorciufijo=$results["CIU"][0]; 

$_POST['refcomponpcion']='tabla';
$_POST['reftablarel']="V_URBANORUSTICO";
if($numerfilas>0)
  {
if( $_POST['refcomponpcion']=='tabla')
{
echo "<table border='1' cellpadding='0' cellspacing='0'  id='subtablaconsul' >";
echo "<tr id='subtablacamposheader'>";
echo "<td>OPCION</td>";
 for($i=2;$i<$totalmiscampos;$i++)
					{
			echo "<th>".strtoupper($opcampos[$i])."</th>"; 
					}  
echo "</tr>";

$vestfila=0;
for($i=0;$i<$numerfilas;$i++)
		{
			if($vestfila==0)
			{
			echo "<tr id='subtabfilaprim'>";
			$vestfila=1;
			}
			else
			{
			echo "<tr id='subtabfilaseg'>";
			$vestfila=0;
			}
			echo "<td><a href=\"javascript:porcambiotabla( '".$_POST['reftxthidden']."','".$results[$opcampos[0]][$i]."','".$results[$opcampos[1]][$i]."','".$opcampos[1]."','".$_POST['refcamporel']."','".$_POST['reftablarel']."' ); \" ><div id='opselbtn' style='width: 111px; height: 32px'></div></a></td>";
			for($km=2;$km<$totalmiscampos;$km++)
		       {
				//	if($opcampos[$km]!="DETALLE_TERRENO")
	               echo "<td  id='subtabfilainfo'>".$results[$opcampos[$km]][$i]."</td>";
			   }
			 echo "</tr>";  
		}
echo " </table>";

}
///////////////////////////////fin de pregunta si hay valores
}
}
else echo "Ingresar datos";

?>

</td>
  </tr>
</table>

</body>
</html>