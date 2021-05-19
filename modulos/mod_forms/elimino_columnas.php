<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Campos</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="elim_campos.php">
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#a4bed4">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0" >
        
        <tr>
          <td><table width="328" border="0" align="center">
            <tr>
              <td colspan="3" align="center" bgcolor="#FFCE9D">SELECCIONAR CAMPOS A ELIMINAR</td>
            </tr>
            <?php 
 
require_once '../../clases/conexion.php';

  $datosql="SELECT id  FROM public.tbli_esq_plant_form_plantilla_campos where nombre_tablacmp='".$_GET["varitab"]."'";
 $consulta = pg_query($conn,$datosql);
 $refidcampo=pg_fetch_result($consulta,0,'id');
 
  $datosql="SELECT id, campo_creado,  campo_nombre  FROM public.tbli_esq_plant_form_plantilla_cmpcolumns where ref_elementcampo='".$refidcampo."'";
 $consulta = pg_query($conn,$datosql);
 

 echo '<input type="hidden" name="varitab" id="varitab"  value="'.$_GET["varitab"].'"/>';
 echo '<input type="hidden" name="varitabcmpid" id="varitabcmpid"  value="'.$_GET["varitabcmpid"].'"/>';
  echo '<input type="hidden" name="varclaveuntramusu" id="varclaveuntramusu"  value="0"/>';
  
  for($i=0;$i<pg_num_rows($consulta);$i++)
  {
 echo'<tr>
    <td width="168"  align="center">'.pg_fetch_result($consulta,$i,'campo_creado').'</td>
    <td width="144">
      <input type="text" name="'.pg_fetch_result($consulta,$i,'campo_creado').'" id="'.pg_fetch_result($consulta,$i,'campo_creado').'" value="'.pg_fetch_result($consulta,$i,'campo_nombre').'" />
    </td>
	<td width="144">
      <input type="radio" name="selecmicamp" id="selecmicamp" value="'.pg_fetch_result($consulta,$i,'campo_creado').'" />
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