<?php
require_once('../../conexion.php');

session_start();
$mensaje="";

   
	//$sqluscont="SELECT count(*) FROM public.tbl_grupo_archivos where  grup_nombre='".$_REQUEST["grup_nombre"]."';";
	//$resulcontt=pg_query($conn, $sqluscont);
	//$verfiexist=pg_fetch_result($resulcontt,0,0);
	$verfiexist=0;
	if($verfiexist == 0)
	{	
	    $darnombregruppo="";
        /////////////creacion automatica del grupo de trabajo o caja
		$sqlusauxdep="SELECT codigo_unif FROM data_departamento_direccion where  id='".$_REQUEST["gparam_departamento"]."';";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
		////////////selecciono codigo deparatmaento
		$vafcodidepart=pg_fetch_result($resultcodauc,0,0);
		
		/////////////////////////////////////////////////////////////////////
		////////////////////////INGRESO DE CATEGORIA///////////////////////
		/////////////////////////////////////////////////////////////////////
		
		$sqlusauxdep="SELECT count(*) as numcontcat FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_categoria"]."';";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
		$varcontarcatexis=pg_fetch_result($resultcodauc,0,0);
		$vafcodicatego=0;
		if($varcontarcatexis==0)
		{
		$sqlusauxdep="INSERT INTO public.dato_categoria(nombre, ref_departamento)  VALUES ('".$_REQUEST["gparam_nom_categoria"]."', '".$_REQUEST["gparam_departamento"]."');";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
        //////////selecciono categoria
		$sqlusauxdep="SELECT id FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_categoria"]."';";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
		$vafcodicatego=pg_fetch_result($resultcodauc,0,0);
			
		}
		else
		{
			 //////////selecciono categoria
		   $sqlusauxdep="SELECT id FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_categoria"]."';";
		   $resultcodauc=pg_query($conn, $sqlusauxdep);
		   $vafcodicatego=pg_fetch_result($resultcodauc,0,0);
		}
		
		/////////////////////////////////////////////////////////////////////
		////////////////////////FIN INGRESO DE CATEGORIA///////////////////////
		/////////////////////////////////////////////////////////////////////
		
		
		/////////////////////////////////////////////////////////////////////
		////////////////////////INGRESO DE SUB-CATEGORIA///////////////////////
		/////////////////////////////////////////////////////////////////////
		 if($_REQUEST["gparam_nom_subcategoria"]!="")
   {
		$sqlusauxdepcat="SELECT count(*) as numcontcat FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_subcategoria"]."';";
		$resultcodaucsub=pg_query($conn, $sqlusauxdepcat);
		$varcontarcatexispreg=pg_fetch_result($resultcodaucsub,0,0);
		$vafcodisubcatego=0;
		if($varcontarcatexispreg==0)
		{
		$sqlusauxdep="INSERT INTO public.dato_categoria(nombre, ref_departamento,parent_id)  VALUES ('".$_REQUEST["gparam_nom_subcategoria"]."', '".$_REQUEST["gparam_departamento"]."','".$vafcodicatego."');";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
        //////////selecciono categoria
		$sqlusauxdep="SELECT id FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_subcategoria"]."';";
		$resultcodauc=pg_query($conn, $sqlusauxdep);
		$vafcodisubcatego=pg_fetch_result($resultcodauc,0,0);
			
		}
		else
		{
			 //////////selecciono categoria
		   $sqlusauxdep="SELECT id FROM dato_categoria where  nombre='".$_REQUEST["gparam_nom_subcategoria"]."';";
		   $resultcodauc=pg_query($conn, $sqlusauxdep);
		   $vafcodisubcatego=pg_fetch_result($resultcodauc,0,0);
		}
	}
		/////////////////////////////////////////////////////////////////////
		////////////////////////FIN INGRESO DE SUB-CATEGORIA///////////////////////
		/////////////////////////////////////////////////////////////////////
		
		/*
		////////////////nombre inicial
		$darnombregruppo="GRUPO_B".$_REQUEST["gparam_bodega"]."E".$_REQUEST["gparam_estanteria"]."N".$_REQUEST["gparam_nivel"]."_";
		////////////////////////////////
		$darmecodginumbergrop=1;
		////////////
		 $sqlusauxdep="SELECT count(*) FROM tbl_grupo_archivos where  grup_codigointer='".$darnombregruppo."';";
		 $resultcodauc=pg_query($conn, $sqlusauxdep);
		 $vafcodcontar=pg_fetch_result($resultcodauc,0,0);
		 if($vafcodcontar==0)
		 {
			$darmecodginumbergrop=1; 
		 }
		else
		{
			$sqlusauxdep="SELECT max(grup_codigointerorden) FROM tbl_grupo_archivos where  grup_codigointer='".$darnombregruppo."';";
		 $resultcodauc=pg_query($conn, $sqlusauxdep);
		 $vafcodcontar=pg_fetch_result($resultcodauc,0,0);
		 $darmecodginumbergrop=$vafcodcontar+1; 
		 }
		*/	
		
		
		
		///////////////////////////////////////////////////////////////////////////	
