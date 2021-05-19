<?php

$connlocal = pg_connect("host=localhost port=5432 dbname=bdd_magactores user=postgres password=postgres");

 $sqlins = "SELECT id, nom_base_datos, host FROM data_proyectos where id='".$_GET[miproy]."';";
$resulver = pg_query($connlocal, $sqlins);
$middbasedatproy=pg_fetch_result($resulver,0,1);
$middhostdatproy=pg_fetch_result($resulver,0,2);


////////////////si la tabla es interna
$latabladesag=explode(".",$_GET[mitabla]);
$tamvec=count($latabladesag);

if($tamvec==2)
{
	if(($latabladesag[0]=='bdd_estadistica_cantonal')||($latabladesag[0]=='bdd_estadistica_nacional')||($latabladesag[0]=='bdd_estadistica_parroquial')||($latabladesag[0]=='bdd_estadistica_provincial')||($latabladesag[0]=='bdd_estadistica_sector'))
	$middhostdatproy='localhost';
	$middbasedatproy='bdd_magactores';
}
//////////////////////////////////////////////////

 $cadenamiconex="host='".$middhostdatproy."' port=5432 dbname='".$middbasedatproy."' user=postgres password=postgres";
$conn = pg_connect( $cadenamiconex );


 $sql = "ALTER TABLE ".$_GET[mitabla]." drop COLUMN ".$_GET[nomcolumn]." ;";
$res = pg_query($conn, $sql);


echo "<script>document.location.href='../app_tipo_tabla.php?pontabla=".$_GET[laidapli]."'</script>";

?>