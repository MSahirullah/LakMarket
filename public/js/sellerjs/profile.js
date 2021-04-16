$(document).ready(function(){

    selectTitle('#sidebarMenuProfile');
    
    $(".file-upload").on('change', function(e){
        e.preventDefault();
        $('#profile_submit').trigger('click');
    });

    
    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });
    

    $(".store-img-input").on('change', function(e){
        e.preventDefault();
        $('#store_submit').trigger('click');
    });

    
    $(".change_store_img").on('click', function() {
        $(".store-img-input").click();
    });


    $('.hotline-edit').on('click', function(){
        $('#edit-hotline').trigger('click');
    });

    $('#hotline_submit-temp').on('click', function(e){

        e.preventDefault();
        var hotline = $('#hotline').val();

        if(hotline){
            if(hotline.length<9){
                $('#hotline').val('');
            }
        }
        $('#hotline_submit').trigger('click');
    });
});
