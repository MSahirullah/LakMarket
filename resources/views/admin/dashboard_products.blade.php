@extends('admin.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>
<link href="{{ URL::asset('css/admincss/product.css') }}" rel="stylesheet">


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Products</h1>
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
                                <th>Item Name</th>
                                <th>Product Category</th>
                                <th>Seller Name</th>
                                <th>Type</th>
                                <th>Images</th>
                                <th>Colors</th>
                                <th>Cash on Delivery</th>
                                <th>Unit price</th>
                                <th>Tax</th>
                                <th>Discount</th>
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


{{-- <div class="modal fade bd-AddEdit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="btnAddEdit" aria-hidden="true" id="modalAddEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action= "{{route('admin.add')}}"  method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="aid" id="aid">
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
                                <input type="text" name="full_name" class="form-control p-input validate-input" id="full_name" pattern="[a-zA-Z ]*"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email" class="col-form-label">Email</label>
                                <span class="required"></span>
                                <input type="email" required name="email" class="form-control p-input validate-input" id="email">
                            </div>
                            <div class="col">
                                <label for="phone_number" class="col-form-label">Phone Number</label>
                                <span class="required"></span> 
                                <input name="phone_number" required type="text" class="form-control p-input validate-input" id="phone_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="9" pattern="[7]{1}[0-8]{1}[0-9]{7}" style="padding-left: 40px;" placeholder="7XXXXXXXX">
                                <span class="mob-contry-code">+94</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="address" class="col-form-label">Address</label>
                                <span class="required"></span>
                                <textarea rows="4" name="address" class="form-control p-input validate-input" id="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col linkedin-col">
                                <label for="linkedin" class="col-form-label">LinkedIn Link</label>
                                <input name="linkedin" type="text"class="form-control p-input validate-input" id="linkedin" pattern='www.linkedin.com/in/[a-zA-Z0-9\-]*'>
                            </div>
                            <div class="col password-col">
                                <label for="ad-password" class="col-form-label">Password</label>
                                <span class="required"></span>
                                <input type="text" required name="password" class="form-control p-input" id="ad-password">
                                <span class="pass-generate">Generate Password</span>
                            </div>
                            <div class="col">
                                <label for="dob" class="col-form-label">DOB</label>
                                <span class="required"></span>
                                <input type="date" required name="dob" class="form-control p-input validate-input" id="dob" min="1975-01-01" max="2007-01-01">
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
</div> --}}

<script type="text/javascript">
        $("input[type='text']").on("click", function() {
            $(this).select();
    });

    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.products') }}",
            columns: [{
                    data: 'ids',
                    name: 'ids'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                 {
                    data: 'product_category',
                    name: 'product_category'
                }, 
                {
                    data: 'seller_name',
                    name: 'seller_name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'images',
                    name: 'images'
                },
                {
                    data: 'colors',
                    name: 'colors'
                },
                {
                    data: 'cod',
                    name: 'cod'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'tax',
                    name: 'tax'
                },
                {
                    data: 'discount',
                    name: 'discount'
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

            deleteAction(pid, "{{ route('product.destroy') }}", table)
        });
        
        //Sweet alert for remove record
        /* $(document).on('click', '.removeBtn1', function() {
            var pid = $(this).attr('data-id');

            deleteAction(pid, "{{ route('admin.destroy') }}", table)
        });
        $(document).on('click', '.removeBtn2', function() {
            var pid = $(this).attr('data-id');

           blacklistAction(pid, "{{ route('admin.blacklist') }}", table)
        });
        formChange = false;
        $(document).on('click', '.editBtn', function() {

            var aid = $(this).attr('data-id');

            $('#aid').val(aid);
            $.post("{{ route('admin.details') }}", {
                rowid: aid,
                _token: "{{ csrf_token() }}"
            }, function(data) {

                // console.log(this);

                $('.btnSubmit').text($('.editBtn').attr('data-button'));

                $('#modalLabel').text($('.editBtn').attr('data-title'));
                $('.btnSubmit').attr('id', $('.editBtn').attr('data-button'));
                $('.linkedin-col').show();
                $('.password-col').hide();

                $('#full_name').val(data[0].full_name);
                $('#email').val(data[0].email);
                $('#phone_number').val(data[0].phone_number);
                $('#dob').val(data[0].date_of_birth);
                $('#address').val(data[0].address);
                $('#linkedin').val(data[0].LinkedIn)
            
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
                var url = "{{ route('admin.update') }}";

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
                                vanillaAlert(0, 'Product details updated!');
                                
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
        }); */

        pageReload();
        sweetPull();
    
    });

</script>
 <script src="{{ asset('js/adminjs/products.js') }}" defer></script> 




@endsection