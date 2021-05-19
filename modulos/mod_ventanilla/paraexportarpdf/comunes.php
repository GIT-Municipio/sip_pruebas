<?

    /*  
  
    Este programa es de distribucion libre, es decir no tiene costo de licencia, sin embargo los costos de Soporte e Implementacion tales como: respaldos, Recuperacion de datos, Administracion de la Base de datos seran cobradas, asi como tambien el mantenimiento preventivo del Software segun las disposiciones generales de Desarrollador.
	
	Autor: Fausto Lucano
	Versión: 1.0
	Fecha Liberación del código: 12/02/2006 
	
	*/
class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('../paraexportarpdf/logo/logo.jpg',20,8,180);
    $this->Ln(30);	
}

//Pie de página
function Footer()
{


/*
    //Posición: a 1,5 cm del final
    $this->SetY(-21);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //Número de página
    $this->Cell(0,10,'http://fausoft.blogspot.com -- E-Mail: faus_luc@hotmail.com',0,0,'C');	
	
	//Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //Número de página
    $this->Cell(0,10,'Proyecto Fausoft v1.0',0,0,'C');	
	
*/

    //Posición: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
    $this->Cell(0,10,'-- '.$this->PageNo().' --',0,0,'C');
}


}
?>