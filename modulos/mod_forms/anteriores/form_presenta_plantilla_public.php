<?php

include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');

if(($_GET['varidplanty'])!="")
{

 $sql = "select *  FROM tbli_esq_plant_form_plantilla  where id='".$_GET['varidplanty']."'  order by id;";
$resulverplan = pg_query($conn, $sql);

$content="BIENVENIDOS AL BALCON MUNICIPAL DE COTACACHI";

QRcode::png($content,"../../../sip_bodega/codqr/"."plantilla_".$_GET['varidplanty']."_comp_qr.png",QR_ECLEVEL_L,10,2);
$verimgqrdado = "../../../sip_bodega/codqr/"."plantilla_".$_GET['varidplanty']."_comp_qr.png";

/////////////////////parametros generales plantilla
$retorn_tableplan=pg_fetch_result($resulverplan,0,'nombre_tablabdd');
$retorn_tableanex=pg_fetch_result($resulverplan,0,'nombre_tabla_anexos');

$varclaveunictramitusu=0;

}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plantillas Formularios</title>
<link rel="stylesheet" href="jquery/jquery-ui.css">
<link rel="stylesheet" href="jquery/jquery-ui.css">
  <script src="jquery/jqueryfecha.js"></script>
  <script src="jquery/jquery-ui.js"></script>
  <script>
  $( function() {
	  
	  <?php
	  $sqldats = "select campo_creado,campo_nombre,campo_requerido,ref_tcamp,campo_orden  FROM tbli_esq_plant_form_plantilla_campos where ref_plantilla='".$_GET['varidplanty']."' and campo_activo=1 order by campo_orden; ";
     $rescamposx = pg_query($conn, $sqldats);
	  for($i=0;$i<pg_num_rows($rescamposx);$i++)
	  {
		  if(pg_fetch_result($rescamposx,$i,'ref_tcamp')=='4')
		  {
	  ?>
    $( "#campo_<?php echo  $i; ?>" ).datepicker();
	<?php
		  }
	  }
	?>
	
  } );
  </script>
  
  <style type="text/css">
  
  fieldset {
	/*width: 100%;*/
	border:1px solid #999;
	border-radius:8px;
	box-shadow:0 0 10px #999;
	/*text-align:  center;*/
    }
	
	legend
	{
		
		border-radius:8px;
		box-shadow:0 0 10px #999;
		background-color:#1491ae;
		color:#FFF;
		
	}
  
  </style>
  
</head>

