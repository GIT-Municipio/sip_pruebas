<?php
require_once('../../conexion.php');

$latabla=$_GET["xvarenvist"];
$camposver="";
///////////CALDULAR CAMPOS
$sql = "SELECT * from ".$latabla;
$restufields = pg_query($conn, $sql);
$totalcamps=pg_num_fields($restufields);
for($col=0;$col<$totalcamps;$col++)
{
	if($col<$totalcamps-1)
      $camposver.=pg_field_name($restufields,$col).",";
   else
      $camposver.=pg_field_name($restufields,$col);
}
//////////////////////////
$campograftipotab=$_GET["xvarentipgraf"];
$campografposiubictab="b";
$campografetiqdatatab="data1";
$campografvalordatatab="data2";
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
        <?php if ($campograftipotab == 'pie') { ?>
                                pieChart.clearAll();
                                pieChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'pie3D') { ?>
                                pie3DChart.clearAll();
                                pie3DChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'donut') { ?>
                                donutChart.clearAll();
                                donutChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'bar') { ?>
                                barChart.clearAll();
                                barChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'barH') { ?>
                                barHChart.clearAll();
                                barHChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'line') { ?>
                                lineChart.clearAll();
                                lineChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'spline') { ?>
                                linesinusoidChart.clearAll();
                                linesinusoidChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'area') { ?>
                                areaChart.clearAll();
                                areaChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'radar') { ?>
                                radarChart.clearAll();
                                radarChart.parse(mygrid, "dhtmlxgrid");
        <?php } if ($campograftipotab == 'scatter') { ?>
                                scatterpuntosChart.clearAll();
                                scatterpuntosChart.parse(mygrid, "dhtmlxgrid");
        <?php } ?>
 		 
   };



