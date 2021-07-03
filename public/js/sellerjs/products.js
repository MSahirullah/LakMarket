$(document).ready(function () {

    $('#name').keyup(function (e) {
        var lng = $(this).val().length;
        document.getElementById("name_len").innerHTML = lng;
    })
    $('#short_desc').keyup(function (e) {
        var lng = $(this).val().length;
        document.getElementById("short_desc_len").innerHTML = lng;
    })
    $('#long_desc').keyup(function (e) {
        var lng = $(this).val().length;
        document.getElementById("long_desc_len").innerHTML = lng;
    })




    selectTitle('#sidebarMenuProducts');

    const actualBtn = document.getElementById('images');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function () {
        $('#file-chosen').attr("style", "color:black")
        $("#file-chosen").addClass('data-uploded');
        $('.checkImg').removeAttr('required');
        if (this.files.length > 1) {

            if (this.files.length > 3) {
                fileChosen.innerHTML = 3 + ' images chosen.';
            }
            else {
                fileChosen.innerHTML = this.files.length + ' images chosen.';
            }

        } else if (this.files.length == 1) {
            fileChosen.innerHTML = this.files.length + ' image chosen.';
        }
        else {
            $("#file-chosen").removeClass('data-uploded');
            fileChosen.innerHTML = 'No file chosen.';
        }
    })

    function readURL(input) {

        if (input.files && input.files[0]) {
            $(".imgShow").show();

            for (i = 0; i < input.files.length; i++) {
                if (i < 3) {
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

    $("#images").change(function () {
        $(".imgShow").empty();
        readURL(this);
    });


    $(".createBtn").click(function () {
        $("#detailsForm .modal-body input, #detailsForm .modal-body textarea").val('');
        $('#tax, #discount, #unit_price').attr('placeholder', '0.00');
        $('#file-chosen').html('No file chosen');
        $(".imgShow").empty();
        $('#sizes').val('-');
        $('#colors').val('-');
        $('#code').removeAttr('disabled');
    });

    setBtnId();

    $(document).on('click', '#Save', function (e) {

        e.preventDefault();
        checkImageInput(actualBtn);

        var price = 0.00;
        var tax = 0.00;
        var discount = 0.00;


        price = parseFloat($('#unit_price').val()).toFixed(2);

        if ($('#tax').val()) {
            tax = parseFloat($('#tax').val()).toFixed(2);
        }
        if ($('#discount').val()) {
            discount = parseFloat($('#discount').val()).toFixed(2);
        }


        if (!(price >= 0 && price <= 1000000)) {
            vanillaAlert(2, 'Unit Price must be between Rs. 0.00 and Rs. 1000000.');
            return false;
        }
        if (!(tax >= 0 && tax <= 100)) {
            vanillaAlert(2, 'Tax must be between 0% and 100%.');
            return false;
        }
        if (!(discount >= 0 && discount <= 100)) {
            vanillaAlert(2, 'Discount must be between 0% and 100%.');
            return false;
        }



        $(this).next('button').trigger('click');

    });



});


