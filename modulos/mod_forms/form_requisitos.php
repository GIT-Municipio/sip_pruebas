<?php
require_once '../../clases/conexion.php';
$idprintramite=$_GET["mvpr"];       ////codigo principal de la plantilla
$idprincodusuarioid=$_GET["varcodgenerado"]; ////codigo principal del usuario

 $sqlplan="select *from vista_presentaplantilla where id='".$idprintramite."'";
$consulplan=pg_query($conn,$sqlplan);
$vertaman=pg_num_rows($consulplan); 

/////// consultar tabla------------////
$vrdatableretnombretram=pg_fetch_result($consulplan,0,"nombre_tramite");
$vrdatableretplantilla="plantillasform.".pg_fetch_result($consulplan,0,"nombre_tablabdd");
$vrdatableretrequisitos="plantillasform.".pg_fetch_result($consulplan,0,"nombre_tabla_anexos");

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

$_SESSION["tramtablanexos"]=$vrdatableretrequisitos;
$_SESSION["tramclicodusario"]=$idprincodusuarioid;

///////////////////////varibales para carga de archivos
if($_SESSION["tramescaneadosx"]=="")
$_SESSION["tramescaneadosx"]=0;
/*
$_SESSION["tramescaneadosx"]="";
$_SESSION["tramescaneacontar"]=0;
*/

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
	background-color: #eaeeef;
	font-family:Arial, Helvetica, sans-serif;
}
</style>

<style type="text/css">
 
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

function abrirPopScanner(varplant,varcodusu)
{
	 var popupgeomap;
        popupgeomap = window.open("form_scannerpdf.php?mvpr="+varplant+"&varcodgenerado="+varcodusu, "mostrarparascanner", "width=600,height=400,scrollbars=no");
        popupgeomap.focus();
}

function validarverImpresion()
{
	 document.getElementById('formCiudadano').submit();
	/*
	var verifcedula=document.getElementById('campo_0').value;
	var verifapelli=document.getElementById('campo_1').value;
	
	if(verifcedula.length>3)
	{
		if(verifapelli.length>3)
	    {
		document.location.href="form_simpresion.php";
		}
		else
		alert("Los campos (*) son requeridos");
		
	}
	else
	{
		alert("Los campos (*) son requeridos");
	}
	*/
}

function cancelarformulario()
{
	window.close();
}

