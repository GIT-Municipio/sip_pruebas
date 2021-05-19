<?php
/////// clase clave del exito
//error_reporting(E_ALL ^ E_NOTICE);

//include db connection settings
function add_row($rowId,$tabla,$mcamprecib){
	global $newId;
	
	 $micamp=explode(",",$mcamprecib);
	 $numelementos = count($micamp);
	//////////////////////////insercion de datos/////////
     $query = "INSERT INTO ".$tabla." ( ";
			 for($i=1;$i<count($micamp);$i++)
				 {
				    if($i==count($micamp)-1)
					  {
				       $query .= $micamp[$i]; 
					  }
				    else	
				      $query .= $micamp[$i].","; 
				 }
			 $query .= ") VALUES ( ";
			 
		     for($i=1;$i<count($micamp);$i++)
				 {
			    if($i==count($micamp)-1)
					//$query .= "'".mb_convert_encoding ($_POST[$rowId."_c".$i], "UTF-8", "ISO-8859-1" )."'"; 
					$query .= "'".$_POST[$rowId."_c".$i]."'"; 
	    		else	
	    		 	//$query .= "'".mb_convert_encoding ($_POST[$rowId."_c".$i], "UTF-8", "ISO-8859-1" )."',";
					$query .= "'".$_POST[$rowId."_c".$i]."',";  
  	  			}////fin de for
	  		 $query .= ");";
			
            require_once('../../../clases/conexion.php');
			$res = pg_query($conn, $query) or die(pg_last_error());
			//////////fin de insercion de datos/////////
	
	$insert_row = pg_fetch_row($res);
	$newId = $insert_row[0];
	
	return "insert";	
}

function update_row($rowId,$tabla,$mcamprecib){
	
	 $micamp=explode(",",$mcamprecib);
	 $numelementos = count($micamp); 
 
	 $query = "UPDATE ".$tabla." SET ";
	 
	 for($i=1;$i<$numelementos;$i++)
	 {
	    if($i==$numelementos-1)
	      $query .= $micamp[$i]."='".$_POST[$rowId."_c".$i]."'"; 
	    else	
	      $query .= $micamp[$i]."='".$_POST[$rowId."_c".$i]."',"; 
	 }
	 
	$query .= " WHERE ".$micamp[0]."='".$_POST[$rowId."_c0"]."'";
	 
    require_once('../../../clases/conexion.php');
	$res = pg_query($conn, $query) or die(pg_last_error());
	
	return "update";	
}

function delete_row($rowId,$tabla,$mcamprecib){
	
	 $micamp=explode(",",$mcamprecib);
	 $d_sql = "DELETE FROM ".$tabla." WHERE ".$micamp[0]."=".$rowId;
	 
	require_once('../../../clases/conexion.php');
	 $resDel = pg_query($conn, $d_sql) or die(pg_last_error());
	
	
	return "delete";
}


//include XML Header (as response will be in xml format)
header("Content-type: text/xml");
//encoding may differ in your case
echo('<?xml version="1.0" encoding="iso-8859-1"?>'); 
//output update results
echo "<data>";

$ids = explode(",",$_POST["ids"]);
////acciones por cada fila
for ($i=0; $i < sizeof($ids); $i++) { 
	$rowId = $ids[$i]; //id or row which was updated 
	$newId = $rowId; //will be used for insert operation	
	$mode = $_POST[$rowId."_!nativeeditor_status"]; //get request mode

	switch($mode){
		case "inserted":
			$action = add_row($rowId,$_GET[mitabla],$_GET[enviocampos]);
		break;
		case "deleted":
			$action = delete_row($rowId,$_GET[mitabla],$_GET[enviocampos]);
		break;
		default:
			$action = update_row($rowId,$_GET[mitabla],$_GET[enviocampos]);
		break;
	}	
	echo "<action type='".$action."' sid='".$rowId."' tid='".$newId."'/>";
}
echo "</data>";
?>