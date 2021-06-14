<?php

require_once('../../clases/conexion.php');
session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
//////INICIALIZO
$_SESSION["tempoanex_mvpr"]="";
$_SESSION["tempoanex_codbarras"]="";
$_SESSION["tempoanex_codtramite"]="";
$_SESSION["tempoanex_ciudcedula"]="";
$_SESSION["tempoanex_verventan"]= 0;
$_SESSION["tempoanex_verasist"]= 0;
//////////////////////



$varcodactual="";
$vartipodocid = "4";
$vartipodocdetalle = "FE: FORMULARIO EXTERNO";
/////////////////////////////si esta en cero colocar al alcalde y su asistente
$sqlcodif = "SELECT  autoridad_cedula,delegado_cedula  FROM public.tblb_org_institucion;";
$rescodif = pg_query($conn, $sqlcodif);
$varced_responsable = pg_fetch_result($rescodif,0,'autoridad_cedula');
$varced_asistente = pg_fetch_result($rescodif,0,'delegado_cedula');


$varasig_depart = "1";
$vartramite_id = "";
$vartramite_name = "";


//////////////////GENERAR LA CODIFICACION RESPECTIVA
if(isset($_GET["myidcuadclasif"])!="")
{
/////////////////configurar codigo
$sqlcodiftram = "SELECT campo,artificio  FROM tbli_esq_plant_form_configcodift where activo=1 order by item_orden;";
$rescodiftr= pg_query($conn, $sqlcodiftram);
$misecuenciacodif="";
for($bm=0; $bm<pg_num_rows($rescodiftr); $bm++)
{
	if($bm==pg_num_rows($rescodiftr)-1)
	$misecuenciacodif.=pg_fetch_result($rescodiftr,$bm,'campo');
	else
	$misecuenciacodif.=pg_fetch_result($rescodiftr,$bm,'campo')."||'".pg_fetch_result($rescodiftr,$bm,'artificio')."'||";
}
///////////////////
	
	
	
	
$sqlcodif = "SELECT id,  ".$misecuenciacodif." as codifica_actual, detalle, numer_inicial, numer_final,ced_responsable,ced_asistente,ref_id_depart,ref_id_proceso  FROM tbli_esq_plant_form_cuadro_clasif where id='".$_GET["myidcuadclasif"]."';";
$rescodif = pg_query($conn, $sqlcodif);
$varcodactual = pg_fetch_result($rescodif,0,'codifica_actual');
/////////////////////ENVIO A USUARIOS JEFE Y ASISTENTE
if(pg_fetch_result($rescodif,0,'ced_responsable')!="")
$varced_responsable = pg_fetch_result($rescodif,0,'ced_responsable');

if(pg_fetch_result($rescodif,0,'ced_asistente')!="")
$varced_asistente = pg_fetch_result($rescodif,0,'ced_asistente');
else
{
	if($varced_asistente=="")
		$varced_asistente ="";
}

if((pg_fetch_result($rescodif,0,'ced_responsable')!="") && (pg_fetch_result($rescodif,0,'ced_asistente')==""))
{
$varced_responsable = pg_fetch_result($rescodif,0,'ced_responsable');
$varced_asistente = "";
}

if(pg_fetch_result($rescodif,0,'ref_id_depart')!="")
$varasig_depart = pg_fetch_result($rescodif,0,'ref_id_depart');

if(pg_fetch_result($rescodif,0,'id')!="")
$vartramite_id = pg_fetch_result($rescodif,0,'id');
if(pg_fetch_result($rescodif,0,'detalle')!="")
{
$vartramite_name = pg_fetch_result($rescodif,0,'detalle');
$vartramite_asuntosolic = "Solicitar el Trámite: ".pg_fetch_result($rescodif,0,'detalle');
}
if(pg_fetch_result($rescodif,0,'ref_id_proceso')!="")
$vartram_procesoid = pg_fetch_result($rescodif,0,'ref_id_proceso');


////////////////////consultar el tipo de documento
if(isset($_GET["myidtipodocum"])!="")
{
	$sqltipdoc = "SELECT id, codigo_doc||': '|| tipo as descriptipo   FROM tbli_esq_plant_formunico_tipodoc where id='".$_GET["myidtipodocum"]."';";
	$restipdoc = pg_query($conn, $sqltipdoc);
	$vartipodocid = pg_fetch_result($restipdoc,0,'id');
	$vartipodocdetalle = pg_fetch_result($restipdoc,0,'descriptipo');
}
//////////////////////////////////////////////////////



///////////////////
}

