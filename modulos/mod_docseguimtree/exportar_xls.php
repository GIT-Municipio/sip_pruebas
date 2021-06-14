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

$query = "SELECT id, ' Usuario: '||origen_nombres||' Asunto: '||origen_form_asunto as detalle, origen_fecha_creado as fecha,hora_ingreso, respuesta_estado as estado, destino_nombres,destino_cargo,origen_tipodoc,respuesta_observacion,respuesta_comentariotxt,fech_tiempo_dias,fecha_tiempo_atencion,resp_comentario_anterior  FROM public.tbli_esq_plant_formunico_docsinternos WHERE codi_barras='".$_GET['enviocodbarr']."' ";

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

<style type="text/css">
.dr {
    background-color: #F5F5F5;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  .sr {
    background-color: #ecf4ff;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  
</style>

</head>
<body>
<?php
echo "<table  border='1'>";
echo "<tr>";

 for($i=0;$i<pg_num_fields($consulta);$i++)
					{
					  echo "<td  bgcolor='#d1e5fe'><font color='#000'>".strtoupper(pg_field_name($consulta,$i))."</font></td>"; 
					}  
echo "</tr>";
  for($i=0;$i<pg_num_rows($consulta);$i++)
			 {
			  $style = "dr";
    					if ($i % 2 != 0) 
    				  $style = "sr";
					  
			    echo "<tr id='".pg_fetch_result($consulta,$i,0)."'  class='".$style."' >";
				
				 for($col=0;$col<pg_num_fields($consulta);$col++)
					{
						if(pg_field_name($consulta,$col)=='estado')
						{
							if(pg_fetch_result($consulta,$i,$col)=="ATENDIDO")
						      echo "<td bgcolor='#b8fb85'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
							else if(pg_fetch_result($consulta,$i,$col)=="PENDIENTE")
						      echo "<td bgcolor='#fcf6a2'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
							else if(pg_fetch_result($consulta,$i,$col)=="REASIGNADO")
						      echo "<td bgcolor='#fdcfaa'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
							else if(pg_fetch_result($consulta,$i,$col)=="ASIGNADO")
						      echo "<td bgcolor='#fef37f'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
							else if(pg_fetch_result($consulta,$i,$col)=="FINALIZADO")
						      echo "<td bgcolor='#03fc15'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
							else
						      echo "<td bgcolor='#ebf3ff'>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
						}
						else
					    echo "<td>". utf8_decode(pg_fetch_result($consulta,$i,$col))."</td>";
				    }
					
			echo "</tr>";
				}
echo "</table>";
?>

</body>
</html>