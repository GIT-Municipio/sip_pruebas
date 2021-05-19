<?php
require_once('../clases/conexion.php');
session_start();

 $sqlups="update tblu_migra_usuarios set usu_sesionactiva=0 where  id='".$_SESSION['sesusuario_idprinusu']."' ";
$result=pg_query($conn, $sqlups);



session_destroy();
echo "<script>document.location.href='../index.php';</script>";

?>