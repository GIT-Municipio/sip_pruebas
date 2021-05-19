<!DOCTYPE html>
<html>
<head>
	<title>Aplicaciones</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../../componentes/codebase/dhtmlx.css"/>
	<script src="../../componentes/codebase/dhtmlx.js"></script>
   
</head>
<body>

<table width="671" border="0" align="center">
  <tr>
    <td colspan="2">
    
    
    </td>
  </tr>
  <tr>
    <td width="385"><table width="281" border="0" align="center">
      <tr>
        <td width="275"><fieldset style="border: solid 1px #a4bed4; text-align: center;">
          <legend style="color: #8699c1"><font face="Tahoma, Geneva, sans-serif" size="2">Crear Nueva Tabla en Blanco</font></legend>
          <p>&nbsp;</p>
          <form name="form1" method="post" action="guarda_tablablanca.php">
          <table width="286" border="0">
              
              
              <tr>
                <td width="132">Nombre Tabla:</td>
                <td width="144"><input name="txtnomtabla" type="text" id="txtnomtabla" value="<?php echo $_GET["valuenomtabl"]; ?>" placeholder="Escriba nombre de tabla"></td>
              </tr>
              <tr>
                <td>Nro Columnas:</td>
                <td><input name="txtnumcolumnas" type="number" id="txtnumcolumnas" value="5"></td>
                </tr>
              <tr>
                <td>Nro Filas:</td>
                <td><input name="txtnumfilas" type="number" id="txtnumfilas" value="5"></td>
                </tr>
              <tr>
                <td colspan="2"><input name="txtcodigplant" type="hidden" id="txtcodigplant" value="<?php echo $_GET["varidplatycmps"]; ?>" >
                  <input name="txtcodigcampo" type="hidden" id="txtcodigcampo" value="<?php echo $_GET["varidenvcmp"]; ?>" ></td>
                </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="btncreartabla" id="btncreartabla" style="background-image:url(../../imagenes/encabezatabls.png); height:32px; border-color:#a4bed4" value=" >>>  Crear TABLA <<<"></td>
                </tr>
              </table>
            </form>
          
  <p>&nbsp;</p>
          </fieldset></td>
        </tr>
    </table></td>
  </tr>
</table>

<form id="realForm" method="POST" enctype="multipart/form-data"  >
<table width="415" border="0" align="center">
  
  <tr>
    <td><div id="myFormdos" align="left"></div></td>
  </tr>
</table>
</form>

 <div id="simpleLog"></div>
</body>
</html>
