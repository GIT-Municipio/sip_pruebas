Ext.Loader.setConfig({enabled: true});

Ext.Loader.setPath('Ext.ux', '../ux/');

Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
	'Ext.ux.grid.FiltersFeature',
    'Ext.ux.PreviewPlugin',
    'Ext.ux.LiveSearchGridPanel',
	'Ext.toolbar.Paging',
    'Ext.tip.QuickTipManager',
    'Ext.state.*',
    'Ext.ModelManager',	
    'Ext.form.*',
    'Ext.form.field.File',
    'Ext.form.field.Number',
    'Ext.form.Panel',
    'Ext.window.MessageBox',
    'Ext.ux.ajax.JsonSimlet',
    'Ext.ux.ajax.SimManager',
    'Ext.ux.grid.Printer',
    
]);

Ext.onReady(function() {    
    Ext.QuickTips.init();    
	    var encode = false;
		var local = false;
	    var remote = true;
	//////////////CREAR INSTANCIAS PARA FILTRADO
	    var filters = {
        ftype: 'filters',
        filters: [{
            type: 'boolean',
            dataIndex: 'visible'
        }]
    };
	/////////////////FIN DE FILTRADO
	/////////////CREAR MI ALMACEN DE DATOS
    Ext.define('MiConjuntoDatos', {
        extend: 'Ext.data.Model',
        fields: [{name:'id_npredio', type: 'int'},{name:'clavecatastral'},{name:'cedula'},{name:'usuario'},{name:'junta'},{name:'toma', type: 'int'},{name:'nro_sector', type: 'int'},{name:'zona', type: 'int'},{name:'caja', type: 'int'},{name:'regable', type: 'float'}, {name:'fecha_creacion', type:'date',  dateFormat: 'Y-m-d' },{name:'lotenro', type: 'float'}, {name:'derivacion'},{name:'regada', type: 'float'}, {name:'fecha_actual', type:'date',  dateFormat: 'Y-m-d' } ]
    });
	
	var store = Ext.create('Ext.data.JsonStore', {
        model: 'MiConjuntoDatos',
		pageSize: 50,         ///esto aumente
        //remoteSort: true,      ///esto aumente
        proxy: {
            type: 'ajax',
            url: 'consultalista.php',
            reader: {
                type: 'json',
                root: 'data',
				totalProperty: 'total'
            },
		  /////////esto aumento	
		//	simpleSortMode: true
			 /////////fin esto aumento	
        },
		/////////esto es para agrupar
		//groupField: 'usuario',
		//remoteGroup: true,
		//sorters: ['usuario'],
		 /////////esto aumento	
		/*
        sorters: [{
            property: 'usuario',
            //direction: 'DESC',
			direction: 'ASC'
        }]*/  
		 /////////fin esto aumento	
		 	
    });
    store.load();
	

    //////////////////FIN DE CREACION DE ALMACENES

/////////////para agrupar datos
var groupingFeature = Ext.create('Ext.grid.feature.Grouping',{
        groupHeaderTpl: 'Usuario: {usuario} ({rows.length} Item{[values.rows.length > 1 ? "s" : ""]})',
        hideGroupedHeader: true,
		startCollapsed: true,	
      //  groupHeaderTpl: '{name}',
      // enableGroupingMenu: false
		
    });

///////////////para  activar solo celdas para edicion
var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
	clicksToMoveEditor: 1,
        clicksToEdit: 2,

		
	 listeners: {

     //////////////para la edicion´
	 afteredit:
               //
            function(cellEditing,  record) {

            var sm = grid.getSelectionModel();
			var seleccionodato=sm.getSelection()[0].get('id_npredio');
			var selecambiadato=sm.getSelection()[0].get('cedula');
             //alert(JSON.stringify(recordData));

             Ext.Ajax.request({

                 url: 'claseoperacionesbdd.php?opcion=Editarunvalor',
                 method: 'POST',
                 // merge row data with other params
                 params: {
				       cedula: selecambiadato,
					   idprimaria: seleccionodato
				          },
				success: function(response){
				   var text = response.responseText;
				       if(text=="success")
							{
						 	Ext.Msg.alert('Mensaje Eliminacion', text);
							}
							else
								Ext.Msg.alert('Mensaje Eliminacion', text); 
					    }
             });
         }
 
      /////////////
       
  } ///final de lisneter
	
    });	
	
