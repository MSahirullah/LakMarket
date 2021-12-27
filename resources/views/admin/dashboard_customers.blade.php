@extends('admin.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>
<link href="{{ URL::asset('css/admincss/customers.css') }}" rel="stylesheet">


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Customers</h1>
        </div>
    </div>

    <section class="content" id="productsTable">
        <div class="container-fluid">
            <div class="row">
                <div class="col md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>District</th>
                                <th>Profile Picture</th>
                                <th>Address</th>
                                <th>Newsletters</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>


<div class="modal fade bd-AddEdit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="btnAddEdit" aria-hidden="true" id="modalAddEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action= "{{route('admin.add')}}"  method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="cid" id="cid">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body admin-modal">
                    <div class="col-md-12 modelAddEdit">

                        <div class="row">
                            <div class="col">
                                <label for="first_name" class="col-form-label">First name</label>
                                <span class="required"></span>
                                <input type="text" name="first_name" class="form-control p-input validate-input" id="first_name" onkeypress="return /^[a-zA-Z]*$/.test(event.key)" pattern="[a-zA-Z]*"required>
                            </div>
                            <div class="col">
                                <label for="last_name" class="col-form-label">Last name</label>
                                <span class="required"></span>
                                <input type="text" name="last_name" class="form-control p-input validate-input" id="last_name" onkeypress="return /^[a-zA-Z]*$/.test(event.key)" pattern="[a-zA-Z]*"required>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col">
                                <label for="address" class="col-form-label">Address</label>
                                
                                <textarea rows="4" name="address" class="form-control p-input " id="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email" class="col-form-label">Email</label>
                                <span class="required"></span>
                                <input type="email" required name="email" class="form-control p-input validate-input" id="email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeBtn" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
        $("input[type='text']").on("click", function() {
            $(this).select();
    });

    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.customers') }}",
            columns: [{
                    data: 'ids',
                    name: 'ids'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                }, 
                {
                    data: 'city',
                    name: 'city'
                }, 
                {
                    data: 'district',
                    name: 'district'
                }, 
                {
                    data: 'pro_pic',
                    name: 'pro_pic'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'newsletters',
                    name: 'newsletters'
                },         
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        
        $(document).on('click', '.removeBtn1', function() {
            var pid = $(this).attr('data-id');

            deleteAction(pid, "{{ route('customer.destroy') }}", table)
        });

        $(document).on('click', '.removeBtn2', function() {
            var pid = $(this).attr('data-id');

            blacklistAction(pid, "{{ route('customer.blacklist') }}", table)
        });
        formChange = false;
        $(document).on('click', '.editBtn', function() {

                var cid = $(this).attr('data-id');

                $('.btnSubmit').text($(this).attr('data-button'));
                $('#modalLabel').text($(this ).attr('data-title'));
                $('.btnSubmit').attr('id', $(this).attr('data-button'));
                $('#cid').val(cid);
                $.post("{{ route('customer.details') }}", {
                    rowid: cid,
                    _token: "{{ csrf_token() }}"
                }, function(data) {

                    //$('.linkedin-col').show();
                    $('.password-col').hide();

                    $('#first_name').val(data[0].first_name);
                    $('#last_name').val(data[0].last_name);
                    $('#email').val(data[0].email);
                    $('#address').val(data[0].address);
                
                    $('#email').attr('disabled', 'disabled');


                });

                $('#detailsForm').on('keyup change paste', 'input, select, textarea', function() {
                    formChange = true;
                });
        });

        $(document).on('click', '#Update', function(e) {
                e.preventDefault();
                e.stopPropagation();

                check = 0;

                if (formChange) {

                    var data = new FormData(this.form);
                    var url = "{{ route('customer.update') }}";

                    $(".validate-input").each(function() {
                        if ($(this).val() == "") {
                            vanillaAlert(2, 'Please fill the required information.');
                            check = 1;
                            return false;

                        }
                    });

                    if (check == 0) {
       

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function(data) {


                                if (data == 1) {
                                    table.ajax.reload();
                                    vanillaAlert(0, 'Customer details updated!');
                                    
                                    $('#closeBtn').trigger('click');

                                } else {
                                    vanillaAlert(1, 'Failed to update.');
                                }
                            }
                        });

                        e.preventDefault();
                    }
                } else {
                    vanillaAlert(2, 'Please make any changes.');
                    return false;
                }
        });

        pageReload();
        sweetPull();
    
    });

</script>
<script src="{{ asset('js/adminjs/customers.js') }}" defer></script> 




@endsection