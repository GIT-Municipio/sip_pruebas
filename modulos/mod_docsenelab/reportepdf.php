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

$query = $_SESSION['miconsultaparaexcel'];
$consulta = pg_query($conn,$query);


define('FPDF_FONTPATH','font/');
require('../paraexportarpdf/mysql_table.php');
include("../paraexportarpdf/comunes.php");
//include ("../paraexportarpdf/conectar.php"); 

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(50);
$pdf->SetX(0);
$pdf->MultiCell(220,6,"Listado de Clientes",0,C,0);//

$pdf->Ln();    


//$micamp[]="ID";
//T�tulos de las columnas
 for($i=0;$i<pg_num_fields($consulta);$i++)
{
	$micamp[]=pg_field_name($consulta,$i);
 }

$header=$micamp;//array('Cod.','Nombre y apellidos','Localidad','Provincia','Telf.','M�vil');

//Colores, ancho de l�nea y fuente en negrita
    $pdf->SetFillColor(200,200,200);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','B',8);
	
//Cabecera
 for($i=0;$i<pg_num_fields($consulta);$i++)
{


     if(pg_field_name($consulta,$i)=='derivacion')
	 $micamptamanios[]=10;
	 else
    if(pg_field_name($consulta,$i)=='junta')
	 $micamptamanios[]=10;
	 else
	 if(pg_field_name($consulta,$i)=='cedula')
	 $micamptamanios[]=15;
	 else
	 {
    if(pg_field_type($consulta,$i)=='int4')
	 $micamptamanios[]=10;
	  if(pg_field_type($consulta,$i)=='numeric')
	 $micamptamanios[]=10;
	  if(pg_field_type($consulta,$i)=='varchar')
	 $micamptamanios[]=60;
	  if(pg_field_type($consulta,$i)=='date')
	 $micamptamanios[]=15;
	 }
	 

 }

    $w=$micamptamanios;//array(10,60,40,30,20,20);
	
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $pdf->Ln();
	
//Restauraci�n de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);

//Buscamos y listamos los clientes


 for($i=0;$i<pg_num_rows($consulta);$i++)
	{
 for($m=0;$m<pg_num_fields($consulta);$m++)
	    {
	        $pdf->Cell($w[$m],5,pg_fetch_result($consulta,$i,$m),'LRTB',0,'L');    ////L: left, C center, R: rigth
	    }
		 $pdf->Ln();
	}

		
$pdf->Cell(array_sum($w),0,'','T');	 
$pdf->Output();
?> 
