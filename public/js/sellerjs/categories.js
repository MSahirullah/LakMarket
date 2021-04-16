$(document).ready(function(){
    $("#sidebarMenuCatagories").addClass('disabled');

    $("#sidebarMenuCatagories").addClass('highlighted-title');
    
    $('#sidebarMenuCatagories').hover( function(){ 
        $('#sidebarMenuCatagories').addClass('highlighted-title:h');
     });
    
     const actualBtn = document.getElementById('image');
 
     const fileChosen = document.getElementById('file-chosen');
 
     actualBtn.addEventListener('change', function(){
         $('#file-chosen').attr("style", "color:black")
         fileChosen.innerHTML = '1 image chosen.';
     })


     function readURL(input) {

        if (input.files && input.files[0]) {
            $(".imgShow").show();

            var reader = new FileReader();
            reader.onload = function (e) {
                var img = $("<img />");
                img.attr("class", "uploaded-image");
                img.attr("src", e.target.result);

                $('.imgShow').append(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#image").change(function(){
        $(".imgShow").empty();
        readURL(this);
    });

    $(".createBtn").click(function(){
        $("#detailsForm .modal-body input").val('');
        $('#file-chosen').html('No file chosen');
        $(".imgShow").empty();
    });

     setBtnId();


});