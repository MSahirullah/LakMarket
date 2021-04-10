$(document).ready(function(){


    $("#sidebarMenuProfile").addClass('disabled');

    $("#sidebarMenuProfile").addClass('highlighted-title');
    
    $('#sidebarMenuProfile').hover( function(){ 
        $('#sidebarMenuProfile').addClass('highlighted-title:h');
     });
    
    var readURL = function(input, imgSrc) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(imgSrc).attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(e){
        readURL(this, '.profile-pic');
        e.preventDefault();
        $('#profile_submit').trigger('click');
        

    });
    
    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });
    

    $(".store-img-input").on('change', function(e){
        readURL(this, '.store-image');
        e.preventDefault();
        $('#store_submit').trigger('click');
    });
    
    $(".change_store_img").on('click', function() {
        $(".store-img-input").click();
    });


    
    
  
});
