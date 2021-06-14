<?php
session_start();
//-------------------------------
header("Refresh: 1210");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 1200; //20min.

	//Calculamos tiempo de vida inactivo.
	$vida_session = time() - $_SESSION['tiempo'];

	//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
	if ($vida_session > $inactivo) {
		//Removemos sesión.
		session_unset();
		//Destruimos sesión.
		session_destroy();
		//Redirigimos pagina.
		header("location: http://localhost/sip_pruebas/404/404.html");
		exit();
	}
}
$_SESSION['tiempo'] = time();
//---------------------
$_SESSION["tramclicontardocscan"]=0;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO</title>
<style type="text/css">
.estilocampos {
	
	font-size:12px;
}
body {
	background-color: #FFF;
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
</style>

<style type="text/css">
 
    #opselbtn
    {
		background-color:#000;
        background:url(../public/images/btnseleccionarno.png) no-repeat;
    }
	
	#opselbtn:hover
    {
        background-image:url(../public/images/btnseleccionarsi.png);
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
	   background-image:url(../public/images/encabezadotablas.png);
		height: 30px;
		font-size:12px; 
		color:#FFF;
		vertical-align: middle;
		 line-height: normal;
		 border-color:#99d6fd;
		 text-align: center;
    }
	
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
	/*
	#mostrarconsulta
	{   
	    height: 100px;
		overflow-y: scroll;
	}
   */
</style>

<script type="text/javascript">

   ///////////////////////////////////////////////////mi codigo
	 var mosmiobjetpublic = null;
	var divmiobjetpublic = null;

    function objetoAjax() {
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }

        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
	

function validarFormupararequ()
{
	var verifcedula=document.getElementById('campo_0').value;
	var verifapelli=document.getElementById('campo_1').value;
	
	if(verifcedula.length>3)
	{
		if(verifapelli.length>3)
	    {
		//document.location.href="form_requisitos.php";
		    document.getElementById('formCiudadano').submit();
		}
		else
		alert("Los campos (*) son requeridos");
		
	}
	else
	{
		alert("Los campos (*) son requeridos");
	}
}


function abrirGeovisor()
{
	 var popupgeomap;
        popupgeomap = window.open("../gesmapsgeo/listarbol_mapas.php", "mostrargeomapsvisor", "width=700,height=570,scrollbars=no");
        popupgeomap.focus();
}


function cancelarformulario()
{
	window.close();
}

function cancelarformulinter()
{
	document.location.href="/sip/gap/index.php?r=TbliEsqPlantilla/index&varenvgestor=1";
}

 
		/////////////////////////////
		function cerrarConsultatab()
		{
		    document.getElementById('mostrarconsulta').style.visibility = "hidden";
		}
	/////////////////////////////
		function typewrite(element,text,delay) {
		alert("Hola");
		//aux = document.getElementById(element).innerHTML;
		aux = document.getElementById(element).value;
		aux = aux.concat(text.charAt(0));
		//document.getElementById(element).innerHTML = aux;
		document.getElementById(element).value = aux;

		// Esperar "delay" milisegundos para la próxima tecla
		if (text.length > 1) {
			// Eliminar la tecla actual
			text = text.substr(1);
			setTimeout(typewrite,delay,element,text,delay);
			}
    }
      //////////////////////////////
	//////////////////////////
	   function ponerdatos(miobjpublicver,varcampobusq, totcampos, vartabla) {
        //donde se mostrará el formulario con los datos
        divFormulario = document.getElementById('mostrarconsulta');
        var datent = miobjpublicver.value;
		//alert("Usuario: "+datent);
		//alert(varcampobusq);
		//alert(totcampos);
		//alert(vartabla);
        //instanciamos el objetoAjax
        ajax = objetoAjax();
        //uso del medotod POST
		
		ajax.open("POST", "../conswebserv/serv_oracle_undatpersona.php");
        divFormulario.innerHTML = '<img src="../public/images/anim.gif">';
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //mostrar resultados en esta capa
				divFormulario.innerHTML = "";
                ////aqui codigo para llenar automaticamente los campos deseados
				///reiniciar valores
				var str = ajax.responseText;
				var res = str.split("@");
				var auxnom=res[0];
				var auxapel=res[1];
				//alert(ajax.responseText);
				document.getElementById('usr_nombre').value=auxnom;
				document.getElementById('usr_nombre').focus();
				document.getElementById('usr_apellido').value=auxapel;
				document.getElementById('usr_apellido').focus();
                document.getElementById('usr_depe').focus();
            }
        }
        //como hacemos uso del metodo POST
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("idemp=" + datent+"&idrefcampo=" + varcampobusq + "&refcamporel=" + totcampos + "&reftablarel=" + vartabla)
    }

	//////////////////////////
	function porcambiotabla(camporeqtorn, varlorret, valorbusq, varcampobuscar, totcampos, vartabla) {
       // alert(valorbusq);
//////se oculta la ayuda de informacion
        document.getElementById('mostrarconsulta').style.visibility = "hidden";
/////se asigna la informacion
        document.getElementById(camporeqtorn).value = varlorret;
        mosmiobjetpublic.value = valorbusq;
///se coloca la informacion en campos especificos
        ponerdatos(mosmiobjetpublic,varcampobuscar, totcampos, vartabla);
    }
	/////////////////////////////
	function consultardatos(retmiobjeto, refcomponent, tablarel, reftxtcampohidden, camporel, vardivmostrar) {
        //donde se mostrará el formulario con los datos
		//alert(retmiobjeto);alert(refcomponent);alert(reftxtcampohidden);alert(vardivmostrar);
        //alert(tablarel);alert(camporel);
	   
		divmiobjetpublic=vardivmostrar;
		
        var ie = document.all;
        var dom = document.getElementById;
        divFormulario = document.getElementById('mostrarconsulta');
        divFormulario.style.visibility = (dom || ie) ? "visible" : "show";

        mosmiobjetpublic = retmiobjeto;
        var varelemenforminput = mosmiobjetpublic;
        var datoentrante = varelemenforminput.value;
        ///////////////obtencion de la posicion del input
        var squareRect = varelemenforminput.getBoundingClientRect();
        var obtpostop = squareRect.top;
        var obtposleft = squareRect.left;

        //alert(datoentrante);
        //instanciamos el objetoAjax
        ajax = objetoAjax();
        //uso del medotod POST
       
		ajax.open("POST", "../conswebserv/serv_oracle_datpredios_forms.php");
        divFormulario.innerHTML = '<img src="../..//iconos/anim.gif">';
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //mostrar resultados en esta capa
                divFormulario.innerHTML = ajax.responseText;
                divFormulario.style.display = "block";
                divFormulario.style.position = "absolute";
                divFormulario.style.top = obtpostop + 25 + "px";
                divFormulario.style.left = obtposleft + "px";
            }
        }
        //como hacemos uso del metodo POST
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("idemp=" + datoentrante + "&refcomponpcion=" + refcomponent + "&reftablarel=" + tablarel + "&reftxthidden=" + reftxtcampohidden + "&refcamporel=" + camporel)
    }
	
  ///////////////////////////////////////////////////mi codigo faus/////////////////////////////////////////
