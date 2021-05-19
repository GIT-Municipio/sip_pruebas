<?php
require_once('../clases/conexion.php');
session_start();

 $sqlups="update tblu_migra_usuarios set usu_sesionactiva=0 where  usua_login='".$_GET["seslogin"]."' and usua_pasw=md5('".$_GET["sespasw"]."');";
$result=pg_query($conn, $sqlups);


echo "<script>alert('Se ha restablecido!!  Intente Acceder ');document.location.href='index.php';</script>";

?>