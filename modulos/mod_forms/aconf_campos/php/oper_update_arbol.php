<?php
/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
This version of Software is free for using in non-commercial applications.
For commercial use please contact sales@dhtmlx.com to obtain license
*/

//start session (see get.php for details) 
	error_reporting(E_ALL ^ E_NOTICE);
	
session_start();
if(!isset($_SESSION["id"]))
	$_SESSION["id"] = microtime();
	
//include db connection settings
//require_once("../../common/config.php");
//require_once("config.php");


//$link = mysql_pconnect($mysql_host, $mysql_user, $mysql_pasw);
//$db = mysql_select_db ($mysql_db);


require_once('../../clases/conexion.php');
$poneridtablagen='idmenuweb';

//FUNCTION TO USE IN THE CODE LATER

//deletes single node in db
function deleteSingleNode($id){
		$d_sql = "Delete from ".$_REQUEST[mitabla]." where ".$poneridtablagen."=".$id;
		// $resDel = mysql_query($d_sql);
		$resDel = pg_query($conn,$d_sql);
	}
//deletes all child nodes of the item
function deleteBranch($pid){
	$s_sql = "Select ".$poneridtablagen.",item_orden from ".$_REQUEST[mitabla]." where ".$_REQUEST[ref_parent_padre]."=$pid";;
	//$res = mysql_query($s_sql);
	$res = pg_query($conn,$s_sql);
	if($res){
		//while($row=mysql_fetch_array($res)){
		while($row=pg_fetch_array($res)){
			deleteBranch($row['item_id']);
			deleteSingleNode($row['item_id']);
		}
	}
}

//XML HEADER

//include XML Header (as response will be in xml format)
/*
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n"); 
*/
//include XML Header (as response will be in xml format)

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
 		header("Content-type: application/xhtml+xml"); } else {
 		header("Content-type: text/xml");
}
echo('<?xml version="1.0" encoding="utf-8"?>'); 


if(isset($_REQUEST[$_REQUEST[ids]."_!nativeeditor_status"]) && $_REQUEST[$_REQUEST[ids]."_!nativeeditor_status"]=="inserted"){

	//INSERT

	//insert new row
	$sql = 	"Insert into ".$_REQUEST[mitabla]."(".$_REQUEST[minombredato].",".$_REQUEST[ref_parent_padre].",item_orden) ";
	$sql.= 	"Values('".addslashes($_REQUEST[$_REQUEST[ids]."_tr_text"])."',".$_REQUEST[$_REQUEST[ids]."_tr_pid"].",".$_REQUEST[$_REQUEST[ids]."_tr_order"].")";
	
		//$res = mysql_query($sql);
		$res = pg_query($conn,$sql);
		
		//$newId = mysql_insert_id();
		$insert_row = pg_fetch_row($res);
		$newId = $insert_row[0];
		
		
	//update items orders on the level where node was added
	$sql_uorders = "UPDATE ".$_REQUEST[mitabla]." SET item_orden=item_orden+1 WHERE ".$_REQUEST[ref_parent_padre]."=".$_REQUEST[$_REQUEST[ids]."_tr_pid"]." AND item_orden>=".$_REQUEST[$_REQUEST[ids]."_tr_order"]." and ".$poneridtablagen."<>".$newId;
		// $res = mysql_query($sql_uorders);
		 $res = pg_query($conn,$sql_uorders);
		
	//set value to use in response
	$action = "insert";
	
	
}else if(isset($_REQUEST[$_REQUEST[ids]."_!nativeeditor_status"]) && $_REQUEST[$_REQUEST[ids]."_!nativeeditor_status"]=="deleted"){

	//DELETE
	
	//updateitems order on the level where node was deleted
	$sql_uorders = "UPDATE ".$_REQUEST[mitabla]." SET item_orden=item_orden-1 WHERE ".$_REQUEST[ref_parent_padre]."=".$_REQUEST[$_REQUEST[ids]."_tr_pid"]." AND item_orden>".($_REQUEST[$_REQUEST[ids]."_tr_order"]);
	
		//delete all nested nodes and current node
		deleteBranch($_REQUEST[$_REQUEST[ids]."_tr_id"]);
		deleteSingleNode($_REQUEST[$_REQUEST[ids]."_tr_id"]);
		//$res = mysql_query($sql_uorders);
		$res = pg_query($conn,$sql_uorders);
	//set values to use in response
	$newId = $_REQUEST[$_REQUEST[ids]."_tr_id"];
	$action = "delete";
	
}else{

	//UPDATE and Drag-n-Drop
	
	//get information about node parent and order before update
	$sql_getoldparent = "Select ".$_REQUEST[ref_parent_padre].",item_orden from ".$_REQUEST[mitabla]." where ".$poneridtablagen."=".$_REQUEST[$_REQUEST[ids]."_tr_id"];
	//$res = mysql_query($sql_getoldparent);
	$res = pg_query($conn,$sql_getoldparent);
	
	//$old_values = mysql_fetch_array($res);
	$old_values = pg_fetch_array($res);
	
	
	//update node info 
	$sql = 	"Update ".$_REQUEST[mitabla]." set ".$_REQUEST[minombredato]." = '".addslashes($_REQUEST[$_REQUEST[ids]."_tr_text"])."',".$_REQUEST[ref_parent_padre]." = ".$_REQUEST[$_REQUEST[ids]."_tr_pid"].",item_orden = ".$_REQUEST[$_REQUEST[ids]."_tr_order"]." where ".$poneridtablagen."=".$_REQUEST[$_REQUEST[ids]."_tr_id"];
	//update nodes order on old node level (after drag-n-drop node level can be changed)
	$sql_uorders_old = "UPDATE ".$_REQUEST[mitabla]." SET item_orden=item_orden-1 WHERE ".$_REQUEST[ref_parent_padre]."=".$old_values[0]." AND item_orden>".$old_values[1]." and ".$poneridtablagen."<>".$_REQUEST[$_REQUEST[ids]."_tr_id"];
	//update nodes order on current node level
	$sql_uorders_new = "UPDATE ".$_REQUEST[mitabla]." SET item_orden=item_orden+1 WHERE ".$_REQUEST[ref_parent_padre]."=".$_REQUEST[$_REQUEST[ids]."_tr_pid"]." AND item_orden>=".$_REQUEST[$_REQUEST[ids]."_tr_order"]." and ".$poneridtablagen."<>".$_REQUEST[$_REQUEST[ids]."_tr_id"];
		//$res = mysql_query($sql);
		$res = pg_query($conn,$sql);
		
		//$res = mysql_query($sql_uorders_old);
		$res = pg_query($conn,$sql_uorders_old);
		
		//$res = mysql_query($sql_uorders_new);
		$res = pg_query($conn,$sql_uorders_new);
	
	//set values to include in response
	$newId = $_REQUEST[$_REQUEST[ids]."_tr_id"];
	$action = "update";
}
?>
<!-- response xml -->
<data>
	<action type='<?php echo $action; ?>' sid='<?php echo $_REQUEST[$_REQUEST[ids]."_tr_id"]; ?>' tid='<?php echo $newId; ?>'/>
</data>
