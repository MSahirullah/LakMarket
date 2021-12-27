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


<div class="modal fade bd-AddEdit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="btnAddEdit" aria-hidden="true" id="modalAddEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action= "{{route('admin.add')}}"  method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="pid" id="pid">
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
                                <label for="item_name" class="col-form-label">Item name</label>
                                <span class="required"></span>
                                <input type="text" name="item_name" class="form-control p-input validate-input" id="item_name" onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" pattern="[a-zA-Z ]*"required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="seller_name" class="col-form-label">Seller name</label>
                                <span class="required"></span>
                                <input type="text" name="seller_name" class="form-control p-input validate-input" id="seller_name" onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" pattern="[a-zA-Z ]*"required>
                            </div>
                            <div class="col">
                                <label for="product_code" class="col-form-label">Product code</label>
                                <span class="required"></span>
                                <input type="text" name="product_code" class="form-control p-input validate-input" id="product_code" onkeypress="return /^[a-zA-Z0-9]*$/.test(event.key)" pattern="[a-zA-Z0-9]*"required>
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
        formChange = false;*/
        formChange = false;
        $(document).on('click', '.editBtn', function() {

            var pid = $(this).attr('data-id');
            $('.btnSubmit').text($(this).attr('data-button'));

            $('#modalLabel').text($(this ).attr('data-title'));
            $('.btnSubmit').attr('id', $(this).attr('data-button'));

            $('#pid').val(pid);
            $.post("{{ route('product.details') }}", {
                rowid: pid,
                _token: "{{ csrf_token() }}"
            }, function(data) {

                // console.log(this);
                //$('.linkedin-col').show();
                //$('.password-col').hide();

                $('#item_name').val(data[0].name);
                $('#product_code').val(data[0].code);
                $('#seller_name').val(data[0].seller_name);
                //$('#email').val(data[0].email);
                //$('#phone_number').val(data[0].phone_number);
                //$('#dob').val(data[0].date_of_birth);
                //$('#address').val(data[0].address);
                //$('#linkedin').val(data[0].LinkedIn)
            
                $('#seller_name').attr('disabled', 'disabled');


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
                var url = "{{ route('product.update') }}";

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
        }); 

        pageReload();
        sweetPull();
    
    });

</script>
 <script src="{{ asset('js/adminjs/products.js') }}" defer></script> 




@endsection