///////GRAFICO PASTEL/////////	
                      ///////GRAFICO PASTEL/////////	
        <?php if ($campograftipotab == 'pie') { ?>
                            pieChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "pie",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                //label:"#<?php echo $campografetiqdatatab; ?>#",
                                label: function (obj) {
                                    var sum = pieChart.sum("#<?php echo $campografvalordatatab; ?>#");
                                    var text = Math.round(parseFloat(obj.<?php echo $campografvalordatatab; ?>) * 100 / parseFloat(sum)) + "%";
                                    return "<div class='label' style='border:1px solid #ee4339'>" + text + "</div>";
                                },
                                //pieInnerText: "#<?php echo $campografvalordatatab; ?>#",
                                gradient: 1,
                                legend: {
                                    width: 300,
                                    align: "right",
                                    valign: "middle",
                                    template: "#<?php echo $campografetiqdatatab; ?>#"
                                }

                            });
                         //var canvas = pieChart.getCanvas().canvas;
						 //var img = canvas.toDataURL ("image/png");
                            ///////GRAFICO PASTEL 3D/////////		
        <?php } if ($campograftipotab == 'pie3D') { ?>
                            pie3DChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "pie3D",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                //label:"#<?php echo $campografetiqdatatab; ?>#",
                                label: function (obj) {
                                    var sum = pie3DChart.sum("#<?php echo $campografvalordatatab; ?>#");
                                    var text = Math.round(parseFloat(obj.<?php echo $campografvalordatatab; ?>) * 100 / parseFloat(sum)) + "%";
                                    return "<div class='label' style='border:1px solid #ee4339'>" + text + "</div>";
                                },
                                //pieInnerText: "#<?php echo $campografvalordatatab; ?>#",
                                gradient: 1,
                                legend: {
                                    width: 300,
                                    align: "right",
                                    valign: "middle",
                                    template: "#<?php echo $campografetiqdatatab; ?>#"
                                }
                            });

                            ///////GRAFICO PASTEL DONA/////////
        <?php } if ($campograftipotab == 'donut') { ?>
                            donutChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "donut",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                //label:"#<?php echo $campografetiqdatatab; ?>#",
                                labelOffset: -5,
                                label: function (obj) {
                                    var sum = donutChart.sum("#<?php echo $campografvalordatatab; ?>#");
                                    var text = Math.round(parseFloat(obj.<?php echo $campografvalordatatab; ?>) * 100 / parseFloat(sum)) + "%";
                                    return "<div class='labeldona' style='border:1px solid #ee4339'>" + text + "</div>";
                                },
                                //shadow:0,
                                gradient: 1,
                                //pieInnerText: "#<?php echo $campografvalordatatab; ?>#"
                                legend: {

                                    width: 300,
                                    align: "right",
                                    valign: "middle",
                                    template: "#<?php echo $campografetiqdatatab; ?>#"
                                }
                            });

                            /////////////BARRAS VERTICALES///////////////////////////
        <?php } if ($campograftipotab == 'bar') { ?>
                            barChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "bar", ///para barras verticales
                                //container:"chart1",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                label: "#<?php echo $campografvalordatatab; ?>#",
                                xAxis: {
                                    template: "#<?php echo $campografetiqdatatab; ?>#",
                                    title: "<?php echo $campografetiquettab; ?>"
                                },
                                yAxis: {
                                    //template:"'#data2#",
                                    title: "<?php echo $campografvalortab; ?>"
                                },
                                barWidth: 35,
                                radius: 0,
                                gradient: "rising"
                            });

                            /////////////BARRAS HORIZONTALES///////////////////////////campografvalortab  campografetiqdatatab campografetiquettab
        <?php } if ($campograftipotab == 'barH') { ?>
                            barHChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "barH", ///para barras verticales
                                //container:"chart1",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                label: "#<?php echo $campografvalordatatab; ?>#",
                                xAxis: {
                                    // template:"#<?php echo $campografetiqdatatab; ?>#",
                                    title: "<?php echo $campografvalortab; ?>"
                                },
                                yAxis: {
                                    template: "#<?php echo $campografetiqdatatab; ?>#",
                                    title: "<?php echo $campografetiquettab; ?>"
                                },
                                barWidth: 35,
                                radius: 0,
                                gradient: "rising"
                            });

                            /////////////agregando series de datos
                            /*barChart.addSeries({
                             value:"#sales2#",
                             color:"#a7ee70",
                             label:"#sales2#"
                             });
                             barChart.addSeries({
                             value:"#sales3#",
                             color:"#36abee",
                             label:"#sales3#"
                             });
                             */

                            /////////////GRAFICO DE LINEAS///////////////////////////
        <?php } if ($campograftipotab == 'line') { ?>
                            lineChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "line",
                                //view:"spline",       ///para lineas suaves
                                container: "chart",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                item: {
                                    borderColor: "#1293f8",
                                    color: "#ffffff"
                                },
                                line: {
                                    color: "#1293f8",
                                    width: 3
                                },
                                xAxis: {
                                    template: "'#<?php echo $campografetiqdatatab; ?>#"
                                },
                                offset: 0,
                                yAxis: {
                                    step: 10,
                                    template: function (obj) {
                                        return (obj % 20 ? "" : obj)
                                    }
                                }
                            });

                            /////////////GRAFICO DE LINEAS SINUSOIDALES///////////////////////////
        <?php } if ($campograftipotab == 'spline') { ?>
                            linesinusoidChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "spline",
                                //view:"spline",       ///para lineas suaves
                                container: "chart",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                item: {
                                    borderColor: "#1293f8",
                                    color: "#ffffff"
                                },
                                line: {
                                    color: "#1293f8",
                                    width: 3
                                },
                                xAxis: {
                                    template: "'#<?php echo $campografetiqdatatab; ?>#"
                                },
                                offset: 0,
                                yAxis: {
                                    step: 10,
                                    template: function (obj) {
                                        return (obj % 20 ? "" : obj)
                                    }
                                }
                            });

                            /////////////GRAFICO DE AREAS///////////////////////////
        <?php } if ($campograftipotab == 'area') { ?>
                            areaChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "area",
                                // container:"chart",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                color: "#36abee",
                                alpha: 0.8,
                                xAxis: {
                                    template: "'#<?php echo $campografetiqdatatab; ?>#"
                                },
                                yAxis: {
                                    step: 10,
                                    template: function (obj) {
                                        return (obj % 20 ? "" : obj)
                                    }
                                }
                            })

                            /////////////GRAFICO DE AREAS///////////////////////////
        <?php } if ($campograftipotab == 'radar') { ?>
                            radarChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                //container:"chartDiv",
                                view: "radar",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                disableLines: true,
                                item: {
                                    borderWidth: 0,
                                    radius: 2,
                                    color: "#6633ff"
                                },
                                xAxis: {
                                    template: "#<?php echo $campografetiqdatatab; ?>#"
                                },
                                yAxis: {
                                    lineShape: "arc",
                                    bg: "#fff8ea",
                                    template: function (value) {
                                        return parseFloat(value).toFixed(1)
                                    }
                                }
                            });

                            /////////////GRAFICO DE PUNTOS DISPERSION///////////////////////////
        <?php } if ($campograftipotab == 'scatter') { ?>
                            scatterpuntosChart = myLayout.cells("<?php echo $campografposiubictab; ?>").attachChart({
                                view: "spline",
                                //view:"spline",       ///para lineas suaves
                                container: "chart",
                                value: "#<?php echo $campografvalordatatab; ?>#",
                                item: {
                                    borderColor: "#1293f8",
                                    color: "#ffffff"
                                },
                                line: {
                                    color: "#1293f8",
                                    width: 3
                                },
                                xAxis: {
                                    template: "'#<?php echo $campografetiqdatatab; ?>#"
                                },
                                offset: 0,
                                yAxis: {
                                    step: 10,
                                    template: function (obj) {
                                        return (obj % 20 ? "" : obj)
                                    }
                                }
                            });

                            /////////////////////////////
        <?php } ?>							
/////////////////////////////////////////////////////////////////			

</script>

</body>
</html>
