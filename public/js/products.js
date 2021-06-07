$(document).ready(function(){
    $('.increaser').click(function(){
        var value = $('#qtyInput').val();
        if (value){
            value = parseInt(value);
            if (value<999){
                value = value + 1;
                $('#qtyInput').val(value);
            }
        }
    });

    $('.dicreaser').click(function(){
        var value = $('#qtyInput').val();
        if (value){
            value = parseInt(value);
            if (value>1){
                value = value - 1;
                $('#qtyInput').val(value);
            }
        }
    });
});