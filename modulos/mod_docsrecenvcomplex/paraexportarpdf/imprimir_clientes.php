<?php


define('FPDF_FONTPATH','font/');
require('mysql_table.php');
include("comunes.php");
include ("conectar.php"); 

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(50);
$pdf->SetX(0);
$pdf->MultiCell(220,6,"Listado de Clientes",0,C,0);//

$pdf->Ln();    

//Títulos de las columnas
$header=array('Cod.','Nombre y apellidos','Localidad','Provincia','Telf.','Móvil');

//Colores, ancho de línea y fuente en negrita
    $pdf->SetFillColor(200,200,200);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','B',10);
	
//Cabecera
    $w=array(10,60,40,30,20,20);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $pdf->Ln();
	
//Restauración de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);

//Buscamos y listamos los clientes

$consulta = "select * from usuario";
$query = pg_query($conexion,$consulta);
		  
while ($row = pg_fetch_array($query))
        {
		
		 //posicion celda, alto,contenido,bordes que mostramos(left,right top botton),0, alineacion izquierda
		 //imprimo nombre, apellidos y localidad
		 $pdf->Cell($w[0],5,$row["id_usuario"],'LRTB',0,'C'); 
		 $acotado = substr($row["indice"], 0, 40);
         $pdf->Cell($w[1],5,$acotado,'LRTB',0,'L');  
		 $pdf->Cell($w[2],5,$row["cedula"],'LRTB',0,'L');
		 
		 /*
		 //averiguo la provincia
		 $provincia=$row["codprovincia"];
		 $consulta2="select * from provincias where codprovincia=$provincia";
		 $query2=pg_query($consulta2);
		 $laprovincia=pg_fetch_array($query2);
		 //imprimo la provincia
         $pdf->Cell($w[3],5,$laprovincia["denprovincia"],'LRTB',0,'L');
		 */
		 //imprimo telefono y movil
         $pdf->Cell($w[4],5,$row["nombres"],'LRTB',0,'R');
	    // $pdf->Cell($w[5],5,$row["movil"],'LRTB',0,'R');
         $pdf->Ln();		 
        };
		
$pdf->Cell(array_sum($w),0,'','T');	 
$pdf->Output();
?> 
