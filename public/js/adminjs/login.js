$(document).ready(function(){
    $.ajax({
        url: "/admin/dashboard/clear-session",
        data: {
            _token: post_token
        },
        method: 'post',
        success: function() {
        
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

    
    alertMSG = $('#status').attr('dataMSG');
    alertID = $('#status').attr('dataID');
    if(alertMSG){
        vanillaAlert(alertID, alertMSG);
    }
}); 

