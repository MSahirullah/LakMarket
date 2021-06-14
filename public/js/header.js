$(document).ready(function(){

    alertMSG = $('#status').attr('dataMSG');
    alertID = $('#status').attr('dataID');
    if(alertMSG){
        vanillaAlert(alertID, alertMSG);
    }

    $(window).scroll(function(){
        if ($(window).scrollTop() >= 36) {
            $('#fixed-header').addClass('fixed-header');
            $('.site-container').css('margin-top','140px');
        }
        else {
            $('#fixed-header').removeClass('fixed-header');
            $('.site-container').css('margin-top','0px');
        }
    });

    $('.cato-link').mouseover(function(){
        $('.cato-link .fa-chevron-down').hide();
        $('.cato-link .fa-chevron-up').show();
        $('.cato-list').show();
    });

    $('.cato-link').mouseout(function(){
        
        $('.cato-link .fa-chevron-up').hide();
        $('.cato-link .fa-chevron-down').show();
        $('.cato-list').hide();

    });

    $('.cato-list').mouseout(function(){
        $('.cato-list').hide();
    });


});
