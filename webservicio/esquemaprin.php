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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>SIP</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script type="text/javascript" src="../gap/extjs421/examples/shared/include-ext.js"></script>
        <script type="text/javascript" src="../gap/extjs421/examples/shared/examples.js"></script>

        <style type="text/css">

            html, body {
                width: 100%;
                height: 100%;
                margin: 0px;
                padding: 0px;
                background-color: #dce7fa;
                overflow: hidden;
                font-family: verdana, arial, helvetica, sans-serif;
                /*font:normal 11px verdana;
            font-size:11px;*/

            }

            #datoscontenido{
                font:normal 11px verdana;
                font-size:11px;
            }

            p {
                margin:5px;
            }

            .movim {
                background-image:url(../gap/icons/fam/book.png);
                /*    background-image:url(imagenes/iconodinero.png);*/
            }

            .icon-ingresar {
                background-image:url(../gap/icons/fam/rss_go.png);
                /*    background-image:url(imagenes/iconodinero.png);*/
            }

            .consultem {
                background-image:url(../gap/icons/fam/rss_go.png);
                /* background-image:url(imagenes/iconcons2.png);*/
            }

            .impues {
                background-image:url(../gap/imagenes/dolarcobro.png);
            }

            .iconturn {

                background-image:url(../gap/icons/fam/image_add.png);
                /* background-image:url(imagenes/btn4.png);*/
            }


            .iconoconfig {

                /*background-image:url(modulos/shared/icons/fam/folder_wrench.png);*/
                background-image:url(../gap/imagenes/planif_icon.gif);
                width: 20px;
                height: 20px;
            }


            a{
                /*color: #0CB225;*/
                color: #006633;
                text-decoration: none;
                /*background: #fff;*/
            }

            /* ICONOS PARA GRIDS  */
            .x-action-col-cell img.icon-reqs {
                width: 80px;
                height: 25px;
                background-image:url(../gap/imagenes/btninter_req.png);
            }

            .x-action-col-cell img.icon-pasos {
                width: 80px;
                height: 25px;
                background-image:url(../gap/imagenes/btninter_pasos.png);
            }

            .x-action-col-cell img.icon-flujow {
                width: 80px;
                height: 25px;
                background-image:url(../gap/imagenes/btninter_flujo.png);
            }
            /* cuando no exista y el valor sea nulo */
            .x-action-col-cell img.icon-inactivo {
                width: 80px;
                height: 25px;
                /*background-color:#CCC;*/
                background-image:url(../gap/imagenes/btnprincipal2_g.png);
            }

        </style>
        <!--
        <link rel="stylesheet" type="text/css" href="extjs421/resources/css/ext-all-gray.css" />
        -->
         <script type="text/JavaScript">
            function irLogin(admin) {
                try{
                var x = screen.width - 20;
                var y = screen.height - 80;
                var param = "";
                if (admin == 1) param = "?txt_administrador=1";
                ventana=window.open("../login.php"+param,"QUIPUX","toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes, width="+x+", height="+y);
                ventana.focus();
                ventana.moveTo(10, 40);
                }
                catch(e){
                    
                }
            }
        </script>



        <script type="text/javascript">

            function BotonSalirSys()
            {
            Ext.MessageBox.alert('Saliendo del Sistema', 'Gracias por Visitarnos');
            window.location = 'index.php?r=site/logout';
            }
			
            Ext.require([
                    '*',
                    'Ext.window.MessageBox',
                    'Ext.tip.*',
                    'Ext.tab.*',
            ]);
            Ext.onReady(function() {

            Ext.QuickTips.init();
            var currentItem;
            var tabs = Ext.create('Ext.tab.Panel', {
            region: 'center', // a center region is ALWAYS required for border layout
                    deferredRender: false,
                    activeTab: 0, // first tab initially active
                    items: [{
                    contentEl: 'center1',
                            title: 'Panel Principal',
                            autoScroll: true,
                            layout: 'fit',
                            items:
                    [  //////inicio items
                           {
                                    //title: 'Principal',
                                            html:'<iframe src="index.php?r=site/login" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>'
                                    }
                    ]   /////fin de item
                    }]
            })

                    /////////////////INICIO
                    Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));
            var viewport = Ext.create('Ext.Viewport', {
            id: 'border-example',
                    layout: 'border',
                    items: [
                            Ext.create('Ext.Component', {
                            region: 'north',
							//collapsible: true,
							//collapsed: false,
                                    height: 78, // give north and south regions a height
                                    autoEl: {
                                    tag: 'div',
                                            html:  '<table width="100%" border="0" cellpadding="0" cellspacing="0" background="../gap/imagenes/encabezadocielo.png"><tr><td><table width="100%" border="0"><tr><td width="43%"><table width="100%" border="0"><tr><td width="26%" rowspan="2"><img src="../gap/imagenes/logointrologin.png" width="111" height="73" /></td><td width="74%" align="center"><font face="Arial Black, Gadget, sans-serif" size="3" color="#cfdef1">SISTEMA INTEGRAL <br/>DE PROCESOS</font></td></tr><tr><td  align="center"><font face="Monotype Corsiva" size="4" color="#fff">Integración de Procesos (SIP)</font></td></tr></table></td><td width="57%"><table width="57%" border="0" align="left" cellspacing="0"><tr><td width="17%" align="center"><a href="http://www.cotacachienlinea.gob.ec/" target="_new"   ><img src="../gap/imagenes/buscarusuario.png" width="32" height="32" /></a></td><td width="1%" rowspan="2" align="center"><img src="../gap/imagenes/separacion.png" width="2" height="46" /></td><td width="17%" align="center"><a href="http://www.cotacachienlinea.gob.ec/geoportal/" target="_new"   ><img src="../gap/imagenes/mundo.png" width="32" height="32" /></a></td><td width="3%" rowspan="2" align="center"><img src="../gap/imagenes/separacion.png" width="2" height="46" /></td><td width="18%" align="center"><a href="#"  onclick="irLogin(0);" target="_parent"   ><img src="../gap/imagenes/conconsul.png" width="32" height="32" /></a></td><td width="2%" rowspan="2" align="center"><img src="../gap/imagenes/separacion.png" width="2" height="46" /></td><td width="24%" align="center"><a href="http://www.cotacachienlinea.gob.ec/sipt/" target="_parent"  ><img src="../gap/imagenes/iconopth3.png" width="32" height="32" /></a></td></tr><tr><td height="17" align="center"><font  size="2" color="#fff">Cotacachi en Linea</font></td><td align="center"><font  size="2" color="#fff">Geoportal</font></td><td align="center"><font  size="2" color="#fff">Gestor Documental</font></td><td align="center"><font  size="2" color="#fff">Tramites en Linea</font></td></tr></table></td></tr></table></td></tr></table>'                                     }
                            }), {
                    region: 'west',
                            stateId: 'navigation-panel',
                            id: 'west-panel',
                            title: 'Menu Principal',
							<?php if (isset($_SESSION["sesusuarioid"])) { ?>
							split:  true,
                            width:  240,
                            minWidth: 50,
                            maxWidth: 240,
                            <?php } else { ?>	
							split:  false,
                            width:  0,
                            minWidth: 0,
                            maxWidth: 0,
							 <?php } ?>	
							animCollapse: true,
                            margins: '0 0 0 5',
                            layout: 'accordion',
                            items: [
														{
                            contentEl: 'west',
                                    title: 'TRAMITES',
                                    //bodyStyle: {"background-image": "url(imagenes/bg.jpg)", "background-size": "100% 100%", "color": "#FFF"},
                                    bodyStyle: {"background-color": "#d4dee6", "color": "#000"},
                                    iconCls: 'movim' // see the HEAD section for style used
                            },  {
                            contentEl: 'informacionparametros',
                                    title: 'MIS DATOS',
                                   
                                    bodyStyle: {"background-color": "#d4dee6", "color": "#000"},
                                    iconCls: 'impues'
                            }, 
							/*							{
                            contentEl: 'informturnos',
                                    title: 'WORKFLOW PROCESOS',
                                    
                                    bodyStyle: {"background-color": "#d4dee6", "color": "#000"},
                                    iconCls: 'iconturn'
                            },{
                            contentEl: 'consultasx',
                                    title: 'CLASIFICACION DOCUMEMTAL',
                                    
                                    bodyStyle: {"background-color": "#d4dee6", "color": "#000"},
                                    iconCls: 'consultem'
                            }, {
                            contentEl: 'informconfiguracion',
                                    title: 'ARCHIVO INSTUTUCIONAL',
                                    
                                    bodyStyle: {"background-color": "#d4dee6", "color": "#000"},
                                    iconCls: 'iconoconfig'
                            }
							*/
							]
                    },
                    {
                    region: 'east',
                            //stateId: 'navigation-panel',
                            //id: 'east-panel', // see Ext.getCmp() below
                            title: 'Usuario',
                            split: false,
                            width:  0,
                            minWidth: 0,
                            maxWidth: 0,
														                    		animCollapse: false,
                            bodyStyle: {"background-image": "url(imagenes/degradusu.png)", "background-size": "100% 100%", "color": "#000"},
                            //margins: '0 0 0 5',
                            // layout: 'border',
                            items: [{
                            contentEl:  'panelsessionusuario',
                                    //title: 'Movimientos',
                                    // iconCls: 'movim' // see the HEAD section for style used
                            }
                            ]
                    },
                            /* {
                             region: 'south',
                             xtype: 'panel',
                             height: 20,
                             html: '<center>Copyright &copy; 2018</center>'
                             },*/
                            tabs
                    ]
            });
            var index = 0;
            function doScroll(item) {
            var id = item.id.replace('_menu', ''),
                    tab = tabs.getComponent(id).tab;
            tabs.getTabBar().layout.overflowHandler.scrollToItem(tab);
            }

            function addTab (tabPanel, id, url, titulomio) {
            var tab = tabPanel.getComponent(id);
            if (!tab) {
            ++index;
            tab = tabPanel.add({
            id       : id,
                    title    : titulomio,
                    closable : true,
                    html:'<iframe src="' + url + '" id="ventan' + id + '" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>'
            });
            }
            //  if(id!='bar0' or id!='bar1')
            tabPanel.setActiveTab(tab);
            }

            //////////////////ACTIVANDO LOS MENUS///////////////////////////////////
            ////////////*************MENU USUARIOS*************/////////////////
           
             Ext.get('btnusuverc1').on('click', function () {
             var titulomiomdeltab = "Configuracion";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabusuverc1', 'modulos/menubakend.php', titulomiomdeltab);
             });
              
             Ext.get('btnusuverc2').on('click', function () {
             var titulomiomdeltab = "Catalogo de Cargos";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabusuverc2', 'index.php?r=tblcThCatalogoCargo/admin', titulomiomdeltab);
             });
			 
			 Ext.get('btnusuverc3').on('click', function () {
             var titulomiomdeltab = "Organico Institucional";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabusuverc3', 'modulos/gesdepartamentos/listarbol_departamento.php', titulomiomdeltab);
             });
			 
			 Ext.get('btnusuverc4').on('click', function () {
             var titulomiomdeltab = "Usuarios";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
			              addTab(tabs, 'tabusuverc4', 'index.php?r=TblaCaAdministracionUsuarios/admin', titulomiomdeltab);
			 			
			              
             });
            
            ////////////*************GESTION DE PROCESOS****************/////////////////
            Ext.get('btngesproc1').on('click', function () {
            var titulomiomdeltab = "Linea Base";
            // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
            addTab(tabs, 'tabgesproc1', 'index.php?r=tbleProcProcesoLineabase/admin', titulomiomdeltab);
            });
          
             Ext.get('btngesproc2').on('click', function () {
             var titulomiomdeltab = "Procesos Departamento";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabgesproc2', 'index.php?r=tbleProcProceso/admin', titulomiomdeltab);
             });
            
             Ext.get('btngesproc3').on('click', function () {
             var titulomiomdeltab = "Cartera de Servicios";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabgesproc3', 'index.php?r=tblfProcTramiteServicio/admin', titulomiomdeltab);
             });
            
             Ext.get('btngesproc4').on('click', function () {
             var titulomiomdeltab = "Guia del Ciudadano";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabgesproc4', 'index.php?r=tblfProcTramiteServicio', titulomiomdeltab);
             });
            
             Ext.get('btngesproc5').on('click', function () {
             var titulomiomdeltab = "Formularios en línea";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabgesproc5', 'index.php?r=tbliEsqPlantilla', titulomiomdeltab);
             });
			 
			  Ext.get('btngesproc6').on('click', function () {
             var titulomiomdeltab = "Formularios en línea";
             // Ext.example.msg('Click','Bienvenido a la sector: "'+titulomiomdeltab+'".');
             addTab(tabs, 'tabgesproc5', 'index.php?r=tbliEsqPlantilla', titulomiomdeltab);
             });
             
             
		
            });
        </script>

    </head>

    <body>
        <!-- use class="x-hide-display" to prevent a brief flicker of the content -->

        <div id="west" class="x-hide-display">

            <table width="100%" border="0">
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc1"  > <table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Facturas</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc2"  ><table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Titulos de Credito</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc3"  ><table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Comprobantes de Retencion</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc4"  ><table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Notas de Credito</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc5"  > <table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Notas de Debito</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                <tr>
                    <td background="../gap/imagenes/btnsesweb.png">
                        <a href="#" id="btngesproc6"  > <table width="100%" border="0">
                                <tr>
                                    <td><img src="../gap/imagenes/procesobtn.png" width="25" height="25" /></td>
                                    <td><font color="#006633" size="2">Deudas</font></td>
                                </tr>
                            </table></a>
                    </td>
                </tr>
                
               
            </table>


        </div>

        <div id="consultasx" class="x-hide-display">
        </div>

        <div id="informacionparametros" class="x-hide-display">
        </div>

        <div id="informturnos" class="x-hide-display">       
        </div>

        <div id="informconfiguracion" class="x-hide-display">
        </div>

        <div id="center2" class="x-hide-display">
        </div>
        
        <div id="center1" class="x-hide-display">
        </div>

        <div id="panelsessionusuario" style="background-image:url(../gap/imagenes/degradusu.png)" >
        </div>


        <div id="props-panel" class="x-hide-display" style="width:200px;height:200px;overflow:hidden;">
        </div>


    </body>
</html>