function cancelarformulinter()
{
	document.location.href="/sip/gap/index.php?r=TbliEsqPlantilla/index&varenvgestor=1";
}

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
		/////////////////////////////
		function cerrarConsultatab()
		{
		    document.getElementById('mostrarconsulta').style.visibility = "hidden";
		}
	/////////////////////////////
		function typewrite(element,text,delay) {
		//alert("Hola");
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
         divFormulario.innerHTML = '<img src="../../iconos/anim.gif">';
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
       // alert(tablarel);alert(camporel);
	   //alert("hola");
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
       
		ajax.open("POST", "../conswebserv/serv_oracle_datpersonas.php");
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

<link rel="stylesheet" type="text/css" href="../../dhtmlx51/codebase/fonts/font_roboto/roboto.css"/>
<link rel="stylesheet" type="text/css" href="../../dhtmlx51/skins/skyblue/dhtmlx.css"/>
<script src="../../dhtmlx51/codebase/dhtmlx.js"></script>

<script>
		var myLayout, myGrid, myForm, myMenuContex, myGridhist;
		var estadup=0;
		
		function doOnLoad() {
			
			////////////inicializando
			myLayout = new dhtmlXLayoutObject({
				parent: "cuerpoformulario",
				pattern: "2E",
				cells: [{id: "a", text: "Cargar los Requisitos >>> ", width: "100%", height: 165   },{id: "b", text: "Informacion de Anexos"   } ]
	
			});
			//////////////elementos
formData = [
  {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 120},
	{type: "fieldset", label: "Informacion Anexo al Formulario",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 340, list:[		
					//{type: "newcolumn"},
	//	type: "input", label: "Plantilla", width: 50,  name: "ref_cod_proyecto", value: "<?php echo $_GET["mvpr"]; ?>", validate:"[0-9]+", readonly : "true" },
		{type: "hidden", label: "Codigo", width: 50,  name: "ref_infoplantilla", readonly : "true", value: "<?php echo  $idprincodusuarioid; ?>"},
		{type: "hidden", label: "Codigo", width: 50,  name: "ref_tablaplantilla", readonly : "true", value: "<?php echo  $vrdatableretplantilla; ?>"},
		
		{type: "template", label: "Archivos", name: "imagenicon",inputWidth: 140, value: ""},
		{type: "upload", name: "myFiles", inputWidth: 290,  offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
]},

	{type:"newcolumn"},
	{type: "fieldset", label: "Informacion Desde Escaner",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 340, list:[	
	{type: "template", name: "link", label: "Obtener desde Scanner:", value: "dhtmlx.com", format:format_a},
	
	]}
	
//{type: "button", value: ">>>  Guardar Capas <<<", name: "send", offsetLeft: 10,  width: 130, className: "button_save"}			
			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onUploadComplete",function(count){
			//	alert("El Archivo se Cargo Correctamente");
			//myGrid.loadXML("php/oper_mostrar_elem.php?mitabla=<?php echo $vrdatableretrequisitos; ?>&enviocampos=<?php echo "id,nro_ordencod,nombre_anexo,url_anexo,validado"; ?>&envioclientid=<?php echo $idprincodusuarioid; ?>");
			document.location.reload(true)
			});
			
			////////////////////eventos boton
			//myForm.setNumberFormat("ref_data_padre","0","'",",");
			myForm.attachEvent("onButtonClick", function(id){
				//alert(id);
				if (id == "cancel") 
				{
					document.location.href="lista_data_departamentos.php";
				}
				
				if (id == "send") 
					{
						//alert(id);
						
						// myForm.save();
						 myForm.send("dato_actual.php", function(loader, response){
						       // alert(response);
					      });
						
					
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { 
							
							document.location.href="lista_grid_objetosgeo.php"; 
							
							 }
							});
							
					}
			});
			///////////////////////////////////////////////////////////////////////////////
			//myForm.setSkin("Skyblue");
			
		
			myGrid = new dhtmlXGridObject('gridbox');
			////////////////elemento grid
			myGrid = myLayout.cells("b").attachGrid();
			myGrid.setImagePath("../../dhtmlx51/codebase/imgs/");
			myGrid.setHeader("ID,CODIGO, NOMBRE_ARCHIVO, DETALLE,  VALIDAR");
			//////si se requiere buscar numerico     #numeric_filter
			//myGrid.attachHeader("#rspan,#text_filter,#text_filter,#text_filter,#rspan");
			myGrid.setInitWidths("10,60,280,290,60");
			myGrid.setColAlign("center,center,left,left,center");
			myGrid.setColTypes("dyn,dyn,txt,co,ch");
			myGrid.setColSorting("int,int,str,str,str");
			//myGrid.enableEditEvents(false,false,false);
			myGrid.sortRows(0,"str","asc");
			//myGrid.enableContextMenu(myMenuContex);
			//myGrid.attachEvent("onRowSelect",doOnRowSelected);
			 		////////////////////////////insercion de un combobox en grid
	var coroColumn = myGrid.getCombo(3);
	coroColumn.put("0","CORRECTO");
	<?
	
	for($i=0;$i<count($_SESSION["tramescaneadosx"]);$i++)
   {
	    echo "coroColumn.put('".$_SESSION["tramescaneadosx"][$i]."','".$_SESSION["tramescaneadosx"][$i]."');"   ;
   }
	 

/*
	 for($comp=1;$comp < 5; $comp++)
   		{
			echo "coroColumn.put('".$comp."','dat".$comp."');"   ;
		}
		*/
 	?>
/////////////////////////////////////////////////////////nuevo
			
			
			
			myGrid.init();
			
						
	
			
			myGrid.load("php/oper_mostrar_elem.php?mitabla=<?php echo $vrdatableretrequisitos; ?>&enviocampos=<?php echo "id,nro_ordencod,nombre_anexo,url_anexo,validado"; ?>&envioclientid=<?php echo $idprincodusuarioid; ?>");
			
			myGrid.enableEditEvents(false,true,false);
//============================================================================================
			myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=<?php echo $vrdatableretrequisitos; ?>&enviocampos=<?php echo "id,nro_ordencod,nombre_anexo,url_anexo,validado"; ?>&envioclientid=<?php echo $idprincodusuarioid; ?>"); //lock feed url
			myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
			//myDataProcessor.setUpdateMode("off"); //disable auto-update
			myDataProcessor.init(myGrid); //link dataprocessor to the grid