?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SIP Gestion Documental</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    

    <link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
    <script src="../../componentes/codebase/dhtmlx.js"></script>
    
    <script src="../../componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    
    <!-- 
    <link rel="stylesheet" type="text/css" href="componentes/codebase/dhtmlxgrid.css">
    <script  src="componentes/codebase/dhtmlxcommon.js"></script>
    <script  src="componentes/codebase/dhtmlxgrid.js"></script>
    <script src="componentes/codebase/ext/dhtmlxgrid_splt.js"></script>
    <script src="componentes/codebase/dhtmlxgridcell.js"></script>
    -->
    <!-- 
    <script src="componentes/codebase/ext/dhtmlxgrid_group.js"></script>
    <script  src="codebase/dhtmlxgridcell.js"></script>	
    -->
   
    <!-- nuevos estilos -->
    
   
  <!-- fin nuevos estilos -->
    <script type="text/javascript">

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
	
	//////////////////////////////////////////guardar formulario con anexos
	
	function guardarformconanexo()
	{
		var comprobclient= document.getElementById("txtnombres").value;
		if(comprobclient!="")
        {
		////////////////////////////
			var comprobarced= document.getElementById("txtcedjeferesp").value;
			document.getElementById("txtprcoconanex").value="999";
			//alert(document.getElementById("txtprcoconanex").value);
			//alert(comprobarced);
			if(comprobarced!="")
		    	document.getElementById("formnamedats").submit();
			else
			{
				dhtmlx.alert({
					title:"Mensaje Error!",
					type:"alert-error",   /////puede ser error  warning  solo alert es para normal   
					text:"Error: NO EXISTE RESPONSABLE DEL PROCESO"
				});
			}
		////////////////////////////
		}
		else
		{
			dhtmlx.alert({
				title:"Mensaje Error!",
				type:"alert-error",   /////puede ser error  warning  solo alert es para normal   
				text:"Error: CAMPOS DEL CIUDADANO ESTA VACIO"
			});
		}
		
	}
	
	
	//////////////////////////////////////////guardar formulario
	function guardarformentrada()
	{
		
		    	document.getElementById("formnamedats").submit();
			
		
	}
	
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
        divFormulario.innerHTML = '<img src="../../imgs/anim.gif">';
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                //mostrar resultados en esta capa
				divFormulario.innerHTML = "";
                ////aqui codigo para llenar automaticamente los campos deseados
				///reiniciar valores
				//alert(ajax.responseText);
				var str = ajax.responseText;
				var res = str.split("#");
				
				var auxciu=res[0];
				var auxcedu=res[1];
				var auxapel=res[2];
				var auxnom=res[3];
				var auxadir=res[4];
				var auxtelf=res[5];
				var auxmail=res[6];
				//alert(ajax.responseText);
				//document.getElementById('mivardarmeciu').value=auxciu;
				//document.getElementById('mivardarmeciu').focus();
				document.getElementById('txtciu').value=auxciu;
				document.getElementById('txtciu').focus();
				document.getElementById('txtcedula').value=auxcedu;
				document.getElementById('txtcedula').focus();
				document.getElementById('txtapellidos').value=auxapel;
				document.getElementById('txtapellidos').focus();
				document.getElementById('txtnombres').value=auxnom;
				document.getElementById('txtnombres').focus();
				document.getElementById('txtdireccion').value=auxadir;
				document.getElementById('txtdireccion').focus();
				document.getElementById('txttelefono').value=auxtelf;
				document.getElementById('txttelefono').focus();
				document.getElementById('txtmail').value=auxmail;
				document.getElementById('txtmail').focus();
				
				document.getElementById('verbusqudaxcedula').value="";
				document.getElementById('verbusqudaxciu').value="";
				document.getElementById('verbusqudaxapellidos').value="";
				
				
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
        divFormulario.innerHTML = '<img src="../../imgs/anim.gif">';
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

