// JavaScript Document
function trim(cadena)
{
 for(i=0; i<cadena.length; )
 {
  if(cadena.charAt(i)==" ")
   cadena=cadena.substring(i+1, cadena.length);
  else
   break;
 }
 for(i=cadena.length-1; i>=0; i=cadena.length-1)
 {
  if(cadena.charAt(i)==" ")
   cadena=cadena.substring(0,i);
  else
   break;
 }
 
 forma.nombre.value=cadena;
}
function espacios(cadena)
{
 for(i=0; i<cadena.length; )
 {
  if(cadena.charAt(i)==" ")
   cadena=cadena.substring(i+1, cadena.length);
  else
   break;
 }
 for(i=cadena.length-1; i>=0; i=cadena.length-1)
 {
  if(cadena.charAt(i)==" ")
   cadena=cadena.substring(0,i);
  else
   break;
 }
 
 forma.apellido.value=cadena;
}
function soloRUT(evt) {
 var key = evt.keyCode ? evt.keyCode : evt.which ;
 return (key <= 31 || (key >= 48 && key <= 57) || key == 75 || key == 107); 
}
function formatearRut(casilla){
 function formatearMillones(nNmb){
  var sRes = "";
  for (var j, i = nNmb.length - 1, j = 0; i >= 0; i--, j++)
   sRes = nNmb.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + sRes;
  return sRes;
 }
 
 var casillaRut=document.getElementById(casilla);
 
 var rut=casillaRut.value;
 var ultimoDigito=rut.substr(rut.length-1,1);
 var terminaEnK = (ultimoDigito.toLowerCase()=="k");
 rutSinFormato=rut.replace(/\W/g,"");
 rut=rut.replace(/\D/g,"");
 var dv=rut.substr(rut.length-1,1);
 if(!terminaEnK){ rut=rut.substr(0,rut.length-1); }
 else{ dv="K"; }
 if(rut && dv) {
  casillaRut.value=formatearMillones(rut)+"-"+dv;
  document.getElementById('buic_rutdv').value=rutSinFormato;
 }
}