</script>

</head>

<body topmargin="0" leftmargin="0" rightmargin="0">

<?php
require_once 'clases/conexion.php';
$idprintramite=$_GET["mvpr"];

//$idprintramite=1;
$sqlplan="select *from vista_presentaplantilla where id='".$idprintramite."'";
$consulplan=pg_query($conn,$sqlplan);
$vertaman=pg_num_rows($consulplan); 


/////// consultar tabla------------////
$vrdatableret=pg_fetch_result($consulplan,0,"nombre_tablabdd");
////////////////////codigo barras



$sqlgrupoetiq="SELECT distinct(ref_grupoc), titulo_grupo, orden_grupo FROM vista_presentaplantilla where id='".$idprintramite."' order by orden_grupo";
$consulplantitleq=pg_query($conn,$sqlgrupoetiq);
$vertamangrupetiq=pg_num_rows($consulplantitleq); 

?>
<form id="formCiudadano" name="formCiudadano" method="post" action="guardarinfo_plan.php">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <table width="409" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr>
		    <td width="209">&nbsp;</td>
		    <td width="200">&nbsp;</td>
	      </tr>
	</table>
</td>
  </tr>
  <tr>
    <td>
    
   
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="72%" align="center" bgcolor="#FFFFFF">
      
      
   
        
        <table width="100%" border="0" align="center" class="estiloformulario" bordercolor="#333333">
          <tr>
            <td bgcolor="#FFFFFF"><table width="100%" border="0">
              <tr>
                <td>
                <fieldset>
                <table width="100%" border="0" align="center">
                  <tr>
                    <td align="center"><img src="imgs/encabezpatrimo.png" width="643" height="94" /></td>
                  </tr>
                  <tr>
                    <td align="center"><font color="#000" size="3"><?php echo pg_fetch_result($consulplan,0,"nombre_plantilla"); ?></font></td>
                  </tr>
                  <tr>
                    <td align="center"><font color="#000" size="3">FICHA DE REGISTRO</font></td>
                  </tr>
                </table>
                </fieldset>
                
                
                </td>
                </tr>
              <tr>
                <td align="left">
                <fieldset><legend>DATOS DE IDENTIFICACIÓN</legend>
                <?php
                  $vrdatableretpla="plantillasform.".$vrdatableret;
				 $sqlplanfich="select *from ".$vrdatableretpla;
				$consulplanfich=pg_query($conn,$sqlplanfich);
				$vertamanfichfield=pg_num_fields($consulplanfich); 
				echo "<table>";
				
				
		        for($fic=2;$fic<5; $fic++) {
					echo "<tr>";
					echo "<td  id='conten_campos' >".strtoupper(pg_field_name($consulplanfich,$fic))."<font color='#FF0000' size='2' face='Arial, Gadget, sans-serif'> (*)</font>"."</td>";
					echo "<td><input type='text' name='".pg_field_name($consulplanfich,$fic)."' id='".pg_field_name($consulplanfich,$fic)."' /></td>";	
                    $fic++;		
					if($fic<9)
					{
					echo "<td  id='conten_campos' >".strtoupper(pg_field_name($consulplanfich,$fic))."<font color='#FF0000' size='2' face='Arial, Gadget, sans-serif'> (*)</font>"."</td>";
					echo "<td><input type='text' name='".pg_field_name($consulplanfich,$fic)."' id='".pg_field_name($consulplanfich,$fic)."' /></td>";			
					}
					echo "</tr>";
				}
				echo "</table>";
				
				?>
                </fieldset>
                
                &nbsp;</td>
              </tr>
              <tr>
                <td align="center"><font color="#003366" size="5"><?php // echo pg_fetch_result($consulplan,0,"nombre_tramite"); ?></font><input type="hidden"  name="mivarnomtablaesq" id="mivarnomtablaesq" value="<?php echo $vrdatableret; ?>"  /><input type="hidden"  name="mivaridplantillaesq" id="mivaridplantillaesq" value="<?php echo $idprintramite; ?>"  /></td>
                </tr>
              <tr>
                <td align="center">&nbsp;</td>
                </tr>
              <?php //////////////////////////////////////////////////  ?>      
              
              <?php for($fil=1;$fil<$vertamangrupetiq; $fil++) {  ?>
              <tr>
                <td>    
                  <fieldset><legend><?php echo pg_fetch_result($consulplantitleq,$fil,"titulo_grupo"); ?></legend>             
                    <table width="100%" border="0">
                      <?php
          $sqlplan="select *from vista_presentaplantilla where  ref_grupoc = '".pg_fetch_result($consulplantitleq,$fil,"ref_grupoc")."' and id='".$idprintramite."'";
          $consulplang1=pg_query($conn,$sqlplan);
		  
		  for($i=0;$i<pg_num_rows($consulplang1);$i++)
		  {
////////////////////////////////////////////////////////////////////
			 if(pg_fetch_result($consulplang1,$i,"nro_columnas")==1)
			 {
			//////////////////////////////////activo	 
			 if(pg_fetch_result($consulplang1,$i,"campo_activo")=='t')
			 {
				 
			 echo  "<tr>";
			 if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {
			  echo  "<td  id='conten_campos' ><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."<font color='#FF0000' face='Arial Black, Gadget, sans-serif'>(*)</font></span></td>";
			 }else{
			 echo  "<td  id='conten_campos' ><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."</span></td>";
			 }
			 
			 if(pg_fetch_result($consulplang1,$i,"campo_referenciado")=="t")
			 		{
						
				       if(pg_fetch_result($consulplang1,$i,"campo_nombre")=="CLAVE CATASTRAL")
					   {
					echo "<td  id='conten_campos' ><input type='text' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."'   onKeyUp=".'"'."javascript:consultardatos(this, 'tabla', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', 'CEDULA,CEDULA,CIU,CEDULA,CLAVE,NOMBRE','verconsulmdatossel')".'"'." autocomplete='off' style='width: 90%' ><a href='#' onclick='javascript:abrirGeovisor()' ><img src='../public/images/icon_mapsgeo.png' width='20' height='20' /></a></td></tr>";
					   }else{
					
					
					echo "<td  id='conten_campos' ><input type='text' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."'   onKeyUp=".'"'."javascript:consultardatos(this, 'tabla', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', 'CEDULA,CEDULA,CIU,CEDULA,CLAVE,NOMBRE','verconsulmdatossel')".'"'." autocomplete='off' style='width: 100%' ></td></tr>";
					   }
							
			 		}else{
						if(pg_fetch_result($consulplang1,$i,"ref_tcamp")==5)
						 {
						echo "<td><input type='checkbox' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' onfocus='javascript:cerrarConsultatab()'  /></td>";
						 }
						 else
						 {
					
			if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {	
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 100%' required  title='Este campo es requerido'  /></td>";
			 }
			 else
			  {	
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 100%' /></td>";
			 }
						 
							
						 }
				  
					 	}
				echo  "</tr>"; 
				//////////fin de if activo
			 }
			 }
 ////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
			 if(pg_fetch_result($consulplang1,$i,"nro_columnas")==2)
			 {
			 //////////////////////////////////activo	 
			 if(pg_fetch_result($consulplang1,$i,"campo_activo")=='t')
			 {
			 echo  "<tr>";
			 
			  if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {
			      echo  "<td  id='conten_campos'><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."<font color='#FF0000' size='2' face='Arial, Gadget, sans-serif'> (*)</font>"."</span></td>";
			 }
			 else
			 {
			      echo  "<td  id='conten_campos'><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."</span></td>";
			 }
			 
			 		if(pg_fetch_result($consulplang1,$i,"campo_referenciado")=="t")
			 		{ 
			    		echo "<td><input type='text' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' size='30'  onKeyUp=".'"'."javascript:consultardatos(this, 'tabla', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', 'CEDULA,CEDULA,CIU,CEDULA,CLAVE,NOMBRE','verconsulmdatossel')".'"'." autocomplete='off' style='width: 150px' ></td></tr>";
				
			 		}else{
						
				         if(pg_fetch_result($consulplang1,$i,"ref_tcamp")==5)
						 {
						echo "<td><input type='checkbox' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' onfocus='javascript:cerrarConsultatab()'  /></td>";
						 }
						 else
						 {
							 if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {	
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 150px' required  /></td>";
			 }
			 else
			 {	
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 150px'   /></td>";
			 }
						 }
				  
					 }
					 ////////////////////
				 $i++;
				 if($i<pg_num_rows($consulplang1))
				 {
				///////////////////////////
				 if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {
				echo  "<td  id='conten_campos'><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."<font color='#FF0000' size='2' face='Arial, Gadget, sans-serif'> (*)</font>"."</span></td>";
			 }
				else
				{
				echo  "<td  id='conten_campos'><span class='estilocampos'>".pg_fetch_result($consulplang1,$i,"campo_nombre")."</span></td>";
			 }
			 
			 		if(pg_fetch_result($consulplang1,$i,"campo_referenciado")=="t")
			 		{ 
			    		echo "<td><input type='text' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' size='30'  onKeyUp=".'"'."javascript:consultardatos(this, 'tabla', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', '".pg_fetch_result($consulplang1,$i,"campo_creado")."', 'CEDULA,CEDULA,CIU,CEDULA,CLAVE,NOMBRE','verconsulmdatossel')".'"'." autocomplete='off' style='width: 150px' ></td></tr>";
				
			 		}else{
				           
						 if(pg_fetch_result($consulplang1,$i,"ref_tcamp")==5)
						 {
						echo "<td><input type='checkbox' name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' /></td>";
						 }
						 else
						 {
							 ///////////////////////////
				 if(pg_fetch_result($consulplang1,$i,"campo_requerido")=='t')
			 {
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 150px' required  /></td>";
			 }
			 else
			  {
				 		 echo  "<td><input name='".pg_fetch_result($consulplang1,$i,"campo_creado")."' type='text' id='".pg_fetch_result($consulplang1,$i,"campo_creado")."' value='' style='width: 150px'  /></td>";
			 }
			 
						 }
					 }
					 /////////////////////////////////	 
				 }
					 
					  
				echo  "</tr>"; 
			 }///fin de if
			 }
 ////////////////////////////////////////////////////////////////////
 
			 
			 /////////////////////////fin de if
		   } ////////////fin de for
		  ?>
                      
                      </table>
                    </fieldset>
                  </td>
                </tr>
              <?php }  ?>
              
              <?php //////////////////////////////////////////////////  ?>  
              
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
        
        
       
      
      
    </td>
  </tr>
  </table>

    
  
    
    </td>
  </tr>
  
  
  <tr>
        <td bgcolor="#FFFFFF" ><table width="400" border="0" align="right">
          <tr>
              <td width="240" align="center"><input type="submit" name="btnenviar" id="btnenviar" value="" style="background-image:url(../public/images/form_btnsiguiente.png); color:#fff;width:202px;height:40px; font-size:14px" /></td>
          </tr>
      </table></td>
    </tr>
  
  
</table>





</form>


</body>
</html>