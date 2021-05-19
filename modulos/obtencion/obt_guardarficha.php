<?php
require_once('../../conexion.php');

echo "ver".$_REQUEST["param_cod_tipo_docum"]."frefe";

$var_est_oficina=0;
$var_est_general=0;
$var_est_pasivo=0;
$var_est_historico=0;
$var_est_digital=0;

if($_REQUEST["param_cod_tipo_docum"]=="")
$_REQUEST["param_cod_tipo_docum"]=0;

if($_REQUEST["doc_param_vigencia_anios"]=="")
$_REQUEST["doc_param_vigencia_anios"]=0;


if($_REQUEST["caret"]=="est_oficina")
$var_est_oficina=1;
else
if($_REQUEST["caret"]=="est_general")
$var_est_general=1;
else
if($_REQUEST["caret"]=="est_pasivo")
$var_est_pasivo=1;
else
if($_REQUEST["caret"]=="est_historico")
$var_est_historico=1;
else
if($_REQUEST["caret"]=="est_digital")
$var_est_digital=1;


$mivarnumtipodocumnasoc=0;
$sqlvertpodoc="select count(*) from dato_tipo_documento where nombre_clasif_documen='".$_REQUEST["param_tipo_documento"]."'";
$result=pg_query($conn, $sqlvertpodoc);
$versifexist=pg_fetch_result($result,0,0);
if($versifexist==0)
{
$sqlusauxdep="insert into dato_tipo_documento(nombre_clasif_documen) values('".$_REQUEST["param_tipo_documento"]."') ";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$sqlusauxdep="SELECT max(id) as codultim FROM dato_tipo_documento;";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$mivarnumtipodocumnasoc=pg_fetch_result($resultcodauc,0,'codultim');
}
else
{
$sqlusauxdep="SELECT id as codultim FROM dato_tipo_documento where nombre_clasif_documen='".$_REQUEST["param_tipo_documento"]."'";
$resultcodauc=pg_query($conn, $sqlusauxdep);
$mivarnumtipodocumnasoc=pg_fetch_result($resultcodauc,0,'codultim');
}

 $sqlus="UPDATE public.tbl_archivos_procesados   SET  doc_titulo='".$_REQUEST["doc_titulo"]."',param_cod_tipo_docum='".$mivarnumtipodocumnasoc."',param_tipo_documento='".$_REQUEST["param_tipo_documento"]."',doc_fecha_conserv_emision='".$_REQUEST["doc_fecha_conserv_emision"]."',doc_param_vigencia_anios='".$_REQUEST["doc_param_vigencia_anios"]."',doc_responsable_emision='".$_REQUEST["doc_responsable_emision"]."',doc_observacion='".$_REQUEST["doc_observacion"]."',est_oficina='".$var_est_oficina."',est_general='".$var_est_general."',est_pasivo='".$var_est_pasivo."',est_historico='".$var_est_historico."',est_digital='".$var_est_digital."',param_tipo_conservacion='".$_REQUEST["param_tipo_conservacion"]."'  WHERE id='".$_REQUEST["id"]."'";
$result=pg_query($conn, $sqlus);


		
?>