
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Informacion Alfanumerica</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
    <script src="dat/data.js"></script>
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
				pattern: "2U",
				cells: [{id: "a", text: "MIDATO", width: 300},{id: "b", text: "GRAFICO DE: MIDATO"} ]
							});
	
	
		
	
	//myLayout.cells("a").collapse();
	
	//carga de informacion///////////////////
	mygrid = new dhtmlXGridObject('gridbox');
	mygrid = myLayout.cells("a").attachGrid();   ////codigo para poner la grilla
	mygrid.setImagePath("codebase/imgs/");
	mygrid.setHeader("ID,CAMPO_0,CAMPO_1");
	mygrid.attachHeader("#text_filter,#text_filter,#text_filter");
	mygrid.setInitWidths("50,150,100");
	mygrid.setColAlign("left,left,left");
	mygrid.setColTypes("dyn,txt,edn");
	mygrid.setSkin("dhx_skyblue");
	mygrid.setColSorting("int,str,int");
	
	///////////////////////inicio seteo numeros///////////////////////////////
	 mygrid.setNumberFormat('0,000.00',2,',','.'); 	////////////////////////fin seteo numeros/////////////////////////////////
	
	mygrid.init();
	mygrid.loadXML("php/oper_get_datosgrid.php?mitabla=vista_estad_tipotramites&enviocampos=id,origen_tipo_tramite,count",refresh_chart);	//used just
	////sirve para desactivar la edicion
	///primer false: editar con un click///segundo false: editar con dos click///tercer false: editar con F2///
	mygrid.enableEditEvents(false,false,true);
	
	
	menusuptools = myLayout.cells("a").attachToolbar({
				icons_path: "../../componentes/common/imgs/",
				xml: "xml/barbtns_conexport.xml",
				
			});
			
	menusuptools.attachEvent("onClick", function(id){
     		//alert(id);
			if(id=="xbtnexcel")
			{
				mygrid.toExcel('../../componentes/codebase/grid-excel-php/generate.php');
			}
			if(id=="xbtnpdf")
			{
				mygrid.toPDF('../../componentes/codebase/grid-pdf-php/generate.php');
			}
			    
	    });
	
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
                               // pieChart.clearAll();
                                //pieChart.parse(mygrid, "dhtmlxgrid");
         		 
   };



///////GRAFICO PASTEL/////////	
                      ///////GRAFICO PASTEL/////////	
                            /*    pieChart = myLayout.cells("b").attachChart({
                                view: "pie",
                                value: "#data2#",
                                //label:"#data1#",
                                label: function (obj) {
                                    var sum = pieChart.sum("#data2#");
                                    var text = Math.round(parseFloat(obj.data2) * 100 / parseFloat(sum)) + "%";
                                    return "<div class='label' style='border:1px solid #ee4339'>" + text + "</div>";
                                },
                                //pieInnerText: "#data2#",
                                gradient: 1,
                                legend: {
                                    width: 300,
                                    align: "right",
                                    valign: "middle",
                                    template: "#data1#"
                                }

                            });*/
							

							 myBarChart = myLayout.cells("b").attachChart({
                                view:"bar",
				container:"chart1",
				value:"#sales#",
				color: "#58dccd",
				gradient:"rising",
				width:20,
				tooltip:{
					template:"#sales#"
				},
				xAxis:{
					template:"'#year#"
				},
				yAxis:{
					start:0,
					step:10,
					end:100
				},
				legend:{
					values:[{text:"Tramites Atendidos",color:"#58dccd"},{text:"Tramites Solicitados",color:"#a7ee70"},{text:"Nivel Servicio",color:"#36abee",markerType: "item"}],
					valign:"middle",
					align:"right",
					width:150,
					layout:"y"
				}

                            });
							
							myBarChart.addSeries({
				value:"#sales2#",
				color:"#a7ee70",
				tooltip:{
					template:"#sales2#"
				}
			});
			myBarChart.addSeries({
				//offset:0,
				view: "line",
				item:{
					radius:0
				},
				line:{
				  color:"#36abee"
				},
				value:"#sales3#",
				tooltip:{
					template:"#sales3#"
				}
			});
			myBarChart.parse(multiple_dataset,"json");
						
                         //var canvas = pieChart.getCanvas().canvas;
						 //var img = canvas.toDataURL ("image/png");
                            ///////GRAFICO PASTEL 3D/////////		
        							
/////////////////////////////////////////////////////////////////			

</script>

</body>
</html>