////////////////////////// INSERCION PROCESO    ///////////////////////////
///////////////////////////////////////////////////////////////////////////
/*echo $sqlusauxdep="SELECT count(*) as numcontcat FROM tbl_archivos_procesados where  id='".$_SESSION["varestaticmyid"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$varverexisdtid=pg_fetch_result($resultcodauc,0,0);
if($varverexisdtid==0)
{
	*/

 $sqlaucre="SELECT count(*) as numcontproces FROM tbl_archivos_procesados where  descripcion='".$_REQUEST["gparam_nom_categoria"]."'  and grupo_codbarras_tramite='".$_SESSION["varses_grup_codigo"]."' and cod_iden_grupo=2;";
$resulaucre=pg_query($conn, $sqlaucre);
 $varcontnumprocsx=pg_fetch_result($resulaucre,0,'numcontproces');
$varetoridgrupi=0;
if($varcontnumprocsx==0)
{
//////consultar grupo
 $sqlusauxgrup="SELECT id as codultim FROM tbl_archivos_procesados where  descripcion='".$_SESSION['varses_grup_nombregrup']."'  and grupo_codbarras_tramite='".$_SESSION["varses_grup_codigo"]."' and cod_iden_grupo=1;";
$resultcodgrup=pg_query($conn, $sqlusauxgrup);
$varetoridgrupi=pg_fetch_result($resultcodgrup,0,'codultim');
		
////////////////INGRESO LA CATEGORIA
$sqlanexgrupi = "insert into tbl_archivos_procesados(grupo_codbarras_tramite,  descripcion, cod_iden_grupo,ultimonivel,usu_respons_edit,parent_id,param_departamento, param_bodega, param_estanteria, param_nivel ,param_grupo ) values('".$_SESSION["varses_grup_codigo"]."', '".$_REQUEST["gparam_nom_categoria"]."', '2', 'false','".$_SESSION["vermientuscedula"]."','".$varetoridgrupi."','".$_SESSION["varses_grup_departid"]."','".$_SESSION["varses_grup_bodega"]."','".$_SESSION["varses_grup_estanteria"]."','".$_SESSION["varses_grup_nivel"]."','".$_SESSION['varses_grup_nombregrup']."')";
$resulgrupi = pg_query($conn, $sqlanexgrupi);

$sqlusauxdepgrpi="SELECT max(id) as codultim FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodaucgrpi=pg_query($conn, $sqlusauxdepgrpi);
$varetoridgrupi=pg_fetch_result($resultcodaucgrpi,0,'codultim');
}
else
{
$sqlusauxgrup="SELECT id as codultim FROM tbl_archivos_procesados where  descripcion='".$_REQUEST["gparam_nom_categoria"]."'  and grupo_codbarras_tramite='".$_SESSION["varses_grup_codigo"]."' and cod_iden_grupo=2;";
$resultcodgrup=pg_query($conn, $sqlusauxgrup);
$varetoridgrupi=pg_fetch_result($resultcodgrup,0,'codultim');
}

	
	
 $sqlanex = "INSERT INTO tbl_archivos_procesados(grupo_codbarras_tramite,usu_respons_edit,param_departamento, param_cod_categoria, param_categoria,  param_bodega, param_estanteria,param_nivel,doc_url_info,doc_tipo_info,param_cod_subcategoria,param_subcategoria,parent_id,ultimonivel,descripcion,cod_iden_grupo,param_grupo)  VALUES ('".$_SESSION["varses_grup_codigo"]."','".$_SESSION["vermientuscedula"]."','".$_SESSION["varses_grup_departid"]."','".$vafcodicatego."','".$_REQUEST["gparam_nom_categoria"]."','".$_SESSION["varses_grup_bodega"]."','".$_SESSION["varses_grup_estanteria"]."','".$_SESSION["varses_grup_nivel"]."','','jpg','".$vafcodisubcatego."','".$_REQUEST["gparam_nom_subcategoria"]."','".$varetoridgrupi."','true','".$_REQUEST["gparam_nom_subcategoria"]."',0,'".$_SESSION['varses_grup_nombregrup']."');";
$resulverifax = pg_query($conn, $sqlanex);

