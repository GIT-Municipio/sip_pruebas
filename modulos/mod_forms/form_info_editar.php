<?php

require_once 'clases/conexion.php';
$datonumfichaus=$_GET["mvpr"];
$sqldatoinf = "select *from plantillasform.plantilla_1 where id='".$datonumfichaus."';";
$resulclasinf = pg_query($conn, $sqldatoinf);
$tamandts=pg_num_fields($resulclasinf);

/////////////////tipo ficha
$sqlplan="select *from vista_presentaplantilla where nombre_tablabdd='plantilla_1'";
$consulplan=pg_query($conn,$sqlplan);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style>
.breadcrumbs
{
	/*width: 75%;*/
	background: #c4c4c4 -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.8)), to(rgba(255,255,255,0)));
	border-radius: 5px; 
}

#infocontenedor_form
{
	width: 100%;
	border: 1px solid #000;
	border-color:#a8a8a8;border-radius: 8px;
	font-size:12px; 
	text-align: center;
	/*position: absolute;*/
}

#page{ width: 97%; }

    #conten_campos
    {
	background-color:#f7f7f7;
	text-align:  left;
	width: 20%;
	font-weight: bold;
	border: 1px solid black;
	border-color:#a8a8a8;border-radius: 3px;
    }
	
	#conten_campos_title
    {
	background-color:#DADADA;
	text-align:  center;
	width: 20%;
	font-weight: bold;
	border: 1px solid black;
	border-color:#a8a8a8;border-radius: 3px;
    }
	
	 #conten_campos_actividad
    {
	background-color:#f7f7f7;
	text-align:  left;
	/*width: 20%;*/
	font-weight: bold;
	border: 1px solid black;
	border-color:#a8a8a8;border-radius: 3px;
    }
	
	#conten_info_actividad
    {
        background-color:#FFF;
        text-align:  left;
		border: 1px solid black;
		border-color:#a8a8a8;border-radius: 3px;
    }
	
	
	#conten_camposencab
    {
	/*background-color:#f7f7f7;*/
	text-align:  left;
	/*width: 20%;*/
	font-weight: bold;
	/*border: 1px solid black;*/
	/*border-color:#a8a8a8;border-radius: 3px;*/
    }
	
    #conten_info
    {
        background-color:#FFF;
        text-align:  left;
		border: 1px solid black;
		border-color:#a8a8a8;border-radius: 3px;
    }
	
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
<form action="guardarinfo_plan_actualizar.php" method="post">
<table width="100%" border="0">
  <tr>
    <td width="757">
    <fieldset>
    <table width="100%" border="0">
      <tr>
        <td width="80%" rowspan="3"><table width="200" border="0">
          <tr>
              <td><img src="imgs/encabezpatrimo.png" width="643" height="94" /></td>
            </tr>
           <tr>
                    <td align="center"><font color="#000" size="3"><?php echo pg_fetch_result($consulplan,0,"nombre_plantilla"); ?></font></td>
                  </tr>
                  <tr>
                    <td align="center"><font color="#000" size="3">FICHA DE REGISTRO</font></td>
                  </tr>
        </table></td>
        <td bgcolor="#1491ae">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%"  id="conten_campos">CODIGO</td>
      </tr>
      <tr>
        <td><?php echo pg_fetch_result($resulclasinf,0,"codigo");?>&nbsp;<input type="hidden" name="idprimusu" id="idprimusu" value="<?php echo $datonumfichaus; ?>" /></td>
      </tr>
    </table>
    </fieldset>
    
    </td>
  </tr>
  <tr>
    <td>
    
   
    <?php
	//////////////////////////////cuando no hay agrupaciones
	/*
	echo "<table width='100%'>";
	 for($i=0;$i<$tamandts;$i++)
	     {
			 
			 $nomcampo=strtoupper(pg_field_name($resulclasinf,$i));
			 
			 $auxtxt=substr($nomcampo, 0, 6);
			if($auxtxt != "CAMPO_")
			{
			//	echo $nomcampo;
			if($nomcampo=="NOMBRE_BIEN")
			  $nomcampo="NOMBRE"; 
			  
			echo '<tr>';
			echo ' <td width="40%" id="conten_campos" >'.$nomcampo.'</td>';
		    echo ' <td  id="conten_info" >'.pg_fetch_result($resulclasinf,0,$i).'</td>';
			echo '</tr>'; 
			}
			
			  
		}
	echo "</table>";
	*/
	////////////////////////////////////////////////////////////para conocer los grupos de informacion
	 $consucolgrupo="select id,titulo_grupo FROM tbli_esq_config_grupo grup where ref_plantilla=1  order by  orden_grupo";
		$resulcampoinfegrup = pg_query($conn, $consucolgrupo);
