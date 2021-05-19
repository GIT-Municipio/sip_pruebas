 <?php 
 function _char ($cadena)
		{
			$cadena_out =  utf8_encode(nl2br($cadena));	
			//$cadena_out =  nl2br($cadena);	
			return $cadena_out;
		};

class DB_mysql { 
		/* variables de conexión */ 
		var $BaseDatos; 
		var $Servidor; 
		var $Usuario; 
		var $Clave; 
		/* identificador de conexión y consulta */ 
		var $Conexion_ID = 0; 
		var $Consulta_ID = 0; 
		/* número de error y texto error */ 
		var $Errno = 0; 
		var $Error = ""; 
		/* Método Constructor: Cada vez que creemos una variable 
		de esta clase, se ejecutará esta función */ 
	    function DB_mysql($bd = "", $host = "", $user = "", $pass = "") { 
			$this->BaseDatos = $bd; 
			$this->Servidor = $host; 
			$this->Usuario = $user; 
			$this->Clave = $pass; 
		} 
			/*Conexión a la base de datos*/ 
		function conectar($bd, $host, $user, $pass){ 
			if ($bd != "") $this->BaseDatos = $bd; 
			if ($host != "") $this->Servidor = $host; 
			if ($user != "") $this->Usuario = $user; 
			if ($pass != "") $this->Clave = $pass; 
		  // Conectamos al servidor 
 		 	$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST =".$host.")(PORT = 1521)))(CONNECT_DATA=(SID=".$bd.")))";
		   $this->Conexion_ID = oci_connect($this->Usuario,$this->Clave,$db,'AL32UTF8'); 

 			if (!$this->Conexion_ID) { 
 				$this->Error = "Ha fallado la conexión."; 
 				return 0; 
			} 
			return $this->Conexion_ID; 
} 
//////////////////////////////////////////////////////////////////////////////////////////////
			/* Ejecuta un consulta */ 
			function consulta($sql = ""){ 
 			if ($sql == "") { 
				$this->Error = "No ha especificado una consulta SQL"; 
				return 0; 
			} 
			//ejecutamos la consulta 
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
 	        oci_execute($this->Consulta_ID, OCI_DEFAULT);
 
			if (!$this->Consulta_ID) { 
			//$this->Errno = mysql_errno(); 
			  $this->Error = oci_error(); 
			} 
			/* Si hemos tenido éxito en la consulta devuelve 
			el identificador de la conexión, sino devuelve 0 */ 
			return $this->Consulta_ID; 

			} 
		    /* Devuelve el número de campos de una consulta */ 
		    function numcampos() { 
					return oci_num_fields($this->Consulta_ID); 
			} 
			/* Devuelve el número de registros de una consulta */ 
			function numregistros(){ 
				return oci_num_rows($this->Consulta_ID); 
			
			} 
			/* Devuelve el nombre de un campo de una consulta */ 
			function nombrecampo($numcampo) { 
				 
				return oci_field_name($this->Consulta_ID, $numcampo + 1); 
			
			} 
			function _etiqueta($etiqueta,$with,$clase)
				{
				  $e1 = '<td class="'.$clase.'" width="'.$with.'">';
				   $e2 = '</td>';
				  $cabecera = $e1.$etiqueta.$e2;
				  echo $cabecera;
			 } 
			/* Muestra los datos de una consulta */ 
           // echo "<td><b>".$this->nombrecampo($i)."</b></td>\n"; 
		function query($edicion, $indice) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="4" >
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a href="'.$edicion.$indice.'='. $row[$indice].
					 				  '" target="_self"><img src="images/View.png" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 	 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = right;
							 }
							 else
							 {
								 $ali = left;
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 
		/* Muestra los datos de una consulta */ 
           // echo "<td><b>".$this->nombrecampo($i)."</b></td>\n"; 
		function query_view($edicion, $indice) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="3"  width="960" align="center" >
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a href="'.$edicion.$indice.'='. $row[$indice].
					 				  '" target="_self"><img src="images/View.png" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 	 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = right;
							 }
							 else
							 {
								 $ali = left;
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 		   
		   // devuelve los datos del areglo 
		   function _dato($CAMPO) { 
				   while (($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC))) {
							return  $row[$CAMPO] ;
 					}
    	   }
		   // devuelve los datos para busqueda de maestro detalle
		   function query_detalle($edicion, $detalle,$indice) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="4" >
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a href="'.$edicion.$indice.'='. $row[$indice].
					 				  '" target="ventana"><img src="../images/editar.gif" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
					
					 $imagen_detalle = '<a href="'.$detalle.$indice.'='. $row[$indice].
					 				  '" target="ventana"><img src="../images/detalle.jpg" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
									  	 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						 echo '  <td class="detalle_grid">' .$imagen_detalle . '</td>';
	  
					     foreach ($row as $item) {
							
							 						 
						     echo '  <td class="detalle_grid">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 
		   // casillero de texto
		   function _text( $variable,$with,$longitud,$class)
				{
				 
					//$variable1 = '<?php echo trim($row["'.$variable.'"]) ';
					//echo $variable1;
  			
					$validacion =  'onblur="'."MM_validateForm('".$variable ."','','R');".'return document.MM_returnValue"';
					
					$variable1 = '';
					$ctexto = '<input class="'.$class.
							  '" name="'.$variable.'"'.
							  ' type= "text" '.
							  '" id="'.$variable.'"'.
							  $validacion.
						      ' value= "'.
							  $variable1.'" size="'.
							  $longitud.'" maxlength="'.
							  $longitud.'" />'; 
					echo $ctexto;
					
					return 1;
				} 
			/// TEXTO CON DATO
			   function _text_dato( $variable,$with,$longitud,$class,$valor,$ready)
				{
				 
					//$variable1 = '<?php echo trim($row["'.$variable.'"]) ';
					//echo $variable1;
  			
					$validacion =  'onblur="'."MM_validateForm('".$variable ."','','R');".'return document.MM_returnValue"';
						$variable1 = $valor;
			
				if ($ready == 0) {	
					$ctexto = '<input class="'.$class.
							  '" name="'.$variable.'"'.
							  ' type= "text" '.
							  '" id="'.$variable.'"'.
							  $validacion.
						      ' value= "'.
							  $variable1.'" size="'.
							  $longitud.'" maxlength="'.
							  $longitud.'" />'; 
				}
				else{
				$ctexto = '<input class="'.$class.
							  '" name="'.$variable.'"'.
							  ' type= "text" '.
							  '" id="'.$variable.'"'.
							  $validacion.
						      ' value= "'.
							  $variable1.'" size="'.
							  $longitud.'" maxlength="'.
							  $longitud.'" readonly="readonly">';				
				}
							  
					echo $ctexto;
					
					return 1;
				} 	
		   function _textReadonly( $variable,$with,$longitud,$class)
				{
				 
					//$variable1 = '<?php echo trim($row["'.$variable.'"]) ';
					//echo $variable1;
					$variable1 = '';
					$ctexto = '<input class="'.$class.'" name="'.$variable.'"'.
							  ' type="text" '.' value= "'.
							  $variable1.'" size="'.
							  $longitud.'" maxlength="'.
							  $longitud.'" readonly="readonly">';
					echo $ctexto;
					
					return 1;
				} 
 			// prepara insertar
			/* Ejecuta un consulta */ 
			function prepara_insertar($sql = ""){ 
 			if ($sql == "") { 
				$this->Error = "No ha especificado una consulta SQL"; 
				return 0; 
			} 
			//ejecutamos que prepare la insercion 
			 
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
			if (!$this->Consulta_ID) { 
			//$this->Errno = mysql_errno(); 
			  $this->Error = oci_error(); 
			} 
			/* Si hemos tenido éxito en la consulta devuelve 
			el identificador de la conexión, sino devuelve 0 */ 
			return $this->Consulta_ID; 

			} 
 
		  function inserta($stid) {
			$r = oci_execute($stid);
		  
			
			if (!$r) {
				  $e = oci_error($stid); // For oci_execute errors pass the statementhandle
				  return 0;
			} 
			else {
				oci_free_statement($stid);
				oci_close($this->Conexion_ID);
				return 1;
			 }
					return 0;		
		 }		
		 // entrega secuencia con variable de secuencia 
		 function _secuencia($nombre_secuencia) {
			 
			$sql = "select ".$nombre_secuencia.".nextval as x1 from dual ";
			
			 if ($sql == "") { 
				$this->Error = "No ha especificado una consulta SQL"; 
				return 0; 
			} 
			//ejecutamos la consulta 
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
 	        oci_execute($this->Consulta_ID, OCI_DEFAULT);
			
			while (($row = oci_fetch_array ($this->Consulta_ID, OCI_ASSOC))) { // Ignore NULLs
				          foreach ($row as $item) {
					         $secuencia_re = $item;
				          }
				}

			return $secuencia_re ;
	 }
	 // fecha del servidor
	function _fecha( ) {
			 
			$sql = "select sysdate  from dual ";
	 			//ejecutamos la consulta 
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
 	        oci_execute($this->Consulta_ID, OCI_DEFAULT);
			while (($row = oci_fetch_array($this->Consulta_ID , OCI_BOTH))) {
				  $val = $row[0];
			}
			return $val ;
	 }
	 // usuario activo del servidor
	function _usuario( ) {
			$sql = "SELECT SEG03COM FROM ST_SEG03 where SEG03CODI = '". strtoupper($this->Usuario)."'" ;
	 			//ejecutamos la consulta 
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
 	        oci_execute($this->Consulta_ID, OCI_DEFAULT);
			
			while (($row = oci_fetch_array($this->Consulta_ID , OCI_BOTH))) {
				  $val = $row[0];
			}
			return $val ;
	 }	 	 	 
	 // valida campos
	 function _valida_fields($a,$b,$c,$d,$e,$f) {
		 $bandera_ingreso = 1;	 
		 if ( trim($a) ==  "")  {
				$bandera_ingreso = 0;			
			}	
		 if ( trim($b) ==  "")  {
				$bandera_ingreso = 0;				
			}	
		 if ( trim($c) ==  "")  {
				$bandera_ingreso = 0;			
			}	
		 if ( trim($d) ==  "")  {
				$bandera_ingreso = 0;			
			}	
		 if ( trim($e) ==  "")  {
				$bandera_ingreso = 0;			
			}	
		 if ( trim($f) ==  "")  {
				$bandera_ingreso = 0;			
			}	
		return 	$bandera_ingreso;
	  }	
	  // RETORNA TIPO DE VARA
	  function sqlstr($val)
		{
		  return str_replace("'", "''", $val);
		}
	  // combo texto fijo 
	  function _combof($variable,$avalor,$atitulo,$count,$clase)
		{
		    $cobjeto = '<select name="'.$variable.'"class="'.$clase.'" id="'.$variable.'">';
			$cvalor = '';
 			for ($i = 0; $i < $count; $i++) {
				$cvalor =  '<option value="'.$avalor[$i].'">'.$atitulo[$i].'</option>'.$cvalor ;
  			}
	    	$cobjeto1 = '</select>';
 
			echo $cobjeto.$cvalor.$cobjeto1;
		  return 1;
		}
	  // combo texto con sql 
	  function _combosql($variable,$sql,$clase)
		{
		    $cobjeto = '<select name="'.$variable.'"class="'.$clase.'" id="'.$variable.'">';
			$cvalor = '';
			$this->Consulta_ID = oci_parse($this->Conexion_ID, $sql  );
			
 	        oci_execute($this->Consulta_ID, OCI_DEFAULT); 
	    	
			while (($row = oci_fetch_array($this->Consulta_ID , OCI_BOTH))) {
				  $val = htmlentities($row[0]);
                  $caption = htmlentities($row[1]);
				
				  if ($row[0] == $val) {
					  $selstr = " selected"; 
				  } 
				 else 
				 {
					 $selstr = ""; 
				 }
                  $cvalor = '<option value="'.$val.'"'.$selstr.'>'.$caption.'</option>'. $cvalor;
 
		    }
 
			$cobjeto1 = '</select>';
 
			echo $cobjeto.$cvalor.$cobjeto1;
           return 1;
		  
		}
	  /// retorna el valor 
	  function sqlvalue($val, $quote)
		{
		  if ($quote)
			$tmp = $this->sqlstr($val);
		  else
			$tmp = $val;
		  if ($tmp == "")
			$tmp = "NULL";
		  elseif ($quote)
			$tmp = "'".$tmp."'";
		  return $tmp;
		}
	//generacion de checkbox	
	function check($name,$var)
    {
     
     echo "<input type='checkbox' name=".$name."  value =".$var." >";

    }	
	
	//Maestro deralle
	function detalle_maestro()
	{
		
		$row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS);
		foreach ($row as $item) {
	echo '  <td class="detalle_grid">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
	}
	
	//Maestro deralle con font
	function detalle_maestro_font($size,$color,$font)
	{
		
		$row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS);
		foreach ($row as $item) {
	echo '  <td class="detalle_grid"><strong><font size='.$size.' color='.$color.' face='.$font.'>' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</font></strong></td>';
				          }
	}
	function detalle_maestro_dato($size,$color,$font)
	{
		
		$row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS);
		foreach ($row as $item) {
			echo  ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") ;
				          }
	}	
    // Insertar un textbox escondido

   function _text_hide( $variable,$with,$longitud,$class,$valor,$ready)
				{
		$validacion =  'onblur="'."MM_validateForm('".$variable ."','','R');".'return document.MM_returnValue"';
		$variable1 = $valor;
			
	$ctexto = '<input class="'.$class.
							  '" name="'.$variable.'"'.
							  ' type= "hidden" '.
							  '" id="'.$variable.'"'.
							  $validacion.
						      ' value= "'.
							  $variable1.'" size="'.
							  $longitud.'" maxlength="'.
							  $longitud.'" readonly="readonly">';	
							  echo $ctexto;			
				}
				
		
	//Validar ingreso de busqueda con Like
		function sqlvaluel($val, $quote)
		{
		  if ($quote)
			$tmp = str_replace('', "", $val);
		  else
		   $tmp = $val;
		  if ($tmp == "")
		   $tmp = "NULL";
		  if ($quote)
			$tmp = "'%".$tmp."%'";
		 return $tmp;
		 
		}
		
	//Lista en ventana emergente (Popup)
	function query_detalle_Popup($edicion, $detalle,$indice,$indice1,$indice2,$indice3,$pag) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="4" >
				       <tr>'; 
					   // para edicion, aprobacion
					   
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
						  
					     foreach ($row as $item) {
							
							 						 
						     echo ' <td class="detalle_grid"> <a href="'.$pag.$indice.'='.$row[$indice].'" onclick=" javascript:bak('.$this->sqlvalue($row[$indice],true).','.$this->sqlvalue($row[$indice1],true).','.$this->sqlvalue($row[$indice2],true).','.$this->sqlvalue($row[$indice3],true).')">'. ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") .' </a></td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 	
//query con popup simple
		
			function query_popup($pagina, $indice, $target) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="4" >
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a href=javascript:windowo("'.$pagina.'var='.$row[$indice].'") ><img src="images/View.png" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 
							 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = right;
							 }
							 else
							 {
								 $ali = left;
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 
		   
		//query con popup simple
		
			function query_popup_tamaño($pagina, $indice, $target) { 
				 
				echo ' <table border="0" cellspacing="1" cellpadding="2" width="960" align="center" >
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a href=javascript:windowo("'.$pagina.'var='.$row[$indice].'") ><img src="images/View.png" alt="editar" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 
							 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = right;
							 }
							 else
							 {
								 $ali = left;
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 
		   
		   
		   //Consulta sin ningun enlace
		   
		   function query_s() {
		
				echo ' <table border="0" cellspacing="1" cellpadding="4"  align="center">
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a> <img src="images/vineta1.png" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 
							 	 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = 'right';
							 }
							 else
							 {
								 $ali = 'left';
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           } 
		   
		   
		   
		   function query_i() {
		
				echo ' <table border="0" cellspacing="1" cellpadding="4"  align="left">
				       <tr>'; 
					   // para edicion, aprobacion
					   $this->_etiqueta('','','cabecera_grid'); 
					   
					// mostramos los nombres de los campos 
					for ($i = 0; $i < $this->numcampos(); $i++){ 
					   $this->_etiqueta($this->nombrecampo($i),'','cabecera_grid');
					} 
					echo "</tr>"; 
				// mostrarmos los registros 
			       echo '<tr>';
				   while ($row = oci_fetch_array($this->Consulta_ID, OCI_ASSOC + OCI_RETURN_NULLS)) {
					 $imagen_editar = '<a> <img src="images/vineta1.png" width="16" height="16" border="0" 			     
									  align="absmiddle" /></a>';
						 
						 echo '  <td class="detalle_grid">' .$imagen_editar . '</td>';
						// echo $row['IDMARCA'] . "<br>\n";
	  
					     foreach ($row as $item) {
							 
							 	 $item = str_replace(",",".",$item);
							 
							if (is_numeric($item))
							 {
								 $ali = 'right';
							 }
							 else
							 {
								 $ali = 'left';
							 }
						     echo '  <td class="detalle_grid" align="'.$ali.'">' . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . '</td>';
				          }
				          print "</tr>";
			       }
 				
			
           }
		   
		   function xml_user()
{		
	
  $xml = simplexml_load_file("data.xml");

$datos = array();
$i = 0;
foreach($xml->children() as $child)
  {

  $datos[$i] = $child;
  $i++;
  }
  
  return $datos[0];
}

function xml_psw()
{		
	
  $xml = simplexml_load_file("data.xml");

$datos = array();
$i = 0;
foreach($xml->children() as $child)
  {

  $datos[$i] = $child;
  $i++;
  }
  
  return $datos[1];
}

function xml_base()
{		
	
  $xml = simplexml_load_file("data.xml");

$datos = array();
$i = 0;
foreach($xml->children() as $child)
  {

  $datos[$i] = $child;
  $i++;
  }
  
  return $datos[2];
} 

function xml_ip()
{		
	
  $xml = simplexml_load_file("data.xml");

$datos = array();
$i = 0;
foreach($xml->children() as $child)
  {

  $datos[$i] = $child;
  $i++;
  }
  
  return $datos[3];
} 
		   
function palabras($cadena)
{
$malas = array("PUTA","CHUCHA","VERGA","MARICON","PUTO","CULO","PERRA","MARICA","TONTO","PENE","POLLA","HUEVOS");	
$cadena = str_replace($malas,"****",$cadena);
return $cadena;	
}	
		
} //fin de la Clse DB_mysql 

?> 

