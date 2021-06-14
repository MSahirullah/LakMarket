
$(document).ready(function(){

    alertMSG = $('#regStatus').attr('dataMSG');
    alertID = $('#regStatus').attr('dataID');
    if(alertMSG){
        vanillaAlert(alertID, alertMSG);
    }

    var x = 1; 
    for(var i = 59; i>=0; i--){
        x = x + 1;
        delay(i, x);
    }


    function delay(i, x) {
        setTimeout(() => {
            $('#timer').text(i);
        }, 1000 * x);
    }

    setTimeout(() => {
        $('.button-3').removeAttr('disabled');
        $('.timer').hide();

    }, 62000);

    $('#verifyBtn').click(function() {
        if($('#timer').text() == 0){
            $('#verifyForm').submit();
        }
    });


});