///////////////////////////////////////////////grupos		
	for($gru=0;$gru<pg_num_rows($resulcampoinfegrup);$gru++)
	{
		echo "<fieldset><legend>&nbsp;&nbsp;".pg_fetch_result($resulcampoinfegrup,$gru,"titulo_grupo")."&nbsp;&nbsp;</legend>";
	     echo "<table width='100%'>";
///////////////////////////////////////////campos	
    for($i=0;$i<$tamandts;$i++)
	{
		//////////////////////////////cuando existen grupos de campos
		 $consucolexis="SELECT  count(*) FROM tbli_esq_camposplantilla where ref_plantilla=1 and campo_creado='".pg_field_name($resulclasinf,$i)."' and ref_grupo_config='".pg_fetch_result($resulcampoinfegrup,$gru,"id")."' ";
		$resulcampoinfexist = pg_query($conn, $consucolexis);
		$nomcampoexist=pg_fetch_result($resulcampoinfexist,0,0);
		
		
		//////////////////compracion si existe
		if($nomcampoexist!=0)
		{
			echo "<tr>";
		 $consucol="SELECT  campo_nombre,campo_requerido FROM tbli_esq_camposplantilla where ref_plantilla=1 and campo_creado='".pg_field_name($resulclasinf,$i)."' and ref_grupo_config='".pg_fetch_result($resulcampoinfegrup,$gru,"id")."' ";
		$resulcampoinf = pg_query($conn, $consucol);
        $nomcampo=pg_fetch_result($resulcampoinf,0,0);
		
		if(pg_fetch_result($resulcampoinf,0,"campo_requerido")=='t')
		{
		   echo ' <td width="20%" id="conten_campos" >'.$nomcampo."<font color='#FF0000' size='2' face='Arial, Gadget, sans-serif'> (*)</font>".'</td>';
		}
		else
		{
		   echo ' <td width="20%" id="conten_campos" >'.$nomcampo.'</td>';
		}
		  // echo '<td width="80%" id="conten_info" >'.pg_fetch_result($resulclasinf,0,$i).'</td>';	
		  if(pg_fetch_result($resulclasinf,0,$i)=='f')
		   echo ' <td width="80%" id="conten_info" ><input type="checkbox" name="'.pg_field_name($resulclasinf,$i).'" id="'.pg_field_name($resulclasinf,$i).'" /></td>';	
		else if(pg_fetch_result($resulclasinf,0,$i)=='t')
			echo ' <td width="80%" id="conten_info" ><input type="checkbox" name="'.pg_field_name($resulclasinf,$i).'" id="'.pg_field_name($resulclasinf,$i).'" checked="checked"  /></td>';	
		else
		{
			if(pg_fetch_result($resulcampoinf,0,"campo_requerido")=='t')
			 {
				 if((pg_field_name($resulclasinf,$i)=='descripcion_bien') || (pg_field_name($resulclasinf,$i)=='campo_110'))
				 {
					  echo "<td width='80%' id='conten_info' ><textarea name='".pg_field_name($resulclasinf,$i)."' id='".pg_field_name($resulclasinf,$i)."' cols='78' rows='5'>".pg_fetch_result($resulclasinf,0,$i)."</textarea></td>";
				 }
				 else
		   echo "<td width='80%' id='conten_info' ><input name='".pg_field_name($resulclasinf,$i)."' type='text' id='".pg_field_name($resulclasinf,$i)."' value='".pg_fetch_result($resulclasinf,0,$i)."' style='width: 100%' required   /></td>";
			 }
			 else
			  {
				  if((pg_field_name($resulclasinf,$i)=='descripcion_bien') || (pg_field_name($resulclasinf,$i)=='campo_110'))
				 {
					  echo "<td width='80%' id='conten_info' ><textarea name='".pg_field_name($resulclasinf,$i)."' id='".pg_field_name($resulclasinf,$i)."' cols='78' rows='5'>".pg_fetch_result($resulclasinf,0,$i)."</textarea></td>";
				 }
				 else
		   echo "<td width='80%' id='conten_info' ><input name='".pg_field_name($resulclasinf,$i)."' type='text' id='".pg_field_name($resulclasinf,$i)."' value='".pg_fetch_result($resulclasinf,0,$i)."' style='width: 100%'   /></td>";
			 }
		}
		   echo "</tr>";
		}
	/*  echo ' <td width="21%" id="conten_campos" >'.pg_field_name($resulclasinf,$i).'</td>'; */
		
	}
	////////////////////////////////fin de grupo
	
	 echo "</table>";
	 echo "</fieldset>";
	 
	}
	
	?>
      
   
    
    
    
    </td>
  </tr>
  <tr>
    <td><input  type="submit" value="GUARDAR" style="width:100px; height: 60px; background-image:url(../public/images/guardar.png; background-repeat:no-repeat; background-position:center)"/></td>
  </tr>
</table>
</form>
</body>
</html>