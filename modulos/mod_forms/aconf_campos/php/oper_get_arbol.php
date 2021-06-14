<?php
/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
This version of Software is free for using in non-commercial applications.
For commercial use please contact sales@dhtmlx.com to obtain license
*/


//start session to build different trees for different sessions (if you set $_SESSION["id"] to some hardcoded value, this way of processing will be skipped)
error_reporting(E_ALL ^ E_NOTICE);
	
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
if(!isset($_SESSION["id"]))
	$_SESSION["id"] = microtime();

//include db connection settings





//FUNCTIONS TO USE IN THE CODE LATER

//print tree XML based on parent_id (function calls itself to go through the nested levels)
	function getLevelFromDB($parent_id){
		
		require_once('../../clases/conexion.php');
		
		
		
		
		//get tree level from database taking parent id as incomming argument
	$sql = "SELECT  ".$_REQUEST[elidprincipal].", ".$_REQUEST[minombredato]." FROM ".$_REQUEST[mitabla]." WHERE ".$_REQUEST[ref_parent_padre]."=$parent_id  ORDER BY ".$_REQUEST[elidprincipal];
		$res = pg_query ($conn, $sql);
		if($res){
			while($row=pg_fetch_array($res)){
				//create xml tag for tree node
				print("<item id='".$row['idmenuweb']."' text=\"". str_replace('"',"&quot;",$row[$_REQUEST[minombredato]])."\">");
				//include child nodes
				getLevelFromDB($row['idmenuweb']);
				//close xml tag for the node
				print("</item>");
			}
		}else{
			//echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
			echo "Error";
		}
	}

//XML HEADER

//include XML Header (as response will be in xml format)
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
/* echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); */
echo('<?xml version="1.0" encoding="utf-8"?>'); 
?>

<!-- start tree xml -->
<tree id="0">
	
<?php
	//print tree XML
	getLevelFromDB(0);
	//Close db connection
	//mysql_close($link);
?>

<!-- close tree xml -->
</tree>
