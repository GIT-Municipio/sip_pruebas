<?php
session_start();
$_SESSION["tramclicontardocscan"]=0;
///////////
$_SESSION["tramescaneadosx"]="";
$_SESSION["tramescaneacontar"]=0;
/////////


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
		
		ajax.open("POST", "../conswebserv/serv_oracle_unempadronado_ciu.php");
        divFormulario.innerHTML = '<img src="../../iconos/anim.gif">';
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //mostrar resultados en esta capa
				divFormulario.innerHTML = "";
                ////aqui codigo para llenar automaticamente los campos deseados
				///reiniciar valores
				//alert(ajax.responseText);
				var str = ajax.responseText;
				var res = str.split("@");
				
				var auxciu=res[0];
				var auxapel=res[1];
				var auxnom=res[2];
				var auxadir=res[3];
				var auxtelf=res[4];
				var auxmail=res[5];
				//alert(ajax.responseText);
				document.getElementById('mivardarmeciu').value=auxciu;
				document.getElementById('mivardarmeciu').focus();
				document.getElementById('campo_1').value=auxapel;
				document.getElementById('campo_1').focus();
				document.getElementById('campo_2').value=auxnom;
				document.getElementById('campo_2').focus();
				document.getElementById('campo_3').value=auxadir;
				document.getElementById('campo_3').focus();
				document.getElementById('campo_4').value=auxtelf;
				document.getElementById('campo_4').focus();
				document.getElementById('campo_5').value=auxmail;
				document.getElementById('campo_5').focus();
				
                //document.getElementById('usr_depe').focus();
            }
        }
        //como hacemos uso del metodo POST
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("idemp=" + datent+"&idrefcampo=" + varcampobusq + "&refcamporel=" + totcampos + "&reftablarel=" + vartabla)
    }

	//////////////////////////
	function porcambiotabla(camporeqtorn, varlorret, valorbusq, varcampobuscar, totcampos, vartabla) {
        //alert(valorbusq);
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
       
		ajax.open("POST", "../conswebserv/serv_oracle_empadronados_ciu.php");
        divFormulario.innerHTML = '<img src="../../iconos/anim.gif">';
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
require_once '../../clases/conexion.php';
$idprintramite=$_GET["mvpr"];

//$idprintramite=1;
$sqlplan="select *from vista_presentaplantilla where id='".$idprintramite."'";
$consulplan=pg_query($conn,$sqlplan);
$vertaman=pg_num_rows($consulplan); 


/////// consultar tabla------------////
$vrdatableret=pg_fetch_result($consulplan,0,"nombre_tablabdd");
////////////////////codigo barras
//////preguntar si existe almenos 1
 $sqlcdb = "select codbarras_actual from tbli_esq_plantilla where nombre_tablabdd='".$vrdatableret."' ";;
$resultcdbarrs = pg_query($conn, $sqlcdb);
$compvernumsecucodb=pg_fetch_result($resultcdbarrs,0,0);
$csecucodbarras=$compvernumsecucodb+1;



$sqlgrupoetiq="SELECT distinct(ref_grupoc), titulo_grupo, orden_grupo FROM vista_presentaplantilla where id='".$idprintramite."' order by orden_grupo";
$consulplantitleq=pg_query($conn,$sqlgrupoetiq);
$vertamangrupetiq=pg_num_rows($consulplantitleq); 

$sqlplanimg="select inst_logo FROM institucion where inst_codi=3";
$consulplanimg=pg_query($conn,$sqlplanimg);
$verimgloginst=pg_fetch_result($consulplanimg,0,"inst_logo")

?>
<form id="formCiudadano" name="formCiudadano" method="post" action="guardarinfo_plan.php">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <div style="width:100%; height: 40px; background-color:#323639; color:#FFF; text-align: center;vertical-align: middle; " align="center">
        <table width="100%" border="0" height="40">
          <tr>
            <td align="center"><?php echo substr(pg_fetch_result($consulplan,0,"nombre_plantilla"),0,80); ?></td>
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
     	$sqllosrequs="select id,codigo_requis,descripcion_requisito from  tblh_cr_catalogo_requisitos where  ref_proceso='".pg_fetch_result($consulplan,0,"refer_procesoid")."' order by codigo_requis;"; 
		$consveresqus=pg_query($conn,$sqllosrequs);
		$vertamreqs=pg_num_rows($consveresqus); 
       
       for($rq=0;$rq<$vertamreqs;$rq++)
	   {
		   echo "<tr>";
		   echo "<td><font color='#FF0000'>".pg_fetch_result($consveresqus,$rq,"codigo_requis")."</font></td>";
		   echo "<td>".pg_fetch_result($consveresqus,$rq,"descripcion_requisito")."</td>";
            echo "<tr>";
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
        </table>
      
      
      
      
      </td>
  </tr>
  
  
  </table>





</form>


</body>
</html>