$(document).ready(function(){
    $.ajax({
        url: "/seller/dashboard/clear-session",
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
}); 

