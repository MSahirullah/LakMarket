@extends('seller.dashboard_layout')

@section('dahsboard_content')

<span id="notificationStatus" {{ Session::has('addNewStatus') ? 'data-notification' : '' }} data-notification-status='{{ Session::get('addNewStatus') }}'>
</span>



<link href="{{ URL::asset('css/sellercss/products.css') }}" rel="stylesheet">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Products</h1>
        </div>
    </div>

    <div class="addNewBtn">
        <button data-toggle="modal" data-button="Save" data-title="Add New Product Details" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn successBtn" target="modalAddEdit"><i class="fas fa-plus addNewBtn"></i>Add New Product</button>

    </div>

    <span>{{Session::get('addNewStatus')}}</span>

    <section class="content" id="productsTable">
        <div class="container-fluid">
            <div class="row">
                <div class="col md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Images</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Discount(%)</th>
                                <th>Tax(%)</th>
                                <th>Unit Price</th>
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
            <form action="{{route('product.add')}}" method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="pid" id="pid">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="product_category" class="col-form-label">Category</label>
                                <span class="required"></span>
                                <select name="product_category" class="form-control btn-input" data-live-search="true" id="product_category">
                                    @foreach($catogeries as $catogery)
                                    <option>{{$catogery->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="col-form-label">Code</label>
                                <span class="required"></span>
                                <input type="text" name="code" class="form-control p-input" id="code" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="name" class="col-form-label">Product Name</label>
                                <span class="required"></span>
                                <input type="text" required name="name" class="form-control p-input" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="images" class="col-form-label">Images</label>
                                <span class="required"></span><br>

                                <input type="file" id="images" hidden multiple accept="image/*" name="images[]" />

                                <label for="images" class="col-form-label labelimg">Choose Images</label><br>
                                <span id="file-chosen">No file chosen</span>
                            </div>
                            <div class="col-md-9 imgShow">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="short_desc" class="col-form-label">Short Description</label>
                                <span class="required"></span>
                                <textarea rows="4" required name="short_desc" class="form-control p-input" id="short_desc"></textarea>
                            </div>
                            <div class="col-md-7">
                                <label for="long_desc" class="col-form-label">Full Description</label>
                                <textarea rows="4" name="long_desc" class="form-control p-input" id="long_desc"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="unit_price" class="col-form-label">Unit Price</label>
                                <span class="required"></span>
                                <input name="unit_price" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="unit_price" maxlength="15" />
                                <span class="money-sign">Rs.</span>
                            </div>
                            <div class="col-md-4">
                                <label for="tax" class="col-form-label">Tax (%)</label>
                                <input type="text" name="tax" class="form-control p-input" id="tax" value="0.00" maxlength="5">
                            </div>
                            <div class="col-md-4">
                                <label for="discount" class="col-form-label">Discount (%)</label>
                                <input type="text" name="discount" class="form-control p-input" id="discount" value="0.00" maxlength="5">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="sizes" class="col-form-label">Sizes</label>
                                <input type="text" name="sizes" class="form-control p-input" id="sizes">
                            </div>
                            <div class="col">
                                <label for="colors" class="col-form-label">Colors</label>
                                <input type="text" name="colors" class="form-control p-input" id="colors">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeBtn" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary btnSubmit">Save</button>
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {

        $(document).ready(function() {
            $("#product_category").selectpicker();
        });

        function sweetalert(type, msg) {
            Swal.fire({
                icon: type,
                title: msg,
                showConfirmButton: true,
                timer: 3000
            })
        }

        //Sweet alert for add record
        (function() {
            var notificationStatus = $('#notificationStatus').attr('data-notification');

            if (typeof notificationStatus === 'undefined') {
                return false;

            } else {
                var status = $('#notificationStatus').attr('data-notification-status');
                var types = ['success', 'error', 'warning'];

                type = types[2];
                message = 'Something went wrong. Please try again later!';

                if (status == '1') {
                    type = types[1];
                    message = 'This product has been blacklisted!';

                } else if (status == '2') {
                    type = types[2];
                    message = 'This product already exists!';

                } else if (status == '3') {
                    type = types[0];
                    message = 'Product has been successfully added to the store!';
                }
            }

            sweetalert(type, message);
            // document.cookie = 'addNewStatus=; Max-Age=-99999999;';
            // $('#notificationStatus').removeAttr('data-notification-status');
            // sessionStorage.removeItem('addNewStatus');
            // console.log(sessionStorage);
            // console.log(sessionStorage.get('sellerimage'));
            

        })();

        //Sweet alert for remove record
        $(document).on('click', '.removeBtn', function() {
            var pid = $(this).attr('data-id');

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
                    $.post("{{ route('product.destroy') }}", {
                        rowid: pid,
                        _token: "{{ csrf_token() }}"
                    }, function(dd) {
                        if (dd == 1) {
                            table.ajax.reload();
                            Swal.fire('Removed!', '', 'success');
                        } else {
                            Swal.fire('Failed to remove.', '', 'info');
                        }
                    });
                }
            })

        });

        var formChange = false;
        const actualBtn = document.getElementById('images');

        $(document).on('click', '.editBtn', function() {

            var pid = $(this).attr('data-id');
            $('#pid').val(pid);
            $.post("{{ route('product.details') }}", {
                rowid: pid,
                _token: "{{ csrf_token() }}"
            }, function(data) {
                $('#product_category').selectpicker('val', data[0].category_name);
                $('#product_category').selectpicker('refresh');

                $('#code').val(data[0].code);
                $('#code').attr('disabled', 'disabled');
                $('#name').val(data[0].name);
                $('#short_desc').text(data[0].short_desc);
                $('#long_desc').text(data[0].long_desc);
                $('#unit_price').val(data[0].unit_price);
                $('#tax').val(data[0].tax);
                $('#discount').val(data[0].discount);
                $('#sizes').val(data[0].sizes);
                $('#colors').val(data[0].colors);

                var pImages = data[0].images;
                pImagesA = pImages.replace('["', '');
                pImagesB = pImagesA.replace('"]', '');
                pImagesC = pImagesB.replace('","', ',');
                var ImagesArray = pImagesC.split(",");

                $('.imgShow').html('');
                $("#file-chosen").html(ImagesArray.length + ' images chosen.')

                for (p = 0; p < ImagesArray.length; p++) {
                    var img = $("<img />");
                    img.attr("class", "uploaded-image");
                    img.attr("src", "/" + ImagesArray[p]);
                    $('.imgShow').append(img);
                    $("#file-chosen").attr('data-uploded', 1);
                }
            });

            $('#detailsForm').on('keyup change paste', 'input, select, textarea', function() {
                formChange = true;
            });
            actualBtn.addEventListener('change', function() {
                formChange = true;
            });
        });

        $(document).on('click', '#Update', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (!actualBtn.files.length > 0) {
                if (!$("#file-chosen").attr('data-uploded')) {
                    fileChosen.innerHTML = 'Please select images';
                    $('#file-chosen').attr("style", "color:red");
                    return false;
                }
            }

            if (formChange) {

                var pid = $('.editBtn').attr('data-id');
                var data = new FormData(this.form);
                var url = "{{ route('product.update') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data, // serializes the form's elements.
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data == 1) {
                            table.ajax.reload();
                            Swal.fire('Product details updated!', '', 'success');
                            $('#closeBtn').trigger('click');

                        } else if (data == 0) {
                            Swal.fire('Failed to update.', '', 'info');
                        }
                    }
                });
                e.preventDefault();
            } else {
                alert('Please make any changes');
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'images',
                    name: 'images'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'product_catrgory_id',
                    name: 'product_catrgory_id'
                },
                {
                    data: 'colors',
                    name: 'colors'
                },
                {
                    data: 'sizes',
                    name: 'sizes'
                },
                {
                    data: 'discount',
                    name: 'discount'
                },
                {
                    data: 'tax',
                    name: 'tax'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
<script src="{{ asset('js/sellerjs/products.js') }}" defer></script>


@endsection