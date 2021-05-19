<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Campos</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="actual_campos.php">
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#a4bed4">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="0" cellspacing="0" >
        
        <tr>
          <td><table width="265" border="0" align="center">
            <tr>
              <td colspan="2" align="center" bgcolor="#CCCCCC">NOMBRE DE CAMPOS</td>
               <td width="35" align="center" bgcolor="#CCCCCC">TIPO</td>
               <td width="69" align="center" bgcolor="#CCCCCC">TAMAÑO</td>
               <td align="center" bgcolor="#CCCCCC"  width="75">BLOQUEO</td>
            </tr>
            <?php 
 
require_once '../../clases/conexion.php';

  $datosql="SELECT id  FROM public.tbli_esq_plant_form_plantilla_campos where nombre_tablacmp='".$_GET["varitab"]."'";
 $consulta = pg_query($conn,$datosql);
 $refidcampo=pg_fetch_result($consulta,0,'id');
 
  $datosql="SELECT id, campo_creado,  campo_nombre,campo_tipo,campo_tamanio,campo_bloqueo  FROM public.tbli_esq_plant_form_plantilla_cmpcolumns where ref_elementcampo='".$refidcampo."'";
 $consulta = pg_query($conn,$datosql);
 

 echo '<input type="hidden" name="varitab" id="varitab"  value="'.$_GET["varitab"].'"/>';
 echo '<input type="hidden" name="varitabcmpid" id="varitabcmpid"  value="'.$_GET["varitabcmpid"].'"/>';
 echo '<input type="hidden" name="varclaveuntramusu" id="varclaveuntramusu"  value="0"/>';
  
  for($i=0;$i<pg_num_rows($consulta);$i++)
  {
    echo'<tr>';
    echo  '<td width="168"  align="center">'.pg_fetch_result($consulta,$i,'campo_creado').'</td>';
    echo '<td width="144">
      <input type="text" name="'.pg_fetch_result($consulta,$i,'campo_creado').'" id="'.pg_fetch_result($consulta,$i,'campo_creado').'" value="'.pg_fetch_result($consulta,$i,'campo_nombre').'" />
    </td>';
	//////campo de tipos
	echo '<td width="144">
      	<select name="combo'.pg_fetch_result($consulta,$i,'campo_creado').'" id="combo'.pg_fetch_result($consulta,$i,'campo_creado').'">';
		   $datosqltipo="SELECT id, tipo_campo   FROM tbli_esq_param_tipocampo where activo_tabla=1 order by id;";
           $consultatipo = pg_query($conn,$datosqltipo);
		   for($tip=0;$tip<pg_num_rows($consultatipo);$tip++)
  				{
					if(pg_fetch_result($consulta,$i,'campo_tipo')==pg_fetch_result($consultatipo,$tip,0))
    		echo '<option value="'.pg_fetch_result($consultatipo,$tip,0).'" selected="selected" >'.pg_fetch_result($consultatipo,$tip,1).'</option>';
			else
			echo '<option value="'.pg_fetch_result($consultatipo,$tip,0).'">'.pg_fetch_result($consultatipo,$tip,1).'</option>';
				}
  	echo '</select></td>';
	//////campo tamanio
	echo '<td>';
	
	if(pg_fetch_result($consulta,$i,'campo_tamanio')!="")
      echo '<input type="number" name="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" id="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" value="'.pg_fetch_result($consulta,$i,'campo_tamanio').'" style=" width: 70px;text-align:center" />';
	else
	{
		if(pg_fetch_result($consulta,$i,'campo_creado')=='campo_0')
	  		echo '<input type="number" name="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" id="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" value="200" style=" width: 70px;text-align:center" />';
	  else
	  		echo '<input type="number" name="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" id="tam'.pg_fetch_result($consulta,$i,'campo_creado').'" value="100" style=" width: 70px;text-align:center" />';
	}
	  
   echo '</td>';
   echo '<td width="50" align="center">';
   
    if(pg_fetch_result($consulta,$i,'campo_bloqueo')==1)
   		echo "<input type='checkbox' name='cheq".pg_fetch_result($consulta,$i,'campo_creado')."' id='cheq".pg_fetch_result($consulta,$i,'campo_creado')."' checked='checked'  />";
   else
		echo "<input type='checkbox' name='cheq".pg_fetch_result($consulta,$i,'campo_creado')."' id='cheq".pg_fetch_result($consulta,$i,'campo_creado')."'   />";
   
   echo '</td>';
   echo '</tr>';
  }
  

  
  
  ?>
            <tr>
              <td width="35">&nbsp;</td>
              <td width="32">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5" align="center"><input type="submit" name="btnenviar" id="btnenviar" value="Guardar Campos" style=" height:32px; border-color:#a4bed4"  /></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>