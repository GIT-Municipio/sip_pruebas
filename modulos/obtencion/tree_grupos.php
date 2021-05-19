<?php

require_once('../../conexion.php');

//$parent_id = $_GET['node'];
//echo $_GET['node'];

if ($_GET['node'] == 'root') {$parent_id = 0;} else {$parent_id = $_GET['node'];} // added by chiken

if($parent_id !="")
  $query = "SELECT id, descripcion as text, ultimonivel as leaf FROM tbl_archivos_procesados WHERE parent_id='".$parent_id."' order by item_orden";
else
  $query = "SELECT id, grupo_codbarras_tramite|| ': ' || descripcion as text, ultimonivel as leaf FROM tbl_archivos_procesados WHERE parent_id=0  order by item_orden";
 

//$rs = mysql_query($query);
$rs = pg_query($conn,$query);     
         

$arr = array(); while($obj = pg_fetch_object($rs)) {
    $arr[] = $obj;
}

echo json_encode($arr);

?>