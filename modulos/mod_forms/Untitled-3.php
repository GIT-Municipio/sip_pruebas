<?php


$valor='Yo [NOMBRES] [APELLIDOS] organizador del evento de cédula de identidad [CEDULA] como organizador del evento, presento el Plan de Contingencia para Eventos de Concentración Masiva, para el"[EVENTO]" con un aforo promedio de 300 asistentes, a través de la presente me comprometo a ejecutar el plan de contingencia de evento de concentración masiva con el fin de precautelar la integridad de los asistentes y dar una respuesta inmediata frente a cualquier incidente o emergencia que se presente.

 

A la vez  declaro que la información consignada en el referido plan, es verdadera y podrá ser verificada por el Secretario Ejecutivo de Seguridad Ciudadana y Gestión de Riesgos del Municipio de Cotacachi. En el caso de falsedad u ocultamiento de información, nos sometemos a las penas que por estos hechos prevén las leyes de la Republica.

Firmas de Responsabilidad';


$reemplazartxt=str_replace("[CEDULA]","0401394747",$valor);
$reemplazartxt=str_replace("[NOMBRES]","fasuto",$reemplazartxt);
$reemplazartxt=str_replace("[APELLIDOS]","lucano",$reemplazartxt);

echo $valor."<br/>";
echo $reemplazartxt."<br/>";


?>