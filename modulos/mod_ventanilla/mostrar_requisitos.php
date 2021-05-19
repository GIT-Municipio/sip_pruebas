 <?php

require_once('../../clases/conexion.php');
	
$sqllosrequs="select nombre_proceso from  tble_proc_proceso where  id='".$_GET["mvpr"]."' "; 
$consulplan=pg_query($conn,$sqllosrequs);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO</title>
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
		background-color:#EEE;
		color:#000;
		font-size:12px;
		padding:0.2em;
		
	}
	
.estilocampos {
	
	font-size:12px;
}
body {
	background-color: #eaeeef;
	font-family:Arial, Helvetica, sans-serif;
}
 
    #opselbtn
    {
		background-color:#000;
        background:url(../../iconos/btnseleccionarno.png) no-repeat;
    }
	
	#opselbtn:hover
    {
        background-image:url(../../iconos/btnseleccionarsi.png);
    }
	
	#subtabfilainfo{
        text-align:  left;
        width: auto;
       /* border: 1px #a8a8a8 solid;*/
		border-color:#99d6fd;
    }
	
	#subtabfilaprim{
        background-color:#afdefc;
		
        text-align:  left;
		font-size:12px; 
		border-color:#dcddde;
    }
	
	 #subtabfilaseg{
        background-color:#e9f6ff; 
		font-size:12px; 
		text-align:  left;
		border-color:#99d6fd;
    }
	
	#subtablacamposheader
    {
       /* background: #157fcc -webkit-gradient(linear, left top, left bottom, from(rgba(255,255,255,0.8)), to(rgba(255,255,255,0)));*/
	   background-image:url(../../iconos/encabezadotablas.png);
		height: 30px;
		font-size:12px; 
		color:#FFF;
		vertical-align: middle;
		 line-height: normal;
		 border-color:#99d6fd;
		 text-align: center;
    }
	/*
	#mostrarconsulta
	{   
	    height: 100px;
		overflow-y: scroll;
	}
   */
</style>



</head>

<body topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <div style="width:100%; height: 40px; background-color:#323639; color:#FFF; text-align: center;vertical-align: middle; " align="center">
        <table width="100%" border="0" height="40">
          <tr>
            <td align="center"><?php if($_GET["mvpr"]!=0)
	   { echo strtoupper(pg_fetch_result($consulplan,0,"nombre_proceso"));  }?></td>
            </tr>
          </table>
        </div>
      
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="28%" valign="top" bgcolor="#525659" align="center">
            <div style="width:90%; background-color:#FFC; font-size:11px">
              <table border="0">
                <tr>
                  <td colspan="2" align="center"><font color="#FF0000" size="3"><b>REQUISITOS</b></font></td>
                  </tr>
                <?php
		
     if($_GET["mvpr"]==0)
	   {
		   echo "<tr>";
		   echo "<td><font color='#0000FF' size='3'>NO APLICA REQUISITOS</font></td>";
		   echo "<td>&nbsp;</td>";
            echo "<tr>";
		   
		   }
	 else
	 {
     	 $sqllosrequs="select id,codigo_requis,descripcion_requisito from  tblh_cr_catalogo_requisitos where  ref_proceso='".$_GET["mvpr"]."' and activo=1 order by codigo_requis;"; 
		$consveresqus=pg_query($conn,$sqllosrequs);
		$vertamreqs=pg_num_rows($consveresqus); 
       
       for($rq=0;$rq<$vertamreqs;$rq++)
	   {
		   echo "<tr>";
		   echo "<td><font color='#FF0000'>".pg_fetch_result($consveresqus,$rq,"codigo_requis")."</font></td>";
		   echo "<td>".pg_fetch_result($consveresqus,$rq,"descripcion_requisito")."</td>";
            echo "<tr>";
	   }
	   
	 }
	?>
                </table>
              <div id="mostrarconsulta"></div>
              </div>
            
            </td>
          </tr>
        <tr>
          <td valign="bottom" bgcolor="#525659">&nbsp;</td>
          </tr>
         <?php
          $sqllosreqcc="select id from tbli_esq_plant_form_cuadro_clasif where ref_id_proceso='".$_GET["mvpr"]."'"; 
		  $consveresquscc=pg_query($conn,$sqllosreqcc);
		  $codcuad=pg_fetch_result($consveresquscc,0,"id");
		  
		   $sqllosreqcc="select count(*) from tbli_esq_plant_form_plantilla where ref_clasif_doc='".$codcuad."'"; 
		  $consveresquscc=pg_query($conn,$sqllosreqcc);
		  $codtadorppka=pg_fetch_result($consveresquscc,00);
		  if($codtadorppka!=0)
		  {
		   $sqllosreqcc="select id from tbli_esq_plant_form_plantilla where ref_clasif_doc='".$codcuad."'"; 
		  $consveresquscc=pg_query($conn,$sqllosreqcc);
		  $codplantilla=pg_fetch_result($consveresquscc,0,"id");
		  
		  
		  echo  '<tr>
          <td valign="bottom" bgcolor="#525659" align="center"><a href="../mod_forms/form_vista.php?rp='.$codplantilla.'"><img src="images/form_btnformu.png" width="202" height="44" /></a></td>
          </tr>';
		  
		  }
		 
		 ?>
      </table>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
        <tr>
          <td valign="bottom" bgcolor="#525659">&nbsp;</td>
          </tr>
      </table>
      
      
      
      
      </td>
  </tr>
  
  
  </table>



</body>
</html>