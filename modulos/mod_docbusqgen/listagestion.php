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



	//echo "hola".$param_verusuactivoses;

	/////////VISTA
	$param_tablavista = "vista_mostrarorigendestino_recibidos";
	$param_campordenvista = "destino_fecha_creado desc";       ////forma ascendente   asc    en descendente desc
	$param_configrup = "0";                 /////para agrupar valor 0: sin agrupar    1: agrupando
	$param_conficampogrup = "codi_barras";          /////si el anterior es 1 especificar el nombre del campo
	$param_configruporden = "DESC";          /////si el anterior es 1 especificar el nombre del campo
	/////////EDICION
	$param_tablaedit = "tbli_esq_plant_formunico_docsinternos";
	$param_camprimarioedit = "id";
	////////////////////////////////////////

	/////////////////TODOS LOS CAMPOS
	$campostodos = "id, num_memocreado AS TRAMITE,codigo_tramite, codi_barras,destino_fecha_creado as FECHA, destino_fecha_creado as RECIBIDO,origen_tipo_tramite, destino_tipo_tramite as tipo_tramite,origen,respuesta_comentariotxt as comentario,respuesta_observacion as observacion, destino_cedul,resp_estado_anterior as tipo	,img_bandera_tatencion,respuesta_estado as estado,origen_tipodoc";
	//$campostodos="id,codi_barras,selec_tempoitem,img_bandera_tatencion, destino_fecha_creado, destino_tipo_tramite,origen,  respuesta_comentariotxt,respuesta_observacion, destino_cedul,respuesta_estado";

	////////////////CAMPOS OCULTOS////////////
	$camposocultos = "id,destino_cedul, tipo_tramite, codi_barras,origen_tipodoc";

	////////////////CAMPOS EDICION////////////
	$camposparaeditar = "id,respuesta_observacion";

	////////////////CAMPOS TAMAÑO////////////
	$camposparatamanios = array("id" => "30", "tipo" => "100",  "tramite" => "70", "fecha" => "50", "recibido" => "70","img_bandera_tatencion" => "30", "codi_barras" => "80", "destino_fecha_creado" => "80", "origen" => "150", "destino" => "150", "respuesta_comentariotxt" => "150", "respuesta_observacion" => "150");
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
 	<!-- GC -->

 	<script type="text/javascript" src="../../extjs421/examples/shared/include-ext.js"></script>

 	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css" />
 	<script src="../../componentes/codebase/dhtmlx.js"></script>


 	<!-- page specific -->
 	<style type="text/css">
 		/* style rows on mouseover */
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

 		.vistamostrarseguim {
 			background-image: url(imgs/btnseg.png) !important;
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistafichaicon {
 			background-image: url(imgs/btnseginfo.png) !important;
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistarespondericon {
 			background-image: url(imgs/btnmenjs.png) !important;
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
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
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 		}

 		.vistavisualizaricon {
 			background-image: url(imgs/btnprev.png) !important;
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
 			background-size: cover;
 			background-repeat: no-repeat;
 		}

 		.vistareasignaricon {
 			background-image: url(imgs/btnreaisgn.png) !important;
 			width: 50px !important;
 			height: 30px !important;
 			margin-right: auto !important;
 			margin-left: auto !important;
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
 		Ext.Loader.setConfig({
 			enabled: true
 		});

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

 			var store = Ext.create('Ext.data.JsonStore', {
 				model: 'MiConjuntoDatos',
 				pageSize: 20, ///esto aumente
 				//remoteSort: true,      ///esto aumente
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
 				<?php if ($param_configrup == "1") { ?>
 					groupField: '<?php echo $param_conficampogrup; ?>', ////sirve para agrupar los datos
 					groupDir: '<?php echo $param_configruporden; ?>',
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
 					//////////////para la edicion´
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
 			/////////////////fin de edicion de celdas
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
 				// if (valest == 'ENVIADO') {
 				// 	return '<div style="background-color:#fef37f;height: 20px;" align="center"><span style="color:#894104;font-weight: bold;font-size:9px">' + valest + '</span></div>';
 				// }
 				//return valest;	 
 				return '<div style="background-color:#ebf3ff;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';
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
										echo "	     width: 100," . "\n";
								}

								echo "	       text: '" . strtoupper($nombrecamp) . "',sortable: true,dataIndex: '" . $nombrecamp . "'," . "\n";
								echo "	         //renderer : cambiacolorcedula," . "\n";

								if ($nombrecamp == "respuesta_estado") {
									echo "	        locked: true," . "\n";
									echo "	        renderer : cambiacoloralestado,";
								}
								if ($nombrecamp == "origen_tipo_tramite") {
									echo "	        locked: true," . "\n";
									echo "	        renderer : cambiacoloralestado,";
									echo "	     width: 150," . "\n";
								}

								if ($nombrecamp == "img_bandera_tatencion")
									echo "renderer: function(value){return " . "'" . "<img src=" . 'imgs/bander_alertalto.png' . " />';}";

								// if ($nombrecamp == "fecha") {
								// 	echo "	        locked: true," . "\n";
								// 	echo "			renderer : cambiacoloralestadotiempo,";
								// 	// echo "renderer: function(value){return " . "'" . "<img src=" . 'imgs/bander_alertalto.png' . " /> ';}";
								// }
								if ($posocults != NULL)
									echo  "	         hidden     : true," . "\n";
								if ($nombrecamp == "img_bandera_tatencion" || $nombrecamp == "fecha")
									echo "	         //filter: { type: '" . $valortipo . "'}," . "\n";
								else {
									echo "	         filter: { type: '" . $valortipo . "'}," . "\n";
									//}
								}
								if ($posedits != NULL)
									echo "	         editor: { allowBlank: true}" . "\n";

								echo "	   }," . "\n";
							}
						}
						?>
 					/////////////////////////ACCIONES DE GRID////////////////////////////////////
 					{
 						xtype: 'actioncolumn',
 						width: 130,
 						locked: true,
 						items: [{
 								xtype: 'space'
 							},
 							
 							{
 								tooltip: 'Visualizar Datos',
 								iconCls: 'vistafichaicon', ///otra manera de poner icono con css				
 								handler: function(grid, rowIndex, colIndex) {
 									var employee = grid.getStore().getAt(rowIndex);
 									var ponidver = employee.get('id');
 									var miPopupmapaobjtabauxgrf;
									var varcodgenerado = employee.get('codi_barras');
 									miPopupmapaobjtabauxgrf = window.open("../mod_docvista/vista_previatram_intern.php?mvpr=" + ponidver +"&varcodgenerado=" +varcodgenerado, "moswinform", "width=700,height=650,scrollbars=no,left=400");
 									miPopupmapaobjtabauxgrf.focus();
 								}
 							},
 							
 							{
 								tooltip: 'Ver documento',
 								iconCls: 'vistavisualizaricon', ///otra manera de poner icono con css	
 								handler: function(grid, rowIndex, colIndex) {
 									var employee = grid.getStore().getAt(rowIndex);
 									var ponidver = employee.get('id');
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
 													miPopupmapaobjtabauxgrf = window.open("../mod_forms/vista_imprimir_memo.php?plantilla=false&mvpr=" + ponidver + "&varcodgenerado=" + verrmisanexos, "moswinform", "width=950,height=650,scrollbars=no,left=400");
 													miPopupmapaobjtabauxgrf.focus();
 												}
 											}
 										});
 									}
								 else  {
										document.cookie = "correos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
 										miPopupmapaobjtabauxgrf = window.open("../mod_docsenelab/nuevo_form_externo_vista.php?varcodgenerado=" + verrmisanexos + "&mvpr=" + ponidver + "&borrador=true&retornmiusuarioseguim=<?php echo $_SESSION['sesusuario_cedula']; ?>&idtramite=" + ponidver + "&elaborado=" + elaborado, "moswinform", "width=940,height=650,scrollbars=no,left=400");
 										miPopupmapaobjtabauxgrf.focus();
								}
 								}
 							},
 						] ///FIN DE TODOS LOS ITEMS
 					} ////OTRO FIN
 					////////////////////////FIN DE ACCIONES DE GRID
 				];
 				return columns.slice(start || 0, finish);
 			};

 			var grid = Ext.create('Ext.grid.Panel', { //////PANEL NORMAL
 				region: 'center',
 				store: store,
 				iconCls: 'icon-grid',
 				/////AUMENTADO 
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
 				// inline buttons
 				dockedItems: [
 					////////////para el paginado
 					Ext.create('Ext.toolbar.Paging', {
 						dock: 'bottom',
 						store: store
 					}), {
 						fbar: [{
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
 									var text = prompt('Please enter the text for your button:');
 									addedItems.push(toolbar.add({
 										text: text
 									}));
 								}
 							},
 							{
 								text: 'Por Fecha',
 								iconCls: 'topbtn_xfech',
 								handler: function() {
 									var text = prompt('Please enter the text for your button:');
 									addedItems.push(toolbar.add({
 										text: text
 									}));
 								}
 							},
 							{
 								text: 'Por Tramite',
 								iconCls: 'topbtn_xtramit',
 								handler: function() {
 									var text = prompt('Please enter the text for your button:');
 									addedItems.push(toolbar.add({
 										text: text
 									}));
 								}
 							},

 							{
 								xtype: 'tbspacer'
 							},
 							{
 								text: 'Desagrupar',
 								iconCls: 'topbtn_desagrup',
 								handler: function() {
 									var text = prompt('Please enter the text for your button:');
 									addedItems.push(toolbar.add({
 										text: text
 									}));
 								}
 							},

 							////////////////////////fin de botones  
 						] //////fin del menu bar superior
 						///////////////////////////////////////
 					}
 				],

 				emptyText: 'No hay registros', /////esto aumente  
 				// plugins: [rowEditing],        /////para editar toda la fila
 				plugins: [cellEditing], ////ESTE ES USA FUNCIONAL para editar solo una celda
 				/////////////////////ver los ttolbars
 				width: '100%',
 				height: '100%',
 				title: 'Gestion de Informacion',
 				header: false,
 				//renderTo: 'grid_padronusu',
 				viewConfig: {
 					stripeRows: true,
 					forceFit: true,
 				},
 			});
 			//////////////////este aumewntadito
 			// add some buttons to bottom toolbar just for demonstration purposes
 			grid.child('pagingtoolbar').add([
 				'->',
 			]);

 			/////////////////fin otro aumento para edicion
 			///////////////////////FINALIZAR VISTA

 		});
 		function funcionexportxls() {
 			document.location.href = "exportar_xls.php";
 		}
 	</script>
 	<link rel="stylesheet" type="text/css" href="../../extjs421/resources/css/ext-all.css" />
 </head>

 <body topmargin="0" leftmargin="0" rightmargin="0">
 </body>

 </html>