<?php
require_once('../../clases/conexion.php');

$varcodbarras = "";
$varcodidtram = "";
$varorignomtram = "";
if (isset($_GET["enviocodid"])) {
    $query = "select codi_barras,codigo_tramite,origen_tipo_tramite, codigo_documento from tbli_esq_plant_formunico_docsinternos where id='" . $_GET["enviocodid"] . "' ";
    $res = pg_query($conn, $query);
    $varcodbarras = pg_fetch_result($res, 0, 0);
    $varcodidtram = pg_fetch_result($res, 0, 1);
    $varorignomtram = pg_fetch_result($res, 0, 2);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
        Edicion de arbol
    </title>
    <link rel="stylesheet" type="text/css" href="ux/css/LiveSearchGridPanel.css" />
    <link rel="stylesheet" type="text/css" href="ux/statusbar/css/statusbar.css" />
    <link rel="stylesheet" type="text/css" href="ux/grid/css/GridFilters.css" />
    <link rel="stylesheet" type="text/css" href="ux/grid/css/RangeMenu.css" />

    <link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
    <script src="../../componentes/codebase/dhtmlx.js"></script>
    <link rel="stylesheet" type="text/css" href="../../extjs421/examples/shared/example.css">
    <!-- GC -->
    <script type="text/javascript" src="../../extjs421/examples/shared/include-ext.js"></script>

    <style type="text/css">
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0px;
            padding: 0px;
            background-color: #dce7fa;
            overflow: hidden;
            font-family: verdana, arial, helvetica, sans-serif;

        }

        .vistafichaicon {
            background-image: url(imgs/btnprev.png) !important;
            width: 40px !important;
            height: 22px !important;
            margin-right: auto !important;
            margin-left: auto !important;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .elimfichaicon {
            background-image: url(imgs/btninfo_eliminar.png) !important;
            width: 80px !important;
            height: 30px !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        .usuarjunta-export {
            background-image: url('../../extjs421/examples/shared/icons/fam/grid.png') !important;
        }

        .task {
            background-image: url(../../extjs421/examples/shared/icons/fam/cog.gif) !important;
        }

        .task-folder {
            background-image: url(../../extjs421/examples/shared/icons/fam/folder_go.gif) !important;
        }

        .export_infoxls {
            background-image: url('shared/icons/fam/iconexportxls.png') !important;
        }
    </style>
    <script type="text/javascript">
        Ext.Loader.setConfig({
            enabled: true
        });
        //Ext.Loader.setPath('Ext.ux', '../ux');
        Ext.Loader.setPath('Ext.ux', 'ux');
        Ext.require([
            'Ext.data.*',
            'Ext.grid.*',
            'Ext.tree.*',
            'Ext.ux.CheckColumn',
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

            /////////////////FIN DE FILTRADO

            //DEFINO CAMPOS A TRABAJAR
            Ext.define('MiModelo', {
                extend: 'Ext.data.Model',
                fields: [{
                        name: 'text',
                        type: 'string'
                    },
                    {
                        name: 'fecha',
                        type: 'string'
                    },
                    {
                        name: 'hora_ingreso',
                        type: 'string'
                    },
                    {
                        name: 'estado',
                        type: 'string'
                    },
                    {
                        name: 'destino_nombres',
                        type: 'string'
                    },
                    {
                        name: 'destino_cargo',
                        type: 'string'
                    },
                    {
                        name: 'origen_tipodoc',
                        type: 'string'
                    },
                    {
                        name: 'respuesta_observacion',
                        type: 'string'
                    },
                    {
                        name: 'respuesta_comentariotxt',
                        type: 'string'
                    },
                    {
                        name: 'fech_tiempo_dias',
                        type: 'string'
                    },
                    {
                        name: 'fecha_tiempo_atencion',
                        type: 'string'
                    },
                    {
                        name: 'resp_comentario_anterior',
                        type: 'string'
                    },
                    {
                        name: 'codigo_documento',
                        type: 'string'
                    },
                    {
                        name: 'origen_tipo_tramite',
                        type: 'string'
                    },
                    /*{name: 'form_cod_barras',     type: 'string'},
                     {name: 'fecha_registro',     type: 'string'},
                     {name: 'total_docsproces',     type: 'string'},
                     {name: 'descripcion',     type: 'string'},
                     {name: 'doc_titulo',     type: 'string'},
                     {name: 'doc_fecha_conserv_emision',     type: 'string'},
                     {name: 'doc_param_vigencia_anios',     type: 'string'},
                     {name: 'doc_responsable_emision',     type: 'string'},
                     {name: 'param_departamento',     type: 'string'},
                     {name: 'param_bodega',     type: 'string'},
                     {name: 'param_estanteria',     type: 'string'},
                     {name: 'param_nivel',     type: 'string'},
                     {name: 'cod_iden_grupo',     type: 'string'},*/
                    //{name: 'parent_id',     type: 'string'},
                ]
            });
            //////////////////////SIRVE PARA LLAMAR A LA PHP CONSULTA

            var treestoremio = Ext.create('Ext.data.TreeStore', {
                model: 'MiModelo',
                proxy: {
                    type: 'ajax',
                    <?php if ($varcodbarras != "") { ?>
                        url: 'treeseg.php?enviocodbarr=<?php echo $varcodbarras; ?>',
                    <?php } else { ?>
                        url: 'treeseg.php',
                    <?php } ?>

                    node: 'id' // send the parent id through GET (default 0)
                }
            });
            //treestoremio.load();    ////cuando se requiere aplicar expand All es necesario deshabilitar

            ///////////////////SIRVE PARA ACTUALIZAR CELDAS
            var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
                clicksToMoveEditor: 1,
                clicksToEdit: 2,
                autoCancel: false,
                listeners: {
                    //////////////para la edicion´
                    edit:

                        function(cellEditing, record) {

                            // ponvaridprim=record[0].get('id');
                            //alert("Edicion"+ponvaridprim);
                            var sm = treegrid.getSelectionModel();
                            var idprimakey = sm.getSelection()[0].get('id');
                            //alert("Edicion"+idprimakey);

                            var varcodigbarrsx = sm.getSelection()[0].get('form_cod_barras');
                            var varcodigvergrup = sm.getSelection()[0].get('cod_iden_grupo');
                            var vardescripcion = sm.getSelection()[0].get('descripcion');
                            var vardoc_titulo = sm.getSelection()[0].get('doc_titulo');
                            var varparam_departamento = sm.getSelection()[0].get('param_departamento');
                            //alert(varparam_departamento);
                            //alert("Edicion"+vardoc_titulo);
                            /////SOLO PARA VISUALIZAR EL CAMBIO
                            if (varcodigvergrup == 1) {
                                sm.getSelection()[0].set('text', varcodigbarrsx + ": " + vardescripcion);
                            } else {
                                sm.getSelection()[0].set('text', vardescripcion);
                            }


                            Ext.Ajax.request({

                                url: 'operacion_bddtree.php?opcion=Editarunvalor',
                                method: 'POST',
                                // merge row data with other params
                                params: {
                                    descripcion: vardescripcion,
                                    doc_titulo: vardoc_titulo,
                                    param_departamento: varparam_departamento,
                                    idprimaria: idprimakey,
                                },
                                success: function(response) {
                                    var text = response.responseText;
                                    if (text == "success") {
                                        Ext.Msg.alert('Mensaje', text);
                                    } else
                                        Ext.Msg.alert('Mensaje', text);
                                }
                            });
                        }
                    /////////////  
                } ///final de lisneter

            });

            ///////////////////////////////
            function cambiacoloralestado(valest) {
                if (valest == 'ATENDIDO') {
                    // return '<span style="color:#99CCFF;">' + valest + '</span>';
                    return '<div style="background-color:#b8fb85;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';
                }
                if (valest == 'PENDIENTE') {
                    return '<div style="background-color:#fcf6a2;height: 20px;" align="center"><span style="color:#F00;font-weight: bold;font-size:9px">' + valest + '</span></div>';
                }
                if (valest == 'REASIGNADO') {
                    return '<div style="background-color:#fdcfaa;height: 20px;" align="center"><span style="color:#894104;font-weight: bold;font-size:9px">' + valest + '</span></div>';
                }
                if (valest == 'ASIGNADO') {
                    return '<div style="background-color:#fef37f;height: 20px;" align="center"><span style="color:#894104;font-weight: bold;font-size:9px">' + valest + '</span></div>';
                }


                //return valest;	 
                return '<div style="background-color:#ebf3ff;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';

            }

            function mostrarcomentario(valest) {
                if (valest != '') {
                    return '<a href="#" data-toggle="tooltip" data-placement="left" title="' + valest + '" onclick="mensaje(\'' + valest + '\')">' + valest + '</a>';
                }
                return '<div class="tooltip top"><span>---</span></div>';
            }

            function cambiacolorcodigo(valest) {
                if (valest == 'BORRADOR') {
                    return '<div style="background-color:#b8fb85;" align="center"><span style="color:green;font-weight: bold;font-size:9px">---</span></div>';
                }
                return '<div style="background-color:#ebf3ff;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';
            }

            function open(val) {
                alert('ingreso');
                dhtmlx.confirm({
                    title: "Tipo de impresión",
                    type: "confirm-warning",
                    ok: "Si",
                    cancel: "No",
                    text: "Desea imprimir documento con cabezera y pie de página institucional?",
                    callback: function(result) {
                        if (result) {
                            miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=true&mvpr=" + val + "&varcodgenerado=", "moswinform", "width=950,height=650,scrollbars=no,left=400");
                            miPopupmapaobjtabauxgrf.focus();
                        } else {
                            miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=&mvpr=" + val + "&varcodgenerado=", "moswinform", "width=950,height=650,scrollbars=no,left=400");
                            miPopupmapaobjtabauxgrf.focus();
                        }
                    }
                });
            }
            ////////////////////////////////

            var configcolumnas = [{
                    //xtype: 'numbercolumn',
                    text: 'ID',
                    // flex     : 1,
                    width: 50,
                    sortable: false,
                    hidden: true,
                    dataIndex: 'id',
                    //locked: true,            ///para bloquear columnas
                    //lockable: false,         ///para bloquear columnas

                }, {
                    xtype: 'treecolumn', //this is so we know which column will show the tree
                    text: 'RESUMEN TRAMITE',
                    width: 490,
                    sortable: true,
                    dataIndex: 'text',
                    //locked: true,
                    //hidden   : true,
                    //sortable: true

                },
                {
                    text: 'TIPO',
                    width: 140,
                    dataIndex: 'origen_tipo_tramite',

                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
                	*/
                },
                {
                    text: 'DOCUMENTO',
                    width: 140,
                    dataIndex: 'codigo_documento',
                    renderer: cambiacolorcodigo,
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
                	*/
                },
                {
                    text: 'FECHA',
                    width: 80,
                    dataIndex: 'fecha',
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                },
                {
                    text: 'HORA',
                    width: 60,
                    dataIndex: 'hora_ingreso',
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                },
                {
                    text: 'ESTADO',
                    width: 100,
                    dataIndex: 'estado',
                    renderer: cambiacoloralestado,
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'DESTINO',
                    width: 100,
                    dataIndex: 'destino_nombres',
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'CARGO',
                    width: 100,
                    dataIndex: 'destino_cargo',
                    //locked: true,
                    //hidden   : true, 
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'FECHA LIMITE',
                    width: 90,
                    dataIndex: 'fecha_tiempo_atencion',
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'TIEMPO',
                    width: 100,
                    dataIndex: 'fech_tiempo_dias',
                    //locked: true,
                    hidden: true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'DOCUMENTO',
                    width: 100,
                    dataIndex: 'origen_tipodoc',
                    //locked: true,
                    hidden: true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'OBSERVACION',
                    width: 100,
                    dataIndex: 'respuesta_observacion',
                    //locked: true,
                    hidden: true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                {
                    text: 'COMENTARIO',
                    width: 100,
                    dataIndex: 'respuesta_comentariotxt',
                    renderer: mostrarcomentario,
                    //locked: true,
                    //hidden   : true,
                    //sortable: true
                    /*
                    editor: {
                    allowBlank: true
                    }
					*/
                },
                // {
                //     text: 'COMENTARIO ANTERIOR',
                //     width: 100,
                //     dataIndex: 'resp_comentario_anterior',
                //     renderer: mostrarcomentario,
                //     //locked: true,
                //     //hidden   : true,
                //     //sortable: true
                //     /*
                //     editor: {
                //     allowBlank: true
                //     }
				// 	*/
                // },

                ///////////////////////ACCIONES DE GRID////////////////////////////////////


                {
                    //header     : 'ACCIONES', 
                    xtype: 'actioncolumn',
                    width: 45,
                    locked: true,
                    items: [{
                            // icon:'imgs/btngrid_obt_verficha.png',
                            xtype: 'button',
                            tooltip: 'Ver documento',
                            //aumento
                            iconCls: 'vistafichaicon',
                            handler: function(grid, rowIndex, colIndex) {

                                var employee = grid.getStore().getAt(rowIndex);
                                // alert(employee.get('id'));
                                //var form = visualizarDialog.down('form').getForm();
                                //form.loadRecord(employee);
                                //visualizarDialog.show();	
                                var ponidver = employee.get('id');
                                var codigo = employee.get('codigo_documento');
                                var verrmisanexos = employee.get('codi_barras');
                                var miPopupmapaobjtabauxgrf;
                                var elaborado = employee.get('usuario_cedseguim');
                                var origen_tipo_tramite = employee.get('origen_tipo_tramite');
                                var verrespestadoedi = employee.get('est_respuesta_enedicion');
                                var origen_tipodoc = employee.get('origen_tipodoc');
                                if (verrespestadoedi == '1') {
                                    document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                    miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_doc_memo.php?borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver + "&elaborado=" + elaborado, "moswinform", "width=940,height=600,scrollbars=no,left=400");
                                    miPopupmapaobjtabauxgrf.focus();

                                } else if (origen_tipo_tramite == 'FORMULARIO EXTERNO') {
                                    document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                    miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_doc_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver + "&elaborado=" + elaborado, "moswinform", "width=940,height=650,scrollbars=no,left=400");
                                    miPopupmapaobjtabauxgrf.focus();
                                } else if (origen_tipodoc == 'TRAMITE') {
                                    document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                    miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_form_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver + "&elaborado=" + elaborado, "moswinform", "width=940,height=650,scrollbars=no,left=400");
                                    miPopupmapaobjtabauxgrf.focus();

                                } else if (origen_tipo_tramite == 'OFICIO') {
                                    dhtmlx.confirm({
                                        title: "Tipo de impresión",
                                        type: "confirm-warning",
                                        ok: "Si",
                                        cancel: "No",
                                        text: "Desea imprimir documento con cabezera y pie de página institucional?",
                                        callback: function(result) {
                                            if (result) {
                                                miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_oficio.php?plantilla=true&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
                                                miPopupmapaobjtabauxgrf.focus();
                                            } else {
                                                miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_oficio.php?plantilla=&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
                                                miPopupmapaobjtabauxgrf.focus();
                                            }
                                        }
                                    });

                                } else {
                                    dhtmlx.confirm({
                                        title: "Tipo de impresión",
                                        type: "confirm-warning",
                                        ok: "Si",
                                        cancel: "No",
                                        text: "Desea imprimir documento con cabezera y pie de página institucional?",
                                        callback: function(result) {
                                            if (result) {
                                                miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=true&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
                                                miPopupmapaobjtabauxgrf.focus();
                                            } else {
                                                miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=false&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
                                                miPopupmapaobjtabauxgrf.focus();
                                            }
                                        }
                                    });
                                }
                            }
                        },


                        {
                            xtype: 'space'
                        },
                        // {
                        //     //icon:'imgs/btninfo_eliminar.png',
                        //     xtype: 'button',
                        //     tooltip: 'Eliminar Dato',
                        //     //aumento
                        //     iconCls: 'elimfichaicon',
                        //     //width:80,
                        //     handler: function(grid, rowIndex, colIndex) {
                        //         Ext.Msg.confirm('Eliminar Usuario?', 'Desea Eliminar el Dato?',
                        //             function(choice) {
                        //                 if (choice === 'yes') {

                        //                     var miusuariopadron = grid.getStore().getAt(rowIndex);
                        //                     var seleccionodato = miusuariopadron.get('id');
                        //                     var versiesgrupo = miusuariopadron.get('cod_iden_grupo');


                        //                     miusuariopadron.remove();

                        //                     //treestoremio.sync();
                        //                     //var selection = treegrid.getSelectionModel().getSelection();
                        //                     //selection[0].remove();
                        //                     //treestoremio.sync();


                        //                     //alert(versiesgrupo);
                        //                     //alert(seleccionodato);
                        //                     ///////////////ENVIAR DATOS AL OPERACIONES////////////
                        //                     Ext.Ajax.request({
                        //                         url: 'operacion_bddtree.php?opcion=Eliminar',
                        //                         method: 'POST',
                        //                         params: {
                        //                             Idenv: seleccionodato,
                        //                         },
                        //                         success: function(response) {
                        //                             var text = response.responseText;
                        //                             //alert("Se elimino correctamente"+text);
                        //                             alert("Se elimino correctamente");

                        //                         } ///fin de success
                        //                     }); ///fin del request
                        //                     ///////////////FIN ENVIAR DATOS AL OPERACIONES////////////
                        //                     //////////////////////////////////solo eliminacion pura
                        //                 }
                        //             }
                        //         );
                        //     }
                        // }
                    ] ///FIN DE ITEMS
                } ////OTRO FIN

                ///////////////////////////////////////////////////////FIN DE ACCIONES DE GRID////////////////////////
            ];
            //CONFIGURACION GLOBAL DEL PANEL TREE CON GRID

            var treegrid = Ext.create('Ext.tree.Panel', {
                title: 'Seguimiento del Trámite  >> Nro: <?php echo $varcodbarras; ?> >> Codigo: <?php echo $varcodidtram; ?>  ',
                width: '100%',
                height: '100%',
                renderTo: Ext.getBody(),
                // collapsible: true,
                // expanded: true,
                useArrows: true,
                rootVisible: false,
                defaultType: 'treepanel',
                store: treestoremio,
                columns: configcolumnas,
                //plugins: [cellEditing],  
                /*
                 viewConfig: {
                 plugins: {
                 ptype: 'treeviewdragdrop',
                 enableDrag: true,
                 enableDrop: true,
                 appendOnly: true,
                 ddGroup: 'selDD',
                 dragGroup: 'selDD'
                 },
                 //copy: false,
                 listeners: {
                 
                 beforedrop: function(node, data) {    
                 //data.records[0].set('leaf', true);
                 //data.records[0].set('checked', null);
                 //alert(arguments);
                 },
                 drop: function(node, data, dropRec, dropPosition) {
                 //var dropOn = dropRec ? ' ' + dropPosition + ' ' + dropRec.get('text') : ' on empty view';
                 //alert(dropOn);
                 //alert(dropRec.get('text'));
                 //alert(dropRec.get('id'));
                 
                 var datorefparentid=dropRec.get('id');
                 var taman=data.records.length;
                 //alert(taman);
                 //sive para una sola fila seleccionada
                 //data.records[0].set('parent_id', daorefid);
                 for(var im=0;im<taman;im++)
                 {
                 ponvaridprim=data.records[im].get('id');
                 //alert(ponvaridprim);  ////id inicial
                 //alert(datorefparentid);  ////refer id padre 
                 /////sirve solo para refrescar la vista
                 // data.records[im].set('parent_id', datorefparentid);
                 
                 ////////////////////////////////////////////////////////////					
                 Ext.Ajax.request({
                 
                 url: 'operacion_bddtree.php?opcion=Editarparentid',
                 method: 'POST',
                 // merge row data with other params
                 params: {
                 parent_id: datorefparentid,
                 idprimaria: ponvaridprim,
                 },
                 success: function(response){
                 var text = response.responseText;
                 //alert(text); 
                 if(text=="success")
                 {
                 Ext.Msg.alert('Mensaje', text);
                 }
                 else
                 Ext.Msg.alert('Mensaje', text); 
                 }
                 });////fin de ajaz	
                 /////////////////////////////////////////////////////////////////////
                 } //fin de for
                 
                 }   ////fin de drop
                 }//////FIN DE LISTENER
                 ////////////////////////////////////
                 },   /////FIN DE viewConfig
                 */
                ///////ESTE EVENTO ES PARA TODO EL ARBOL			
                listeners: {
                    /*
                     itemclick: function(treeModel, record, item, index, e, eOpts){
                     regresavarid=record.get('id');
                     regresavartexto=record.get('text');
                     //alert(regresavarid);
                     
                     //////////////////////////////////////
                     }
                     */
                    ////////////////////////////////////////////////////
                },
                //multiSelect: true,
                //EN CASO DE SOLO PRESENTAR COMO ARBOL SIMPLEMENTE SE COMENTA ESTA LINEA DE COLUMNAS


                ///////////////MENU SUPERIOR
                dockedItems: [

                    /////////////////////item 1
                    {

                        fbar: [
                            'Trámite: <?php echo $varorignomtram; ?>',
                            '->',
                            {
                                text: 'Exportar Informacion',
                                iconCls: 'export_infoxls',
                                handler: function() {
                                    window.open("exportar_xls.php?enviocodbarr=<?php echo $varcodbarras; ?>");
                                }
                            },
                            /*
                    {
                    		text: 'Mostrar Información',
                            	handler: function(){
                            		treegrid.expandAll();
                            	}
					},
					*/
                            /*
                             {
                             text: 'Nuevo Usuario',
                             iconCls: 'usuarjunta-add',
                             handler: function() {
                             nuevousuarioDialog.show();
                             }
                             },
                             
                             {
                             text: 'Actualizar Contadores',
                             iconCls: 'usuarjunta-export',
                             handler: function() {
                             ///////////////////poner la funcion de exportacion
                             //Ext.ux.grid.Printer.printAutomatically = false;
                             //Ext.ux.grid.Printer.print(grid); 
                             document.location.href='crea_actualizogrupos.php';
                             }
                             },
                             */
                            // '->',
                            /*
                    {
                    xtype: 'textfield',
                            name: '_',
                            fieldLabel: 'BUSCAR INFORMACION',
                            width: 350,
                            labelWidth: 120,
                            allowBlank: true,
                            enableKeys: true,
                            listeners: {
                            specialkey: function (textfield, keypressEvent) {
                            if (keypressEvent.getKey() == keypressEvent.ENTER) {
                            // treegrid.searchFunction(textfield.getValue());
                            // alert(textfield.getValue());
                            rn = treegrid.getRootNode();
                            regex = new RegExp(textfield.getValue());
                            rn.findChildBy(function (child) {
                            var text = child.data.text;
                            if (regex.test(text) === true) {
                            //console.warn("selecting child", child);
                            treegrid.getSelectionModel().select(child, true);
                            var idencontrado = treegrid.getSelectionModel().getSelection()[0].get('id');
                            treegrid.getStore().getNodeById(idencontrado).expand();
                            }


                            });
                            //////////////////////////////////////////////

                            }
                            }
                            }
                    }, /////////////////////fin item 2
                  */
                            ////////////////////////fin de botones  
                        ] //////fin del menu bar superior
                        ///////////////////////////////////////
                    },
                    /////////////////////fin item 1

                ] ////fin de  dockedItems

                ///////////////////FIN DE MENU SUPERIOR
                ////////////////////OTRAS FUNCIONES
                ////////////////////FIN DE OTRAS FUNCIONES

                //////////////FINALIN
            });
            treegrid.expandAll();
            //////////////////////VISTA PREVIA
            /*
             var visualizarDialog = Ext.create('Ext.window.Window', {
             closeAction: 'hide',
             title: 'Vista Parametros',
             
             // Make the Window out of a <form> el so that the <button type="submit"> will invoke its handler upon CR
             autoEl: 'form',
             width: 600,
             bodyPadding: 4,
             //layout: 'anchor',
             layout: 'hbox',
             defaults: {
             anchor: '100%'
             },
             // defaultFocus: '[name=cedula]',
             items: [
             {
             xtype: 'form',
             layout:'hbox',
             items:[{
             xtype: 'hidden',
             fieldLabel: 'id',
             name: 'id'
             },
             ///////////////////////////////inicio fieldset
             {
             xtype:'fieldset',
             title:'Datos:',
             width:600,
             height:550,
             // border      :false,
             items:[
             {
             xtype: 'displayfield',
             fieldLabel: 'Codigo',
             name: 'form_cod_barras',
             width:200,
             },
             {
             xtype: 'displayfield',
             fieldLabel: 'Descripcion',
             name: 'descripcion',
             width:300,
             },
             {
             xtype : "component",
             autoEl : {
             tag : "iframe",
             width:560,
             height:470,
             margin: '5 5 5 0',
             layout: 'fit',
             autoScroll: true,
             //src : "reports.html"
             html : '<iframe src="../docs_grupos/mostrar_formficha.php?envidprimaria=100" width="100%" height="100%"></iframe>'
             }
             }
             ]
             }
             ///////////////////////////////fin fieldset
             ]
             }]
             });
             */
            //////////////////////////FIN DE VISTA PREVIA

        });
    </script>
    <link rel="stylesheet" type="text/css" href="../../extjs421/resources/css/ext-all-gray.css" />
    <link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
    <script>
        function mensaje(val) {
            // alertify.mensaje("This is a confirm dialog.");
            alertify
                .alert("Comentario", val, function() {

                });
            // alert('Comentario: \n' + val);
        }
    </script>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0">
</body>

</html>