
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Obtencion de Informacion</title>
    <meta charset='utf-8'>
    <script src="script_scan/scanner.js" type="text/javascript"></script>
    
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
	

    function saltardatoload(targ,selObj,restore){ //v3.0
	   
	   var datover="D:\usoscanner\2018-07-04_10-06-32.917.pdf";
	   
       //eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        //if (restore) selObj.selectedIndex=0;
		
		
     }
	 
    /////////////////////////
	   function guardarinfodocs(miobjpublicver,varcampobusq, totcampos, vartabla) {
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
	
    </script>

    <script>
        //
        // Please read scanner.js developer's guide at: http://asprise.com/document-scan-upload-image-browser/ie-chrome-firefox-scanner-docs.html
        //

        /** Initiates a scan */
        function scanToLocalDisk() {
            scanner.scan(displayResponseOnPage,
                {
                    "output_settings": [
                        {
                            "type": "save",
                            "format": "pdf",
                            "save_path": "D:\\usoscanner\\${TMS}${EXT}"
                        }
                    ]
                }
            );
        }

        function displayResponseOnPage(successful, mesg, response) {
            if(!successful) { // On error
                document.getElementById('response').innerHTML = 'Failed: ' + mesg;
                return;
            }

            if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
                document.getElementById('response').innerHTML = 'User cancelled';
                return;
            }

            document.getElementById('response').innerHTML = scanner.getSaveResponse(response);
        }
    </script>

    <style>
        img.scanned {
            height: 200px; /** Sets the display size */
            margin-right: 12px;
        }

        div#images {
            margin-top: 20px;
        }
    </style>
       <style>
        .asprise-footer, .asprise-footer a:visited { font-family: Arial, Helvetica, sans-serif; color: #999; font-size: 13px; }
        .asprise-footer a {  text-decoration: none; color: #999; }
        .asprise-footer a:hover {  padding-bottom: 2px; border-bottom: solid 1px #9cd; color: #06c; }
		
		#cmbselecarchreq
		{
			width: 500px;
		}
		
    </style>
    
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
				pattern: "1C",
				cells: [{id: "a", text: "Cargar los Requisitos >>> ", width: "100%", height: 120   } ]
	
			});
			//////////////elementos
formData = [
  {type: "settings", position: "label-left", labelWidth: 100, inputWidth: 120},
	{type: "fieldset", label: "Informacion Anexo al Formulario",  offsetLeft: 5, offsetRight: 5, offsetTop: 0, inputWidth: 360, list:[		
					//{type: "newcolumn"},
	//	type: "input", label: "Plantilla", width: 50,  name: "ref_cod_proyecto", value: "<?php echo $_GET["mvpr"]; ?>", validate:"[0-9]+", readonly : "true" },
		{type: "hidden", label: "Codigo", width: 210,  name: "ref_infoplantilla", readonly : "true", value: "<?php echo  $idprincodusuarioid; ?>"},
		{type: "hidden", label: "Codigo", width: 210,  name: "ref_tablaplantilla", readonly : "true", value: "<?php echo  $vrdatableretplantilla; ?>"},
		
		{type: "template", label: "Archivos", name: "imagenicon",inputWidth: 140, value: ""},
		{type: "upload", name: "myFiles", inputWidth: 310,  offsetTop: 0, url: "php/carga_upload_imgs.php", autoStart: true, swfPath: "uploader.swf", swfUrl: "php/carga_upload_imgs.php"},
]},

	{type:"newcolumn"},

//{type: "button", value: ">>>  Guardar Capas <<<", name: "send", offsetLeft: 10,  width: 130, className: "button_save"}			
			];

			myForm = myLayout.cells("a").attachForm(formData);
			
			myForm.attachEvent("onUploadComplete",function(count){
				alert("El Archivo se Cargo Correctamente");
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
						<?php if($devuelveidprin!="") { ?>
						// myForm.save();
						 myForm.send("dato_actual.php", function(loader, response){
						       // alert(response);
					      });
						<?php } else { ?>
						 myForm.send("dato_actual.php", function(loader, response){
						       // alert(response);
					      });
					<?php }  ?>
							dhtmlx.alert({
							title:"Mensaje!",
						  //  type:"confirm",
						    text: "Se guardo con exito!!",
						    callback: function() { 
							
							//document.location.href="lista_grid_objetosgeo.php"; 
							
							 }
							});
							
					}
			});
			///////////////////////////////////////////////////////////////////////////////

			
		}
		
		
	</script>
    
</head>
<body onload="doOnLoad();">
<form>
  <h2>Scaneo de Informacion</h2>
<p>
    <button type="button" onclick="scanToLocalDisk();" style="width: 100px; height: 80px;background-image:url(../../iconos/scanbtnini.png);background-repeat: no-repeat;background-position: center; font-size:14px; color:#FFF; vertical-align: text-bottom; ">Iniciar</button>
   </p>
   <select name="cmbselecarchreq" id="cmbselecarchreq" onchange="saltardatoload('parent',this,0)">
   <?php 
  
  
   
   ?>
 </select>
    <div id="response"></div>
    
  <div id="cuerpoformulario" name="cuerpoformulario"  style="width:100%; height: 200px; overflow-y: hidden;overflow-x: hidden; "></div>
   
</form>
</body>
</html>