<?php

require_once '../../clases/conexion.php';

if(isset($_POST["mivarcodigoplantilla"]))
$idprintramite=$_POST["mivarcodigoplantilla"];       ////codigo principal de la plantilla
$idprincodusuarioid=$_POST["mivarcodigousuario"]; ////codigo principal del usuario

 $sqlplan="select *from vista_presentaplantilla where id='".$idprintramite."'";
$consulplantitleq=pg_query($conn,$sqlplan);
$vertamangrupetiq=pg_num_rows($consulplantitleq); 

 $vrdaretprinusuars="plantillasform.".pg_fetch_result($consulplantitleq,0,"nombre_tablabdd");
$vrdatableretrequisitos="plantillasform.".pg_fetch_result($consulplantitleq,0,"nombre_tabla_anexos");


$sqldatoinf = "select *from ".$vrdaretprinusuars." where id='".$idprincodusuarioid."';";
$resulclasinf = pg_query($conn, $sqldatoinf);
$tamandts=pg_num_fields($resulclasinf);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	background-color: #eaeeef;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}

 #conten_campos
    {
	/*background-color:#f7f7f7;*/
	text-align:  left;
	width: 30%;
	/*font-weight: bold;*/
	/*border: 1px solid black;*/
	border-color:#a8a8a8;border-radius: 3px;
	
	border-left: solid black 0px;
    border-right: solid black 0px;
   /* border-bottom: 1px solid black;*/
    border-top: solid black 0px;
	
    }
	
	#conten_info
    {
        background-color:#FFF;
        text-align:  left;
		border: 1px solid black;
		border-color:#a8a8a8;border-radius: 3px;
		
		border-left: solid black 0px;
    border-right: solid black 0px;
   /* border-bottom: 1px solid black;*/
    border-top: solid black 0px;
    }

fieldset {
	/*width: 100%;*/
	border:1px solid #999;
	border-radius:8px;
	box-shadow:0 0 10px #999;
	text-align:  left;
    }
	
legend
	{
		
		border-radius:8px;
		box-shadow:0 0 10px #999;
		background-color:#EEE;
		color:#000;
		font-size:12px;
		padding:0.2em;
		
	}
	

	
	
</style>
<script>
function cancelarformulario()
{
	window.close();
}
</script>
</head>

