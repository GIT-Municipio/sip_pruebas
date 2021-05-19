
<?php require ("class_cabildo.php");

global $miconexion;
$miconexion = new DB_mysql ; 
global $miconexion;
$ip =  $miconexion->xml_ip();
$base =  $miconexion->xml_base();
$user =  $miconexion->xml_user();
$psw =  $miconexion->xml_psw();

$conexion = $miconexion->conectar($base,$ip,$user,$psw); 
?>
<?php


$ip = $_SERVER['REMOTE_ADDR'];   

@$dia = date('d'); 
@$mes = date('M'); 
@$anio = date('Y');





$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and mes like '%".$mes."%' and dia like '%".$dia."%' and anio =".$anio; 


$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$d=0;
while($row = oci_fetch_array ($Q))
{
$d = $d +1;

}






$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and mes like '%".$mes."%' and  anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$m=0;
while($row = oci_fetch_array ($Q))
{
$m = $m +1;

}





$sql="SELECT * FROM contador WHERE ip like '%".$ip."%' and anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$a=0;
while($row = oci_fetch_array ($Q))
{
$a = $a +1;

}



$sql="SELECT * FROM contador"; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$t=0;
while($row = oci_fetch_array ($Q))
{
$t = $t +1;

}

$sql="SELECT * FROM contador WHERE mes like '%".$mes."%' and dia like '%".$dia."%' and anio =".$anio; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$td=0;
while($row = oci_fetch_array ($Q))
{
$td = $td +1;

}

$sql="SELECT * FROM contador"; 

$Q = oci_parse($conexion, $sql);
oci_execute($Q, OCI_DEFAULT);
$t=0;
while($row = oci_fetch_array ($Q))
{
$t = $t +1;

}
//TOCA SACAR FECHA ACTUAL
/*@$dia = 27; 
@$mes=06;
@$anio=2019;
*/

@$dia1 = date('d'); 
@$mes1 = date('m'); 
@$anio1 = date('Y');

$sql = 'insert into  CONTADOR ( id , ip ,  dia, mes, anio) values    
								   ( :vid , :vip, :vdia, :vmes, :vanio ) ' ;
												
			
					$stid =  $miconexion->prepara_insertar( $sql);
					$sec =  $miconexion->_secuencia('SE_CONTADOR_WEB');
					
					 oci_bind_by_name ( $stid ,  ':vid' ,$sec ); 
					 oci_bind_by_name ( $stid ,  ':vip' ,$ip); 	
					 oci_bind_by_name ( $stid , ':vdia' ,$dia1);
					  oci_bind_by_name ( $stid , ':vmes' ,$mes1); 	 
					  oci_bind_by_name ( $stid , ':vanio' ,$anio1); 	 	
					
					$miconexion->inserta($stid);


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<title>.: Sistema de Gestion Ciudadano :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="scripts/jquery.hoverIntent.js"></script>
<script type="text/javascript" src="scripts/jquery.hslides.1.0.js"></script>
<script type="text/javascript" src="scripts/jquery.hslides.setup.js"></script>
<style type="text/css">
body {
	background-color: #FFF;
	background-image: url(images/fondo_ciudadano.jpg);
	background-repeat: no-repeat;
}
#apDiv1 {
	position:absolute;
	width:200px;
	height:72px;
	z-index:1;
	left: 85px;
	top: 839px;
}
#apDiv2 {
	position:absolute;
	width:278px;
	height:115px;
	z-index:2;
	left: 587px;
	top: 675px;
}
#apDiv3 {
	position:absolute;
	width:59px;
	height:18px;
	z-index:2;
	left: 219px;
	top: 612px;
	color: #069;
}
#apDiv4 {
	position:absolute;
	width:61px;
	height:53px;
	z-index:3;
	left: 604px;
	top: 630px;
}
</style>
</head>
<body id="top">
<div id="header">
  <div class="wrapper">
    <div class="fl_left">
      <h1><a href="#"> <img src="images/En.png" alt="en linea" width="148" height="42" border="0" /></a></h1>
      <p>Sistema de Informaci&oacute;n Ciudadano</p>
    </div>
    <div class="fl_right">
      <h1><a href="#"><img src="images/demo/468x60.jpg" alt="" /></a></h1>