</script>


<style type="text/css"> 

	html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
			/*font-size: 10px;*/
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
/*
.botonClasacep
    {
        background:url(../../imgs/acepload.png) no-repeat;
    }
*/	
.botonClasacep
    {
	background:url(../../imgs/acepload.png) no-repeat;
    -webkit-border-radius: 8px;
    -webkit-border-bottom-left-radius: 8px;
    -moz-border-radius: 8px;
    -moz-border-radius-bottomleft: 8px;
    border-radius: 10px;
    border-bottom-left-radius: 10px;
    cursor: pointer;
    height: 30px;
    width: 150px;
    font-family: Verdana;
    font-size: 10px;
    font-weight: bolder;
    text-align: center;
    background-color: #FFAE4A;
    border: thin solid #AAAAAA;
    color: #000000;
	 
}

.botones {
/* este cambio los botones faus*/
	background-color: #FFAE4a;
	color: #fff;
	/*border: thin solid #aaa;*/
}

.botones_aceptar {

   /* fausoft cambio */
	/*background-color: #FFAE4a;*/
	background-image:url(../../imgs/tablogin.png);
	color: #FFFFFF;
	border: thin solid #aaa;
	box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0,0,0,.4);
	border-color:#FFF;border-radius: 10px; 
	box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0,0,0,.4);
	 cursor: pointer;
	 font-size: 11px;
    
}
.botones_anexar {

   /* fausoft cambio */
	/*background-color: #FFAE4a;*/
	background-image:url(../../imgs/btnnuevo.png);
	color: #FFFFFF;
	border: thin solid #aaa;
	box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0,0,0,.4);
	border-color:#FFF;border-radius: 10px; 
	box-shadow: 0px 2px 0px #2b638f, 0px 3px 15px rgba(0,0,0,.4);
     cursor: pointer;
	 font-size: 11px;
}
.botones_pequeno {

	background-color: #FFAE4a;
	color: #555;
	border: thin solid #aaa;
}
		
#opselbtn
    {
		background-color:#000;
        background:url(../../imgs/btnseleccionarno.png) no-repeat;
    }
	
#opselbtn:hover
    {
        background-image:url(../../imgs/btnseleccionarsi.png);
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
	   background-image:url(../../imgs/encabezadotablas.png);
		height: 30px;
		font-size:12px; 
		color:#FFF;
		vertical-align: middle;
		 line-height: normal;
		 border-color:#99d6fd;
		 text-align: center;
    }

#mostrarconsulta
	{   
	   /* height: 100px;
		overflow-y: scroll;*/
		z-index: 10;
	}

	
	
table, th, td {
 font-family: Arial, Helvetica, sans-serif;
 font-size: 11px;
}
		
    .estilolog {
		background-image:url(imgs/fondolog.png);
	}

