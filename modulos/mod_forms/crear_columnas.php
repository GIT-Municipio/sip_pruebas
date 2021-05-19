<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="actual_campos.php">
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#a4bed4">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0" >
        
        <tr>
          <td><table width="328" border="0" align="center">
            <tr>
              <td colspan="2" align="center" bgcolor="#CCCCCC">NOMBRE DE CAMPOS</td>
            </tr>
            <?php 
 
require_once '../../clases/conexion.php';

  $datosql="select *from plantillas.".$_GET["varitab"];
 $consulta = pg_query($conn,$datosql);

 echo '<input type="hidden" name="varitab" id="varitab"  value="'.$_GET["varitab"].'"/>';
 echo '<input type="hidden" name="varitabcmpid" id="varitabcmpid"  value="'.$_GET["varitabcmpid"].'"/>';
  
  for($i=2;$i<pg_num_fields($consulta);$i++)
  {
 echo'<tr>
    <td width="168"  align="center">'.pg_field_name($consulta,$i).'</td>
    <td width="144">
      <input type="text" name="'.pg_field_name($consulta,$i).'" id="'.pg_field_name($consulta,$i).'" />
    </td>
  </tr>';
  }
  

  
  
  ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center"><input type="submit" name="btnenviar" id="btnenviar" value="Guardar Campos" style="background-image:url(../../imagenes/encabezatabls.png); height:32px; border-color:#a4bed4"  /></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>