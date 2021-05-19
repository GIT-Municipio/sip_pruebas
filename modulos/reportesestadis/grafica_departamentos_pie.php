<?php
require_once('../../conexion.php');

$latabla="vista_estad_totalarch_depar";
$camposver="id,nombre_departamento,total_archivos";
$tipografica="pie";
?>
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
   <script type="text/javascript"> 
    function abreventana(pagina)
{
	var miPopupmapaobj;

	miPopupmapaobj = window.open(pagina,"mostrarmapawindconfig","width=900,height=610,scrollbars=no");
	miPopupmapaobj.focus();
	
}
</script>


    <style type="text/css"> 
	
			  html,body{

			margin:0px;
			width: 100%;
			height: 100%;

			}
	
        .labeldona{
            background-color:#ffffff;
            -moz-border-radius:4px;
            -ms-border-radius:4px;
            -webkit-border-radius:4px;
            border-radius:4px;
            height:15px;
            line-height:15px;
            font-size: 9px;
            width:25px;
            text-align:center;
        }
		
		#encabezadomenu
		{
			background-color: #e8ebf2;
			}	
			
    </style>
</head>
<body>
<div id="gridbox"></div>
<script>
   ///esquema para ventanas//////////////////
   var myLayout, myChart, mygrid, barChart, lineChart, areaChart, radarChart, myToolbar;
   
// myLayout =   new layout1.attachLayout({
   myLayout = new dhtmlXLayoutObject({
				//parent: "ventanacomponentesgraf",
				parent: document.body,
				//pattern: "3L",  //
				pattern: "2E",
				cells: [{id: "a", text: "MIDATO", width: 300},{id: "b", text: "GRAFICO DE: MIDATO"} ]
							});
	
	
		
	
	myLayout.cells("a").collapse();
	
	//carga de informacion///////////////////
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid = myLayout.cells("a").attachGrid();   ////codigo para poner la grilla
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,CAMPO_0,CAMPO_1");
	mygrid.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("50,100,100");
	mygrid.setColAlign("left,left,left");
	mygrid.setColTypes("dyn,txt,edn");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("int,str,int");
	
	///////////////////////inicio seteo numeros///////////////////////////////
	 mygrid.setNumberFormat('0,000.00',2,',','.'); 	////////////////////////fin seteo numeros/////////////////////////////////
	
	mygrid.init();
	mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=<?php echo $latabla; ?>&enviocampos=<?php echo $camposver; ?>",refresh_chart);	//used just
	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,false,true);
//============================================================================================
/*
	myDataProcessor = new dataProcessor("php/oper_update_allgrid.php?mitabla=data_departamento_direccion&enviocampos=id,nombre_departamento,total_archivos"); //lock feed url
	myDataProcessor.setTransactionMode("POST",true); //set mode as send-all-by-post
	myDataProcessor.setUpdateMode("off"); //disable auto-update
	myDataProcessor.init(mygrid); //link dataprocessor to the grid
	
//============================================================================================
///////////mensajes de salida


   myDataProcessor.attachEvent("onAfterUpdate",function(){ dhtmlx.alert({ title:"Mensaje",type:"alert",text:"Se actualizó correctamente"}); })
*/

 //myDataProcessor.attachEvent("onAfterUpdateFinish",function(){ log("onAfterUpdateFinish",arguments); return true; })
/*
   myDataProcessor.attachEvent("onAfterUpdate",function(){ log("onAfterUpdate",arguments); return true; })
   myDataProcessor.attachEvent("onRowMark",function(){ log("onRowMark",arguments); return true; })
   myDataProcessor.attachEvent("onBeforeUpdate",function(){ log("onBeforeUpdate",arguments); return true; })
   myDataProcessor.attachEvent("onValidatationError",function(){ log("onValidatationError",arguments); return true; })
   myDataProcessor.attachEvent("onAfterUpdateFinish",function(){ log("onAfterUpdateFinish",arguments); return true; })
   myDataProcessor.attachEvent("onFullSync",function(){ log("onFullSync",arguments); return true; })	
*/
//////////////////la grafica
mygrid.enableSmartRendering(true);
mygrid.attachEvent("onEditCell",function(stage){
		if (stage == 2)
			refresh_chart();
		return true;
	});
/////////////////////



function refresh_chart(){
	   
	   		
	///////////////////////////////////////////////
        		pieChart.clearAll();
		pieChart.parse(mygrid,"dhtmlxgrid");
				////////////////////////////
 		 
   };



///////GRAFICO PASTEL/////////	
pieChart = myLayout.cells("b").attachChart({
				view: "pie",
				value: "#data2#",
				//label:"#data1#",
				label:function(obj){
               			 var sum = pieChart.sum("#data2#");
                		 var text = Math.round(parseFloat(obj.data2)*100/parseFloat(sum))+"%";
               			 return "<div class='label' style='border:1px solid #ee4339'>"+text+"</div>";
                  },
				//pieInnerText: "#data2#",
				gradient:1,
				legend: {
					width: 365,
					align: "right",
					valign: "middle",
					template: "#data1#"
				}
				
			});
			


							
/////////////////////////////////////////////////////////////////			

</script>

</body>
</html>