<body>
<?php
if(($_GET['varidplanty'])!="")
{
?>
<table width="100%" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="90" align="center"><img src="../../imgs/logos/logo_cotac2019.png" width="54" height="101" /></td>
    <td width="672"><table width="90%" border="0" align="center">
      <tr>
        <td align="center"><b>MUNICIPIO DE COTACACHI</b></td>
      </tr>
      <tr>
        <td align="center"><b><?php echo pg_fetch_result($resulverplan,0,'nombre_plantilla'); ?></b></td>
      </tr>
    </table></td>
    <td width="164" align="center"><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0"></td>
  </tr>
  <tr>
    <td colspan="3">
    
    
    <?php
	  $sqlgrups = "select id,titulo_grupo,orden_grupo,publico  FROM tbli_esq_plant_form_plantilla_grupo where ref_plantilla='".$_GET['varidplanty']."' and activo=1 order by orden_grupo";
	 $resulvgrups = pg_query($conn, $sqlgrups);

    for($grup=0;$grup<pg_num_rows($resulvgrups);$grup++)
	{
		
		if(pg_fetch_result($resulvgrups,$grup,"publico")==1)
			  {
			///////////////////////INI ESPACIO	  
		echo '<fieldset><legend>'.pg_fetch_result($resulvgrups,$grup,"titulo_grupo").'</legend>';
		
		$sqlcamps = "select id,campo_creado,campo_nombre,campo_requerido,ref_tcamp,campo_orden,nombre_tablacmp,ref_plantilla,nombre_combocmp,publico,valorx_defecto  FROM tbli_esq_plant_form_plantilla_campos where ref_plantilla='".$_GET['varidplanty']."' and ref_grupo='".pg_fetch_result($resulvgrups,$grup,"id")."' and campo_activo=1 order by campo_orden; ";
	    $resulvcamps = pg_query($conn, $sqlcamps);
		
		
		echo '<table width="100%" border="1" cellpadding="0" cellspacing="0">';
		 for($items=0;$items<pg_num_rows($resulvcamps);$items++)
	     {
			  if(pg_fetch_result($resulvcamps,$items,"publico")==1)
			  {
			//////////////////////FILA///////////
			 echo '<tr>';
			 if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==11)
			{
				   echo '<td colspan="2" align="center"><div name="text'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" id="text'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" >'.pg_fetch_result($resulvcamps,$items,"valorx_defecto").'</div></td>';
			}
			else  if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==10)
			{
				   echo '<td colspan="2" align="center"><iframe name="map'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" id="map'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" frameborder="0"  width="100%" height="400"  src="app_tipo_mapaubic_rutas.php?ponref_plantilla='.pg_fetch_result($resulvcamps,$items,"ref_plantilla").'&varitabcmpid='.pg_fetch_result($resulvcamps,$items,"campo_creado").'&varclaveuntramusu='.$varclaveunictramitusu.'"></iframe></td>';
			}
			else if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==9)
			{
				   echo '<td colspan="2" align="center"><iframe name="tab'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" id="tab'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" frameborder="0"  width="100%" height="400"  src="app_tipo_tabla.php?pontabla='.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'&varitabcmpid='.pg_fetch_result($resulvcamps,$items,"id").'&varclaveuntramusu='.$varclaveunictramitusu.'"></iframe></td>';
			}
			else{
			
			if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
			{	 
			echo '<td  bgcolor="#E2E2E2" width="40%"><b>'.pg_fetch_result($resulvcamps,$items,"campo_nombre").':</b><font color="#FF0000" size="2" face="Arial, Gadget, sans-serif"> (*)</font></td>';
			}
			 else
			 {
			  echo '<td  bgcolor="#E2E2E2" width="40%"><b>'.pg_fetch_result($resulvcamps,$items,"campo_nombre").':</b></td>';
			 }
			
			 if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==5)
			{
				if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' required  title='Este campo es requerido'  /></td>";
				else
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'   /></td>";
				
			}
			else
			 if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==7)
			 {
				if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
				{
				
				$sqlcampscombo = "select  item_nom  FROM plantillas.".pg_fetch_result($resulvcamps,$items,"nombre_combocmp")." order by id; ";
	    $rescampocombo = pg_query($conn, $sqlcampscombo);
		
				
				echo "<td  align='center' ><select name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' style='width: 90%' >";
				for($icomb=0;$icomb<pg_num_rows($rescampocombo);$icomb++)
					{
    					echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."'>".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
					}
  					echo		"</select></td>";

				}
				else
				{
					$sqlcampscombo = "select  item_nom  FROM plantillas.".pg_fetch_result($resulvcamps,$items,"nombre_combocmp")." order by id; ";
	    			$rescampocombo = pg_query($conn, $sqlcampscombo);
		
				
					echo "<td  align='center' ><select name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' style='width: 90%'>";
				for($icomb=0;$icomb<pg_num_rows($rescampocombo);$icomb++)
					{
    					echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."'>".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
					}
  					echo		"</select></td>";
				}
				
			}
			else 
			{
				if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
    		     echo  "<td align='center'  height='25'><input name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' type='text' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' value='' style='width: 90%' required  title='Este campo es requerido'  /></td>";
				 else
				  echo  "<td align='center'  height='25'><input name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' type='text' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' value='' style='width: 90%'  /></td>";
				 
			}
			
			}
			 
              echo '</tr>';
			   //////////////////////FIN FILA///////////
			  }
		 }
		echo '</table>';
		
		echo '</fieldset>&nbsp;';
		///////////////////////INI ESPACIO	  
		}
		//echo '<td colspan="3">&nbsp;</td>';
	}
	
	?>
    
    
    
    
    
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>
</body>
</html>