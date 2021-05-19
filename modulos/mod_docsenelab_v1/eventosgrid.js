Ext.Loader.setConfig({enabled: true});

Ext.Loader.setPath('Ext.ux', 'ux/');

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
        fields: [
			{name:'id', type: 'int'},
			{name: 'fecha_registro',     type: 'string'},
            {name: 'grupo_codbarras_tramite',     type: 'string'},
			{name: 'grup_nombre',     type: 'string'},
			{name: 'form_cod_barras',     type: 'string'},
			{name: 'fecha_modificacion',     type: 'string'},
			{name: 'doc_fecha_conserv_emision',     type: 'string'},
			{name: 'doc_param_vigencia_anios',     type: 'string'},
			{name: 'doc_fecha_conserv_final',     type: 'string'},
			{name: 'descripcion',     type: 'string'},
			{name: 'doc_titulo',     type: 'string'},
			{name: 'param_tipo_documento',     type: 'string'},
			{name: 'doc_texto_contenido',     type: 'string'},
			{name: 'doc_responsable_emision',     type: 'string'},
			{name: 'nombre_departamento',     type: 'string'},
			{name: 'param_bodega',     type: 'string'},
			{name: 'param_estanteria',     type: 'string'},
			{name: 'param_nivel',     type: 'string'},
			{name: 'doc_observacion',     type: 'string'},
			{name: 'doc_estado',     type: 'string'},
			{name: 'usu_respons_edit',     type: 'string'},
			{name: 'cod_iden_grupo',     type: 'string'},
			{name: 'total_docsproces',     type: 'string'},
			{name: 'est_oficina',     type: 'string'},
			{name: 'est_general',     type: 'string'},
			{name: 'est_pasivo',     type: 'string'},
			{name: 'est_historico',     type: 'string'},
			{name: 'est_digital',     type: 'string'},
			{name: 'est_dardebaja',     type: 'string'},
			{name: 'param_cod_tipo_docum',     type: 'string'}	,
			{name: 'doc_fecha_conserv_alerta_1',     type: 'string'},
			{name: 'doc_fecha_conserv_alerta_2',     type: 'string'},
			{name: 'doc_numfolio',     type: 'string'},
			{name: 'doc_tipo_info',     type: 'string'},
			{name: 'doc_novedades',     type: 'string'},
			{name: 'nombre',     type: 'string'},
			{name: 'param_categoria',     type: 'string'},
			{name: 'param_subcategoria',     type: 'string'}
		]
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
        },
		//groupField: 'grup_nombre',     ////sirve para agrupar los datos
		//groupField: ['grup_nombre','descripcion'],
		 	
    });
    store.load();
	

    //////////////////FIN DE CREACION DE ALMACENES

/////////////para agrupar datos
var groupingFeature = Ext.create('Ext.grid.feature.Grouping',{
        groupHeaderTpl: 'Grupo: {name} ({rows.length} Item{[values.rows.length > 1 ? "s" : ""]})',
        hideGroupedHeader: true,
		startCollapsed: true,	

		
    });

/*
///////////////////PARA EDITAR LAS CELDAS DEL GRID
///////////////para  activar solo celdas para edicion
var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
	clicksToMoveEditor: 1,
        clicksToEdit: 2,
		autoCancel: false,
		
	 listeners: {

     //////////////para la edicion´
	 edit:
               //
            function(cellEditing,  record) {

            var sm = grid.getSelectionModel();
			var idprimaria=sm.getSelection()[0].get('id_usuario');
			var cedula=sm.getSelection()[0].get('cedula');
			var nombre=sm.getSelection()[0].get('nombre');
			var direccion_domicilio=sm.getSelection()[0].get('direccion_domicilio');
			var email=sm.getSelection()[0].get('email');
			var telefono_fijo=sm.getSelection()[0].get('telefono_fijo');
			var telefono_celular=sm.getSelection()[0].get('telefono_celular');
             //alert(JSON.stringify(recordData));

             Ext.Ajax.request({

                 url: 'claseoperacionesbdd.php?opcion=Editarunvalor',
                 method: 'POST',
                 // merge row data with other params
                 params: {
				       cedula: cedula,
					   nombre:  nombre,
					   direccion_domicilio: direccion_domicilio,
					   email: email,
					   telefono_fijo: telefono_fijo,
					   telefono_celular: telefono_celular,
					   idprimaria: idprimaria,
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
	/////////////////fin de edicion de celdas
///////////////////FIN PARA EDITAR LAS CELDAS DEL GRID
*/

