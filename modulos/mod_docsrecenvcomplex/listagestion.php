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

$_SESSION["configmodusesion"]="openmod_recibidos";


//////////////////////PARAMETROS GLOBALES/////////////////

if(isset($_GET['mibtnopcionbandeja'])!="")
$param_mitipobandeja=$_GET['mibtnopcionbandeja'];
else
$param_mitipobandeja="";


//////////USUARIO ACTIVO
if(isset($_GET['retornmiusuarioseguim'])!="")
$param_verusuactivoses=$_GET['retornmiusuarioseguim'];
else
$param_verusuactivoses="";

/////////VISTA
$param_tablavista="vista_mostrarorigendestino_recibidos";
$param_campordenvista="destino_fecha_creado desc";       ////forma ascendente   asc    en descendente desc

if(isset($_GET['optgrupconfig'])==1)
{
$param_configrup="1";                 /////para agrupar valor 0: sin agrupar    1: agrupando
$param_conficampogrup=$_GET['optgrupcampo'];           /////si el anterior es 1 especificar el nombre del campo
}
else
{
$param_configrup="0";                 /////para agrupar valor 0: sin agrupar    1: agrupando
$param_conficampogrup="codi_barras";          /////si el anterior es 1 especificar el nombre del campo
}


$param_configruporden="DESC";          /////si el anterior es 1 especificar el nombre del campo
/////////EDICION
$param_tablaedit="tbli_esq_plant_formunico_docsinternos";
$param_camprimarioedit="id";
////////////////////////////////////////


/////////////////TODOS LOS CAMPOS
//$campostodos="id,codi_barras,selec_tempoitem,img_bandera_tatencion, destino_fecha_creado, destino_tipo_tramite,destino_tipodoc,destino_form_asunto,  origen,  destino,respuesta_comentariotxt,respuesta_observacion, destino_cedul";
$campostodos="id,codi_barras,selec_tempoitem,img_bandera_tatencion, codigo_tramite, destino_fecha_creado, destino_tipo_tramite,origen,  respuesta_comentariotxt,respuesta_observacion, destino_cedul,resp_estado_anterior,respuesta_estado,est_respuesta_reasignado,est_respuesta_enviado,ref_plantilla,ref_tramwebid";

////////////////CAMPOS OCULTOS////////////
//$camposocultos="id,destino_cedul,codigo_tramite,respuesta_estado,est_respuesta_reasignado,est_respuesta_enviado";
$camposocultos="id,destino_cedul,codi_barras,est_respuesta_reasignado,est_respuesta_enviado,ref_plantilla,ref_tramwebid";

////////////////CAMPOS EDICION////////////
$camposparaeditar="id,respuesta_comentariotxt,respuesta_observacion";

////////////////CAMPOS TAMAÑO////////////
$camposparatamanios= array("id"=>"30", "img_bandera_tatencion"=>"30", "codi_barras"=>"80", "destino_fecha_creado"=>"80", "origen"=>"150", "destino"=>"150", "respuesta_comentariotxt"=>"150", "respuesta_observacion"=>"150");
/////////////////////////////////////////////////////////////////////////////


 $sql="SELECT ".$campostodos." FROM ".$param_tablavista;
$res = pg_query($conn, $sql);
$numercampos=pg_num_fields($res);

///////////funcion de busquedas
function buscardatocadena($camposovector,$datentrada)
{
	$varlrposic=NULL;
	$vectext=explode(',',$camposovector);
	for($im=0;$im<count($vectext);$im++)
	{
	     if(trim($vectext[$im])==$datentrada)
		 {
		     $varlrposic='999';
			 break;
		 }
		   
	}
	return  $varlrposic;
};

