@extends('admin.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Admins</h1>
        </div>
    </div>

    <div class="addNewBtn">
        <button data-toggle="modal" data-button="Save" data-title="Add New Product Details" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit"><i class="fas fa-plus addNewBtn"></i>Add New Product</button>

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
                                <th>Image</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>DOB</th>
                                <th>Address</th>
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
                    <h5 class="modal-title" id="modalLabel">Add New Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">

                            <div class="col-md-4">
                                <label for="code" class="col-form-label">Code</label>
                                <span class="required"></span>
                                <input type="text" name="code" class="form-control p-input" id="code" required />
                            </div>
                            <div class="col-md-4">
                                <label for="type" class="col-form-label">Product Type</label>
                                <span class="required"></span>
                                <select name="type" class="form-control btn-input" id="type">
                                    <option selected>Local Product</option>
                                    <option>Imported Product</option>
                                </select>

                                <!-- <input type="text" name="type" class="form-control p-input" id="type" required /> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="name" class="col-form-label">Product Name</label>
                                <span class="required"></span>
                                <input type="text" required name="name" class="form-control p-input validate-input" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="images" class="col-form-label">Images</label>
                                <span class="required"></span><br>

                                <input type="file" id="images" hidden multiple accept="image/*" name="images[]" />

                                <label for="images" class="col-form-label labelimg">Choose images</label><br>
                                <span id="file-chosen">No file chosen.</span>

                                <input type="text" oninvalid="this.setCustomValidity('Please select the images.')" oninput="setCustomValidity('')" class="checkImg" value="0" name="0">

                            </div>
                            <div class="col-md-9 imgShow p-input">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="short_desc" class="col-form-label">Short Description</label>
                                <span class="required"></span>
                                <textarea rows="4" required name="short_desc" class="form-control p-input validate-input" id="short_desc"></textarea>
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
                                <input name="unit_price" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input validate-input" id="unit_price" maxlength="15" />
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
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.list') }}",
            columns: [{
                    data: 'ids',
                    name: 'ids'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'date_of_birth',
                    name: 'date_of_birth'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        //Sweet alert for remove record
        $(document).on('click', '.removeBtn', function() {
            var pid = $(this).attr('data-id');

            deleteAction(pid, "{{ route('product.destroy') }}", table)
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

                $('#type').selectpicker('val', data[0].type);
                $('#type').selectpicker('refresh');

                $('#code').val(data[0].code);
                $('#code').attr('disabled', 'disabled');
                $('#first_name').val(data[0].first_name);
                $('#last_name').val(data[0].last_name);
                $('#phone_number').text(data[0].phone_number);
                $('#DOB').text(data[0].date_of_birth);
                $('#address').val(data[0].address);
                

                var pImages = data[0].images;
                pImagesA = pImages.replace('["', '');
                pImagesB = pImagesA.replace('"]', '');
                pImagesC = pImagesB.replace('","', ',').replace('"', '').replace('"', '');
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

            checkImageInput(actualBtn);

            var check = 0

            if (formChange) {

                var data = new FormData(this.form);
                var url = "{{ route('product.update') }}";

                $(".validate-input").each(function() {
                    if ($(this).val() == "") {
                        alert('Please fill the required information.');
                        check = 1;
                        return false;

                    }
                });

                if ($('.checkImg').attr('required')) {
                    alert('Please select the images.');
                    check = 1;
                    return false;
                }

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
                                Swal.fire('Product details updated!', '', 'success');
                                $('#closeBtn').trigger('click');

                            } else if (data == 0) {
                                Swal.fire('Failed to update.', '', 'info');
                            }
                        }
                    });

                    e.preventDefault();
                }
            } else {
                alert('Please make any changes');
                return false;
            }
        });

        pageReload();
        sweetPull();
    });
</script>




@endsection