
$(document).ready(function(){

    alertMSG = $('#status').attr('data');
    if(alertMSG){
        vanillaAlert(1, alertMSG);
    }


});
    
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
