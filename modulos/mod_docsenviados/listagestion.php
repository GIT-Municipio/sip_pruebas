 <?php
	require_once('../../clases/conexion.php');
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
	$_SESSION["configmodusesion"] = "openmod_recibidos";
	//////////////////////PARAMETROS GLOBALES/////////////////
	if (isset($_GET['mibtnopcionbandeja']) != "")
		$param_mitipobandeja = $_GET['mibtnopcionbandeja'];
	else
		$param_mitipobandeja = "";
	//////////USUARIO ACTIVO
	if (isset($_GET['retornmiusuarioseguim']) != "")
		$param_verusuactivoses = $_GET['retornmiusuarioseguim'];
	else
		$param_verusuactivoses = "";
	/////////VISTA
	$param_tablavista = "vista_mostrarorigendestino_recibidos";
	$param_campordenvista = "destino_fecha_creado desc";       ////forma ascendente   asc    en descendente desc

	if (isset($_GET['optgrupconfig']) == 1) {
		$param_configrup = "1";                 /////para agrupar valor 0: sin agrupar    1: agrupando
		$param_conficampogrup = $_GET['optgrupcampo'];           /////si el anterior es 1 especificar el nombre del campo
	} else {
		$param_configrup = "0";                 /////para agrupar valor 0: sin agrupar    1: agrupando
		$param_conficampogrup = "codi_barras";          /////si el anterior es 1 especificar el nombre del campo
	}

	$param_configruporden = "DESC";          /////si el anterior es 1 especificar el nombre del campo
	/////////EDICION
	$param_tablaedit = "tbli_esq_plant_formunico_docsinternos";
	$param_camprimarioedit = "id";
	////////////////////////////////////////

	/////////////////TODOS LOS CAMPOS
	//$campostodos="id,codi_barras,selec_tempoitem,img_bandera_tatencion, destino_fecha_creado, destino_tipo_tramite,destino_tipodoc,destino_form_asunto,  origen,  destino,respuesta_comentariotxt,respuesta_observacion, destino_cedul";
	$campostodos = "id,codi_barras,img_bandera_tatencion,num_memocreado as tramite,codigo_documento,destino_fecha_creado as fecha, destino_tipo_tramite as tipo_tramite,destino, origen_form_asunto as asunto,  respuesta_comentariotxt as comentario, resp_estado_anterior as tipo,est_respuesta_reasignado,est_respuesta_enviado,origen_tipo_tramite,ref_plantilla,ref_tramwebid, origen_tipodoc";
	////////////////CAMPOS OCULTOS////////////
	//$camposocultos="id,destino_cedul,codigo_tramite,respuesta_estado,est_respuesta_reasignado,est_respuesta_enviado";
	$camposocultos = "id,destino_cedul,codi_barras,est_respuesta_reasignado,codigo_tramite,est_respuesta_enviado,ref_plantilla,ref_tramwebid,destino_tipo_tramite as tipo_tramite,origen_tipodoc,origen_tipo_tramite";

	////////////////CAMPOS EDICION////////////
	$camposparaeditar = "";

	////////////////CAMPOS TAMAÑO////////////
	$camposparatamanios = array("id" => "30", "img_bandera_tatencion" => "30", "tramite" => "70", "fecha" => "70", "codigo_documento" => "150", "codigo_tramite" => "110", "memocreado" => "100", "codi_barras" => "80", "num_memocreado" => "80", "destino_fecha_creado" => "80", "origen" => "150", "destino" => "150", "respuesta_comentariotxt" => "150", "respuesta_observacion" => "150");
	/////////////////////////////////////////////////////////////////////////////

	$sql = "SELECT " . $campostodos . " FROM " . $param_tablavista;
	$res = pg_query($conn, $sql);
	$numercampos = pg_num_fields($res);
	///////////funcion de busquedas
	function buscardatocadena($camposovector, $datentrada)
	{
		$varlrposic = NULL;
		$vectext = explode(',', $camposovector);
		for ($im = 0; $im < count($vectext); $im++) {
			if (trim($vectext[$im]) == $datentrada) {
				$varlrposic = '999';
				break;
			}
		}
		return  $varlrposic;
	};

	function buscardatotamanio($arraycmps, $datentrada)
	{
		$valortama = 0;
		foreach ($arraycmps as $x => $x_value) {
			if ($x == $datentrada)
				$valortama = $x_value;
		}
		//echo $valortama;
		return $valortama;
	};
	?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
 <html>

 <head>
 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	<title>Gestion de Archivo</title>
 	<link rel="stylesheet" type="text/css" href="ux/css/LiveSearchGridPanel.css" />
 	<link rel="stylesheet" type="text/css" href="ux/statusbar/css/statusbar.css" />
 	<link rel="stylesheet" type="text/css" href="shared/example.css" />
 	<link rel="stylesheet" type="text/css" href="ux/grid/css/GridFilters.css" />
 	<link rel="stylesheet" type="text/css" href="ux/grid/css/RangeMenu.css" />
 	<script type="text/javascript" src="../../extjs421/examples/shared/include-ext.js"></script>
 	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
	 <script src="../../componentes/codebase/dhtmlx.js"></script>
	 <link href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" rel="stylesheet" />
 	<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
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

 		.usuarjunta-add {
 			background-image: url('shared/icons/fam/user_add.gif') !important;
 		}

 		.usuarjunta-remove {
 			background-image: url('shared/icons/fam/user_delete.gif') !important;
 		}

 		.usuarjunta-export {
 			background-image: url('shared/icons/fam/grid.png') !important;
 		}

 		.icon-grid {
 			background-image: url(shared/icons/fam/grid.png) !important;
 		}

 		.x-grid-row-over .x-grid-cell-inner {
 			font-weight: bold;
 		}

 		.vistafichaicon {
 			background-image: url(imgs/btnseginfo.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistamostrarseguim {
 			background-image: url(imgs/btnseg.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistarespondericon {
 			background-image: url(imgs/btnmenjs.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistaimprimiricon {
 			background-image: url(imgs/btngrid_obt_imprimir.png) !important;
 			width: 80px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistadarbajaicon {
 			background-image: url(imgs/btninfo_dardebaja.png) !important;
 			width: 80px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistaeliminaricon {
 			background-image: url(imgs/btninfo_eliminar.png) !important;
 			width: 80px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistaanexosicon {
 			background-image: url(imgs/btnmanex.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistareasignaricon {
 			background-image: url(imgs/btnreaisgn.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistavisualizaricon {
 			background-image: url(imgs/btnprev.png) !important;
 			width: 40px !important;
 			height: 24px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		/* PARA MENUS SUPERIORES*/
 		.topbtn_desagrup {
 			background-image: url('shared/icons/fam/xdesagruplist.png') !important;
 		}

 		.topbtn_expe {
 			background-image: url('shared/icons/fam/btnxexped.png') !important;
 		}

 		.topbtn_xfech {
 			background-image: url('shared/icons/fam/btnfecha.png') !important;
 		}

 		.topbtn_xtramit {
 			background-image: url('shared/icons/fam/btnxtramit.png') !important;
 		}

 		.topbtn_xtipodoc {
 			background-image: url('shared/icons/fam/btnxcateg.png') !important;
 		}

 		.topbtn_xusuar {
 			background-image: url('shared/icons/fam/btnxgrupus.png') !important;
 		}
 	</style>

 	<script type="text/javascript">
 		function mensaje(val) {
 			alertify
 				.alert("Comentario", val, function() {

 				});
 		}

 		function funcionexportxls() {
 			document.location.href = "exportar_xls.php";
 		}
 		// Ext.Loader.setConfig({
 		// 	enabled: true
 		// });

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
 					<?php
						for ($col = 0; $col < $numercampos; $col++) {
							$valortipo = pg_field_type($res, $col);
							switch ($valortipo) {
								case 'int4':
									echo "{name:'" . pg_field_name($res, $col) . "', type: 'int'},";
									break;
								case 'date':
									echo "{name:'" . pg_field_name($res, $col) . "', type: 'string'},";
									break;
								case 'varchar':
									echo "{name:'" . pg_field_name($res, $col) . "', type: 'string'},";
									break;
								case 'text':
									echo "{name:'" . pg_field_name($res, $col) . "', type: 'string'},";
									break;
								default:
									echo "{name:'" . pg_field_name($res, $col) . "', type: '" . pg_field_type($res, $col) . "'},";
							}
						}
						?>
 				]
 			});
 			Ext.define('Sandbox.view.SearchTrigger', {
 				extend: 'Ext.form.field.Text',
 				alias: 'widget.searchtrigger',
 				triggers: {
 					search: {
 						cls: 'x-form-search-trigger',
 						handler: function() {
 							this.setFilter(this.up().dataIndex, this.getValue())
 						}
 					},
 					clear: {
 						cls: 'x-form-clear-trigger',
 						handler: function() {
 							this.setValue('')
 							if (!this.autoSearch) this.setFilter(this.up().dataIndex, '')
 						}
 					}
 				},
 				setFilter: function(filterId, value) {
 					var store = this.up('grid').getStore();
 					if (value) {
 						store.removeFilter(filterId, false)
 						var filter = {
 							id: filterId,
 							property: filterId,
 							value: value
 						};
 						if (this.anyMatch) filter.anyMatch = this.anyMatch
 						if (this.caseSensitive) filter.caseSensitive = this.caseSensitive
 						if (this.exactMatch) filter.exactMatch = this.exactMatch
 						if (this.operator) filter.operator = this.operator
 						console.log(this.anyMatch, filter)
 						store.addFilter(filter)
 					} else {
 						store.filters.removeAtKey(filterId)
 						store.reload()
 					}
 				},
 				listeners: {
 					render: function() {
 						var me = this;
 						me.ownerCt.on('resize', function() {
 							me.setWidth(this.getEl().getWidth())
 						})
 					},
 					change: function() {
 						if (this.autoSearch) this.setFilter(this.up().dataIndex, this.getValue())
 					}
 				}
 			})
 			var store = Ext.create('Ext.data.JsonStore', {
 				model: 'MiConjuntoDatos',
 				pageSize: 20, ///esto aumente
 				proxy: {
 					type: 'ajax',
 					<?php if ($param_verusuactivoses != "") { ?>

 						<?php if ($param_mitipobandeja != "") { ?>
 							url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&mibtnopcionbandeja=<?php echo $param_mitipobandeja; ?>',
 						<?php } else { ?>
 							/////////////////////////////////////////////
 							<?php if (isset($_GET['consulvarfecha']) != "") { ?>
 								url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&consulvarfecha=<?php echo $_GET['consulvarfecha']; ?>',
 								//////////////////////////////
 							<?php } else if (isset($_GET['consulvarfechaini']) != "") { ?>
 								url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&consulvarfechaini=<?php echo $_GET['consulvarfechaini']; ?>&consulvarfechafin=<?php echo $_GET['consulvarfechafin']; ?>',
 							<?php } else if (isset($_GET['consulvarcampo']) != "") { ?>
 								url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&consulvarcampo=<?php echo $_GET['consulvarcampo']; ?>&consulvarinfo=<?php echo $_GET['consulvarinfo']; ?>',
 							<?php } else { ?>
 								url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>',
 							<?php } ?>
 							//////////////////////////////////////////////////////
 						<?php } ?>
 					<?php } else { ?>
 						url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>',
 					<?php } ?>
 					reader: {
 						type: 'json',
 						root: 'data',
 						totalProperty: 'total'
 					},
 				},
 				groupField: 'codigo_tramite',
 				groupDir: 'DESC'
 				<?php if ($param_configrup == "1") { ?>
 					////sirve para agrupar los datos
 				<?php } ?>
 			});
 			store.load();
 			//////////////////FIN DE CREACION DE ALMACENES
 			/////////////para agrupar datos
 			var groupingFeature = Ext.create('Ext.grid.feature.Grouping', {
 				groupHeaderTpl: 'Grupo: {name} ({rows.length} Item{[values.rows.length > 1 ? "s" : ""]})',
 				hideGroupedHeader: true,
 				//startCollapsed: true,	
 			});

 			///////////////////PARA EDITAR LAS CELDAS DEL GRID
 			///////////////para  activar solo celdas para edicion
 			var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
 				clicksToMoveEditor: 1,
 				clicksToEdit: 2,
 				autoCancel: false,
 				listeners: {
 					edit:
 						//
 						function(cellEditing, record) {

 							var sm = grid.getSelectionModel();

 							<?php
								for ($col = 0; $col < $numercampos; $col++) {
									$nombrecamp = pg_field_name($res, $col);
									$posedits = buscardatocadena($camposparaeditar, $nombrecamp);
									if ($posedits != NULL)
										echo "var " . $nombrecamp . "=sm.getSelection()[0].get('" . $nombrecamp . "');" . "\n";
								}
								?>
 							Ext.Ajax.request({

 								url: 'claseoperacionesbdd.php?opcion=Editarunvalor&mitabla=<?php echo $param_tablaedit; ?>&enviocampos=<?php echo $camposparaeditar; ?>&elidprimar=<?php echo $param_camprimarioedit; ?>',
 								method: 'POST',
 								// merge row data with other params
 								params: {

 									<?php
										for ($col = 0; $col < $numercampos; $col++) {
											$nombrecamp = pg_field_name($res, $col);
											$posedits = buscardatocadena($camposparaeditar, $nombrecamp);
											if ($posedits != NULL)
												echo " " . $nombrecamp . ": " . $nombrecamp . ", " . "\n";
										}
										?>

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
 			///////////////////FIN PARA EDITAR LAS CELDAS DEL GRID
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
 				if (valest == 'EN_RESPUESTA' || valest == 'EN_DEVOLUCION' || valest == 'EN_RESPUESTA MEMO') {
 					return '<div style="background-color:#A7D4DA;height: 20px;" align="center"><span style="color:#CD5C5C;font-weight: bold;font-size:9px">' + valest + '</span></div>';
 				}
 				//return valest;	 
 				return '<div style="background-color:#A7D4DA;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';
 			}

 			function mostrarcomentario(valest) {
 				if (valest != '') {
 					return '<a href="#" data-toggle="tooltip" data-placement="left" title="' + valest + '" onclick="mensaje(\'' + valest + '\')">' + valest + '</a>';
 				}
 				return '<div class="tooltip top"><span>---</span></div>';
 			}

 			//creando columnas
 			var createColumns = function(finish, start) {
 				var columns = [
 					<?php
						for ($col = 0; $col < $numercampos; $col++) {
							$nombrecamp = pg_field_name($res, $col);
							$valortipo = pg_field_type($res, $col);
							/////////////////buscar
							$posocults = buscardatocadena($camposocultos, $nombrecamp);
							$posedits = buscardatocadena($camposparaeditar, $nombrecamp);
							$posdartamancelda = buscardatotamanio($camposparatamanios, $nombrecamp);
							switch ($valortipo) {
								case 'int4':
									$valortipo = "int";
									break;
								case 'date':
									$valortipo = "date";
									break;
								case 'varchar':
									$valortipo = "string";
									break;
								case 'text':
									$valortipo = "string";
									break;
								default:
									$valortipo = $valortipo;
							}
							if ($nombrecamp == 'id') {
								echo "{" . "\n";
								echo "	         //xtype: 'numbercolumn'," . "\n";
								echo "	         text     : '" . strtoupper($nombrecamp) . "'," . "\n";
								echo "	         // flex     : 1," . "\n";
								echo "	         width    : 50, " . "\n";
								echo "	         sortable : false, " . "\n";
								if ($posocults != NULL)
									echo  "	         hidden     : true," . "\n";
								echo "	         dataIndex: '" . $nombrecamp . "'," . "\n";
								echo "	         //locked: true,            ///para bloquear columnas" . "\n";
								echo "	         //lockable: false,         ///para bloquear columnas" . "\n";
								echo "	   }," . "\n";
							} else {
								echo "	   {" . "\n";
								echo "	       //header	 : '" . strtoupper($nombrecamp) . "'," . "\n";
								if ($nombrecamp == "selec_tempoitem") {
									echo "	         xtype: 'checkcolumn'," . "\n";
									echo "	         width: 30," . "\n";
									echo "	        locked: true," . "\n";
								} else {
									if ($posdartamancelda >= 1)
										echo "	     width: " . $posdartamancelda . "," . "\n";
									else
										echo "	     width: 130," . "\n";
								}

								echo "	       text: '" . strtoupper($nombrecamp) . "',sortable: true,dataIndex: '" . $nombrecamp . "'," . "\n";
								echo "	         //renderer : cambiacolorcedula," . "\n";

								if ($nombrecamp == "img_bandera_tatencion")
									echo "	        locked: true," . "\n";

								if ($nombrecamp == "resp_estado_anterior") {
									echo "	        locked: true," . "\n";
									echo "	        renderer : cambiacoloralestado,";
								}
								if ($nombrecamp == "codigo_documento") {
									echo "	         width    : 200, " . "\n";
								}
								if ($nombrecamp == "tipo") {
									echo "	        locked: true," . "\n";
									echo "	         width: 100," . "\n";
									echo "	        renderer : cambiacoloralestado,";
								}
								if ($nombrecamp == "img_bandera_tatencion")
									echo "renderer: function(value){return " . "'" . "<img src=" . "'+value+'" . " />';}";

								if ($posocults != NULL)
									echo  "	         hidden     : true," . "\n";
								if ($nombrecamp == "img_bandera_tatencion")
									echo "	         //filter: { type: '" . $valortipo . "'}," . "\n";
								else {
									echo "	         filter: { type: '" . $valortipo . "'}," . "\n";
								}
								if ($posedits != NULL)
									echo "	         editor: { allowBlank: true}" . "\n";
								if ($nombrecamp == "asunto") {
									echo "			renderer : mostrarcomentario,";
								}
								if ($nombrecamp == "comentario") {
									echo "			renderer : mostrarcomentario,";
								}
								if ($nombrecamp == "tramite") {
									echo "	        locked: false," . "\n";
									echo "	         sortable : true, " . "\n";
									echo "			items:[{xtype: 'searchtrigger',	autoSearch: true }] " . "\n";
								}
								echo "	   }," . "\n";
							}
						}
						?>

 					/////////////////////////ACCIONES DE GRID////////////////////////////////////
 					{
 						//header     : 'ACCIONES', 
 						xtype: 'actioncolumn',
 						<?php if ($_SESSION['sesusuario_usutipo_rol'] == "1" or $_SESSION['sesusuario_usutipo_rol'] == "2") { ?>
 							width: 110,
 						<?php } else { ?>
 							width: 110,
 						<?php } ?>

 						locked: true,

 						items: [{
 								xtype: 'space'
 							},
 							// {
 							// 	tooltip: 'Mostrar Seguimiento',
 							// 	iconCls: 'vistamostrarseguim', ///otra manera de poner icono con css				
 							// 	handler: function(grid, rowIndex, colIndex) {
 							// 		var employee = grid.getStore().getAt(rowIndex);
 							// 		var ponidver = employee.get('id');
 							// 		var miPopupmapaobjtabauxgrf;
 							// 		miPopupmapaobjtabauxgrf = window.open("../mod_docseguimtree/modtreeseguim.php?enviocodid=" + ponidver, "moswinform", "width=800,height=420,scrollbars=no,left=400");
 							// 		miPopupmapaobjtabauxgrf.focus();
 							// 	}
 							// },
 							{
 								tooltip: 'Visualizar Datos',
 								iconCls: 'vistafichaicon', ///otra manera de poner icono con css				
 								handler: function(grid, rowIndex, colIndex) {
 									var employee = grid.getStore().getAt(rowIndex);
 									var ponidver = employee.get('id');
 									var verrmisanexos = employee.get('codi_barras');
 									var vermyplantillx = employee.get('ref_plantilla');
 									var vermicodidtramitx = employee.get('ref_tramwebid');
 									var miPopupmapaobjtabauxgrf;
 									miPopupmapaobjtabauxgrf = window.open("../mod_docvista/vista_previatram_intern.php?mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos + "&vermyplantillx=" + vermyplantillx + "&vermicodidtramitx=" + vermicodidtramitx, "moswinform", "width=900,height=650,scrollbars=no,left=400");
 									miPopupmapaobjtabauxgrf.focus();
 								}
 							},
 							// {
 							// 	tooltip: 'Ver Anexos',
 							// 	iconCls: 'vistaanexosicon', ///otra manera de poner icono con css			
 							// 	handler: function(grid, rowIndex, colIndex) {
 							// 		var employee = grid.getStore().getAt(rowIndex);
 							// 		var ponidver = employee.get('id');
 							// 		var verrmisanexos = employee.get('codi_barras');
 							// 		var miPopupmapaobjtabauxgrf;
 							// 		miPopupmapaobjtabauxgrf = window.open("vista_previanexos.php?mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=700,height=420,scrollbars=no,left=400");
 							// 		miPopupmapaobjtabauxgrf.focus();
 							// 	}
 							// },
 							{
 								tooltip: 'Ver documento',
 								iconCls: 'vistavisualizaricon', ///otra manera de poner icono con css			

 								handler: function(grid, rowIndex, colIndex) {
 									var employee = grid.getStore().getAt(rowIndex);
 									var ponidver = employee.get('id');
 									var verrmisanexos = employee.get('codi_barras');
 									var miPopupmapaobjtabauxgrf;
 									var origen_tipo_tramite = employee.get('origen_tipo_tramite');
 									var origen_tipodoc = employee.get('origen_tipodoc');
 									if (origen_tipo_tramite == 'FORMULARIO EXTERNO') {
 										document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
 										miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_doc_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver, "moswinform", "width=940,height=600,scrollbars=no,left=400");
 										miPopupmapaobjtabauxgrf.focus();

 									} else if (origen_tipo_tramite == 'OFICIO') {

 										miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_oficio.php?plantilla=true&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
 										miPopupmapaobjtabauxgrf.focus();
 									} else if (origen_tipodoc == 'TRAMITE') {
 										document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
 										miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_form_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver, "moswinform", "width=940,height=600,scrollbars=no,left=400");
 										miPopupmapaobjtabauxgrf.focus();
 									} else if (origen_tipo_tramite == 'MEMORANDO') {
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
 													miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
 													miPopupmapaobjtabauxgrf.focus();
 												}
 											}
 										});
 									} else {
 										document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
 										miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_form_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver, "moswinform", "width=940,height=600,scrollbars=no,left=400");
 										miPopupmapaobjtabauxgrf.focus();
 									}
 								}
 							},

 						] ///FIN DE TODOS LOS ITEMS
 					} ////OTRO FIN
 				];
 				return columns.slice(start || 0, finish);

 			};
 			var grid = Ext.create('Ext.grid.Panel', { //////PANEL NORMAL
 				region: 'center',
 				store: store,
 				iconCls: 'icon-grid',
 				selType: 'cellmodel',
 				features: [filters], //solo filtrados
 				<?php if ($param_configrup == "1") { ?>
 					features: [filters, groupingFeature], //filtrado y agrupamiento simple
 				<?php }  ?>
 				columnLines: true,
 				loadMask: false,
 				columns: createColumns(<?php echo $numercampos + 5; ?>),
 				renderTo: Ext.getBody(),
 				/////////////////para toolbars ver
 				dockedItems: [
 					Ext.create('Ext.toolbar.Paging', {
 						dock: 'bottom',
 						store: store
 					}), {
 						fbar: [
 							//  {
 							// 	xtype: 'box',
 							// 	text: '',
 							// 	autoEl: {
 							// 		tag: 'div',
 							// 		cls: 'x-btn',
 							// 		html: '<table width="100" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="20" align="center"><img src="imgs/menu_sup/esquinaizquierda.png" width="25" height="51"></td><?php if ($_SESSION['sesusuario_usutipo_rol'] == "1" or $_SESSION['sesusuario_usutipo_rol'] == "2") { ?><td width="20" align="center"><a href="#" onClick="btn_regresarpagprin()" ><img src="imgs/menu_sup/reasignar.gif" width="66" height="51"></a></td><?php } ?><td width="20" align="center"><a href="lista_data.php" ><img src="imgs/menu_sup/informar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_archivarinfodoc()" ><img src="imgs/menu_sup/archivar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_crearnuevodato()" ><img src="imgs/menu_sup/comentar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_crearnuevodato()" ><img src="imgs/menu_sup/tareaNueva.gif" width="66" height="51"></a></td><td width="20" align="center"><img src="imgs/menu_sup/esquinaderecha.png" width="25" height="51"></td></tr></table>'
 							// 	}
 							// },
 							{
 								xtype: 'box',
 								text: '',
 								autoEl: {
 									tag: 'div',
 									cls: 'x-btn',
 									html: '<table width="100" border="0" align="right"><tr><td width="77" align="center"><a href="#" onClick="javascript:funcionexportxls();"><img src="imgs/excel_icon.png" width="20" height="20" border="0"></a></td><td width="73" align="center"><a href="#" onClick="javascript:funcionexportpdf();" ><img src="imgs/pdficon.png" width="20" height="20" border="0"></a></td></tr><tr><td align="center">Exportar</td><td height="21" align="center">Reporte</td></tr></table>'
 								}
 							},
 							'->',

 							'Agrupar por:',
 							{
 								text: 'Por Expediente',
 								iconCls: 'topbtn_expe',
 								handler: function() {
 									document.location.href = "listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=codigo_tramite";
 								}
 							},
 							{
 								text: 'Por Fecha',
 								iconCls: 'topbtn_xfech',
 								handler: function() {
 									document.location.href = "listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=destino_fecha_creado";
 								}
 							},
 							{
 								text: 'Por Tramite',
 								iconCls: 'topbtn_xtramit',
 								handler: function() {
 									document.location.href = "listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=destino_tipo_tramite";
 								}
 							},
 							{
 								xtype: 'tbspacer'
 							},
 							{
 								text: 'Desagrupar',
 								iconCls: 'topbtn_desagrup',
 								handler: function() {
 									document.location.href = "listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>";
 								}
 							},
 							////////////////////////fin de botones  
 						] //////fin del menu bar superior
 						///////////////////////////////////////
 					}
 				],
 				emptyText: 'No hay registros', /////esto aumente  
 				plugins: [cellEditing], ////ESTE ES USA FUNCIONAL para editar solo una celda
 				/////////////////////ver los ttolbars
 				width: '100%',
 				height: '100%',
 				title: 'Gestion de Informacion',
 				header: false,
 				viewConfig: {
 					stripeRows: true,
 					forceFit: true,
 				},
 				///////////ver
 			});
 			grid.child('pagingtoolbar').add([
 				'->',
 			]);
 			/////////////////fin otro aumento para edicion
 			///////////////////////FINALIZAR VISTA
 		});
 	</script>
 	<link rel="stylesheet" type="text/css" href="../../extjs421/resources/css/ext-all.css" />
 </head>

 <body topmargin="0" leftmargin="0" rightmargin="0">
 </body>

 </html>