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


    

    
});