div.tab_portafolio {
			/*color: red;*/
			color: blue;
			background-image:url(imgs/icon_portafolio.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_reportes {
			color: blue;
			background-image:url(imgs/tag_orange.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}



div.tab_recibidos {
			/*color: blue;*/
			background-image:url(imgs/icon_recibidos.png);
			background-position: left;
			background-repeat: no-repeat;
			margin-left: 10px;
		}
div.tab_nuevos {
			/*color: blue;*/
			background-image:url(imgs/icon_nuevodoc.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enedicion {
			/*color: blue;*/
			background-image:url(imgs/icon_enedicion.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_enviados {
			/*color: blue;*/
			background-image:url(imgs/icon_enviados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_reasignados {
			/*color: blue;*/
			background-image:url(imgs/icon_reasignados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_informados {
			/*color: blue;*/
			background-image:url(imgs/icon_informados.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_archivados {
			/*color: blue;*/
			background-image:url(imgs/icon_archivado.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_eliminados {
			/*color: blue;*/
			background-image:url(imgs/icon_elimmsj.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}		
div.tab_busquedas {
			/*color: blue;*/
			background-image:url(imgs/buscnombresdat.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}
div.tab_perspermisos {
			/*color: blue;*/
			background-image:url(imgs/permisosusu.png);
			background-position: left;
			background-repeat: no-repeat;
			
		}			
    </style>

<script>
	//carga de informacion
	var myLayout, myAcc, myForm, formData, myDataProcessor,mygrid,myTabbar, mygrid;
	
	
	function btn_regresarpagprin()
	{
		document.location.href="reporte_panel.php";
	}
	
	////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////
	
function doOnLoad() {
	
	myLayout = new dhtmlXLayoutObject({
	parent: document.body,
	//parent: "layoutObj",
	pattern: "2E",
	cells: [{id: "a", text: "Datos",  height: 490   },{id: "b", text: "REPORTE GENERAL"  }
	 ] });
	 
	
	//myLayout.cells("a").hideHeader();
	myLayout.cells("b").hideHeader();
	myLayout.cells("a").attachObject("layoutmenusuperderecha");	
	
	
		
  ///////////fin metodo onload()
	}
	
	
	
</script>

 
</head>
<body onLoad="doOnLoad();">


<div id="layoutmenusuperderecha" style="background-color:#e7f1ff">
<table width="100%" border="0" align="center"><tr><td width="133"><font color="#0000FF"><b>Código del Documento:</b></font></td><td width="847" align="left"><font color="#FF0000"><b><?php if($varcodactual!="") echo $varcodactual; else echo "SIN CODIGO"; ?></b></font></td></tr></table><form id="formname" name="formname"><table width="100%" border="0" align="center"><tr><td width="14%">Buscar Ciudadano por:</td><td width="5%" align="left">Cédula:</td><td width="15%"><label for="busqcedula"></label><input type="text" name="verbusqudaxcedula" id="verbusqudaxcedula" onKeyUp="javascript:consultardatos(this, 'tabla', 'verbusqudaxcedula', 'verbusqudaxcedula', 'GEN01RUC,GEN01RUC,GEN01CODI,GEN01RUC,GEN01NOM,GEN01APE','verconsulmdatossel')" autocomplete="off" style="width: 100%"></td><td width="3%" align="right">CIU:</td><td width="15%"><input type="text" name="verbusqudaxciu" id="verbusqudaxciu" onKeyUp="javascript:consultardatos(this, 'tabla', 'verbusqudaxciu', 'verbusqudaxciu', 'GEN01RUC,GEN01CODI,GEN01CODI,GEN01RUC,GEN01NOM,GEN01APE','verconsulmdatossel')" autocomplete="off" style="width: 100%"></td>
  <td width="7%" align="right">Apellidos:</td>
  <td width="15%" align="left"><input type="text" name="verbusqudaxapellidos" id="verbusqudaxapellidos" onKeyUp="javascript:consultardatos(this, 'tabla', 'verbusqudaxciu', 'verbusqudaxciu', 'GEN01RUC,GEN01APE,GEN01CODI,GEN01RUC,GEN01NOM,GEN01APE','verconsulmdatossel')" autocomplete="off" style="width: 100%"></td><td width="22%">&nbsp;</td>
</tr>
</table></form><form id="formnamedats" name="formnamedats" method="post" action="serv_oracle_update_ciudadano.php"><fieldset style="background-color:#F3F3F3"><legend>DATOS PERSONALES</legend><table width="89%" border="0"><tr>
        <td width="64">Cédula</td><td width="186"><input type="text" name="txtcedula" id="txtcedula" style="width: 110px;" /><input type="text" name="txtciu" id="txtciu" /><input name="txttipdocid" type="hidden" id="txttipdocid" value="<?php echo $vartipodocid;  ?>" /><input name="txttipdocdescrip" type="hidden" id="txttipdocdescrip" value="<?php echo $vartipodocdetalle;  ?>" /><input name="txtcedjeferesp" type="hidden" id="txtcedjeferesp" value="<?php echo $varced_responsable;  ?>" /><input name="txtcedasistenresp" type="hidden" id="txtcedasistenresp" value="<?php echo $varced_asistente;  ?>" /><input name="txtasigndepart" type="hidden" id="txtasigndepart" value="<?php echo $varasig_depart;  ?>" /><input name="txttramitnom" type="hidden" id="txttramitnom" value="<?php echo $vartramite_name;  ?>" /><input name="txttramitid" type="hidden" id="txttramitid" value="<?php echo $vartramite_id;  ?>" /><input name="txtprcocesoid" type="hidden" id="txtprcocesoid" value="<?php echo $vartram_procesoid;  ?>" /></td><td width="69">Apellidos</td><td width="181"><input type="text" name="txtapellidos" id="txtapellidos" /></td><td width="63">Nombres</td><td width="181"><input type="text" name="txtnombres" id="txtnombres" /></td>
        <td width="74">Dirección</td><td width="226"><input type="text" name="txtdireccion" id="txtdireccion" style="width: 205px"  /></td>
        </tr>
  <tr>
          <td>Teléfono</td><td><input type="text" name="txttelefono" id="txttelefono" style="width: 110px;" /></td>
          <td>Institución</td><td><input type="text" name="txtinstitu" id="txtinstitu" /></td>
          <td>Email</td><td><input type="text" name="txtmail" id="txtmail" /></td>
          <td>Ubicación</td><td><table width="54%" border="0">
              <tr>
                <td width="53%"><select name="txtseleccionarubic" id="txtseleccionarubic" style="width: 150px">
                  <option value="COTACACHI">COTACACHI</option>
                  <option value="APUELA">APUELA</option>
                  <option value="CUELLAJE">CUELLAJE</option>
                  <option value="GARCIA MORENO">GARCIA MORENO</option>
                  <option value="IMANTAG">IMANTAG</option>
                  <option value="PEÑAHERRERA">PEÑAHERRERA</option>
                  <option value="PLAZA GUTIERREZ">PLAZA GUTIERREZ</option>
                  <option value="QUIROGA">QUIROGA</option>
                  <option value="SAGRARIO">SAGRARIO</option>
                  <option value="SAN FRANCISCO">SAN FRANCISCO</option>
                  <option value="VACAS GALINDO">VACAS GALINDO</option>
                </select></td>
                <td width="18%"><input type="text" name="txturbanorural" id="txturbanorural" style="width: 50px" /></td>
                <td width="29%">.</td>
              </tr>
            </table></td>
        </tr>
</table></fieldset><table width="100%" border="0">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="123" rowspan="3" align="center"><input name="txtprcoconanex" type="hidden" id="txtprcoconanex" value="1" /></td>
    <td width="167" rowspan="3" align="center"><input type="button" name="btncaceptar" id="btncaceptar" class="botones_aceptar" value="GUARDAR" style="width: 100px; height: 30px" onClick="guardarformentrada()" /></td>
  </tr>
  <tr><td width="132">ASUNTO O SOLICITUD:</td><td width="550"><input type="text" name="txtasuntosol" id="txtasuntosol" style="width: 550px" value="<?php echo $vartramite_asuntosolic;  ?>"  /></td>
  </tr><tr><td>&nbsp;</td><td>&nbsp;</td>
    </tr></table></form>

</div>
<div id="mostrarconsulta"></div>
</body>
</html>
