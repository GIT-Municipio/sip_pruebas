<?php

require_once('../../clases/conexion.php');

$motrarmensaje="";
if(isset($_GET['opcion'])) {
if($_GET['opcion']=='Agregar')
{
//$query="INSERT INTO usuario_datosinfo( cedula,nombre,direccion_domicilio,email,telefono_fijo,telefono_celular,fotoimagen,observacionpredio,total_predios)    VALUES ( '".$_POST['cedula']."', '".$_POST['nombre']."','".$_POST['direccion_domicilio']."','".$_POST['email']."','".$_POST['telefono_fijo']."','".$_POST['telefono_celular']."','".$_POST['fotoimagen']."','".$_POST['observacionpredio']."','".$_POST['total_predios']."' );";
//$query="INSERT INTO nuevopredio( cedula, usuario)    VALUES ( '2222222222', 'fre2' );";
$motrarmensaje="El registro fue exitoso";
}

if($_GET['opcion']=='Editar')
{

//$query=	"UPDATE usuario_datosinfo   SET  cedula='".$_POST['cedula']."', nombre=upper('".$_POST['nombre']."'),direccion_domicilio='".$_POST['direccion_domicilio']."',email='".$_POST['email']."',telefono_fijo='".$_POST['telefono_fijo']."',telefono_celular='".$_POST['telefono_celular']."',observacionpredio='".$_POST['observacionpredio']."'   WHERE id_usuario='".$_POST['idprimaria']."';";

$motrarmensaje="Se actualizo correctamente";


}

if($_GET['opcion']=='Actualvistaunvalor')
{
/*
$query ="select descripcion||' ('||total_docsproces||')' as text FROM tbl_archivos_procesados   WHERE id='".$_POST['Idenv']."';";
$result = pg_query($conn,$query);
$versiesgrupocat=pg_fetch_result($result,0,0);
*/
$motrarmensaje="Solo vista";

}


if($_GET['opcion']=='Editarunvalor')
{
$queryinternsol =	"select parent_id FROM tbl_archivos_procesados   WHERE id='".$_POST['idprimaria']."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumgrupocon=pg_fetch_result($resultinsolint,0,0);
$query="";
if($vernumgrupocon<>0)
{
$queryinternsol =	"select id,descripcion,param_bodega, param_estanteria, param_nivel  FROM tbl_archivos_procesados   WHERE id='".$vernumgrupocon."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumbodega=pg_fetch_result($resultinsolint,0,'param_bodega');
$vernumestant=pg_fetch_result($resultinsolint,0,'param_estanteria');
$vernumnivel=pg_fetch_result($resultinsolint,0,'param_nivel');

$query=	"UPDATE tbl_archivos_procesados   SET  param_bodega='".$vernumbodega."',param_estanteria='".$vernumestant."',param_nivel='".$vernumnivel."'  WHERE id='".$_POST['idprimaria']."';";
}

if(isset($_POST['param_departamento']))
{
/////actualizo procesados
$query.=	"UPDATE tbl_archivos_procesados   SET  descripcion='".$_POST['descripcion']."',doc_titulo='".$_POST['doc_titulo']."',param_departamento='".$_POST['param_departamento']."'  WHERE id='".$_POST['idprimaria']."';";

////actualizo imagenes	
$query.="UPDATE tbl_archivos_scanimgs   SET  gparam_departamento='".$_POST['param_departamento']."'  WHERE ref_archprocesados='".$_POST['idprimaria']."';";
}
else
{
/////actualizo procesados
$query.=	"UPDATE tbl_archivos_procesados   SET  descripcion='".$_POST['descripcion']."',doc_titulo='".$_POST['doc_titulo']."'  WHERE id='".$_POST['idprimaria']."';";

}


//$query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$_POST['idprimaria']."') where id='".$_POST['idprimaria']."'; ";


$motrarmensaje="Se actualizo correctamente";

}



if($_GET['opcion']=='Editarparentid')
{
	
$queryinternsol =	"select id,descripcion,param_bodega, param_estanteria, param_nivel  FROM tbl_archivos_procesados   WHERE id='".$_POST['parent_id']."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumbodega=pg_fetch_result($resultinsolint,0,'param_bodega');
$vernumestant=pg_fetch_result($resultinsolint,0,'param_estanteria');
$vernumnivel=pg_fetch_result($resultinsolint,0,'param_nivel');


$query=	"UPDATE tbl_archivos_procesados   SET  param_bodega='".$vernumbodega."',param_estanteria='".$vernumestant."',param_nivel='".$vernumnivel."'  WHERE id='".$_POST['idprimaria']."';";

////actualizacion normal
$query.=	"UPDATE tbl_archivos_procesados   SET  parent_id='".$_POST['parent_id']."'  WHERE id='".$_POST['idprimaria']."';";

////actualizo imagenes contadores	
$query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$_POST['parent_id']."') where id='".$_POST['parent_id']."'; ";

$motrarmensaje="Se actualizo correctamente";

}


if($_GET['opcion']=='Eliminar')
{

$query =	"select cod_iden_grupo FROM tbl_archivos_procesados   WHERE id='".$_POST['Idenv']."';";
$result = pg_query($conn,$query);
$versiesgrupocat=pg_fetch_result($result,0,0);
if($versiesgrupocat!=0)
{
if($versiesgrupocat==1)	
{	

$queryintern =	"select id,parent_id FROM tbl_archivos_procesados   WHERE parent_id='".$_POST['Idenv']."';";
$resultintern = pg_query($conn,$queryintern);

for($km=0;$km<pg_num_rows($resultintern);$km++)
{
$veridintern=pg_fetch_result($resultintern,$km,0);

 $querysol =	"insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where parent_id='".$veridintern."');DELETE FROM tbl_archivos_procesados  WHERE parent_id='".$veridintern."';";
 ///////////actualizo contador
// $querysol.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$veridintern."') where id='".$veridintern."'; ";
 
 $reselimintern = pg_query($conn,$querysol);
// echo $querysol;
}

 $query =	"insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where parent_id='".$_POST['Idenv']."');insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where id='".$_POST['Idenv']."');DELETE FROM tbl_archivos_procesados  WHERE parent_id='".$_POST['Idenv']."';DELETE FROM tbl_archivos_procesados  WHERE id='".$_POST['Idenv']."';";
 
  ///////////actualizo contador
// $query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$_POST['Idenv']."') where id='".$_POST['Idenv']."';";
 
}

if($versiesgrupocat==2)	
{	

$queryinternsol =	"select parent_id FROM tbl_archivos_procesados   WHERE id='".$_POST['Idenv']."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumgrupocon=pg_fetch_result($resultinsolint,0,0);

 $query =	"insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where parent_id='".$_POST['Idenv']."');insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where id='".$_POST['Idenv']."');DELETE FROM tbl_archivos_procesados  WHERE parent_id='".$_POST['Idenv']."';DELETE FROM tbl_archivos_procesados  WHERE id='".$_POST['Idenv']."';";
 
   ///////////actualizo contador
// $query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$vernumgrupocon."') where id='".$vernumgrupocon."';";
 /////////////////////////////////////
}

///////////////////////////////////////
 
}
else
{
$queryinternsol =	"select parent_id FROM tbl_archivos_procesados   WHERE id='".$_POST['Idenv']."';";
$resultinsolint = pg_query($conn,$queryinternsol);
$vernumgrupocon=pg_fetch_result($resultinsolint,0,0);

 $query =	"insert into tbl_archivos_procesados_elim (select * from tbl_archivos_procesados where id='".$_POST['Idenv']."');DELETE FROM tbl_archivos_procesados  WHERE id='".$_POST['Idenv']."';";
    ///////////actualizo contador
 $query.="UPDATE tbl_archivos_procesados SET total_docsproces=(SELECT count(*)  FROM tbl_archivos_procesados where parent_id='".$vernumgrupocon."') where id='".$vernumgrupocon."';";
 /////////////////////////////////////
 
}


$motrarmensaje="El registro fue eliminado";
}


$result = pg_query($conn,$query);

    //json output to notify the insert is success or not
if ($motrarmensaje) {
json_encode(array('success' => true));
echo $motrarmensaje;
//echo "El registro fue un exito";
}
else {
json_encode(array('success' => false));
echo "Error en la Actualizacion";

}

}
pg_close($conn);
?>