//============================================================================================

myDataProcessor.attachEvent("onAfterUpdate",function(rowID){ 
//dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"});
//myGrid.cells(rowID,3).setValue("CORRECTO");
myGrid.cells(rowID,4).setValue(true);
myGrid.cells(rowID,3).setTextColor('red');  
myDataProcessor.setUpdated(rowID,true);

//if(estadup==0)
//{
doOnLoad();
//estadup=1;
//}

 });
///////////mensajes de salida
   			//myDataProcessor.attachEvent("onAfterUpdate",function(){ dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"}); });
			function format_a(name, value) {
			
			if (name == "link") return "<div class='simple_link'><a href='#' style='text-decoration: none;' onclick='abrirPopScanner(<?php echo $_GET["mvpr"].",".$_GET["varcodgenerado"]; ?>)' target='blank'><br/><table width='200' ><tr><td><font color='#a1a9c1'>Hacer Click para Ingresar a Scanner >>></font></td><td> <img src='../../iconos/btnscanner.png' width='54' height='54' /></td></tr></table>&nbsp;</a></div>";
		}
		
			
		}
		
		
	</script>

</head>

<body topmargin="0" leftmargin="0" rightmargin="0" onload="doOnLoad();">
&nbsp;
<form id="formCiudadano" name="formCiudadano" method="post" action="form_simpresion.php">

<input type="hidden"  name="mivarcodigoplantilla" id="mivarcodigoplantilla" value="<?php echo $idprintramite; ?>"  />
<input type="hidden"  name="mivartablaplantilla" id="mivartablaplantilla" value="<?php echo $vrdatableretplantilla; ?>"  />
<input type="hidden"  name="mivarcodigousuario" id="mivarcodigousuario" value="<?php echo $idprincodusuarioid; ?>"  />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <table width="409" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr>
		    <td width="209"><img src="../../iconos/tab_btnforminact.png" width="200" height="25" /></td>
		    <td width="200"><img src="../../iconos/tab_btnrequisitact.png" width="200" height="25" /></td>
		    <td width="200"><a href="#" onclick="javascript:validarverImpresion();"><img src="../../iconos/tab_btnfinimprimirinact.png" width="200" height="25" /></a></td>
	      </tr>
	</table>
</td>
  </tr>
  <tr>
    <td>
    <div style="width:100%; height: 40px; background-color:#323639; color:#FFF; text-align: center;vertical-align: middle; " align="center">
  <table width="100%" border="0" height="40">
  <tr>
    <td align="center"><?php echo pg_fetch_result($consulplan,0,"nombre_plantilla"); ?></td>
  </tr>
</table>
</div>
   
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="28%" valign="top" bgcolor="#525659" align="center">
    <div style="width:250px; background-color:#FFC; font-size:11px">
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
    </div>
    
    </td>
    <td width="72%" rowspan="2" align="center" bgcolor="#525659">
    
    
<div id="cuerpoformulario" name="cuerpoformulario"  style="width:100%; height: 530px; overflow-y: hidden;overflow-x: hidden; background-color:#525659; ">

</div>

    
    </td>
  </tr>
  <tr>
    <td valign="bottom" bgcolor="#525659">&nbsp;</td>
  </tr>
    </table>

    
  
    
    </td>
  </tr>
  
  
  <tr>
        <td><table width="400" border="0" align="right">
          <tr>
              <td width="240" align="center"><input type="submit" name="btnenviar" id="btnenviar" value="" style="background-image:url(../../iconos/form_btnsiguiente.png); color:#fff;width:202px;height:40px; font-size:14px" /></td>
              <td width="261" align="right">
              <?php  if(isset($_GET["varinter"])==1) {  ?>
          <input type="button" onclick="javascript:cancelarformulinter();" name="btncancelar" id="btncancelar" value=""  style="background-image:url(../../iconos/form_btncancelar.png); color:#fff;width:202px;height:40px; font-size:14px"  />
              <?php  } else {  ?>
              <input type="button" onclick="javascript:cancelarformulario();" name="btncancelar" id="btncancelar" value=""  style="background-image:url(../../iconos/form_btncancelar.png); color:#fff;width:202px;height:40px; font-size:14px"  />
               <?php  } ?>
              
              </td>
          </tr>
      </table></td>
    </tr>
  
  
</table>





</form>

<div id="mostrarconsulta"></div>
<div id="gridbox"></div>	
</body>
</html>