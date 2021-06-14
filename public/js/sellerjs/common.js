function deleteAction(id, url, table = null) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {
            $.post(url, {
                rowid: id,
                _token: post_token
            }, function(dd) {
                if (dd == 1) {
                    if (table){
                        table.ajax.reload();
                    }
                    Swal.fire('Removed!', '', 'success');
                } else {
                    Swal.fire('Failed to remove.', '', 'info');
                }
            });
        }
    })
}

function pageReload(){

    $.ajax({
        url: "/seller/dashboard/clear-session",
        data: {
            _token: post_token
        },
        method: 'post',
        success: function() {
            
            $('#actionStatus').removeAttr('data-status');
            $('#actionStatus').val('data-status-alert', '');
            $('#actionStatus').val('data-status-message', '');
        
        }
    });
}

function sweetPull() {
    var actionStatus = $('#actionStatus').attr('data-status');

    if (typeof actionStatus === 'undefined') {
        return false;

    } else {
        var type = $('#actionStatus').attr('data-status-alert');
        var message = $('#actionStatus').attr('data-status-message');

        Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: true,
            timer: 3000
        })
    }
}

function selectTitle(idName){

    $(idName).addClass('disabled');
    $(idName).addClass('highlighted-title'); 
    $(idName).hover( function(){ 
        $(idName).addClass('highlighted-title:h');
    });
}


function checkImageInput(actualBtn){
    if(!actualBtn.files.length>0){
        $('.checkImg').removeAttr('required');
        if (!$("#file-chosen").attr('data-uploded')){
            $('.checkImg').attr('required', '');
        }
    }
}

function setBtnId(){
    $(document).on('click', '.editBtn, .createBtn', function(){
        var ModalLabel= $(this).attr('data-title');
        var BtnLabel= $(this).attr('data-button');
        $("#file-chosen").removeAttr('data-uploded');
        $('#file-chosen').attr("style", "color:black");

        $("#modalLabel").html(ModalLabel);
        $(".btnSubmit").html(BtnLabel);
        $('.btnSubmit').attr('id', BtnLabel);
     });
}

function clickSubmit(actualBtn){
    $(document).on('click', '#Save', function(e){
         
        e.preventDefault();

        checkImageInput(actualBtn);

        $(this).next('button').trigger('click');

     });
}


function vanillaAlert(inp, msg, time = 6000){

    var title = ['Success!','Error!','Warning!','Information!'];
    var type = ['success', 'error', 'warning','info'];
    var icon = ['success.png', 'error.png', 'warning.png', 'info.png']
    var path = '/img/alert-logo/';

    VanillaToasts.create({
        title: title[inp],
        text: msg,
        type: type[inp], 
        icon: path + icon[inp], 
        timeout: time
        // callback: function() { ... } // executed when toast is clicked / optional parameter
      });
}


