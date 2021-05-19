<html>
<head>
    <title>Geoportal</title>

    <!-- GC -->

    <style type="text/css">
    html, body {
        font:normal 12px verdana;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
    .x-panel-body p {
        margin:5px;
    }
    .settings {
        background-image:url(../../extjs421/examples/shared/icons/fam/folder_wrench.png) !important;
    }
    .nav {
        background-image:url(../../extjs421/examples/shared/icons/fam/folder_go.png) !important;
    }
	
	#menutopsupervis{
width:100%;background-image: linear-gradient(to bottom, rgba(225,238,255), rgba(199,224,255));border: 1px solid #a4bed4; height:29px;font-family:Tahoma, Geneva, sans-serif; font-size:11px;color:#000;text-decoration: none;  	
	}
	
    </style>
    <script type="text/javascript" src="../../extjs421/examples/shared/include-ext.js"></script>
    
<script type="text/javascript" src="../../extjs421/examples/shared/examples.js"></script><!-- EXAMPLES -->
<script type="text/javascript">
function imprimirmap()
  {
	   if ((navigator.appName == "Netscape")) { window.print() ; 
        } 
        else { 
            var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
            document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
        } 
  };
</script>

<script type="text/javascript">
Ext.require(['*']);

    Ext.onReady(function(){

       // NOTE: This is an example showing simple state management. During development,
       // it is generally best to disable state management as dynamically-generated ids
       // can change across page loads, leading to unpredictable results.  The developer
       // should ensure that stable state ids are set for stateful components in real apps.
	   
	   
       Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));

       var viewport = Ext.create('Ext.Viewport', {
            layout: 'border',
			//id: "MainViewPort",
            items:[{
                region: 'west',
                title: 'Grupos',
                split: true,
                width: 400,
                minWidth: 400,
                maxWidth: 400,
                collapsible: true,
                margin: '5 0 5 5',
               /* layout: {
                    type: 'accordion',
                    animate: false
                },*/
                items: [
				
				  Ext.create('Ext.tree.Panel', {
					  /*
					   tbar: new Ext.Toolbar({
                        //cls:'top-toolbar',
                        	items:[{
							text: 'Ver Menu Geografico',
                            //tooltip: 'Expand All',
                            	handler: function(){ 
							    	document.location.href='principal_capasgeo.php';
									}
                        		}]
                    	}),
					*/
        			store:  Ext.create('Ext.data.TreeStore', {
  							      proxy: {
 						          type: 'ajax',
						          url: 'tree_grupos.php',
						          node:'id' // send the parent id through GET (default 0)
						        }
						    }),
       				 rootVisible: false,
       				// title: 'Estructura de Proyectos',
       				 renderTo: 'tree',
        			width: 400,
					//collapsible: true,
        			height: 580,
					
					//////////////////evnetos
					listeners: {
            			itemclick: function(treeModel, record, item, index, e, eOpts){
							regresavarid=record.get('id');
							regresavartexto=record.get('text');
							//alert(regresavarid);
							tempovectddat=regresavartexto.split(":");
							darmecodbarras=tempovectddat[0];
							//alert(darmecodbarras);
							
							
							var centr=Ext.getCmp('centerView');
                    		//var viewport=Ext.getCmp('MainViewPort');
                    		viewport.remove(centr);
							var newPanel = new Ext.Panel({
    								region: 'center',
                					margin: '5 5 5 0',
                					layout: 'fit',
                					autoScroll: true,
                					defaultType: 'container',
    								html: '<iframe src="../parametros/lista_generar_busq_validados_arb.php?xenviovalorarb='+darmecodbarras+' " id="miframe" name="miframe" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>'
							
							});
							viewport.add(newPanel);
							//viewport.add(newcmp);
                    		//viewport.doLayout();
							//////////////////////////////////////
            				}
       				}
					///////////////////fin de eventos tree
       			}),
				
				/*{
                    html: Ext.example.shortBogusMarkup,
                    title:'Proyectos',
                    autoScroll:true,
                    border:false,
                    iconCls:'nav'
                }*/]
            },	{
				id:'centerView',
                region: 'center',
                margin: '5 5 5 0',
                layout: 'fit',
                autoScroll: true,
                defaultType: 'container',
                items: [
				            {
							  title: 'Objetos Geograficos',
							  html: '<iframe src="../parametros/lista_generar_busq_validados_arb.php?xenviovalorarb=1000000001" id="miframe" name="miframe" frameborder="0" scrolling="auto" width="100%" height="100%"></iframe>'
							}
				
						]
////////////////////////////////////////////////
            	}
				///////////////////////////fin de region center
			]
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="../../extjs421/resources/css/ext-all.css" />

</head>
<body>
<div id="tree"></div>
</body>
</html>