////////////////activando para la edicion
var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', {
        clicksToMoveEditor: 1,
		//clicksToEdit: 2,
        autoCancel: false,
		/////////////////esto sirve para guardar datos en la base en grilla cuando esta
	/*	
		listeners: {
            edit: function(rowEditing , record) {
                        if (Status==0)
                        {
                           var UpdateRec=grid.getSelectionModel().getSelected().get('id_npredio');
                          
                        //var UpdateRec=MyGrd.getSelectionModel().getSelected().get('Id');   
                           Ext.Ajax.request({
                                url:'guardarporeventos.php?opcion=Editar',
                                method:'POST',
                                params: 
                                {
									cedula: record.get('cedula'),
									usuario: record.get('usuario'),
									junta: record.get('junta'),
									toma: record.get('toma'),
									sector: record.get('sector'),
									zona: record.get('zona'),
									caja: record.get('caja'),
									regable: record.get('regable'),
									fecha_creacion: record.get('fecha_creacion'),
							        Idenv: UpdateRec,
                                },
                            });
                        }
                        else
                        {
                                Ext.Ajax.request({
                                url:'guardarporeventos.php?opcion=Agregar',
                                method:'POST',
                                params: 
                                {
									cedula: record.get('cedula'),
									usuario: record.get('usuario'),
									junta: record.get('junta'),
									toma: record.get('toma'),
									sector: record.get('sector'),
									zona: record.get('zona'),
									caja: record.get('caja'),
									regable: record.get('regable'),
									fecha_creacion: record.get('fecha_creacion'),
                                },
                            });
                        }        
            }, 
            canceledit:function(rowEditing){
                var record = grid.store.getAt(rowEditing.rowIndex);
                if(Status==1) {
                    grid.store.removeAt(rowEditing.rowIndex);
                    grid.getView().refresh();
                    Status=0;
                }
                return true;
            }
       
      }
  */
	/////////////
		//////////////////////////////////////////////////
    });
	//////////////////////////////

    function cambiacolorcedula(val) {
        if (val > 0) {
            return '<span style="color:green;">' + val + '</span>';
        } else if (val < 0) {
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    }
	
	function cambiacolornombre(valcol) {

            return '<span style="color:#203860;">' + valcol + '</span>';

    }
		
//creando columnas
   var createColumns = function (finish, start) {
	
	var columns = [
	{
                text     : 'ID',
                // flex     : 1,
			    width    : 50, 
                sortable : false, 
                dataIndex: 'id_npredio',
				//locked: true,            ///para bloquear columnas
                //lockable: false,         ///para bloquear columnas
				filter: {
                  //type: 'string'
                        },
            },
			{
                text     : 'CLAVE_CATASTRO', 
                width    : 100, 
                sortable : true, 
				hidden   : true,
              //  renderer : 'usMoney', 
                dataIndex: 'clavecatastral',
				filter: {
                type: 'string'
                        },
						  editor: {
                             // defaults to textfield if no xtype is supplied
                             allowBlank: true
                            }
            },
            {
                text     : 'CEDULA', 
                width    : 100, 
                sortable : true, 
				//renderer : cambiacolorcedula, 
                dataIndex: 'cedula',
				filter: {
                type: 'string'
                        },
						  editor: {
                             // defaults to textfield if no xtype is supplied
                             allowBlank: true
                            }
            },
            {
				//header	 : 'USUARIO', 
                text     : 'USUARIO', 
                width    : 300, 
                sortable : true, 
				//renderer : cambiacolornombre,
                dataIndex: 'usuario',
				filter: {
                type: 'string'
                        },
						  editor: {
                             // defaults to textfield if no xtype is supplied
                             allowBlank: true
                            }
               // renderer: change
            },
            {
                text     : 'JUNTA', 
                width    : 75, 
                sortable : true, 
                dataIndex: 'junta',
				filter: {
               // type: 'string'
                        },
						  editor: {
                             // defaults to textfield if no xtype is supplied
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
				
               // renderer: pctChange
            },
            {
               // xtype    : 'datecolumn',
                text     : 'TOMA', 
                width    : 85, 
                sortable : true, 
                dataIndex: 'toma',
				filter: {
                //type: 'string'
                        },
						  editor: {
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
            },
            {
               // xtype    : 'datecolumn',
                text     : 'SECTOR', 
                width    : 85, 
                sortable : true, 
                dataIndex: 'nro_sector',
				filter: {
                //type: 'string'
                        },
						  editor: {
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
            },
            {
               // xtype    : 'datecolumn',
                text     : 'ZONA', 
                width    : 85, 
                sortable : true, 
                dataIndex: 'zona',
				filter: {
                //type: 'string'
                        },
						  editor: {
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
            },
            {
               // xtype: 'numbercolumn',
                text     : 'CAJA', 
                width    : 85, 
                sortable : true, 
                dataIndex: 'caja',
				format: '0',
				filter: {
                //type: 'string'
                        },
						  editor: {
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
            },
            {
                //xtype: 'numbercolumn',
                text     : 'HAS.', 
                width    : 90, 
                sortable : true, 
                dataIndex: 'regable',
				format: '0,000',
				filter: {
                //type: 'string'
                        },
						      editor: {
                              xtype: 'numberfield',
                              allowBlank: false,
                              minValue: 0,
                              maxValue: 150000
                            }
            },
			 {
            xtype: 'datecolumn',
            header: 'FECHA_CREACION',
            dataIndex: 'fecha_creacion',
            width: 105,
			filter: {
                //type: 'string'
                        },
            renderer: Ext.util.Format.dateRenderer('Y-m-d'),
            	editor: 	{
    	            	xtype: 'datefield',
	    	            allowBlank: false,
	        	        format: 'Y-m-d',
	            	    minValue: '1995/01/01',
	                	minText: 'No existe la fecha!',
		                maxValue: Ext.Date.format(new Date(), 'Y-m-d')
                        	}
			 },

/////////////////////////ACCIONES DE GRID////////////////////////////////////
			  {
				    //header     : 'ACCIONES', 
                    xtype:'actioncolumn',
                    width:55,
					locked: true,   
                    items:[{
                        icon:'images/edit.png',
                        tooltip:'Edit Employee',
                        handler:function(grid, rowIndex, colIndex) {


                              var employee = grid.getStore().getAt(rowIndex);
                              var review = store.findRecord('id_npredio', employee.get('id_npredio'));
                           
                              var form = actualdatoDialog.down('form').getForm();
                              form.loadRecord(employee);
                              form.loadRecord(review);
                              actualdatoDialog.show();	 
                       		  
                        }
                    },
					{xtype: 'space'},
                    {
                        icon:'images/elim.png',
                        tooltip:'Delete Employee',
                        width:75,
                        handler:function(grid, rowIndex, colIndex) {
                           Ext.Msg.confirm('Eliminar Usuario?', 'Desea Eliminar el Dato?',
                                function(choice) {
                                    if(choice === 'yes') {
                                       
                                        var miusuariopadron = grid.getStore().getAt(rowIndex);
										///posicion del elemento seleccionado
                                        var posicelem = store.find('id_npredio', miusuariopadron.get('id_npredio'));
                                        store.removeAt(posicelem);
                                       // grid.getStore().removeAt(rowIndex);
										/////////////para empezar a eliminar cogemos el dato pero de la base de datos
										var seleccionodato=miusuariopadron.get('id_npredio');

				         ///////////////ENVIAR DATOS AL OPERACIONES////////////
						Ext.Ajax.request({
					    	url: 'claseoperacionesbdd.php?opcion=Eliminar',
							method:'POST',
					    	params: {
									 Idenv: seleccionodato,
							    	},
					    		success: function(response){
					        	var text = response.responseText;
								if(text=="success")
									{
								 	Ext.Msg.alert('Mensaje Eliminacion', text);
									}
							 		else
								 		Ext.Msg.alert('Mensaje Eliminacion', text); 
					           	}
							});   ///fin del request
				            ///////////////FIN ENVIAR DATOS AL OPERACIONES////////////
                      //////////////////////////////////solo eliminacion pura
                                    }
                                }
                            );   
                        }
                    }]    ///FIN DE ITEMS
			  }    ////OTRO FIN
					////////////////////////FIN DE ACCIONES DE GRID
        ];
	
	  return columns.slice(start || 0, finish);  
	  
   };
	



        
    
// Ext.create('Ext.ux.LiveSearchGridPanel', {
// Ext.create('Ext.grid.Panel', {
	 
  var grid =  Ext.create('Ext.grid.Panel', {
		region      : 'center',
		store: store,
		iconCls: 'icon-grid',
		collapsible:true,
		/////AUMENTADO 
		selType: 'cellmodel',
		features: [filters],    //filtrado y agrupamiento
		//features: [filters,groupingFeature],    //filtrado y agrupamiento
        columnLines: true,
        loadMask: false,
		columns: createColumns(16),

		/////////////////para toolbars ver
		 // inline buttons
        dockedItems: [
		////////////para el paginado
		Ext.create('Ext.toolbar.Paging', {
            dock: 'bottom',
            store: store
        }),

		/////////////fin de paginado
		 /*{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            layout: {
                pack: 'center'
            },
            items: [{
                minWidth: 80,
                text: 'Save'
            },{
                minWidth: 80,
                text: 'Cancel'
            }]
        }, */
			////////////////para botones de insercion y actualizacion en grilla BOTONES //////////////////////////////
		/*
		{
            xtype: 'toolbar',
            items: [{
                text:'Agregar Nuevo Predio',
                tooltip:'Add a new row',
                iconCls:'add',
				/////////////evento para insertar valores
				handler : function() {
                rowEditing.cancelEdit();

                // Create a model instance
                var r = Ext.create('MiConjuntoDatos', {
                    clavecatastral: 'Nuevo',
                    cedula: 'cedula',
                    usuario: 'faust',
                    junta: 50000,
                    toma: 50000,
					sector: 1,
					zona: 1,
					caja: 1,
					regable: 0,
					//fecha_creacion: '1996/01/01'
                });
                /////////////fin del evento para insertar valores
                store.insert(0, r);
                rowEditing.startEdit(0, 0);
            }
            }, '-', {
                text:'Options',
                tooltip:'Set options',
                iconCls:'option'
            },'-',{
                itemId: 'removeButton',
                text:'Eliminar Seleccion',
                tooltip:'Remove the selected item',
                iconCls:'remove',
                //disabled: true,
				///////////////////para enviar actualizr
				 handler: function(){
                var sm = grid.getSelectionModel();
                rowEditing.cancelEdit();
                store.remove(sm.getSelection());
                if (store.getCount() > 0) {
                    sm.select(0);
                      }
                }
				/////////////////// fin para actualizar  para enviar actualizr
				
            }]
        },   */     // fin de botones
		////////////////FIN BOTONES //////////////////////////////
		
		{
		fbar  : [{
            text: 'Nuevo Usuario',
			iconCls: 'usuarjunta-add',
            handler: function() {
                nuevousuarioDialog.show();
            }
        }, 
		{
            text: 'Imprimir',
			iconCls: 'usuarjunta-export',
            handler: function() {
				///////////////////poner la funcion de exportacion
	            	Ext.ux.grid.Printer.printAutomatically = false;
	            	Ext.ux.grid.Printer.print(grid); 
            }
        },
		/* {
            text: 'Eliminar Usuario',
			iconCls: 'usuarjunta-remove',
            handler: function() {
/////////////////////////////INICIO PARA ELIMINAR EN LA BASE DE DATOS	
				 Ext.Msg.confirm('Eliminar Usuario?', 'Desea Eliminar el Dato?',
                 function(choice) {
                    if(choice === 'yes') {
						var sm = grid.getSelectionModel();
						var seleccionodato=sm.getSelection()[0].get('id_npredio');
				         ///////////////ENVIAR DATOS AL OPERACIONES////////////
						Ext.Ajax.request({
					    	url: 'claseoperacionesbdd.php?opcion=Eliminar',
							method:'POST',
					    	params: {
									 Idenv: seleccionodato,
							    	},
					    		success: function(response){
					        	var text = response.responseText;
								if(text=="success")
									{
								 	Ext.Msg.alert('Message', text);
									}
							 		else
								 		Ext.Msg.alert('Message', text); 
					           	}
							});   ///fin del request
				            ///////////////FIN ENVIAR DATOS AL OPERACIONES////////////
				            /////////////ELIMINAR DEL GRID Y QUEDARSE EN EL PRIMER REGISTRO
				  			store.remove(sm.getSelection());
				 				        if (store.getCount() > 0) {
                    				       sm.select(0);
             			   				}					
                     } /////fin PREGUNTA DE CONFIRMACION YES
                   });////fin FUNCION CHOICE   Y EVENTO CONFIRM
/////////////////////////////FIN PARA ELIMINAR EN LA BASE DE DATOS	
            },   ////DEL EVENTO DEL BOTON
        }, */

            '->',
					{
		xtype: 'box',
		text: 'Exportar Informacion',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<form name="paraexpxls" id="paraexpxls" action="exportar_reportexcel.php" method="post">' +
            '<table width="154" border="0" cellpadding="0" cellspacing="0"><tr><td width="25"><img src="images/excel_icon1.png" width="25" height="25" /></td><td width="129"><input type="submit" value="Exportar Datos xls" ' +  'style="color:#ffffff; font:normal 11px arial,tahoma,verdana,helvetica; background-image:url(images/bagkboton.png);border-style:hidden;height: 24px;cursor:pointer; font-weight: bold;font-size:12px;-webkit-border-radius: 3px 3px;-ms-border-radius: 3px 3px;-moz-border-radius: 3px 3px;" /></td></tr></table></form>'
            }

		},{
		xtype: 'box',
		text: 'Exportar Informacion PDF',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<form  name="paraexpdf" id="paraexpdf" action="reportepdf.php" method="post">' +
            '<table width="150" border="0" cellpadding="0" cellspacing="0"><tr><td width="25"><img src="images/pdf_icon_b.png" width="25" height="25" /></td><td width="155"><input type="submit" value="Exportar Datos PDF" ' +  'style="color:#ffffff; font:normal 11px arial,tahoma,verdana,helvetica; background-image:url(images/bagkboton.png);border-style:hidden;height: 24px;cursor:pointer; font-weight: bold;font-size:12px;-webkit-border-radius: 3px 3px;-ms-border-radius: 3px 3px;-moz-border-radius: 3px 3px;" /></td></tr></table></form>'
            }

		}
			
		/*	{
            text: 'Agrupar',
			iconCls: 'usuarjunta-export',
            handler: function() {

				 groupingFeature.enable();
            }
        },{
                text: 'collapse all',
                handler: function (btn) {        
                    groupingFeature.collapseAll();
                }
            },{
                text: 'expand all',
                handler: function (btn) {        
                    groupingFeature.expandAll();
                }
            }, {
            text:'Quitar Agrupacion',
            //iconCls: 'icon-clear-group',
            handler : function(b) {
                groupingFeature.disable();
            }
        }, {
            text:'Activar Edicion',
            //iconCls: 'icon-clear-group',
            handler : function(b) {
			
            }
        }*/ 
		////////////////////////fin de botones  
		]  //////fin del menu bar superior
		///////////////////////////////////////
		}
		],  
		
	    emptyText: 'No hay registros',    /////esto aumente  
        // plugins: [rowEditing],        /////para editar toda la fila
		plugins: [cellEditing],       ////para editar solo una celda
		/////////////////////ver los ttolbars
        height: 410,
        width: '100%',
        title: 'Padron de Usuarios',
        renderTo: 'grid_padronusu',
        viewConfig: {
            stripeRows: true,
			forceFit: true
        },
		
    });
	
	//////////////////este aumewntadito
	// add some buttons to bottom toolbar just for demonstration purposes
    grid.child('pagingtoolbar').add([
        '->',
       /* {
            text: 'Codificar: ' + (encode ? 'On' : 'Off'),
            tooltip: 'Toggle Filter encoding on/off',
            enableToggle: true,
            handler: function (button, state) {
                var encode = (grid.filters.encode !== true);
                var text = 'Encode: ' + (encode ? 'On' : 'Off'); 
                grid.filters.encode = encode;
                grid.filters.reload();
                button.setText(text);
            } 
        },
        {
            text: 'Filtro Local: ' + (local ? 'On' : 'Off'),
            tooltip: 'Toggle Filtering between remote/local',
            enableToggle: true,
            handler: function (button, state) {
                var local = (grid.filters.local !== true),
                    text = 'Local Filtering: ' + (local ? 'On' : 'Off'),
                    newUrl = local ? url.local : url.remote,
                    store = grid.view.getStore();
                 
                // update the GridFilter setting
                grid.filters.local = local;
                // bind the store again so GridFilters is listening to appropriate store event
                grid.filters.bindStore(store);
                // update the url for the proxy
                store.proxy.url = newUrl;

                button.setText(text);
                store.load();
            } 
        },
		
        {
            text: 'Todos los filtros',
            tooltip: 'Get Filter Data for Grid',
            handler: function () {
                var data = Ext.encode(grid.filters.getFilterData());
                Ext.Msg.alert('All Filter Data',data);
            } 
        },{
            text: 'Limpiar Busqueda',
            handler: function () {
                grid.filters.clearFilters();
            } 
        },{
            text: 'Agregar Columnas',
            handler: function () {
                if (grid.headerCt.items.length < 6) {
                    grid.headerCt.add(createColumns(6, 4));
                    grid.view.refresh();
                    this.disable();
                }
            }
			
        }   */ 
    ]);


	////////////////////para acutalizacion de datos
	    var nuevousuarioDialog = Ext.create('Ext.window.Window', {
        closeAction: 'hide',
        title: 'Registro de Nuevo Usuario del Padron',

        // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
        autoEl: 'form',
        width: 400,
        bodyPadding: 5,
        layout: 'anchor',
        defaults: {
            anchor: '100%'
        },
        defaultFocus: '[name=cedula]',
        items: [{
			//////para agrupamientos
		//	xtype:'fieldset',
        //    title:'Datos Informativos',
		//	items:[{
            xtype: 'textfield',
            fieldLabel: 'Cedula',
            name: 'cedula'
        }, {
            xtype: 'textfield',
            fieldLabel: 'Usuario',
            name: 'usuario'
        //}]         ////fin de agrupamiento
		}, {
            xtype: 'textfield',
            fieldLabel: 'Clave_Catastral',
            name: 'clavecatastral'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Junta',
            name: 'junta'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Toma',
            name: 'toma'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Sector',
            name: 'nro_sector'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Zona',
            name: 'zona'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Caja',
            name: 'caja'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Regable',
            name: 'regable'
        }, {
            xtype: 'datefield',
            fieldLabel: 'Fecha_Creacion',
            name: 'fecha_creacion'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Lote',
            name: 'lotenro'
        }, {
            xtype: 'textfield',
            fieldLabel: 'Derivacion',
            name: 'derivacion'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Regada',
            name: 'regada'
        }, {
            xtype: 'datefield',
            fieldLabel: 'Fecha_Actual',
            name: 'fecha_actual'
        }],
        buttons: [{
            text: 'Agregar',
            type: 'submit',
			
            handler: function() {
			
				////////////////metodos para la INSERCION de DATOS
                   var newRec = Ext.ModelManager.create({
				    cedula: nuevousuarioDialog.down('[name=cedula]').getValue(),
                    usuario: nuevousuarioDialog.down('[name=usuario]').getValue(),
                    junta: nuevousuarioDialog.down('[name=junta]').getValue(),
                    toma: nuevousuarioDialog.down('[name=toma]').getValue(),
					sector: nuevousuarioDialog.down('[name=nro_sector]').getValue(),
					zona: nuevousuarioDialog.down('[name=zona]').getValue(),
					caja: nuevousuarioDialog.down('[name=caja]').getValue(),
					regable: nuevousuarioDialog.down('[name=regable]').getValue(),
					fecha_creacion: nuevousuarioDialog.down('[name=fecha_creacion]').getValue(),
					lotenro: nuevousuarioDialog.down('[name=lotenro]').getValue(),
					derivacion: nuevousuarioDialog.down('[name=derivacion]').getValue(),
					regada: nuevousuarioDialog.down('[name=regada]').getValue(),
					fecha_actual: nuevousuarioDialog.down('[name=fecha_actual]').getValue(),
				}, 'MiConjuntoDatos');
				/////aumenta a la secuencia de datos
                store.add(newRec);
				
				//////////////////PARA EL GUARDADO DE ELEMENTOS
				////////////creacion de las variables
			    var cedula= nuevousuarioDialog.down('[name=cedula]').getValue();
                var usuario= nuevousuarioDialog.down('[name=usuario]').getValue();
                var junta= nuevousuarioDialog.down('[name=junta]').getValue();
                var toma= nuevousuarioDialog.down('[name=toma]').getValue();
				var	sector= nuevousuarioDialog.down('[name=nro_sector]').getValue();
				var	zona= nuevousuarioDialog.down('[name=zona]').getValue();
				var	caja= nuevousuarioDialog.down('[name=caja]').getValue();
				var	regable= nuevousuarioDialog.down('[name=regable]').getValue();
				var	fecha_creacion= nuevousuarioDialog.down('[name=fecha_creacion]').getValue();
				var lotenro= nuevousuarioDialog.down('[name=lotenro]').getValue();
				var derivacion= nuevousuarioDialog.down('[name=derivacion]').getValue();
				var regada= nuevousuarioDialog.down('[name=regada]').getValue();
				var fecha_actual= nuevousuarioDialog.down('[name=fecha_actual]').getValue();
			   //////////////////fin de creacion de variables
				Ext.Ajax.request({
				    url: 'claseoperacionesbdd.php?opcion=Agregar',
					method:'POST',
				    params: {
							cedula: cedula,
							usuario: usuario,
							junta: junta,
							toma: toma,
							sector: sector,
							zona: zona,
							caja: caja,
							regable: regable,
							fecha_creacion: fecha_creacion,
							lotenro: lotenro,
							derivacion: derivacion,
							regada: regada,
							fecha_actual: fecha_actual,
						    },
					    success: function(response){
					        var text = response.responseText;
							if(text=="success")
								{
								 Ext.Msg.alert('Message', text);
								}
							 else
								 Ext.Msg.alert('Message', text);
      
					    }
				});  ///fin del request

				//////////////////FIN PARA EL GUARDADO DE ELEMENTOS
				nuevousuarioDialog.hide();
                nuevousuarioDialog.el.dom.reset();
				////////////////FINALIZACION DE metodos para la INSERCION de DATOS
				
				
            }  ///fin de handler
        }, {
            text: 'Cancelar',
            handler: function() {
                nuevousuarioDialog.hide();
            }
        }]
    });
	/////////////////////////////fin aumento
	
	/////////////////otro aumento para edicion
	    var actualdatoDialog = Ext.create('Ext.window.Window', {
        closeAction: 'hide',
        title: 'Actualizacion de Usuarios del Padron',

        // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
        autoEl: 'form',
        width: 400,
        bodyPadding: 5,
        layout: 'anchor',
        defaults: {
            anchor: '100%'
        },
        defaultFocus: '[name=cedula]',
        items: [{
			xtype: 'form',
			items:[{
            xtype: 'hidden',
            fieldLabel: 'id_npredio',
            name: 'id_npredio'
        },{
			//////para agrupamientos
		//	xtype:'fieldset',
        //    title:'Datos Informativos',
		//	items:[{
            xtype: 'textfield',
            fieldLabel: 'Cedula',
            name: 'cedula'
        }, {
            xtype: 'textfield',
            fieldLabel: 'Usuario',
            name: 'usuario'
        //}]         ////fin de agrupamiento
		}, {
            xtype: 'textfield',
            fieldLabel: 'Clave_Catastral',
            name: 'clavecatastral'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Junta',
            name: 'junta'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Toma',
            name: 'toma'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Sector',
            name: 'nro_sector'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Zona',
            name: 'zona'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Caja',
            name: 'caja'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Regable',
            name: 'regable'
        }, {
            xtype: 'datefield',
            fieldLabel: 'Fecha_Creacion',
            name: 'fecha_creacion'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Lote',
            name: 'lotenro'
        }, {
            xtype: 'textfield',
            fieldLabel: 'Derivacion',
            name: 'derivacion'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Regada',
            name: 'regada'
        }, {
            xtype: 'datefield',
            fieldLabel: 'Fecha_Actual',
            name: 'fecha_actual'
			 }]   /////fin de form 
        }],
        buttons: [{
            text: 'Actualizar',
            type: 'submit',
			
            handler: function() {
			

          
                var form = actualdatoDialog.down('form').getForm();
				
				 var vals = form.getValues();
                 var currentdatousu = store.findRecord('id_npredio', vals['id_npredio']);
				 
				 if(vals['id_npredio'] && currentdatousu) {
                                currentdatousu.set('cedula', vals['cedula']);
                                currentdatousu.set('usuario', vals['usuario']);
                                currentdatousu.set('junta', vals['junta']);
                                currentdatousu.set('toma', vals['toma']);
                                currentdatousu.set('sector', vals['nro_sector']);
                                currentdatousu.set('zona', vals['zona']);
                                currentdatousu.set('caja', vals['caja']);
                                currentdatousu.set('regable', vals['regable']);
                                currentdatousu.set('fecha_creacion', vals['fecha_creacion']);
								currentdatousu.set('lotenro', vals['lotenro']);
								currentdatousu.set('derivacion', vals['derivacion']);
								currentdatousu.set('regada', vals['regada']);
								currentdatousu.set('fecha_actual', vals['fecha_actual']);
 			    }
				//////////////////PARA EL GUARDADO DE ELEMENTOS
				////////////creacion de las variables
				var idprimaria= actualdatoDialog.down('[name=id_npredio]').getValue();
			    var cedula= actualdatoDialog.down('[name=cedula]').getValue();
                var usuario= actualdatoDialog.down('[name=usuario]').getValue();
                var junta= actualdatoDialog.down('[name=junta]').getValue();
                var toma= actualdatoDialog.down('[name=toma]').getValue();
				var	sector= actualdatoDialog.down('[name=nro_sector]').getValue();
				var	zona= actualdatoDialog.down('[name=zona]').getValue();
				var	caja= actualdatoDialog.down('[name=caja]').getValue();
				var	regable= actualdatoDialog.down('[name=regable]').getValue();
				var	fecha_creacion= actualdatoDialog.down('[name=fecha_creacion]').getValue();
				var lotenro= nuevousuarioDialog.down('[name=lotenro]').getValue();
				var derivacion= nuevousuarioDialog.down('[name=derivacion]').getValue();
				var regada= nuevousuarioDialog.down('[name=regada]').getValue();
				var fecha_actual= nuevousuarioDialog.down('[name=fecha_actual]').getValue();
			   //////////////////fin de creacion de variables
			   
				Ext.Ajax.request({
				    url: 'claseoperacionesbdd.php?opcion=Editar',
					method:'POST',
				    params: {
						    idprimaria: idprimaria,        /////envio datos del id
							cedula: cedula,
							usuario: usuario,
							junta: junta,
							toma: toma,
							sector: sector,
							zona: zona,
							caja: caja,
							regable: regable,
							fecha_creacion: fecha_creacion,
							lotenro: lotenro,
							derivacion: derivacion,
							regada: regada,
							fecha_actual: fecha_actual,
						    },
					    success: function(response){
					        var text = response.responseText;
							if(text=="success")
								{
								 Ext.Msg.alert('Message', text);
								}
							 else
								 Ext.Msg.alert('Message', text);
      
					    }
				});  ///fin del request

				//////////////////FIN PARA EL GUARDADO DE ELEMENTOS
				actualdatoDialog.hide();
                actualdatoDialog.el.dom.reset();
				////////////////FINALIZACION DE metodos para la INSERCION de DATOS
				
				
            }  ///fin de handler
        }, {
            text: 'Cancelar',
            handler: function() {
                actualdatoDialog.hide();
            }
        }]
    });
	/////////////////fin otro aumento para edicion
	//////////////////////////////////////////////
	
	
});