<body>
<form id="formCiudadano" name="formCiudadano" method="post" action="guardarinfo_plan.php">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="409" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="209"><img src="../../iconos/tab_btnforminact.png" width="200" height="25" /></td>
          <td width="200"><img src="../../iconos/tab_btnrequisitinact.png" width="200" height="25" /></td>
          <td width="200"><img src="../../iconos/tab_btnfinimprimiract.png" width="200" height="25" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div style="width:100%; height: 40px; background-color:#323639; color:#FFF; text-align: center;vertical-align: middle; " align="center">
        <table width="100%" border="0" height="40">
          <tr>
            <td align="center"><?php echo pg_fetch_result($consulplantitleq,0,"nombre_plantilla"); ?></td>
          </tr>
        </table>
      </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="78%" align="center" bgcolor="#525659"><div id="cuerpoformulario" style="width:100%; height: 530px; overflow-y: scroll;overflow-x: hidden;
 background-color:#525659; ">
              <table width="600" border="2" align="center" class="estiloformulario" bordercolor="#333333">
                <tr>
                  <td bgcolor="#FFFFFF"><table width="100%" border="0">
                    <tr>
                      <td><table width="100%" border="0">
                        <tr>
                          <td width="14"><img src="<?php   if (isset($verimgloginst)!="") { echo "../../..".$verimgloginst; } else { echo "../../imagenes/logointrologin.png"; }?>" alt="" width="80" height="60" /></td>
                          <td width="440"><font color="#003366" size="5"><?php echo pg_fetch_result($consulplantitleq,0,"nombre_tramite"); ?></font></td>
                          <td width="48" align="right"><?php
				
			require_once('../barcode2018/barcode.inc.php'); 
  			new barCodeGenrator(pg_fetch_result($resulclasinf,0,"form_cod_barras"),1,'barcode.gif', 180, 42, true);
  			echo '<img src="barcode.gif" width = "150" height="60" />'; 
		

	?>
                            &nbsp;
                            <input type="hidden"  name="mivarcodbarrasform" id="mivarcodbarrasform" value="<?php echo $csecucodbarras; ?>"  /></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                    </tr>
                   
                    <tr>
                      <td align="center">
                      
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
		echo "<br/><fieldset><legend>".pg_fetch_result($resulcampoinfegrup,$gru,"titulo_grupo")."</legend>";
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
		 $consucol="SELECT  campo_nombre,ref_tcamp FROM tbli_esq_camposplantilla where ref_plantilla=1 and campo_creado='".pg_field_name($resulclasinf,$i)."' and ref_grupo_config='".pg_fetch_result($resulcampoinfegrup,$gru,"id")."' ";
		$resulcampoinf = pg_query($conn, $consucol);
        $nomcampo=pg_fetch_result($resulcampoinf,0,0);
		$tipcampo=pg_fetch_result($resulcampoinf,0,1);
		
		   echo ' <td width="30%" id="conten_campos" >'.$nomcampo.':</td>';
		   if($tipcampo=="5")
		         if(pg_fetch_result($resulclasinf,0,$i)=='t')
		              echo ' <td width="70%" id="conten_info" ><input type="checkbox" checked="checked"  /></td>';	
				 else
				      echo ' <td width="70%" id="conten_info" ><input type="checkbox" /></td>';	
				 
		   else
		   echo ' <td width="70%" id="conten_info" >'.pg_fetch_result($resulclasinf,0,$i).'</td>';	
		   
		   echo "</tr>";
		}
	/*  echo ' <td width="21%" id="conten_campos" >'.pg_field_name($resulclasinf,$i).'</td>'; */
		
	}
	////////////////////////////////fin de grupo
	
	 echo "</table>";
	 echo "</fieldset>";
	 
	}
	
	?>
      
                      
                      
                      &nbsp;</td>
                    </tr>
                    
                    <!--
     <tr>
        <td><fieldset>
          <table width="100%" border="0">
         
          <?php
		  /////////////para REQUISITOS
		  /*
          $sqlplan="select *from vista_presentaplantilla where  ref_grupoc = 2 and id='".$idprintramite."'";
          $consulplang1=pg_query($conn,$sqlplan);
		  
		  for($i=0;$i<pg_num_rows($consulplang1);$i++)
		  {
			 echo  "<tr><td><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."</span></td>";
			 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 400px'  /></td></tr>";
		   }
		   */
		  ?>
           
          </table>
        </fieldset></td>
      </tr>
      -->
                    <?php //////////////////////////////////////////////////  ?>
                  </table></td>
                </tr>
              </table>
              
            </div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><table width="400" border="0" align="right">
        <tr>
          <td width="240" align="center"><input type="button" onclick="javascript:cancelarformulario();" name="btnenviar" id="btnenviar" value="" style="background-image:url(../../iconos/form_btnsiguientefinalizar.png); color:#fff;width:202px;height:40px; font-size:14px" /></td>
          <td width="261" align="right"><?php  if(isset($_GET["varinter"])==1) {  ?>
            <input type="button" onclick="javascript:cancelarformulinter();" name="btncancelar" id="btncancelar" value=""  style="background-image:url(../../iconos/form_btncancelar.png); color:#fff;width:202px;height:40px; font-size:14px"  />
            <?php  } else {  ?>
            <input type="button" onclick="javascript:cancelarformulario();" name="btncancelar" id="btncancelar" value=""  style="background-image:url(../../iconos/form_btncancelar.png); color:#fff;width:202px;height:40px; font-size:14px"  />
            <?php  } ?></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
 
</body>
</html>