$sqlusauxdep="SELECT max(id) as codultim FROM tbl_archivos_procesados where  usu_respons_edit='".$_SESSION["vermientuscedula"]."';";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$_SESSION["varestaticmyid"]=pg_fetch_result($resultcodauc,0,'codultim');
//}	
///////////////////////////////////////////////////////////////////////////	
////////////////////////// INSERCION PROCESO    ///////////////////////////
///////////////////////////////////////////////////////////////////////////


		$codigofinaldegrupscaja=$_SESSION['varses_grup_nombregrup'];//$darnombregruppo.$darmecodginumbergrop;
         
    

     
	 $sqlus="update tbl_grupo_archivos set gparam_lista_categorias=gparam_lista_categorias ||'\n'||'-> ".$_REQUEST["gparam_nom_categoria"]."' where grup_nombre='".$codigofinaldegrupscaja."'";
	//	 $sqlus="INSERT INTO public.tbl_grupo_archivos(grup_nombre,grup_codigointer,grup_codigointerorden,  gparam_departamento, gparam_cod_categoria,gparam_nom_categoria, gparam_bodega, gparam_estanteria, gparam_nivel,gterminal_usu) VALUES ('".$codigofinaldegrupscaja."','".$darnombregruppo."','".$darmecodginumbergrop."','".$_REQUEST["gparam_departamento"]."','".$vafcodicatego."','".$_REQUEST["gparam_nom_categoria"]."','".$_REQUEST["gparam_bodega"]."','".$_REQUEST["gparam_estanteria"]."','".$_REQUEST["gparam_nivel"]."','".$_REQUEST["gterminal_usu"]."') ";
		$result=pg_query($conn, $sqlus);
		
		
		///////////////////////seleccionar departamento
		$sqlus="SELECT grup_cod_barras,gparam_lista_categorias FROM tbl_grupo_archivos where  grup_nombre='".$codigofinaldegrupscaja."';";
		$result=pg_query($conn, $sqlus);
		$_SESSION['varses_grup_codigo']=pg_fetch_result($result,0,0);
		$_SESSION['varses_grup_milistacategs']=pg_fetch_result($result,0,1);
		$_SESSION['varses_grup_nombregrup']=$codigofinaldegrupscaja;
		///////////////////////seleccionar departamento
		$sqlus="SELECT nombre_departamento FROM data_departamento_direccion where  id='".$_REQUEST["gparam_departamento"]."';";
		$result=pg_query($conn, $sqlus);
		$_SESSION['varses_grup_depart']=pg_fetch_result($result,0,0);
		$_SESSION['varses_grup_departid']=$_REQUEST["gparam_departamento"];
		///////////////////////seleccionar departamento
		$sqlus="SELECT nombre FROM dato_categoria where  id='".$vafcodicatego."';";
		$result=pg_query($conn, $sqlus);
		$_SESSION['varses_grup_categ']=pg_fetch_result($result,0,0);
		$_SESSION['varses_grup_categid']=$vafcodicatego;
		$_SESSION['varses_grup_categnom']=$_REQUEST["gparam_nom_categoria"];
		///////////////////////////////////////////////
		//////////////////////////////subcategoria
		$_SESSION['varses_grup_subcategid']=$vafcodisubcatego;
		$_SESSION['varses_grup_subcategnom']=$_REQUEST["gparam_nom_subcategoria"];
		/////////////////////////////////////////////////////////////////////////////
		$_SESSION['varses_grup_bodega']=$_SESSION['varses_grup_bodega'];
		$_SESSION['varses_grup_estanteria']=$_SESSION['varses_grup_estanteria'];
		$_SESSION['varses_grup_nivel']=$_SESSION['varses_grup_nivel'];

		$_SESSION['varses_grup_avisogrupo']="Grupo Activo: ".$codigofinaldegrupscaja;
		
		//////--------------------CODIGOS QR
	include('phpqrcode/qrlib.php'); 

	$content = "NOMBRE: ".$codigofinaldegrupscaja."\n DEPARTAMENTO: ".$_REQUEST["gparam_departamento"]."\n CATEGORIAS: ".$_SESSION['varses_grup_milistacategs']."\n BODEGA: ".$_SESSION['varses_grup_nivel'];

	QRcode::png($content,"imgqrs/".$_SESSION['varses_grup_codigo']."_qr.png",QR_ECLEVEL_L,10,2);
	$imgcodigo_qr = "imgqrs/".$_SESSION['varses_grup_codigo']."_qr.png";
//////--------------------CODIGOS QR
	$sqlupfre="UPDATE public.tbl_grupo_archivos SET grup_cod_qr='".$imgcodigo_qr."' "." WHERE grup_nombre='".$codigofinaldegrupscaja."';";
	$res = pg_query($conn, $sqlupfre) or die(pg_last_error());
///////////////////////////////////////////////////////FIN CODIGOS QR
////almaceno en una vriable
		$_SESSION['varses_grup_codigogenqrusu']=$imgcodigo_qr;
		
		echo $mensaje="ok#".$codigofinaldegrupscaja."#".$_SESSION['varses_grup_categ'];
	}


?>