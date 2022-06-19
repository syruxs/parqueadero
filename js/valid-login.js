$(document).ready(function () {
	$("input").focusout(function(){     
		$(this).val(jQuery.trim($(this).val())); 
	});
    $(".contendor_general").submit(function () {
		if($("#user").val().length < 1) {
			alert("Por favor ingrese su usuario");
				$("#user").focus();
			return false;
		}
        if($("#pass").val().length < 4) {
            alert("Por favor ingrese su contraseña. ¡Recuerde que debe ser minimo 4 a 12 caracteres!");
            $("#pass").focus();
        return false;
    }
    });
});