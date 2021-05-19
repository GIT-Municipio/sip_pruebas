<?php

require_once('../../clases/conexion.php');

$motrarmensaje="";

if($_GET[opcion]=='Agregar')
{
$query="INSERT INTO usuario_datosinfo( cedula,nombre,direccion_domicilio,email,telefono_fijo,telefono_celular,fotoimagen,observacionpredio,total_predios)    VALUES ( '".$_POST['cedula']."', '".$_POST['nombre']."','".$_POST['direccion_domicilio']."','".$_POST['email']."','".$_POST['telefono_fijo']."','".$_POST['telefono_celular']."','".$_POST['fotoimagen']."','".$_POST['observacionpredio']."','".$_POST['total_predios']."' );";
//$query="INSERT INTO nuevopredio( cedula, usuario)    VALUES ( '2222222222', 'fre2' );";
$motrarmensaje="El registro fue exitoso";
}

if($_GET[opcion]=='Editar')
{

$query=	"UPDATE usuario_datosinfo   SET  cedula='".$_POST['cedula']."', nombre=upper('".$_POST['nombre']."'),direccion_domicilio='".$_POST['direccion_domicilio']."',email='".$_POST['email']."',telefono_fijo='".$_POST['telefono_fijo']."',telefono_celular='".$_POST['telefono_celular']."',observacionpredio='".$_POST['observacionpredio']."'   WHERE id_usuario='".$_POST['idprimaria']."';";

$motrarmensaje="Se actualizo correctamente";


}

if($_GET[opcion]=='Editarunvalor')
{
$vectorcamposedit=explode(",",$_GET['enviocampos']);
$numelementos = count($vectorcamposedit); 

 $query="UPDATE ".$_GET['mitabla']."   SET  ";
 
 for($iv=1;$iv<$numelementos;$iv++)
 {
	 if($iv==$numelementos-1)
	    $query.= " ".$vectorcamposedit[$iv]."='".$_POST[$vectorcamposedit[$iv]]."' ";
	 else
	    $query.= " ".$vectorcamposedit[$iv]."='".$_POST[$vectorcamposedit[$iv]]."', ";
 }
 
$query.=" WHERE ".$_GET['elidprimar']."='".$_POST[$_GET['elidprimar']]."'";
  

$result = pg_query($conn,$query);

$queryadicional="UPDATE ".$_GET['mitabla']." SET resp_comentario_anterior='".$_POST['respuesta_comentariotxt']."'  WHERE parent_id='".$_POST[$_GET['elidprimar']]."';";
$result = pg_query($conn,$queryadicional);

$motrarmensaje="Se actualizo correctamente";

}


if($_GET[opcion]=='Eliminar')
{
	
 $query =	"DELETE FROM usuario_datosinfo  WHERE id_usuario='".$_POST['Idenv']."';";
$motrarmensaje="El registro fue eliminado";
}




    //json output to notify the insert is success or not
if ($q) {
json_encode(array('success' => true));
echo $motrarmensaje;
//echo "El registro fue un exito";
}
else {
json_encode(array('success' => false));
echo $motrarmensaje;

}
pg_close($conn);
?>