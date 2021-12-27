@extends('admin.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>
<link href="{{ URL::asset('css/admincss/sellers.css') }}" rel="stylesheet">


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Sellers</h1>
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
                                <th>Name</th>
                                <th>Shop Category</th>
                                <th>Shop Name</th>
                                <th>Store Logo</th>
                                <th>Business Email</th>
                                <th>Delivering Districts</th>
                                <th>Business Mobile</th>
                                <th>City</th>
                                <th>District</th>
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
                <input type="hidden" name="sid" id="sid">
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
                                <label for="full_name" class="col-form-label">Full name</label>
                                <span class="required"></span>
                                <input type="text" name="full_name" class="form-control p-input validate-input" id="full_name" onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" pattern="[a-zA-Z ]*"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email" class="col-form-label">Business Email</label>
                                <span class="required"></span>
                                <input type="email" required name="email" class="form-control p-input validate-input" id="email">
                            </div>
                            <div class="col">
                                <label for="full_name" class="col-form-label">Store name</label>
                                <span class="required"></span>
                                <input type="text" name="store_name" class="form-control p-input validate-input" id="store_name" onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" pattern="[a-zA-Z ]*"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="address" class="col-form-label">Business Address</label>
                                <span class="required"></span>
                                <textarea rows="4" name="address" class="form-control p-input validate-input" id="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col password-col">
                                <label for="ad-password" class="col-form-label">Password</label>
                                <span class="required"></span>
                                <input type="text" required name="password" class="form-control p-input" id="ad-password">
                                <span class="pass-generate">Generate Password</span>
                            </div>
                            <div class="col">
                                <label for="phone_number" class="col-form-label">Business Mobile</label>
                                <span class="required"></span> 
                                <input name="phone_number" required type="text" class="form-control p-input validate-input" id="phone_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" style="padding-left: 40px;" placeholder="7XXXXXXXX">
                                <span class="mob-contry-code">+94</span>
                            </div>
                            <div class="col">
                                <label for="hotline_number" class="col-form-label">Hotline</label>
                                <span class="required"></span> 
                                <input name="hotline_number" required type="text" class="form-control p-input validate-input" id="hotline_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" style="padding-left: 40px;" placeholder="7XXXXXXXX">
                                <span class="mob-contry-code">+94</span>
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
            ajax: "{{ route('admin.sellers') }}",
            columns: [{
                    data: 'ids',
                    name: 'ids'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'shop_category',
                    name: 'shop_category'
                },
                {
                    data: 'store_name',
                    name: 'store_name'
                },
                {
                    data: 'store_logo',
                    name: 'store_logo'
                },
                {
                    data: 'business_email',
                    name: 'business_email'
                },
                {
                    data: 'delivering_districts',
                    name: 'delivering_districts'
                },
                {
                    data: 'business_mobile',
                    name: 'business_mobile'
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

            deleteAction(pid, "{{ route('seller.destroy') }}", table)
        });
        $(document).on('click', '.removeBtn2', function() {
            var pid = $(this).attr('data-id');

           blacklistAction(pid, "{{ route('seller.blacklist') }}", table)
        });
        
        formChange = false;
        $(document).on('click', '.editBtn', function() {

                var sid = $(this).attr('data-id');
                $('.btnSubmit').text($(this).attr('data-button'));

                $('#modalLabel').text($(this ).attr('data-title'));
                $('.btnSubmit').attr('id', $(this).attr('data-button'));

                $('#sid').val(sid);
                $.post("{{ route('seller.details') }}", {
                    rowid: sid,
                    _token: "{{ csrf_token() }}"
                }, function(data) {

                    // console.log(this);

                    
                    //$('.linkedin-col').show();
                    $('.password-col').hide();

                    $('#full_name').val(data[0].full_name);
                    $('#store_name').val(data[0].store_name);
                    $('#email').val(data[0].business_email);
                    $('#phone_number').val(data[0].business_mobile);
                    $('#dob').val(data[0].birthday);
                    $('#address').val(data[0].address);
                    $('#hotline_number').val(data[0].hotline);
                    //$('#linkedin').val(data[0].LinkedIn)

                    $('#email').attr('disabled', 'disabled');


                });

                $('#detailsForm').on('keyup change paste', 'input, select, textarea', function() {
                    formChange = true;
                });
                });

                $(document).on('click', '#Update', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var phoneNum = $('#phone_number').val();
                var phoneValidate = new RegExp('[7]{1}[0-8]{1}[0-9]{7}');

                var phoneNum1 = $('#hotline_number').val();
                var phoneValidate1 = new RegExp('[1]{2}[0-9]{7}');

                if (!phoneValidate.test(phoneNum)) {
                    vanillaAlert(1, 'The Business number you entered does not match.');
                    return false;
                }

                if (!phoneValidate1.test(phoneNum1)) {
                    if(!phoneValidate.test(phoneNum1)){
                             vanillaAlert(1, 'The hotline number you entered does not match.');
                             return false;
                    }
                }

                check = 0;

                if (formChange) {

                    var data = new FormData(this.form);
                    var url = "{{ route('seller.update') }}";

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

                                console.log(data);
                                if (data == 1) {
                                    table.ajax.reload();
                                    vanillaAlert(0, 'Seller details updated!');
                                    
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
<script src="{{ asset('js/adminjs/sellers.js') }}" defer></script>




@endsection