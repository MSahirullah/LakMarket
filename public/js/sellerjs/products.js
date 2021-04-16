$(document).ready(function() {


    selectTitle('#sidebarMenuProducts');
    
    const actualBtn = document.getElementById('images');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
        $('#file-chosen').attr("style", "color:black")
        if (this.files.length > 1){
            if(this.files.length > 3){
                fileChosen.innerHTML = 3 + ' images chosen.';
            }
            else{
                fileChosen.innerHTML = this.files.length + ' images chosen.';
            }
            
        } else if (this.files.length == 1 ){
            fileChosen.innerHTML = this.files.length + ' image chosen.';
        }
        else{
            fileChosen.innerHTML = 'No file chosen.';
        }
    })

    function readURL(input) {

        if (input.files && input.files[0]) {
            $(".imgShow").show();

            for (i = 0; i < input.files.length; i++) {
                if (i<3){
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("class", "uploaded-image");
                        img.attr("src", e.target.result);
    
                        $('.imgShow').append(img);
                    }
                    reader.readAsDataURL(input.files[i]);
                }

            }
        }
    }
    
    $("#images").change(function(){
        $(".imgShow").empty();
        readURL(this);
    });


    $(".createBtn").click(function(){
        $("#detailsForm .modal-body input, #detailsForm .modal-body textarea").val('');
        $('#tax, #discount').val('0.00');
        $('#file-chosen').html('No file chosen');
        $(".imgShow").empty();
        $('#code').removeAttr('disabled');
    });

    setBtnId();

    clickSubmit(actualBtn);


} );


