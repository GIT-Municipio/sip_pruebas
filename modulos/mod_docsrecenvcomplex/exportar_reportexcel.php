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

$query = "select ".$_GET["enviocampxls"]." from ".$_GET["envtabxls"];

$consulta = pg_query($conn,$query);


//muestra los datos consultados
//haremos uso de tabla para tabular los resultados

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reportes al ".date("d-m-y").".xls");
?>
<HTML LANG="es">
<title>Bases de Datos.</title>
</head>
<body>
<?php
echo "<table>";
echo "<tr>";

 for($i=0;$i<pg_num_fields($consulta);$i++)
					{
					  echo "<td  bgcolor='#003366'><font color='#FFFFFF'>".pg_field_name($consulta,$i)."</font></td>"; 
					}  
echo "</tr>";
  for($i=0;$i<pg_num_rows($consulta);$i++)
			 {
			 
			    echo "<tr id='".pg_fetch_result($consulta,$i,0)."'>";
				
				 for($col=0;$col<pg_num_fields($consulta);$col++)
					{
					echo "<td>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
				    }
					
			echo "</tr>";
				}
echo "</table>";
?>

</body>
</html>