</div>
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="topbar">
  <div class="wrapper">
    <div id="topnav">
     
    </div>
 
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="featured_slide">
  <div class="wrapper">
    <div class="featured_content">
      <ul id="accordion">
        <li class="current">
          <div class="featured_box" >
            <h2>1. Estado de Cuenta</h2>
            <p>Atenci&oacute;n oportuna y automatizada, la informaci&oacute;n al dia de todas las obligaciones con la municipalidad.</p>
            <p class="readmore"><a href="web_deuda_cuenta.php" ><img src="images/dinero.png" alt="estado de cuenta" width="320" height="90" border="0" align="right" /></a></p>
          </div>
          <div class="featured_tab"> <img src="images/demo/deuda.jpg" alt="" />
       
          </div>
        </li>
        <li>
          <div class="featured_box">
            <h2>2. Títulos de Crédito</h2>
            <p> También ponemos a disposición de la Ciudadanía la descarga del Título de Crédito Digital.
              </p>
               <p class="readmore"><a href="web_pago_cuenta.php" ><img src="images/titulocredito.png" alt="Titulo de Credito" width="300" height="90" border="0" align="right" /></a></p>                        
          </div>
          <div class="featured_tab"><img src="images/demo/catastro.jpg" alt="" width="100" /></div>
        </li>
        <li>
          <div class="featured_box">
            <h2>3. Busqueda de Tr&aacute;mites</h2>
            <p>Revise el estado de su tr&aacute;mite dentro de la institucion, un servicio de la municipalidad hacia la comunidad</p>
                          <p class="readmore"><a href="web_tramites.php" ><img src="images/tramitesonline.png" alt="Busqueda de Tramites" width="320" height="90" border="0" align="right" /></a></p>
          </div>
          <div class="featured_tab"><img src="images/demo/tramite.jpg" alt="" />
            <p>Tabbed Navigation 3</p>
          </div>
        </li>
        <li>
          <div class="featured_box">
            <h2>4. Seguimiento de Obras</h2>
            <p>La informacion que se ha incluido dentro de esta p&aacute;gina proporcionan datos a diversos de las obras de gestion de la municipalidad de car&aacute;cter general.</p>
                          <p class="readmore"><a href="web_obras.php" ><img src="images/obra.png" alt="Obra Publica" width="320" height="90" border="0" align="right" /></a></p>
          </div>
          <div class="featured_tab"><img src="images/demo/obra.jpg" alt="" />
            <p>Tabbed Navigation4</p>
          </div>
        </li>
        <li>
          <div class="featured_box">
            <h2>5. Guia de Tr&aacute;mites</h2>
            <p>El Objetivo de la Gu&iacute;a es brindar al ciudadano informaci&oacute;n sobre los pasos a seguir y los requisitos necesarios para realizar tr&aacute;mites ante la Administraci&oacute;n Municipal</p>
          <p class="readmore"><a href="web_guia_tramites.php" ><img src="images/guia.png" alt="Informacion Tramites" width="320" height="90" border="0" align="right" /></a></p>  </div>
          <div class="featured_tab"><img src="images/demo/guia.jpg" alt="" />
            <p>Tabbed Navigation 5</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="homecontent">
  <div class="wrapper">
    <ul>
      <li>
        <h2 class="title"><a href="web_deuda_cuenta.php">Estado de Cuenta del Contribuyente</a></h2>
        <p>Con el objetivo de ofrecer cada d&iacute;a un mejor servicio, y sobre todo mayor eficiencia, el Gobierno Municipal brinda a la comunidad su Estado de Cuenta desde la Web...</p>
      </li>
      <li>
        <h2 class="title"><a href="web_predio.php"> Informacion Predial del Contribuyente</a></h2>
        <p>El impuesto predial es un tributo que grava  los inmuebles que se encuentran ubicados en el Cant&oacute;n. Los propietarios, poseedores o usufructuarios lo deben  pagar una vez al a&ntilde;o.</p>
      </li>
      <li class="last">
        <h2 class="title"><a href="web_actividad_comercial.php">Actividades Comerciales del Cant&oacute;n</a></h2>
        <p>La patente municipal se lo establece para personas naturales, jur&iacute;dicas, sociedades nacionales o extranjeras domiciliadas o con establecimiento en el Canton, que ejerzan permanentemente actividades comerciales, industriales, financieras, inmobiliarias y profesionales</p>
      </li>
    </ul>
    <p><br class="clear" />
    </p>
 
  </div>
</div>

<div id="homecontent">
  <div class="wrapper">
    <ul>
      <li>
        <h2 class="title"><a href="#">Visitas</a></h2>
       

<img src="images/ip.png" width="42" height="42" alt="i" title="IP" /><?php echo $ip; ?>

<p>Total de vistas hoy: <?php echo $td; ?></p>
<p>Historial de visitas: <?php echo $t; ?></p>


      </li>
      <li>
        <h2 class="title"><a href="web_predio.php"> Blog de comentarios</a></h2>
        <a href="blog.php" ><img src="images/blog.jpg" alt="bg" width="56" height="47"  align="left" /></a>
        <p>Dejanos tus comentarios, sobre las actividades del municipio.</p>
      </li>
      
    </ul>
    <p><br class="clear" />
    </p>
  </div>
</div>


<!-- ####################################################################################################### --><!-- ####################################################################################################### -->
<div id="footer">
  <div class="wrapper">
 
  </div>
</div>
<!-- ####################################################################################################### -->
<div id="copyright">
  <div class="wrapper">
    <p class="fl_left">Copyright &copy; 2012 - All Rights Reserved - <a href="#">Prishard</a> Cia.Ltda</p>
    <p class="fl_right">GAD Municipio de Santa Ana de Cotacachi<a href="http://www.os-templates.com/" title="Open Source Templates"></a></p>
    <br class="clear" />
  </div>
</div>
</body>
</html>
