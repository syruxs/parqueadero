document.addEventListener("DOMContentLoaded", function() {
  	document.getElementById("formulario").addEventListener('submit', validarFormulario); 
	});

		function validarFormulario(evento) {
		  evento.preventDefault();
			indice = document.getElementById("filter").selectedIndex;
			if( indice == null || indice == 0 ) {
				alert('Seleccione una opcion');
				document.getElementById("filter").focus();
				return false;
			}
			if(document.getElementById("date1").value == false){
				alert('Seleccione la fecha de inicio');
				document.getElementById("date1").focus();
				return false;
			}
			if(document.getElementById("date2").value == false){
				alert('Seleccione la fecha de final');
				document.getElementById("date2").focus();
				return false;
			}
			if(document.getElementById("date1").value > document.getElementById("date2").value){
				alert("¡El formato es incorrecto! \n Fecha Incio NO puede ser mayor que Fecha Final");
			 	document.getElementById("date1").focus();
				return false;  
			}
		  this.submit();
		}