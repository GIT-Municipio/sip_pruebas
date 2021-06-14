<?php
/* libreria creada por Fausto Lucano*/
class mismetodos
{

var $cad_conexion;//cadena de conexion
var $Error;
//creo el constructor
function mismetodos($cone)
{
$this->cad_conexion=$cone;
}

//Consulta de la Base Datos
function Consultas($sql = "")
{
	if($sql == "")
	{
		$this->Error = "No se ha Realizado Ninguna Consulta";
		return 0;
	}
	
	$this->result = @pg_query($this->cad_conexion,$sql);
   ////////////////////////////////////////
	
	return $this->result;	
}

function actualizarinactivos($tabla,$micamp,$elvec)
{
   $numelementos = count($micamp); 
 
  //////////////ver exitencia
  $seleccionodato = "select * FROM $tabla WHERE ".$micamp[0]." = '".$elvec[0]."'";
 $resultaselec = @pg_query($this->cad_conexion,$seleccionodato);
 //////////////////////////////////
  
   
     $query = "UPDATE ".$tabla." SET ";
	 
	 for($i=1;$i<$numelementos;$i++)
	 {
	    if($i==$numelementos-1)
	      $query .= $micamp[$i]."='".$elvec[$i]."'"; 
	    else	
	      $query .= $micamp[$i]."='".$elvec[$i]."',"; 
	 }
	 
	echo $query .= " WHERE ".$micamp[0]."='".$elvec[0]."'";
	
	 
     $result = @pg_query($this->cad_conexion,$query);
	 
	  
 
     if ($result)
	 {
	  session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
    //if (session_is_registered("elusuarioadmin")) -----cambio por error funcion no disponible en php7
    if ($_SESSION["elusuarioadmin"] = "elusuarioadmin")
    {
   $elusuario=$_SESSION["elusuarioadmin"];
   
   
   	   $concatenarcad="";
		 for($i=0;$i<pg_num_fields($resultaselec);$i++)
		 {
		     $concatenarcad.=pg_fetch_result($resultaselec,0,$i).",";
		 } 
   
  echo $laauditoria="insert into auditoria(fecha,hora,usuario,tabla,dato,transaccion,cadenatrans) values(now(),now(),'$elusuario','$tabla','$elvec[0]','UPDATE','$concatenarcad')";
   
   $resultaudit = @pg_query($this->cad_conexion,$laauditoria);
    }
       return true;
	   }
     else
       return false;
  
 }//FIN DE METODO

//Numeros de Campos
function numcampos()
{
	//return pg_numfields($_pagi_result); ----funcion mal definida en el retorno no declarada
  return pg_numfields($this->result);
}
//Numero de Filas
function numregistros()
{
    return pg_num_rows($this->result);
}
//Nombre de los Campos
function nombrecampo($numcampo)
{
   return pg_field_name($this->result,$numcampo);
}


//Mostrar la Consulta
//Sin Paginar
function verconsulta($centrado,$title,$border,$centrar,$bordertabla,$bordertabla1)
{   
    echo "<$centrado>";
	echo "$title";
	echo "<table border=$border align=$centrar cellpadding=bordertabla cellspacing=bordetabla1>\n";
	
	// mostramos los nombres de los campos
	
	for ($i = 0; $i < $this->numcampos(); $i++){
	
	echo "<td><b>".$this->nombrecampo($i)."</b></td>\n";
	
	}
	
	echo "</tr>\n";
	
	// mostrarmos los registros
	
	while ($row = pg_fetch_row($this->result)) {
	
	echo "<tr> \n";
	
	for ($i = 0; $i < $this->numcampos(); $i++){
	
	echo "<td>".$row[$i]."</td>\n";
	
	}
	
	echo "</tr>\n";
	
	}
	echo "</$centrado>";
	
}

//Funcion Borrado De Un Registro
function borrado($tabla="",$campo,$dato)
{
 if($tabla == "")
 {
        $this->Error = "No se Elegio La Tabla";
        return 0;
 }
 if($dato == "")
 {
	 	$this->Error = "No se ha Encontrado el Registro";
		return 0;
 }
 
  $seleccionodato = "select * FROM $tabla WHERE $campo = '$dato'";
 $resultaselec = @pg_query($this->cad_conexion,$seleccionodato);

		 
 
  $Borrado = "DELETE FROM $tabla WHERE $campo = '$dato'";

 $this->result = @pg_query($this->cad_conexion,$Borrado);
 
  if($this->result)
 {
  session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
//if (session_is_registered("elusuarioadmin")) funcion no disponible en PHP 7
if ($_SESSION["elusuarioadmin"] = "elusuarioadmin")
{
//////////verificar dato
   $concatenarcad="";
		 for($i=0;$i<pg_num_fields($resultaselec);$i++)
		 {
		     $concatenarcad.=pg_fetch_result($resultaselec,0,$i).",";
		 }       

//////////
  echo $elusuario=$_SESSION["elusuarioadmin"];
  echo $laauditoria="insert into auditoria(fecha,hora,usuario,tabla,dato,transaccion,cadenatrans) values(now(),now(),'$elusuario','$tabla','$dato','DELETE','$concatenarcad')";
   
   $resultaudit = @pg_query($this->cad_conexion,$laauditoria);
 } 
 echo " ";
 }
 else
 {
 echo "No se ha borrado el registro";
 }
 
 return $this->result; 
 
}

//Funcion Agregar Nuevo Registro 
function Agregar($tabla ="",$campos="",$valores="")
{

  //echo $tabla," ",$campos," ",$valores;
  if($tabla == "")
  {
        $this->Error = "No se Elegio La Tabla";
        return 0;
  }
  
   $mirestsol= "INSERT INTO $tabla($campos) VALUES($valores)";
   $result = @pg_query($this->cad_conexion,$mirestsol);
   
  
// echo $this->result;
 //$this->Valor = @mysql_num_rows($this->result);
  //echo $this->Valor;
  if($result)
  {
   $solocampconsu="select * from $tabla";
   $verisol=@pg_query($this->cad_conexion,$solocampconsu);
   $nuevo=pg_num_rows($verisol);
   $nuevo=$nuevo-1;
   $vermio=pg_fetch_result($verisol,$nuevo,0);
//  
   session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
//if (session_is_registered("elusuarioadmin"))  funcion no disponible en php 7
if ($_SESSION["elusuarioadmin"] = "elusuarioadmin")
{
   $elusuario=$_SESSION["elusuarioadmin"];
   
   if($tabla!="tabla_cobro_predios")
         {
		 //////////tratamientos
		 	
		 $concatenarcad="";
		 //$mivectorins=split("'",$valores);   Spli no disponible en PHP 7
     $mivectorins=preg_split("'",$valores);
		 for($i=0;$i<count($mivectorins);$i++)
		 {
		   if($mivectorins[$i]!="'")
		     $concatenarcad.=$mivectorins[$i];
		 }
			 //////
 
      $laauditoria="insert into auditoria(fecha,hora,usuario,tabla,dato,transaccion,cadenatrans) values(now(),now(),'$elusuario','$tabla','$vermio','INSERT','".$concatenarcad."')";
   $resultaudit = @pg_query($this->cad_conexion,$laauditoria);  
         }
	} 
  // echo "Registro con exito";
  }else
  {

   echo "<center>El registro no de Inserto</center>";
  }
  
 
 return $result; 
  
	
}

//Funcion Actualizar Registro
 function Modificar($tabla,$micamp,$elvec){
   $numelementos = count($micamp); 
 
  //////////////ver exitencia
  $seleccionodato = "select * FROM $tabla WHERE ".$micamp[0]." = '".$elvec[0]."'";
 $resultaselec = @pg_query($this->cad_conexion,$seleccionodato);
 //////////////////////////////////
  
   
     $query = "UPDATE ".$tabla." SET ";
	 
	 for($i=1;$i<$numelementos;$i++)
	 {
	    if($i==$numelementos-1)
	      $query .= $micamp[$i]."='".$elvec[$i]."'"; 
	    else	
	      $query .= $micamp[$i]."='".$elvec[$i]."',"; 
	 }
	 
	 $query .= " WHERE ".$micamp[0]."='".$elvec[0]."'";
	
	 
     $result = @pg_query($this->cad_conexion,$query);
	 
	  
 
     if ($result)
	 {
	  session_start();
//-------------------------------
header("Refresh: 20");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 10; //20min.

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
    //if (session_is_registered("elusuarioadmin"))  funcion no disponible en PHP 7
    if ($_SESSION["elusuarioadmin"] = "elusuarioadmin")
    {
   $elusuario=$_SESSION["elusuarioadmin"];
   
   
   	   $concatenarcad="";
		 for($i=0;$i<pg_num_fields($resultaselec);$i++)
		 {
		     $concatenarcad.=pg_fetch_result($resultaselec,0,$i).",";
		 } 
   
  echo $laauditoria="insert into auditoria(fecha,hora,usuario,tabla,dato,transaccion,cadenatrans) values(now(),now(),'$elusuario','$tabla','$elvec[0]','UPDATE','$concatenarcad')";
   
   $resultaudit = @pg_query($this->cad_conexion,$laauditoria);
    }
       return true;
	   }
     else
       return false;
  
 }


}//fin de clase



?>
