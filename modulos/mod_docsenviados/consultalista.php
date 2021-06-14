<?php

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

/*
function getDB() {
    $dbFile = "filter-demo.db";
    $hasDB = file_exists($dbFile);

    $db = new SQLiteDatabase($dbFile);
    if (!$hasDB) {
        $db->query(readCreateSql());
    }
    return $db;
}

function readCreateSql() {
    $filename = "grid-demo.sql";
    $file = fopen($filename, 'r');
    $data = fread($file, filesize($filename));
    fclose($file);
    return $data;
}
*/

// collect request parameters
$start  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
$count  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 50;
$sort   = isset($_REQUEST['sort'])   ? json_decode($_REQUEST['sort'])   : null;
$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

//$sortProperty = $sort[0]->property; 
//$sortDirection = $sort[0]->direction;

// GridFilters sends filters as an Array if not json encoded
if (is_array($filters)) {
    $encoded = false;
} else {
    $encoded = true;
    $filters = json_decode($filters);
}

$where = ' 0 = 0 ';
$qs = '';

// loop through filters sent by client
if (is_array($filters)) {
    for ($i=0;$i<count($filters);$i++){
        $filter = $filters[$i];

        // assign filter data (location depends if encoded or not)
        if ($encoded) {
            $field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;
        } else {
            $field = $filter['field'];
            $value = $filter['data']['value'];
            $compare = isset($filter['data']['comparison']) ? $filter['data']['comparison'] : null;
            $filterType = $filter['data']['type'];
        }

        switch($filterType){
            case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; Break;
            case 'list' :
                if (strstr($value,',')){
                    $fi = explode(',',$value);
                    for ($q=0;$q<count($fi);$q++){
                        $fi[$q] = "'".$fi[$q]."'";
                    }
                    $value = implode(',',$fi);
                    $qs .= " AND ".$field." IN (".$value.")";
                }else{
                    $qs .= " AND ".$field." = '".$value."'";
                }
            Break;
            case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
            case 'numeric' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
                    case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
                    case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
                }
            Break;
            case 'date' :
                switch ($compare) {
                    case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
                    case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
                }
            Break;
        }
    }
    $where .= $qs;
}
if(isset($_GET['micmpususeguim'])!="")
{

   

      if(isset($_GET['mibtnopcionbandeja'])!="")
       {
		   switch($_GET['mibtnopcionbandeja'])
            {
	            case "1":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_recibido=1 and destino_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;
				 case "2":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE (est_respuesta_enviado=1 and origen_cedul='".$_GET['micmpususeguim']."' and ".$where.") or (est_respuesta_enviado=1 and destino_cedul='".$_GET['micmpususeguim']."' and resp_estado_anterior='FINALIZADO' and ".$where.") ";
		                   break;
				 case "3":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_reasignado=1 and destino_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;
				 case "4":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_enedicion=1 and origen_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;
				 case "5":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_enedicion=1 and origen_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;
				 case "6":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_informado=1 and destino_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;
                 case "7": $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_enviado=1 and est_respuesta_atendido=1 and origen_cedul='".$_GET['micmpususeguim']."' and ".$where;
                           break;			   
			     case "8":  $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE origen_cedul='".$_GET['micmpususeguim']."' and ".$where;
		                   break;	
		   
                           
                           default: $query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE est_respuesta_recibido=1 and destino_cedul='".$_GET['micmpususeguim']."' and ".$where;

			}


	   } else {
///////////////////////////////////////////////////////////////////////////
  
             if(isset($_GET['consulvarfecha'])!="")
			 {

$query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and destino_fecha_creado='".$_GET['consulvarfecha']."' and ".$where;
			 }
			 else if(isset($_GET['consulvarfechaini'])!="")
			 {

$query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and destino_fecha_creado BETWEEN  '".$_GET['consulvarfechaini']."'  AND '".$_GET['consulvarfechafin']."'  and ".$where;

			 }
			 else if(isset($_GET['consulvarcampo'])!="")
			 {

$query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and ".$_GET['consulvarcampo']." like '%".$_GET['consulvarinfo']."%'  and ".$where;
			 }
			 else
			 {

$query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and ".$where;
			 }



///////////////////////////////////////////////////////////////////////////
	   }


}
else
$query = "SELECT ".$_GET['milistcampos']." FROM ".$_GET['mitablavista']." WHERE ".$where;
//$query .= " ORDER BY ".$sortProperty." ".$sortDirection;
//$query .= " LIMIT ".$start.",".$count;
//$query .= " ORDER BY ".$_GET['miordencmp']." ";
$query .= " ORDER BY destino_fecha_creado desc,codi_barras desc ";

///session_register("miconsultaparaexcel");

$_SESSION['miconsultaparaexcel']=$query;

$query .= " LIMIT ".$count." OFFSET ".$start;

//echo $query;

/*$db = getDB();
$count = $db->singleQuery("SELECT COUNT(id) FROM demo WHERE ".$where);
$result = $db->query($query);
*/
require_once('../../clases/conexion.php');
$result = pg_query($conn,$query);


if(isset($_GET['micmpususeguim'])!="")
{

 if(isset($_GET['mibtnopcionbandeja'])!="")
       {
		   
		   switch($_GET['mibtnopcionbandeja'])
            {
				 case "1":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_recibido=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
				 case "2":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_enviado=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
			     case "3":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_reasignado=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
				case "4":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_enedicion=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
				case "5":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_enedicion=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
				case "6":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_informado=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
			    case "7":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_enviado=1 and est_respuesta_atendido=1 and destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;
				case "8":  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		                   break;		   
				default:  $total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE est_respuesta_recibido=1 and  destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
		
				
				

			}


  } else {
$total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE destino_cedul='".$_GET['micmpususeguim']."' and ".$where);
  }



}
else
$total = pg_query($conn,"SELECT COUNT(*) FROM ".$_GET['mitablavista']." WHERE ".$where);


$count = pg_fetch_result($total, 0, 0);


$rows = Array();
//while($row = $result->fetch(SQLITE_ASSOC)) {
while($row = pg_fetch_object($result)) {
    array_push($rows, $row);
}
echo json_encode(Array(
    "total"=>$count,
    "data"=>$rows
));

?>