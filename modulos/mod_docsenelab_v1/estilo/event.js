// JavaScript Document



function abreventanatablagrafaux(pagina)
	{
	var miPopupmapaobjtabauxgrf;
	miPopupmapaobjtabauxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopupmapaobjtabauxgrf.focus();
	}
	
	function abrevenimpresion(pagina)
	{
	var miPopimpresionxgrf;
	miPopimpresionxgrf = window.open(pagina,"mostrarmapawindgrafaux","width=700,height=420,scrollbars=no,left=400");
	miPopimpresionxgrf.focus();
	}
	
	function abrevenuevafecha(lafechdfre)
	{
		//alert(lafechdfre);
	   document.location.href="index.php?envnfilfecha="+lafechdfre;
	}
	
	
	
	
	function crearnuevasfilas()
	{
		
	var varfils = prompt("Ingrese el Numero de filas", "1");

		if (varfils != null) {
             document.location.href="crearfilasdat.php?envnfil="+varfils;
		}

	}
	
	function crearnuevasfilasmemos()
	{
		
	var varfils = prompt("Ingrese el Numero de filas", "1");

		if (varfils != null) {
             document.location.href="crearfilasdat_memos.php?envnfil="+varfils;
		}

	}
	
	
	function mostrafechadiv()
	{
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var datofecha=diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
return 	datofecha;
	}
	

function relojillo()
{
fecha = new Date()
hora = fecha.getHours()
minuto = fecha.getMinutes()
segundo = fecha.getSeconds()
horita = hora + ":" + minuto + ":" + segundo
document.getElementById('horapag').innerHTML = horita;
setTimeout('relojillo()',1000);
}