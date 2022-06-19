$(document).ready(function () {
	$("input").focusout(function(){     
		$(this).val(jQuery.trim($(this).val())); 
	});
    $(".save-date-in").submit(function () {
		if($("#tracto").val().length < 1) {
			alert("Por favor ingrese el Tracto");
				$("#tracto").focus();
			return false;
		}
        if($("#semi").val().length < 1) {
            alert("Por favor ingrese el Semi");
            $("#semi").focus();
        return false;
    	}
		if($("#name").val().length < 1) {
            alert("Por favor ingrese el nombre del Chofer");
            $("#name").focus();
        return false;
    	}
    });
});
