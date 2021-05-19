<?php
require_once('../../conexion.php');
include('phpqrcode/qrlib.php');
/*
//////////////////////////////////////GENERAR QR POR GRUPO///////////////////////////////////////////////////
$sqlupgrup="SELECT grup_cod_barras,  grup_nombre, dep.nombre_departamento, gparam_bodega, gparam_estanteria, gparam_nivel FROM public.tbl_grupo_archivos grup, data_departamento_direccion dep where grup.gparam_departamento=dep.id order by grup.id;";
	$resgroup = pg_query($conn, $sqlupgrup) or die(pg_last_error()); 

 for($i=0;$i<pg_num_rows($resgroup);$i++)
 {
	//////--------------------CODIGOS QR
 
	 $content = "CODIGO: ".pg_fetch_result($resgroup,$i,"grup_cod_barras")."\n GRUPO: ".pg_fetch_result($resgroup,$i,"grup_nombre")."\n DEPARTAMENTO: ".pg_fetch_result($resgroup,$i,"nombre_departamento")."\n BODEGA: ".pg_fetch_result($resgroup,$i,"gparam_bodega")."\n ESTANTERIA: ".pg_fetch_result($resgroup,$i,"gparam_estanteria")."\n NIVEL: ".pg_fetch_result($resgroup,$i,"gparam_nivel");

QRcode::png($content,"imgqrs/".pg_fetch_result($resgroup,$i,"grup_cod_barras")."_grup_qr.png",QR_ECLEVEL_L,10,2);
$imgcodigo_qr = "imgqrs/".pg_fetch_result($resgroup,$i,"grup_cod_barras")."_grup_qr.png";
     //////--------------------ACTUALIZACION
	$sqlupfre="UPDATE public.tbl_grupo_archivos SET grup_cod_qr='".$imgcodigo_qr."' "." WHERE grup_cod_barras='".pg_fetch_result($resgroup,$i,"grup_cod_barras")."';";
	$res = pg_query($conn, $sqlupfre);

 }
////////////////////////////////////////////////////////////////////////////////////////
*/
//////////////////////////////////////GENERAR QR POR GRUPO COMPLETO///////////////////////////////////////////
$sqlupgrup="SELECT grup_cod_barras,  grup_nombre, dep.nombre_departamento, gparam_bodega, gparam_estanteria, gparam_nivel, gparam_nom_categoria FROM public.tbl_grupo_archivos grup, data_departamento_direccion dep where grup.gparam_departamento=dep.id order by grup.id;";
	$resgroup = pg_query($conn, $sqlupgrup) or die(pg_last_error()); 

 for($i=0;$i<pg_num_rows($resgroup);$i++)
 {
	 $sqlupcategroris="SELECT  param_subcategoria  FROM public.tbl_archivos_procesados where  grupo_codbarras_tramite='".pg_fetch_result($resgroup,$i,"grup_cod_barras")."' and est_eliminado=0 and est_elimin_defin=0;";
	 $rescategs = pg_query($conn, $sqlupcategroris);
	 $lassubcategorias="";
	 	for($im=0;$im<pg_num_rows($rescategs);$im++)
       {
		   $lassubcategorias=$lassubcategorias."\n".pg_fetch_result($rescategs,$im,"param_subcategoria");
	   }
	//////--------------------CODIGOS QR
	 $content = "CODIGO: ".pg_fetch_result($resgroup,$i,"grup_cod_barras")."\n GRUPO: ".pg_fetch_result($resgroup,$i,"grup_nombre")."\n DEPARTAMENTO: ".pg_fetch_result($resgroup,$i,"nombre_departamento")."\n BODEGA: ".pg_fetch_result($resgroup,$i,"gparam_bodega")."\n ESTANTERIA: ".pg_fetch_result($resgroup,$i,"gparam_estanteria")."\n NIVEL: ".pg_fetch_result($resgroup,$i,"gparam_nivel")."\n CATEGORIA: ".pg_fetch_result($resgroup,$i,"gparam_nom_categoria")."\n SUBCATEGORIA: ".$lassubcategorias;

	QRcode::png($content,"imgqrs/".pg_fetch_result($resgroup,$i,"grup_cod_barras")."_comp_qr.png",QR_ECLEVEL_L,10,2);
	$imgcodigo_qr = "imgqrs/".pg_fetch_result($resgroup,$i,"grup_cod_barras")."_comp_qr.png";
     //////--------------------ACTUALIZACION
	$sqlupfre="UPDATE public.tbl_grupo_archivos SET grup_descripcionqr='".$imgcodigo_qr."' "." WHERE grup_cod_barras='".pg_fetch_result($resgroup,$i,"grup_cod_barras")."';";
	$res = pg_query($conn, $sqlupfre);
	

 }
////////////////////////////////////////////////////////////////////////////////////////


 
?>