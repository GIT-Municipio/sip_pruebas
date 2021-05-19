<?php

//////ojo hay q descomentar    extension=php_soap.dll   de php.ini

    require_once "nusoap-0.9.5/lib/nusoap.php";
            
    $server = new soap_server();	
    $server->configureWSDL("consulciudadanodatxciu", "urn:consulciudadanodatxciu");
	
	$server->register('MetodoConsultaId',
   // array('miparam_id' => 'xsd:string','param_txt' => 'xsd:string'),
	array('miparam_id' => 'xsd:string'),
    array('return' => 'xsd:string'),
    'urn:consulciudadanodatxciu',
    'urn:consulciudadanodatxciu#MetodoConsultaId',
    'rpc',
    'encoded',
    'Retorna el datos'
	);
      
	  
   // function MetodoConsulta($param_id,$param_txt) {
      function MetodoConsultaId($miparametro) {

		$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.3.14)(PORT = 1521)))(CONNECT_DATA=(SID=CABILDO)))";
		$conn = oci_connect('CONSULTA','CONSULTA',$dbstr);

		$sql = "SELECT GEN01CODI,GEN01RUC,GEN01NOM,GEN01APE,GEN01COM,GEN01DIR,GEN01TELF,GEN01EMAIL,GEN01SEX,GEN01FNAC,GEN01DISCA FROM  GEN01 WHERE GEN01CODI='".$miparametro."'";
		


		$res = oci_parse($conn,$sql);
		oci_execute($res);
		$numerfilas = oci_fetch_all($res,$results);
		$numercampos = oci_num_fields($res);

		///////////////DESDE CUALQUIER CONSULTA DEBE VOTARNOS EL CIU ENTONCES
		$valorciufijo=$results["GEN01CODI"][0];
		$valorcedula=$results["GEN01RUC"][0]; 
		$valornombres=$results["GEN01NOM"][0]; 
		$valorapellids=$results["GEN01APE"][0]; 
		$valornomcompletos=$results["GEN01COM"][0]; 
		$valordireccion=$results["GEN01DIR"][0]; 
		$valortelefon=$results["GEN01TELF"][0]; 
		$valoremail=$results["GEN01EMAIL"][0];
		$valorsexo=$results["GEN01SEX"][0]; 
		$valorfechnacim=$results["GEN01FNAC"][0]; 
		$valordiscap=$results["GEN01DISCA"][0]; 
		
        

		 
		  return "CIU=".strtoupper($valorciufijo)."\n"."CEDULA=".strtoupper($valorcedula)."\n"."NOMBRES=".strtoupper($valornombres)."\n"."APELLIDOS=".strtoupper($valorapellids)."\n"."DIRECCION=".strtoupper($valordireccion)."\n"."TELEFONO=".strtoupper($valortelefon)."\n"."EMAIL=".strtolower($valoremail)."\n"."NOMBRESCOMP=".strtoupper($valornomcompletos)."\n"."SEXO=".strtoupper($valorsexo)."\n"."FECHANAC=".strtoupper($valorfechnacim)."\n"."DISCAPACIDAD=".strtoupper($valordiscap);
        
		

		// Cerrar la conexión 
		//mysql_close($link); 

}
	
	
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) 
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service                    
$server->service($POST_DATA);                
exit();
  
 //   $server->service($HTTP_RAW_POST_DATA);
	

//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
	//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : ";
	
?>