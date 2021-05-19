<?php

include('phpqrcode/qrlib.php');
require_once('../../clases/conexion.php');

$_GET["myidcuadclasif"]=258;

if(($_GET['rp'])!="")
{

 $sql = "select *  FROM tbli_esq_plant_form_plantilla  where id='".$_GET['rp']."'  order by id;";
$resulverplan = pg_query($conn, $sql);



/////////////////////parametros generales plantilla
$retorn_tableplan=pg_fetch_result($resulverplan,0,'nombre_tablabdd');
$retorn_tableanex=pg_fetch_result($resulverplan,0,'nombre_tabla_anexos');



 $sqldatsusu = "select *  FROM plantillas.".$retorn_tableplan."  where id='".$_GET['varclaveuntramusu']."'  order by id;";
$myresuldatusu = pg_query($conn, $sqldatsusu);
$varcodactual=pg_fetch_result($myresuldatusu,0,'cod_traminterno');
$varclaveunictramitusu=$_GET['varclaveuntramusu'];

$content=pg_fetch_result($myresuldatusu,0,'campo_1')."\n".pg_fetch_result($myresuldatusu,0,'campo_2')."\n".pg_fetch_result($myresuldatusu,0,'campo_3');

QRcode::png($content,"../../../sip_bodega/codqr/"."plantilla_".$_GET['rp']."_comp_qr.png",QR_ECLEVEL_L,10,2);
$verimgqrdado = "../../../sip_bodega/codqr/"."plantilla_".$_GET['rp']."_comp_qr.png";

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plantillas Formularios</title>
<style>
 @page { size: auto; margin: 5mm; } 
</style>
    
<script>

// document.getElementById("txtdiscapaciaux").style.display = "block";


function imprimirpag()
{
document.getElementById("formvericonprint").style.visibility = "hidden";
//document.getElementById("formverqr").style.display = "block";

 var ie = document.all;
        var dom = document.getElementById;
        divFormulario = document.getElementById('formverqr');
        divFormulario.style.visibility = (dom || ie) ? "visible" : "show";
		
window.print();
}

</script>
<link rel="stylesheet" href="jquery/jquery-ui.css">
<link rel="stylesheet" href="jquery/jquery-ui.css">
  <script src="jquery/jqueryfecha.js"></script>
  <script src="jquery/jquery-ui.js"></script>
  <script>
  $( function() {
	  
	  <?php
	  $sqldats = "select campo_creado,campo_nombre,campo_requerido,ref_tcamp,campo_orden  FROM tbli_esq_plant_form_plantilla_campos where ref_plantilla='".$_GET['rp']."' and campo_activo=1 order by campo_orden; ";
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
  
 /*
  html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
		}
		*/
		
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
  
  </style>
  <link href="estilotabla.css" rel="stylesheet" type="text/css" />
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
	function mifuncionpasporce()
	{
		var elvalor= document.getElementById("txtdiscapaciaux").value;
		document.getElementById("txtdiscapaci").value= elvalor;
		
	}
	
	
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
		var comprobclient= document.getElementById("txtnombres").value;
		if(comprobclient!="")
        {
		////////////////////////////
			var comprobarced= document.getElementById("txtcedjeferesp").value;
			//alert(comprobarced);
			//alert(document.getElementById("txtprcoconanex").value);
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
				
				document.getElementById('campo_0').value=auxciu;
				document.getElementById('campo_0').focus();
				document.getElementById('campo_1').value=auxcedu;
				document.getElementById('campo_1').focus();
				document.getElementById('campo_2').value=auxnom;
				document.getElementById('campo_2').focus();
				document.getElementById('campo_3').value=auxapel;
				document.getElementById('campo_3').focus();
				document.getElementById('campo_4').value=auxtelf;
				document.getElementById('campo_4').focus();
				document.getElementById('campo_5').value=auxmail;
				document.getElementById('campo_5').focus();
				document.getElementById('campo_6').value=auxadir;
				document.getElementById('campo_6').focus();
				
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
</head>

<body>

<?php
if(($_GET['rp'])!="")
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
      <tr>
        <td align="center"><font color="#FF0000"><?php echo $varcodactual; ?></font>&nbsp;</td>
      </tr>
    </table></td>
    <td width="164" align="center"><table width="200" border="0">
        <tr>
          <td align="center"><div id="formverqr" name="formverqr"><img src="<?php echo $verimgqrdado; ?>" width="70" height="70" border="0"><br /><?php echo $varcodactual; ?></div><a href="#" onclick="imprimirpag();"><div id="formvericonprint" name="formvericonprint"><img src="imgs/imprimir.png" width="48" height="48" border="0" /><br />IMPRIMIR</div></a></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td colspan="3">
    
    
    <?php
	  $sqlgrups = "select id,titulo_grupo,orden_grupo,publico,titulo,mostrar_titulo  FROM tbli_esq_plant_form_plantilla_grupo where ref_plantilla='".$_GET['rp']."' and activo=1 order by orden_grupo";
	 $resulvgrups = pg_query($conn, $sqlgrups);
	 
	 echo '<form id="formCiudadano" name="formCiudadano" method="post" action="guardarinfo_planext.php">';
     echo  "<input name='mivaridplantillaesq' type='hidden' id='mivaridplantillaesq' value='".$_GET['rp']."'  />";
	 echo  "<input name='mivarplancodtramite' type='hidden' id='mivarplancodtramite' value='".$varclaveunictramitusu."'  />";
	 
    for($grup=0;$grup<pg_num_rows($resulvgrups);$grup++)
	{
		//if(pg_fetch_result($resulvgrups,$grup,"publico")==1)
			//  {
				  if(pg_fetch_result($resulvgrups,$grup,"mostrar_titulo")==1)
					echo '<div>'.pg_fetch_result($resulvgrups,$grup,"titulo").'</div>';
			///////////////////////INI ESPACIO	
		echo '<fieldset><legend>'.pg_fetch_result($resulvgrups,$grup,"titulo_grupo").'</legend>';
		
		$sqlcamps = "select id,campo_creado,campo_nombre,campo_requerido,ref_tcamp,campo_orden,nombre_tablacmp,ref_plantilla,nombre_combocmp,publico,valorx_defecto  FROM tbli_esq_plant_form_plantilla_campos where ref_plantilla='".$_GET['rp']."' and ref_grupo='".pg_fetch_result($resulvgrups,$grup,"id")."' and campo_activo=1 order by campo_orden; ";
	    $resulvcamps = pg_query($conn, $sqlcamps);
		
		
		echo '<table width="100%" border="1" cellpadding="0" cellspacing="0">';
		 for($items=0;$items<pg_num_rows($resulvcamps);$items++)
	     {
			// if(pg_fetch_result($resulvcamps,$items,"publico")==1)
			 // {
			//////////////////////FILA///////////
			 echo '<tr>';
			if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==12)
			{
				   echo '<td colspan="2" align="center"><table><tr><td><div name="text_'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" id="text_'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" ><img src="../../../sip_bodega/archformularios/'.pg_fetch_result($resulvcamps,$items,"valorx_defecto").'" width="500" height="300" /></div></td></tr></table></td>';
				      
			}
			else  if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==11)
			{
				   echo '<td colspan="2" align="center"><div name="text'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" id="text'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" >'.pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado")).'</div><textarea name="'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" type="text" id="'.pg_fetch_result($resulvcamps,$items,"campo_creado").'" style="width: 90%; visibility:hidden" >'.pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado")).'</textarea></td>';
			}
			else  if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==10)
			{
				   echo '<iframe name="map'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" id="map'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" frameborder="0"  width="100%" height="400"  src="app_tipo_mapaubic_vistaimpres.php?ponref_plantilla='.pg_fetch_result($resulvcamps,$items,"ref_plantilla").'&varitabcmpid='.pg_fetch_result($resulvcamps,$items,"campo_creado").'&varclaveuntramusu='.$varclaveunictramitusu.' "></iframe>';
			}
			else if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==9)
			{
				/*
				   echo '<iframe name="tab'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" id="tab'.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'" frameborder="0"  width="100%" height="400"  src="app_tipo_tabla.php?pontabla='.pg_fetch_result($resulvcamps,$items,"nombre_tablacmp").'&varitabcmpid='.pg_fetch_result($resulvcamps,$items,"id").'&varclaveuntramusu='.$varclaveunictramitusu.' "></iframe>';*/
				   echo '<td colspan="2" align="center">';
					
				   /////////////////////////impresion de tabla
				   $sqltabgen = "select campo_creado, campo_nombre, campo_tipo  FROM tbli_esq_plant_form_plantilla_cmpcolumns where ref_elementcampo='".pg_fetch_result($resulvcamps,$items,"id")."'";
					$consulcamps = pg_query($conn, $sqltabgen);
					$miconjuntocamps="";
				    for($i=0;$i<pg_num_rows($consulcamps);$i++)
					{
						if($i==pg_num_rows($consulcamps)-1)
						   $miconjuntocamps.=pg_fetch_result($consulcamps,$i,"campo_creado");
						else
						   $miconjuntocamps.=pg_fetch_result($consulcamps,$i,"campo_creado").',';
					}
					
				  	$sqltabgen = "select $miconjuntocamps  FROM plantillas.".pg_fetch_result($resulvcamps,$items,"nombre_tablacmp"). " where ref_plantillausu='".$varclaveunictramitusu."' ";
					$consul = pg_query($conn, $sqltabgen);
					//echo " total: ".pg_num_rows($consul)." - ".pg_num_rows($consulcamps)." - ".pg_num_fields($consul);

					echo "<table id='consultab' width='95%' align='center'  border='1' cellpadding='0' cellspacing='0'>";
					echo "<tr id='encabezadotab'>";

 for($i=0;$i<pg_num_rows($consulcamps);$i++)
					{
					  echo "<td><b>".strtoupper( pg_fetch_result($consulcamps,$i,"campo_nombre") )."</b></td>"; 
					}     
echo "</tr>";
  for($i=0;$i<pg_num_rows($consul);$i++)
			 {
			     $style = "dr";
    					if ($i % 2 != 0) 
    				  $style = "sr";
			 
			    echo "<tr id='".pg_fetch_result($consul,$i,0)."' class='".$style."' >";
				
				 for($col=0;$col<pg_num_fields($consul);$col++)
					{
						if(pg_fetch_result($consulcamps,$col,"campo_tipo")==5)
						{
							if(pg_fetch_result($consul,$i,$col)==1)
						    echo "<td><input type='checkbox' name='cheq".$col."' id='cheq".$col."'   checked='checked'  /></td>";	
							else
							echo "<td><input type='checkbox' name='cheq".$col."' id='cheq".$col."'   /></td>";	
						}
						else
						{
							if(pg_fetch_result($consul,$i,$col)!="")
							echo "<td>".pg_fetch_result($consul,$i,$col)."</td>";
							else
							echo "<td>&nbsp;</td>";
						}
				    }		
					echo "</tr>";
				}
			echo "</table>";
				   //////////////////////////fin de impresion de tablas
		    echo '</td>';
				   
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
				{
					if(pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))=="on")
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  checked='checked'   required  title='Este campo es requerido'  /></td>";
					else
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' required  title='Este campo es requerido'  /></td>";
				}else{
					if(pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))=="on")
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  checked='checked'    /></td>";
					
			else		
				echo "<td>&nbsp;&nbsp;<input type='checkbox' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'   /></td>";
				}
				
			}
			else
			 if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==7)
			 {
				if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
				{
				
				$sqlcampscombo = "select  item_nom  FROM plantillas.".pg_fetch_result($resulvcamps,$items,"nombre_combocmp")." order by id; ";
	    $rescampocombo = pg_query($conn, $sqlcampscombo);
		
				
				echo "<td  align='center' ><select name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  style='width: 90%'>";
				for($icomb=0;$icomb<pg_num_rows($rescampocombo);$icomb++)
					{
    					if(pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))==pg_fetch_result($rescampocombo,$icomb,"item_nom"))
						echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."' selected='selected' >".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
						else
						echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."'>".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
						
					}
  					echo		"</select></td>";

				}
				else
				{
					$sqlcampscombo = "select  item_nom  FROM plantillas.".pg_fetch_result($resulvcamps,$items,"nombre_combocmp")." order by id; ";
	    			$rescampocombo = pg_query($conn, $sqlcampscombo);
		
				
					echo "<td  align='center' ><select name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  style='width: 90%'>";
				for($icomb=0;$icomb<pg_num_rows($rescampocombo);$icomb++)
					{
						if(pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))==pg_fetch_result($rescampocombo,$icomb,"item_nom"))
    					echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."'  selected='selected' >".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
						else
						echo "<option value='".pg_fetch_result($rescampocombo,$icomb,"item_nom")."'>".pg_fetch_result($rescampocombo,$icomb,"item_nom")."</option>";
						
					}
  					echo		"</select></td>";
				}
				
			}
			else if(pg_fetch_result($resulvcamps,$items,"ref_tcamp")==2)
			 {
				 if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
    		     echo  "<td align='center'  height='25'><textarea  cols='100%' rows='5' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' type='text' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  style='width: 90%;margin-top: 5px; margin-bottom: 5px'  required  title='Este campo es requerido'  >".pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))."</textarea></td>";
				 else
				  echo  "<td align='center'  height='25'><textarea  cols='100%' rows='5' name='".pg_fetch_result($resulvcamps,$items,"campo_creado")."' type='text' id='".pg_fetch_result($resulvcamps,$items,"campo_creado")."'  style='width: 90%;margin-top: 5px; margin-bottom: 5px' >".pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))."</textarea></td>";
			 }
			else
			{
				if(pg_fetch_result($resulvcamps,$items,"campo_requerido")==1)
    		     echo  "<td align='left'  height='25'>&nbsp;".pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))."</td>";
				 else
				  echo  "<td align='left'  height='25'>&nbsp;".pg_fetch_result($myresuldatusu,0,pg_fetch_result($resulvcamps,$items,"campo_creado"))."</td>";
				 
			}
			
			}
			 
			 
  			 
              echo '</tr>';
			  //////////////////////FIN FILA///////////
			  }
		// }
		echo '</table>';
		
		echo '</fieldset>&nbsp;';
		///////////////////////INI ESPACIO	  
		//}
		//echo '<td colspan="3">&nbsp;</td>';
	}
	//echo '<input type="submit" name="btnenviar" id="btnenviar" value="" style="background-image:url(imgs/form_btnsiguiente.png); color:#fff;width:202px;height:40px; font-size:14px" />';
	echo '</form>';
	
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
<script>
document.getElementById("formverqr").style.visibility = "hidden";
</script>
</body>
</html>