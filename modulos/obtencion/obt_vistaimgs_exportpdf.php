<?php
   

    require('phpToPDF/phpToPDF.php');


// SET YOUR PDF OPTIONS
// FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
$pdf_options = array(
  "source_type" => 'url',
  "source" => 'obt_vistaimgs_pdf.php?envidprimaria=1',
  "action" => 'save',
  "save_directory" => '',
  "file_name" => 'url_reporte.pdf');

// CALL THE phptopdf FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);

// OPTIONAL - PUT A LINK TO DOWNLOAD THE PDF YOU JUST CREATED
echo "<script> document.location.href='url_reporte.pdf' </script>"
//echo ("<a href='url_google.pdf'>Hacer click para ver el Archivo PDF</a>");
?>