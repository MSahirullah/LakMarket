$(document).ready(function(){

    $('.button-reg-4').click(function() {
    
        var password1 = $('#password').val();
        var password2 = $('#confirm-password').val();
    
        if (password1 != password2) {
    
            $('#confirm-password').attr('type', 'text');
            $('#confirm-password').val('');
            $('#confirm-password').attr('type', 'text');
        }
        $('#form-submit').trigger("click");
    });

    var input = document.getElementById('confirm-password');
    input.oninvalid = function(event) {
        event.target.setCustomValidity('Please make sure your passwords match.');
    }


    $(".toggle-password").click(function() {

        var input = $($(this).attr("toggle"));
        if ($(input).val()){
            $(this).toggleClass("fa-eye fa-eye-slash");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        }
    });
    
});