function buscardatotamanio($arraycmps,$datentrada)
{
$valortama=0;
foreach($arraycmps as $x => $x_value) {
	if($x==$datentrada)
        $valortama=$x_value;
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

   <link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
    <script src="../../componentes/codebase/dhtmlx.js"></script>


    <!-- page specific -->
    <style type="text/css">
        /* style rows on mouseover */
		    html, body {
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
            background-image:url(shared/icons/fam/grid.png) !important;
        }
		
        .x-grid-row-over .x-grid-cell-inner {
            font-weight: bold;
        }
		
		.vistamostrarseguim {
    		background-image: url(imgs/btnseg.png) !important;
    		width:50px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistafichaicon {
    		background-image: url(imgs/btnprev.png) !important;
    		width:50px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistarespondericon {
    		background-image: url(imgs/btnmenjs.png) !important;
    		width:50px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistaimprimiricon {
    		background-image: url(imgs/btngrid_obt_imprimir.png) !important;
    		width:80px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistadarbajaicon {
    		background-image: url(imgs/btninfo_dardebaja.png) !important;
    		width:80px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistaeliminaricon {
    		background-image: url(imgs/btninfo_eliminar.png) !important;
    		width:80px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		
		.vistaanexosicon {
    		background-image: url(imgs/btnmanex.png) !important;
    		width:50px!important;
    		height:30px!important;
    		margin-right: auto !important;
    		margin-left: auto !important;
		}
		.vistareasignaricon {
    		background-image: url(imgs/btnreaisgn.png) !important;
    		width:50px!important;
    		height:30px!important;
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
	
	function funcionexportxls()
	{
		//alert("comienza la descarga");
		document.location.href="exportar_xls.php";
	}
	
    
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
		
		    <?php
			for($col=0;$col<$numercampos;$col++)
            {  
			    $valortipo=pg_field_type($res,$col);
			    switch($valortipo)
				{
			    	case 'int4':  echo "{name:'".pg_field_name($res,$col)."', type: 'int'},";
							  break;	
					case 'date':  echo "{name:'".pg_field_name($res,$col)."', type: 'string'},";
				              break;
					case 'varchar':  echo "{name:'".pg_field_name($res,$col)."', type: 'string'},";
				              break;
					case 'text':  echo "{name:'".pg_field_name($res,$col)."', type: 'string'},";
				              break;	
					default:      echo "{name:'".pg_field_name($res,$col)."', type: '".pg_field_type($res,$col)."'},";
				}
			}
			
			
			?>
			
		]
    });
	
	var store = Ext.create('Ext.data.JsonStore', {
        model: 'MiConjuntoDatos',
		pageSize: 20,         ///esto aumente
        //remoteSort: true,      ///esto aumente
        proxy: {
            type: 'ajax',
			<?php if ($param_verusuactivoses!="") { ?>
			
            		<?php if ($param_mitipobandeja!="") { ?>
			url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&mibtnopcionbandeja=<?php echo $param_mitipobandeja; ?>',
					<?php } else { ?>
					/////////////////////////////////////////////
					      	<?php if(isset($_GET['consulvarfecha'])!="") { ?>
			url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&consulvarfecha=<?php echo $_GET['consulvarfecha']; ?>',
			     //////////////////////////////
							<?php } else if(isset($_GET['consulvarfechaini'])!="") { ?>
			     url: 'consultalista.php?mitablavista=<?php echo $param_tablavista; ?>&milistcampos=<?php echo $campostodos; ?>&miordencmp=<?php echo $param_campordenvista; ?>&micmpususeguim=<?php echo $param_verusuactivoses; ?>&consulvarfechaini=<?php echo $_GET['consulvarfechaini']; ?>&consulvarfechafin=<?php echo $_GET['consulvarfechafin']; ?>',
				       <?php } else if(isset($_GET['consulvarcampo'])!="") { ?>
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
		<?php if($param_configrup=="1") {?>
		      groupField: '<?php  echo $param_conficampogrup; ?>',     ////sirve para agrupar los datos
			  groupDir: '<?php echo $param_configruporden; ?>',
		<?php } ?>
		//groupField: ['grup_nombre','descripcion'],
		//groupDir: 'DESC',
		//sorters: [{property: 'id', direction: 'desc'}]
		
    });
    store.load();
	

    //////////////////FIN DE CREACION DE ALMACENES

/////////////para agrupar datos
var groupingFeature = Ext.create('Ext.grid.feature.Grouping',{
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
            function(cellEditing,  record) {

            var sm = grid.getSelectionModel();
			
<?php
			for($col=0;$col<$numercampos;$col++)
            {   
			    $nombrecamp=pg_field_name($res,$col);
			    $posedits = buscardatocadena($camposparaeditar, $nombrecamp);
				if($posedits!=NULL)
				echo "var ".$nombrecamp."=sm.getSelection()[0].get('".$nombrecamp."');"."\n";
			}
			?>
			
             //alert(JSON.stringify(recordData));

             Ext.Ajax.request({

                 url: 'claseoperacionesbdd.php?opcion=Editarunvalor&mitabla=<?php echo $param_tablaedit; ?>&enviocampos=<?php echo $camposparaeditar; ?>&elidprimar=<?php echo $param_camprimarioedit; ?>',
                 method: 'POST',
                 // merge row data with other params
                 params: {
					 
<?php
			         for($col=0;$col<$numercampos;$col++)
            		{  
					    $nombrecamp=pg_field_name($res,$col);
					    $posedits = buscardatocadena($camposparaeditar, $nombrecamp); 
						if($posedits!=NULL)
						echo " ".$nombrecamp.": ".$nombrecamp.", "."\n";
					}
					?>
					
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
             });
         }
 
      /////////////
  } ///final de lisneter
		
    });	
	/////////////////fin de edicion de celdas
///////////////////FIN PARA EDITAR LAS CELDAS DEL GRID


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
function cambiacoloralestado(valest) {
           if (valest == 'ATENDIDO')
		   {
           // return '<span style="color:#99CCFF;">' + valest + '</span>';
		    return '<div style="background-color:#b8fb85;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';
		   }
		  if (valest == 'PENDIENTE') 
		     {
		    return '<div style="background-color:#fcf6a2;height: 20px;" align="center"><span style="color:#F00;font-weight: bold;font-size:9px">' + valest + '</span></div>';
			 }
		  if (valest == 'REASIGNADO') 
		     {
		    return '<div style="background-color:#fdcfaa;height: 20px;" align="center"><span style="color:#894104;font-weight: bold;font-size:9px">' + valest + '</span></div>';
			 }
		   if (valest == 'ASIGNADO') 
		     {
		    return '<div style="background-color:#fef37f;height: 20px;" align="center"><span style="color:#894104;font-weight: bold;font-size:9px">' + valest + '</span></div>';
			 }
			 
			 
		//return valest;	 
		return '<div style="background-color:#ebf3ff;" align="center"><span style="color:green;font-weight: bold;font-size:9px">' + valest + '</span></div>';

    }
		
//creando columnas
   var createColumns = function (finish, start) {
	
	var columns = [
        <?php
	for($col=0;$col<$numercampos;$col++)
    {  
		$nombrecamp=pg_field_name($res,$col);
		$valortipo=pg_field_type($res,$col);
		/////////////////buscar
		$posocults = buscardatocadena($camposocultos, $nombrecamp);
		$posedits = buscardatocadena($camposparaeditar, $nombrecamp);
		$posdartamancelda = buscardatotamanio($camposparatamanios, $nombrecamp);
		
				
		switch($valortipo)
		{
			case 'int4':  $valortipo="int";
							  break;	
			case 'date':  $valortipo="date";
				              break;
			case 'varchar':  $valortipo="string";
				              break;
			case 'text':  $valortipo="string";
				              break;	
			default:      $valortipo=$valortipo;
		}
				
		if($nombrecamp=='id')
		{	
				echo "{"."\n";
		        echo "	         //xtype: 'numbercolumn',"."\n";
                echo "	         text     : '".strtoupper($nombrecamp)."',"."\n";
                echo "	         // flex     : 1,"."\n";
			    echo "	         width    : 50, "."\n";
                echo "	         sortable : false, "."\n";
				if($posocults!=NULL)
				   echo  "	         hidden     : true,"."\n";
                echo "	         dataIndex: '".$nombrecamp."',"."\n";
				echo "	         //locked: true,            ///para bloquear columnas"."\n";
                echo "	         //lockable: false,         ///para bloquear columnas"."\n";
                echo "	   },"."\n";
		}
		else
		{
			echo "	   {"."\n";
			echo "	       //header	 : '".strtoupper($nombrecamp)."'," ."\n";
			if($nombrecamp=="selec_tempoitem")
			{
			echo "	         xtype: 'checkcolumn',"."\n";
			echo "	         width: 30,"."\n";
			echo "	        locked: true,"."\n";
			}
			else
			{
				//$camposparatamanios[$nombrecamp]
				if($posdartamancelda>=1)
					echo "	     width: ".$posdartamancelda.","."\n";
				else
					echo "	     width: 100,"."\n";
			}
			
            echo "	       text: '".strtoupper($nombrecamp)."',sortable: true,dataIndex: '".$nombrecamp."',"."\n";
			echo "	         //renderer : cambiacolorcedula,"."\n";
			
			if($nombrecamp=="img_bandera_tatencion")
			echo "	        locked: true,"."\n";
			
			if($nombrecamp=="resp_estado_anterior")
			{
			echo "	        locked: true,"."\n";
			echo "	        renderer : cambiacoloralestado,";
			}
			
			if($nombrecamp=="img_bandera_tatencion")
			     echo "renderer: function(value){return "."'"."<img src="."'+value+'"." />';}";
			
			if($posocults!=NULL)
				   echo  "	         hidden     : true,"."\n";
			if($nombrecamp=="img_bandera_tatencion")
				echo "	         //filter: { type: '".$valortipo."'},"."\n";
			else
			{	  
			     /*
			    if($nombrecamp=="usuario_cedseguim")
				{
					echo "	         filter: { type: '".$valortipo."',value: '1002201588', active:true },flex: 1, filterable:true,"."\n";
				}
				else
				{
					*/
				   echo "	         filter: { type: '".$valortipo."'},"."\n";
				//}
			}
			if($posedits!=NULL)
				echo "	         editor: { allowBlank: true}"."\n";
				
            	echo "	   },"."\n";
		}
				
	}
			
			
			?>
			
			
			
			
			
			 //{text:'Image', xtype:'widgetcolumn', widget:{xtype:'image', src: 'images/xlsicon.png'}, dataIndex:'image'},
			 /*
			 {
    			header: 'Photo',dataIndex: 'img_bandera_tatencion',
    			renderer: function(value){return '<img src="' + value + '" />';}
			 },
			 */
/////////////////////////ACCIONES DE GRID////////////////////////////////////
			  {
				    //header     : 'ACCIONES', 
                    xtype:'actioncolumn',
					<?php if($_SESSION['sesusuario_usutipo_rol']=="1" or $_SESSION['sesusuario_usutipo_rol']=="2" ) { ?>
                    width:280,
					<?php } else { ?>
					width:220,
					<?php } ?>
					
					locked: true, 
					  
                    items:[
					{xtype: 'space'},
					{
                        //icon:'images/lupa10.gif',    ///cuando se tiene iconos pequenios
                        tooltip:'Mostrar Seguimiento',	
						iconCls:'vistamostrarseguim',   ///otra manera de poner icono con css				
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
							  //var ponidver= employee.get('codi_barras');
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("../mod_docseguimtree/modtreeseguim.php?enviocodid="+ponidver,"moswinform","width=800,height=420,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
                       		  
                        }
                    },
					
					//{xtype: 'space'},
					{
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
							  var verrmisanexos= employee.get('codi_barras');
							  /////aumento
							  var vermyplantillx= employee.get('ref_plantilla');
							  var vermicodidtramitx= employee.get('ref_tramwebid');
							  //alert(verrmisanexos);
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("../mod_docvista/vista_previatram_intern.php?mvpr="+ponidver+"&varcodgenerado="+verrmisanexos+"&vermyplantillx="+vermyplantillx+"&vermicodidtramitx="+vermicodidtramitx,"moswinform","width=900,height=500,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
                       		  
                        }
                    },
					//{xtype: 'space'},
					{
                        //icon:'images/edit.png',
                        tooltip:'Responder - Atender - Finalizar',
						iconCls:'vistarespondericon',   ///otra manera de poner icono con css			
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
							  var verrmisanexos= employee.get('codi_barras');
							  
							  var verrespestadoreas= employee.get('est_respuesta_reasignado');
							  var verrespestadoenv= employee.get('est_respuesta_enviado');
							  
							  if(verrespestadoreas=='1')
							  {
								  
								dhtmlx.alert({
									title:"Mensaje Advertencia!",
									type:"alert-warning",   /////puede ser error  warning  solo alert es para normal   
									text:"Error: EL TRAMITE YA FUE REASIGNADO"
								});
								
							  } else
							  if(verrespestadoenv=='1')
							  {
								  
								dhtmlx.alert({
									title:"Mensaje Advertencia!",
									type:"alert",   /////puede ser error  warning  solo alert es para normal   
									text:"Error: EL TRAMITE YA FUE ATENDIDO"
								});
								
							  }
							  else
							  {
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("responder.php?vafil="+ponidver+"&varcodgenerado="+verrmisanexos,"moswinform","width=900,height=550,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
							  }
                       		  
                        }
                    },
					//{xtype: 'space'},
					{
                        //icon:'images/edit.png',
                        tooltip:'Ver Anexos',
						iconCls:'vistaanexosicon',   ///otra manera de poner icono con css			
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
							  var verrmisanexos= employee.get('codi_barras');
							 // var verrmisfechas= employee.get('destino_fecha_creado');
							  //  alert(verrmisfechas);
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("vista_previanexos.php?mvpr="+ponidver+"&varcodgenerado="+verrmisanexos,"moswinform","width=700,height=420,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
                       		  
                        }
                    },
					//{xtype: 'space'},
					<?php if($_SESSION['sesusuario_usutipo_rol']=="1" or $_SESSION['sesusuario_usutipo_rol']=="2" ) { ?>
					{
                        //icon:'images/edit.png',
                        tooltip:'Reasignar',
						iconCls:'vistareasignaricon',   ///otra manera de poner icono con css			
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
							  var verrespestado= employee.get('est_respuesta_reasignado');
							  // alert(verrespestado);
							  if(verrespestado=='1')
							  {
								  
								dhtmlx.alert({
									title:"Mensaje Advertencia!",
									type:"alert-warning",   /////puede ser error  warning  solo alert es para normal   
									text:"Error: EL TRAMITE YA FUE REASIGNADO"
								});
								
							  }
							  else
							  {
							  var miPopupmapaobjtabauxgrf;
							  miPopupmapaobjtabauxgrf = window.open("reasign.php?vafil="+ponidver,"moswinform","width=900,height=550,scrollbars=no,left=400");
							  miPopupmapaobjtabauxgrf.focus();
							  }
                       		  ///////////////////////////////////////
                        }
                    },
					{xtype: 'space'},
					<?php } ?>
					/*
                    {
                       // icon:'images/elim.png',
                        tooltip:'Eliminar Dato',
						iconCls:'vistaeliminaricon',   ///otra manera de poner icono con css			
                        handler:function(grid, rowIndex, colIndex) {
					       ///////////////////////////////////////////////////////////////	
						   ////////////////////PROCESO DE ELIMINACION DE UN DATOS//////////
						   ///////////////////////////////////////////////////////////////	
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
										//alert(seleccionodato);
				         ///////////////ENVIAR DATOS AL OPERACIONES////////////
						Ext.Ajax.request({
					    	url: 'crea_eliminar.php',
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
                                    }
                                }
                            );  
					  ///////////////////////////////////////////////////////////////	
					 ///////////FIN PARA EL PROCESO DE ELIMINACION DE UN DATOS///////
					 ///////////////////////////////////////////////////////////////
					 
                        }    /////FIN DE HANDLER
                    }       /////FIN DEL ITEM O BOTON
					*/
		///////////////////////////////////////////////////////////////			
					]    ///FIN DE TODOS LOS ITEMS
			  }    ////OTRO FIN
					////////////////////////FIN DE ACCIONES DE GRID
        ];
	
	  return columns.slice(start || 0, finish);  
	  
   };
	  
    
// Ext.create('Ext.ux.LiveSearchGridPanel', {
// Ext.create('Ext.grid.Panel', {
	 
  var grid = Ext.create('Ext.grid.Panel', {      //////PANEL NORMAL
//	var grid = Ext.create('Ext.ux.LiveSearchGridPanel', {    ////PANEL CON BUSQUEDAS
		region      : 'center',
		store: store,
		iconCls: 'icon-grid',
		//collapsible:true,
		/////AUMENTADO 
		selType: 'cellmodel',
		features: [filters],    //solo filtrados
		<?php if($param_configrup=="1") {?>
		    features: [filters,groupingFeature],    //filtrado y agrupamiento simple
		<?php }  ?>
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
		columns: createColumns(<?php echo $numercampos+5; ?>),
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
		
		{
		xtype: 'box',
		text: '',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<table width="100" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="20" align="center"><img src="imgs/menu_sup/esquinaizquierda.png" width="25" height="51"></td><?php if($_SESSION['sesusuario_usutipo_rol']=="1" or $_SESSION['sesusuario_usutipo_rol']=="2" ) { ?><td width="20" align="center"><a href="#" onClick="btn_regresarpagprin()" ><img src="imgs/menu_sup/reasignar.gif" width="66" height="51"></a></td><?php } ?><td width="20" align="center"><a href="lista_data.php" ><img src="imgs/menu_sup/informar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_archivarinfodoc()" ><img src="imgs/menu_sup/archivar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_crearnuevodato()" ><img src="imgs/menu_sup/comentar.gif" width="66" height="51"></a></td><td width="20" align="center"><a href="#" onClick="btn_crearnuevodato()" ><img src="imgs/menu_sup/tareaNueva.gif" width="66" height="51"></a></td><td width="20" align="center"><img src="imgs/menu_sup/esquinaderecha.png" width="25" height="51"></td></tr></table>'
            }

		},
		{
		xtype: 'box',
		text: '',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<table width="100" border="0" align="right"><tr><td width="77" align="center"><a href="#" onClick="javascript:funcionexportxls();"><img src="imgs/excel_icon.png" width="20" height="20" border="0"></a></td><td width="73" align="center"><a href="#" onClick="javascript:funcionexportpdf();" ><img src="imgs/pdficon.png" width="20" height="20" border="0"></a></td></tr><tr><td align="center">Exportar</td><td height="21" align="center">Reporte</td></tr></table>'
            }

		},
		/*
		{
		xtype: 'box',
		text: '',
            autoEl: {
            tag: 'div',
            //cls: 'x-btn',
            html: '<table width="100%" border="1" align="center"><tr><td><div align="center"><font color="#333333">Bandeja: Documentos Recibidos</font></div></td></tr></table>'
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
		 */
		 /*
		{
            text: 'Imprimir Reporte',
			iconCls: 'usuarjunta-export',
            handler: function() {
				///////////////////poner la funcion de exportacion
	            	Ext.ux.grid.Printer.printAutomatically = false;
	            	Ext.ux.grid.Printer.print(grid); 
            }
        }, 
		*/
		 '->',  
		
		'Agrupar por:',
		 {
            text   : 'Por Expediente',
            iconCls: 'topbtn_expe',
            handler: function() {
                document.location.href="listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=codigo_tramite";
            }
        },
		{
            text   : 'Por Fecha',
            iconCls: 'topbtn_xfech',
            handler: function() {
                document.location.href="listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=destino_fecha_creado";
            }
        },
		{
            text   : 'Por Tramite',
            iconCls: 'topbtn_xtramit',
            handler: function() {
               document.location.href="listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>&optgrupconfig=1&optgrupcampo=destino_tipo_tramite";
            }
        },
		/*
		{
            text   : 'Por Tipo Docum.',
            iconCls: 'topbtn_xtipodoc',
            handler: function() {
                var text = prompt('Please enter the text for your button:');
                addedItems.push(toolbar.add({
                    text: text
                }));
            }
        },
		{
            text   : 'Por Usuario',
            iconCls: 'topbtn_xusuar',
            handler: function() {
                var text = prompt('Please enter the text for your button:');
                addedItems.push(toolbar.add({
                    text: text
                }));
            }
        },
		*/
		{ xtype: 'tbspacer' },
		{
            text   : 'Desagrupar',
            iconCls: 'topbtn_desagrup',
            handler: function() {
                document.location.href="listagestion.php?retornmiusuarioseguim=<?php echo $_GET['retornmiusuarioseguim']; ?>";
            }
        },
		/*	{
		xtype: 'box',
		text: 'Exportar Informacion',
            autoEl: {
            tag: 'div',
            cls: 'x-btn',
            html: '<form name="paraexpxls" id="paraexpxls" action="exportar_reportexcel.php" method="post">' +
            '<table width="100" border="0" cellpadding="0" cellspacing="0"><tr><td width="25"><img src="images/excel_icon1.png" width="25" height="25" /></td><td width="129"><input type="submit" value="Exportar Datos" ' +  'style="color:#000; font:normal 10px arial,tahoma,verdana,helvetica; background-image:url(images/bagkboton.png);border-style:hidden;height: 24px;cursor:pointer; font-size:11px;-webkit-border-radius: 3px 3px;-ms-border-radius: 3px 3px;-moz-border-radius: 3px 3px;" /></td></tr></table></form>'
            }

		},
		
		*/
		
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
		plugins: [cellEditing],       ////ESTE ES USA FUNCIONAL para editar solo una celda
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
		
		///////////ver
		
		
    });
	
	//////////////////este aumewntadito
	// add some buttons to bottom toolbar just for demonstration purposes
    grid.child('pagingtoolbar').add([
        '->',
    ]);
     
	/////////////////fin otro aumento para edicion
	///////////////////////FINALIZAR VISTA
	
});


    
    
    </script>
    <link rel="stylesheet" type="text/css" href="../../extjs421/resources/css/ext-all.css" />
</head>
<body topmargin="0"  leftmargin="0" rightmargin="0" >
   
    
    

</body>
</html>