/*
///////////////////PARA COLOCAR ESTILOS COLORES
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
//////////////////FIN /PARA COLOCAR ESTILOS COLORES
*/		
//creando columnas
   var createColumns = function (finish, start) {
	
	var columns = [
	         {
		        //xtype: 'numbercolumn',
                text     : 'ID',
                // flex     : 1,
			    width    : 50, 
                sortable : false, 
				//hidden   : true,
                dataIndex: 'id',
				//locked: true,            ///para bloquear columnas
                //lockable: false,         ///para bloquear columnas
				
            },
            {
				//header	 : 'USUARIO', 
                text: 'FECHA', width: 100, sortable: true, dataIndex: 'fecha_registro',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'date'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'COD_GRUPO', width: 100, sortable: true, dataIndex: 'grupo_codbarras_tramite',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'GRUPO', width: 100, sortable: true, dataIndex: 'grup_nombre',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'COD_BARRAS', width: 100, sortable: true, dataIndex: 'form_cod_barras',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			/*
			{
				//header	 : 'USUARIO', 
                text: 'USUARIO', width: 100, sortable: true, dataIndex: 'fecha_modificacion',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			*/
			{
				//header	 : 'USUARIO', 
                text: 'FECHA_EMISION', width: 100, sortable: true, dataIndex: 'doc_fecha_conserv_emision',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'date'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'VIGENCIA', width: 100, sortable: true, dataIndex: 'doc_param_vigencia_anios',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'FECHA_CONSERVACION', width: 100, sortable: true, dataIndex: 'doc_fecha_conserv_final',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'DETALLE', width: 100, sortable: true, dataIndex: 'descripcion',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'TITULO', width: 100, sortable: true, dataIndex: 'doc_titulo',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'DOCUM.', width: 100, sortable: true, dataIndex: 'param_tipo_documento',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'CONTENIDO', width: 100, sortable: true, dataIndex: 'doc_texto_contenido',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'RESPONSABLE', width: 100, sortable: true, dataIndex: 'doc_responsable_emision',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'DEPARTAMENTO', width: 100, sortable: true, dataIndex: 'nombre_departamento',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'BODEGA', width: 100, sortable: true, dataIndex: 'param_bodega',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'int'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTANTERIA', width: 100, sortable: true, dataIndex: 'param_estanteria',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'int'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'NIVEL', width: 100, sortable: true, dataIndex: 'param_nivel',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'int'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'OBSERVACION', width: 100, sortable: true, dataIndex: 'doc_observacion',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO', width: 100, sortable: true, dataIndex: 'doc_estado',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'DIGITADOR', width: 100, sortable: true, dataIndex: 'usu_respons_edit',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'TIPO_GEN_GRUPO', width: 100, sortable: true, dataIndex: 'cod_iden_grupo',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'TOTAL', width: 100, sortable: true, dataIndex: 'total_docsproces',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_OF', width: 100, sortable: true, dataIndex: 'est_oficina',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_GEN', width: 100, sortable: true, dataIndex: 'est_general',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_PAS', width: 100, sortable: true, dataIndex: 'est_pasivo',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_HIS', width: 100, sortable: true, dataIndex: 'est_historico',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_DIG', width: 100, sortable: true, dataIndex: 'est_digital',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ESTADO_BAJA', width: 100, sortable: true, dataIndex: 'est_dardebaja',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'COD_TIPO_DOC', width: 100, sortable: true, dataIndex: 'param_cod_tipo_docum',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ALERTA 1', width: 100, sortable: true, dataIndex: 'doc_fecha_conserv_alerta_1',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'ALERTA 2', width: 100, sortable: true, dataIndex: 'doc_fecha_conserv_alerta_2',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			/*
			{
				//header	 : 'USUARIO', 
                text: 'NUM_FOLIO', width: 100, sortable: true, dataIndex: 'doc_numfolio',
				//renderer : cambiacolorcedula, 
				//hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			*/
			{
				//header	 : 'USUARIO', 
                text: 'TIPO_DOC', width: 100, sortable: true, dataIndex: 'doc_tipo_info',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'NOVEDADES', width: 100, sortable: true, dataIndex: 'doc_novedades',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'NOMBRE', width: 100, sortable: true, dataIndex: 'nombre',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'CATEGORIA', width: 100, sortable: true, dataIndex: 'param_categoria',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },
			{
				//header	 : 'USUARIO', 
                text: 'SUBCAT', width: 100, sortable: true, dataIndex: 'param_subcategoria',
				//renderer : cambiacolorcedula, 
				hidden   : true,
				filter: { type: 'string'},
				//editor: { allowBlank: true}
            },

/////////////////////////ACCIONES DE GRID////////////////////////////////////
			  {
				    //header     : 'ACCIONES', 
                    xtype:'actioncolumn',
                    width:280,
					locked: true,   
                    items:[{
                        //icon:'images/lupa10.gif',    ///cuando se tiene iconos pequenios
                        tooltip:'Visualizar Datos',	
						iconCls:'vistafichaicon',   ///otra manera de poner icono con css				
                        handler:function(grid, rowIndex, colIndex) {


                              var employee = grid.getStore().getAt(rowIndex);
							  /*
                              var review = store.findRecord('id_usuario', employee.get('id_usuario'));
                           
                              var form = visualizarDialog.down('form').getForm();
                              form.loadRecord(employee);
                              form.loadRecord(review);
                              visualizarDialog.show();	 
							  */
							  var ponidver= employee.get('id');
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("mostrar_formficha.php?envidprimaria="+ponidver,"moswinform","width=700,height=420,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
                       		  
                        }
                    },
					{xtype: 'space'},
					{
                        //icon:'images/edit.png',
                        tooltip:'Imprimir',
						iconCls:'vistaimprimiricon',   ///otra manera de poner icono con css			
                        handler:function(grid, rowIndex, colIndex) {


                              var employee = grid.getStore().getAt(rowIndex);
							  /*
                              var review = store.findRecord('id_usuario', employee.get('id_usuario'));
                           
                              var form = actualdatoDialog.down('form').getForm();
                              form.loadRecord(employee);
                              form.loadRecord(review);
                              actualdatoDialog.show();	 
							  */
							  var ponidver= employee.get('id');
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("../obtencion/obt_vistaimgdocum.php?envidprimaria="+ponidver,"moswinform","width=700,height=420,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
                       		  
                        }
                    },
					{xtype: 'space'},
                    {
                       // icon:'images/elim.png',
                        tooltip:'Dar de Baja Dato',
						iconCls:'vistadarbajaicon',   ///otra manera de poner icono con css			
                        handler:function(grid, rowIndex, colIndex) {
							
							
							/*
							Ext.Msg.confirm('Dar de Baja Informacion?', 'Desea Dar de Baja el Dato?',
                                function(choice) {
                                    if(choice === 'yes') {
                                       
                                        var miusuariopadron = grid.getStore().getAt(rowIndex);
										var seleccionodato=miusuariopadron.get('id');
										//var versiesgrupo=miusuariopadron.get('cod_iden_grupo');
										alert(seleccionodato);
										//miusuariopadron.remove();
				         		        ///////////////ENVIAR DATOS AL OPERACIONES////////////
										Ext.Ajax.request({
					    				url: 'crea_dardebaja.php',
										method:'POST',
					    				params: {
												 Idenv: seleccionodato,
							    			},
					    				success: function(response){
					        			var text = response.responseText;
										     alert("Se Dio de Baja correctamente"+text);
					           			 }   ///fin de success
							           });   ///fin del request
									}
								});
                       		///////////////////  
                       */
							
						  ////////////////////PROCESO DE ELIMINACION DE UN DATOS
						
                           Ext.Msg.confirm('Eliminar?', 'Desea Eliminar el Dato?',
                                function(choice) {
                                    if(choice === 'yes') {
                                       
                                        var miusuariopadron = grid.getStore().getAt(rowIndex);
										///posicion del elemento seleccionado
                                        var posicelem = store.find('id', miusuariopadron.get('id'));
                                        store.removeAt(posicelem);
                                       // grid.getStore().removeAt(rowIndex);
										/////////////para empezar a eliminar cogemos el dato pero de la base de datos
										var seleccionodato=miusuariopadron.get('id');
										alert(seleccionodato);
				         ///////////////ENVIAR DATOS AL OPERACIONES////////////
						Ext.Ajax.request({
					    	url: 'crea_dardebaja.php',
							method:'POST',
					    	params: {
									 Idenv: seleccionodato,
							    	},
					    		success: function(response){
					        	var text = response.responseText;
								if(text=="success")
									{
								 	Ext.Msg.alert('Mensaje Eliminacion', "Se Dio de Baja correctamente"+text);
									}
							 		else
								 		Ext.Msg.alert('Mensaje Eliminacion', "Se Dio de Baja correctamente"+text); 
					           	}
							});   ///fin del request
				            ///////////////FIN ENVIAR DATOS AL OPERACIONES////////////
                      //////////////////////////////////solo eliminacion pura
                                    }
                                }
                            );  
							
					 ///////////////////FIN PARA EL PROCESO DE ELIMINACION DE UN DATOS
                        }    /////FIN DE HANDLER
                    }       /////FIN DEL ITEM O BOTON
					
					]    ///FIN DE TODOS LOS ITEMS
			  }    ////OTRO FIN
					////////////////////////FIN DE ACCIONES DE GRID
        ];
	
	  return columns.slice(start || 0, finish);  
	  
   };
	  
    
// Ext.create('Ext.ux.LiveSearchGridPanel', {
// Ext.create('Ext.grid.Panel', {
	 
//  var grid = Ext.create('Ext.grid.Panel', {      //////PANEL NORMAL
	var grid = Ext.create('Ext.ux.LiveSearchGridPanel', {    ////PANEL CON BUSQUEDAS
		region      : 'center',
		store: store,
		iconCls: 'icon-grid',
		//collapsible:true,
		/////AUMENTADO 
		selType: 'cellmodel',
		features: [filters],    //solo filtrados
		//features: [filters,groupingFeature],    //filtrado y agrupamiento simple
		/*
		features: [filters,{
            id: 'group',
            //ftype: 'groupingsummary',     ///para agrupamiento para sumatoria
			ftype:'grouping',
            groupHeaderTpl: '{name}',
            hideGroupedHeader: true,
			startCollapsed: true,	
            enableGroupingMenu: false
        }],
		*/
		
        columnLines: true,
        loadMask: false,
		columns: createColumns(50),
        renderTo: Ext.getBody(),
		/////////////////para toolbars ver
		 // inline buttons
        dockedItems: [
		////////////para el paginado
		Ext.create('Ext.toolbar.Paging', {
            dock: 'bottom',
            store: store
        }), {
		fbar  : [
		/*
		{
            text: 'Nuevo Usuario',
			iconCls: 'usuarjunta-add',
            handler: function() {
                nuevousuarioDialog.show();
            }
        },
		*/ 
		{
            text: 'Imprimir',
			iconCls: 'usuarjunta-export',
            handler: function() {
				///////////////////poner la funcion de exportacion
	            	Ext.ux.grid.Printer.printAutomatically = false;
	            	Ext.ux.grid.Printer.print(grid); 
            }
        },  '->',  	{
		xtype: 'box',
		text: 'Exportar Informacion',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<form name="paraexpxls" id="paraexpxls" action="exportar_reportexcel.php" method="post">' +
            '<table width="100" border="0" cellpadding="0" cellspacing="0"><tr><td width="25"><img src="images/excel_icon1.png" width="25" height="25" /></td><td width="129"><input type="submit" value="Exportar Datos" ' +  'style="color:#000; font:normal 10px arial,tahoma,verdana,helvetica; background-image:url(images/bagkboton.png);border-style:hidden;height: 24px;cursor:pointer; font-size:11px;-webkit-border-radius: 3px 3px;-ms-border-radius: 3px 3px;-moz-border-radius: 3px 3px;" /></td></tr></table></form>'
            }

		},
		/*{
		xtype: 'box',
		text: 'Exportar Informacion PDF',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<form  name="paraexpdf" id="paraexpdf" action="reportepdf.php" method="post">' +
            '<table width="150" border="0" cellpadding="0" cellspacing="0"><tr><td width="25"><img src="images/pdf_icon_b.png" width="25" height="25" /></td><td width="155"><input type="submit" value="Exportar Datos PDF" ' +  'style="color:#000; font:normal 11px arial,tahoma,verdana,helvetica; background-image:url(images/bagkboton.png);border-style:hidden;height: 24px;cursor:pointer; font-weight: bold;font-size:12px;-webkit-border-radius: 3px 3px;-ms-border-radius: 3px 3px;-moz-border-radius: 3px 3px;" /></td></tr></table></form>'
            }
		}
		*/
		////////////////////////fin de botones  
		]  //////fin del menu bar superior
		///////////////////////////////////////
		}
		],  
		
	    emptyText: 'No hay registros',    /////esto aumente  
        // plugins: [rowEditing],        /////para editar toda la fila
		//plugins: [cellEditing],       ////ESTE ES USA FUNCIONAL para editar solo una celda
		/////////////////////ver los ttolbars
        width: '100%',
        height: '100%',
        title: 'Gestion de Archivos de Oficina',
        //renderTo: 'grid_padronusu',
        viewConfig: {
            stripeRows: true,
			forceFit: true
        },
		
    });
	
	//////////////////este aumewntadito
	// add some buttons to bottom toolbar just for demonstration purposes
    grid.child('pagingtoolbar').add([
        '->',
    ]);

    /*
	///////////////////PARA CREAR CON FORMULARIO
	////////////////////para acutalizacion de datos
	    var nuevousuarioDialog = Ext.create('Ext.window.Window', {
        closeAction: 'hide',
        title: 'Registro de Nuevo Usuario del Padron',

        // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
        autoEl: 'form',
        width: 580,
        bodyPadding: 4,
        //layout: 'anchor',
		layout: 'hbox',
		//layout: 'column',
        defaults: {
            anchor: '100%'
        },
        defaultFocus: '[name=cedula]',
        items: [{
			//////para agrupamientos
			xtype:'fieldset',
            title:'.',
		   border      :false,
			items:[{
			    xtype:'fieldset',
             //   title:'Datos secundaria',
				
				layout:'hbox',
			    items:[{
				xtype:'fieldset',
                title:'Imagen ',
			    items:[{
				xtype: 'box', html: new Ext.XTemplate('<img style=" width="70px" height="55px" src="images/sinfoto.jpg" />').apply({
                name: 'logos-01'})
                } ,{
            xtype: 'fileuploadfield',
            fieldLabel: 'Subir Imagen',
            name: 'fotoimagen',
			width:200,
				}]
			
        },{
				xtype:'fieldset',
                title:'Datos Informativos',
			    border      :false,
			    items:[{
            xtype: 'textfield',
            fieldLabel: 'Cedula',
            name: 'cedula',
			minValue: 0,
		   // maxValue: 99,
		    maxLength: 10,
			enforceMaxLength: true,
			width:200,
			
        }, {
            xtype: 'textfield',
            fieldLabel: 'Usuario',
            name: 'nombre',
			width:280,
			},{
            xtype: 'textfield',
            fieldLabel: 'Domicilio',
            name: 'direccion_domicilio',
			width:280,
			}]         ////fin de agrupamiento
			}]         ////fin de agrupamiento
			}, {
				xtype:'fieldset',
               // title:'Datos ',
				columnWidth: 0.5,
				
				layout:'hbox',
			    items:[{
				 xtype:'fieldset',
               // title:'Datos Contacto',
			    border      :false,
				width:300,
			    items:[{
            xtype: 'textfield',
            fieldLabel: 'Email',
            name: 'email',
			width:250,
			}, {
            xtype: 'textfield',
            fieldLabel: 'Telf_Fijo',
            name: 'telefono_fijo',
			width:250,
			}, {
            xtype: 'textfield',
            fieldLabel: 'Telf_Celular',
            name: 'telefono_celular',
			width:250,
			       }]         ////fin de agrupamiento
					}, {
			xtype:'fieldset',
            //title:'Ubicacion Predial',
			border      :false,
			width:220,
			items:[{
				
				xtype: 'textfield',
            fieldLabel: 'Observacion',
            name: 'observacionpredio',
			width:200,
	       },{
            xtype: 'textfield',
            fieldLabel: 'Total_Predios',
            name: 'total_predios',
			value: 1,
			readOnly: true,
			width:200,
	       }]         ////fin de agrupamiento
	               }] 
				}]
		}
		
		],
		
        buttons: [{
            text: 'Agregar',
            type: 'submit',
			
            handler: function() {
			
				////////////////metodos para la INSERCION de DATOS
                   var newRec = Ext.ModelManager.create({
				    cedula: nuevousuarioDialog.down('[name=cedula]').getValue(),
                    nombre: nuevousuarioDialog.down('[name=nombre]').getValue(),
                    direccion_domicilio: nuevousuarioDialog.down('[name=direccion_domicilio]').getValue(),
					email: nuevousuarioDialog.down('[name=email]').getValue(),
					telefono_fijo: nuevousuarioDialog.down('[name=telefono_fijo]').getValue(),
					telefono_celular: nuevousuarioDialog.down('[name=telefono_celular]').getValue(),
					fotoimagen: nuevousuarioDialog.down('[name=fotoimagen]').getValue(),
					observacionpredio: nuevousuarioDialog.down('[name=observacionpredio]').getValue(),
					total_predios: nuevousuarioDialog.down('[name=total_predios]').getValue(),
					
					
					
				}, 'MiConjuntoDatos');
				/////aumenta a la secuencia de datos
                store.add(newRec);
				
				//////////////////PARA EL GUARDADO DE ELEMENTOS
				////////////creacion de las variables
			    var cedula= nuevousuarioDialog.down('[name=cedula]').getValue();
                var nombre= nuevousuarioDialog.down('[name=nombre]').getValue(); 			   					                 /////////////////////////datos adicionales de usuaiors
				var	direccion_domicilio= nuevousuarioDialog.down('[name=direccion_domicilio]').getValue();
				var	email= nuevousuarioDialog.down('[name=email]').getValue();
				var	telefono_fijo= nuevousuarioDialog.down('[name=telefono_fijo]').getValue();
				var	telefono_celular= nuevousuarioDialog.down('[name=telefono_celular]').getValue();
				var	fotoimagen= nuevousuarioDialog.down('[name=fotoimagen]').getValue();
				var	observacionpredio= nuevousuarioDialog.down('[name=observacionpredio]').getValue();
				var total_predios= nuevousuarioDialog.down('[name=total_predios]').getValue();

					
				Ext.Ajax.request({
				    url: 'claseoperacionesbdd.php?opcion=Agregar',
					method:'POST',
				    params: {
							cedula: cedula,
							nombre: nombre,							
							direccion_domicilio: direccion_domicilio,
							email: email,
							telefono_fijo: telefono_fijo,
							telefono_celular: telefono_celular,
							fotoimagen: fotoimagen,
							observacionpredio: observacionpredio,
							total_predios: total_predios,
						    },
					    success: function(response){
					        var text = response.responseText;
							if(text=="success")
								{
								 Ext.Msg.alert('Mensaje', text);
								}
							 else
								 Ext.Msg.alert('Mensaje', text);
      
					    }
				});  ///fin del request

				//////////////////FIN PARA EL GUARDADO DE ELEMENTOS
				nuevousuarioDialog.hide();
                nuevousuarioDialog.el.dom.reset();
				////////////////FINALIZACION DE metodos para la INSERCION de DATOS
				
				
            }  ///fin de handler
        }, '->', {
            text: 'Cancelar',
            handler: function() {
                nuevousuarioDialog.hide();
            }
        }]
    });
	/////////////////////////////fin aumento
	///////////////////PARA ACTUALIZAR CON FORMULARIO
	/////////////////otro aumento para edicion
	    var actualdatoDialog = Ext.create('Ext.window.Window', {
        closeAction: 'hide',
        title: 'Actualizacion de Usuarios del Padron',

        // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
        autoEl: 'form',
        width: 580,
        bodyPadding: 4,
        //layout: 'anchor',
		layout: 'hbox',
        defaults: {
            anchor: '100%'
        },

        defaultFocus: '[name=cedula]',
        items: [
		{
			xtype: 'form',
			layout:'hbox',
			items:[{
            xtype: 'hidden',
            fieldLabel: 'id_npredio',
            name: 'id_npredio'
            },{
			//////para agrupamientos
			xtype:'fieldset',
            title:'.',
		   border      :false,
			items:[{
			    xtype:'fieldset',
             //   title:'Datos secundaria',
				
				layout:'hbox',
			    items:[{
				xtype:'fieldset',
                title:'Imagen ',
			    items:[{
				xtype: 'box', html: new Ext.XTemplate('<img style=" width="70px" height="55px" src="images/sinfoto.jpg" />').apply({
                name: 'logos-01'})
                } ,{
            xtype: 'fileuploadfield',
            fieldLabel: 'Subir Imagen',
            name: 'fotoimagen',
			width:200,
				}]
			
        },{
				xtype:'fieldset',
                title:'Datos Informativos',
			    items:[{
            xtype: 'textfield',
            fieldLabel: 'Cedula',
            name: 'cedula',
			width:200,
			
        }, {
            xtype: 'textfield',
            fieldLabel: 'Usuario',
            name: 'nombre',
			width:200,
			},{
            xtype: 'textfield',
            fieldLabel: 'Domicilio',
            name: 'direccion_domicilio',
			width:200,
			}]         ////fin de agrupamiento
			}]         ////fin de agrupamiento
			}, {
				xtype:'fieldset',
               // title:'Datos ',
				columnWidth: 0.5,
				layout:'hbox',
			    items:[{
				 xtype:'fieldset',
                title:'Datos Contacto',
				width:220,
			    items:[{
            xtype: 'textfield',
            fieldLabel: 'Email',
            name: 'email',
			width:200,
			}, {
            xtype: 'textfield',
            fieldLabel: 'Telf_Fijo',
            name: 'telefono_fijo',
			width:200,
			}, {
            xtype: 'textfield',
            fieldLabel: 'Telf_Celular',
            name: 'telefono_celular',
			width:200,
			       }]         ////fin de agrupamiento
					}, {
			xtype:'fieldset',
            //title:'Ubicacion Predial',
			width:220,
			items:[{
				
				xtype: 'textfield',
            fieldLabel: 'Observacion',
            name: 'observacionpredio',
			width:200,
	       },{
            xtype: 'textfield',
            fieldLabel: 'Total_Predios',
            name: 'total_predios',
			width:200,
	       }]         ////fin de agrupamiento
	               }]  /////fin agrup
				}]
		}
		
		]}       ////////////fin del form
		],
		
        buttons: [{
            text: 'Actualizar',
            type: 'submit',
			
            handler: function() {
			

                var form = actualdatoDialog.down('form').getForm();
				
				 var vals = form.getValues();
                 var currentdatousu = store.findRecord('id_usuario', vals['id_usuario']);
				 
				 if(vals['id_usuario'] && currentdatousu) {
                                currentdatousu.set('cedula', vals['cedula']);
                                currentdatousu.set('nombre', vals['nombre']);
								
								currentdatousu.set('direccion_domicilio', vals['direccion_domicilio']);
								currentdatousu.set('email', vals['email']);
								currentdatousu.set('telefono_fijo', vals['telefono_fijo']);
								currentdatousu.set('telefono_celular', vals['telefono_celular']);
								currentdatousu.set('fotoimagen', vals['fotoimagen']);
								currentdatousu.set('observacionpredio', vals['observacionpredio']);
								currentdatousu.set('total_predios', vals['total_predios']);
 			    }
				//////////////////PARA EL GUARDADO DE ELEMENTOS
				////////////creacion de las variables
				var idprimaria= actualdatoDialog.down('[name=id_usuario]').getValue();
			    var cedula= actualdatoDialog.down('[name=cedula]').getValue();
                var nombre= actualdatoDialog.down('[name=nombre]').getValue();
			    /////////////////////////datos adicionales de usuaiors
				var	direccion_domicilio= actualdatoDialog.down('[name=direccion_domicilio]').getValue();
				var	email= actualdatoDialog.down('[name=email]').getValue();
				var	telefono_fijo= actualdatoDialog.down('[name=telefono_fijo]').getValue();
				var	telefono_celular= actualdatoDialog.down('[name=telefono_celular]').getValue();
				var	fotoimagen= actualdatoDialog.down('[name=fotoimagen]').getValue();
				var	observacionpredio= actualdatoDialog.down('[name=observacionpredio]').getValue();
				var	total_predios= actualdatoDialog.down('[name=total_predios]').getValue();
			   
				Ext.Ajax.request({
				    url: 'claseoperacionesbdd.php?opcion=Editar',
					method:'POST',
				    params: {
						    idprimaria: idprimaria,        /////envio datos del id
							cedula: cedula,
							nombre: nombre,							
							direccion_domicilio: direccion_domicilio,
							email: email,
							telefono_fijo: telefono_fijo,
							telefono_celular: telefono_celular,
							fotoimagen: fotoimagen,
							observacionpredio: observacionpredio,
							total_predios: total_predios,
							
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
        },'->', {
            text: 'Cancelar',
            handler: function() {
                actualdatoDialog.hide();
            }
        }]
    });
	/////////////////fin otro aumento para edicion
	//////////////////////////////////////////////
	///////////////////PARA VISTA TPREDETERMINADAS
		/////////////////otro aumento para edicion
	    var visualizarDialog = Ext.create('Ext.window.Window', {
        closeAction: 'hide',
        title: 'Actualizacion de Usuarios del Padron',

        // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
        autoEl: 'form',
        width: 580,
        bodyPadding: 4,
        //layout: 'anchor',
		layout: 'hbox',
        defaults: {
            anchor: '100%'
        },
        defaultFocus: '[name=cedula]',
        items: [{
			xtype: 'form',
			layout:'hbox',
			items:[{
            xtype: 'hidden',
            fieldLabel: 'id_npredio',
            name: 'id_npredio'
            },{
			//////para agrupamientos
			xtype:'fieldset',
            title:'.',
		   border      :false,
			items:[{
			    xtype:'fieldset',
             //   title:'Datos secundaria',
				
				layout:'hbox',
			    items:[{
				xtype:'fieldset',
                title:'Imagen ',
			    items:[{
				xtype: 'box', html: new Ext.XTemplate('<img style=" width="70px" height="55px" src="images/sinfoto.jpg" />').apply({
                name: 'logos-01'})
                } ,{
            xtype: 'fileuploadfield',
            fieldLabel: 'Subir Imagen',
            name: 'fotoimagen',
			width:200,
				}]
			
        },{
				xtype:'fieldset',
                title:'Datos Informativos',
			    items:[{
            xtype: 'displayfield',
            fieldLabel: 'Cedula',
            name: 'cedula',
			width:200,
			
        }, {
            xtype: 'displayfield',
            fieldLabel: 'Usuario',
            name: 'nombre',
			width:200,
			},{
            xtype: 'displayfield',
            fieldLabel: 'Domicilio',
            name: 'direccion_domicilio',
			width:200,
			}]         ////fin de agrupamiento
			}]         ////fin de agrupamiento
			}, {
				xtype:'fieldset',
               // title:'Datos ',
				columnWidth: 0.5,
				layout:'hbox',
			    items:[{
				 xtype:'fieldset',
                title:'Datos Contacto',
				width:220,
			    items:[{
            xtype: 'displayfield',
            fieldLabel: 'Email',
            name: 'email',
			width:200,
			}, {
            xtype: 'displayfield',
            fieldLabel: 'Telf_Fijo',
            name: 'telefono_fijo',
			width:200,
			}, {
            xtype: 'displayfield',
            fieldLabel: 'Telf_Celular',
            name: 'telefono_celular',
			width:200,
			       }]         ////fin de agrupamiento
					}, {
			xtype:'fieldset',
            //title:'Ubicacion Predial',
			width:220,
			items:[{
				
				xtype: 'displayfield',
            fieldLabel: 'Observacion',
            name: 'observacionpredio',
			width:200,
	       },{
            xtype: 'displayfield',
            fieldLabel: 'Total_Predios',
            name: 'total_predios',
			width:200,
	       }]         ////fin de agrupamiento
	               }] 
				}]
		}
		]}  //////fin del form
		],
        buttons: [{
            text: 'Imprimir',
            type: 'submit',
			
            handler: function() {
			
	            	Ext.ux.grid.Printer.printAutomatically = false;
	            	Ext.ux.grid.Printer.print(form); 
				
				
            }  ///fin de handler
        },'->', {
            text: 'Cancelar',
            handler: function() {
                visualizarDialog.hide();
            }
        }]
    });
	*/
	/////////////////fin otro aumento para edicion
	///////////////////////FINALIZAR VISTA
	
	
});