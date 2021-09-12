@extends('seller.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>
<span id="last_data" data-last-cato="{{ Session::has('last_data') ? Session::get('last_data')[0]  : '' }}" data-last-type="{{ Session::has('last_data') ? Session::get('last_data')[1] : '' }}"> </span>

<link href="{{ URL::asset('css/sellercss/products.css') }}" rel="stylesheet">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid content-wrapper-title">
            <h1 class="m-0">Manage Products</h1>
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
                                <th>Images</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>COD Status</th>
                                <th>Colors</th>
                                <th>Discount(%)</th>
                                <!-- <th>Tax(%)</th> -->
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
                    <h5 class="modal-title" id="modalLabel">Add New Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="product_category" class="col-form-label">Category</label>
                                <span class="required"></span>
                                <select name="product_category" class="form-control btn-input" data-live-search="true" id="product_category" data-size="8">
                                    @foreach($catogeries as $catogery)
                                    <option>{{$catogery->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="code" class="col-form-label">Code</label>
                                <span class="required"></span>
                                <input type="text" name="code" class="form-control p-input" id="code" required maxlength="20" />
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
                                <span class="char-len">(<span id="name_len">0</span>/70)</span>
                                <input type="text" required name="name" class="form-control p-input validate-input" id="name" maxlength="70">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="images" class="col-form-label">Images</label>
                                <span class="required"></span><br>

                                <input type="file" id="images" hidden multiple accept="image/*" name="images[]" />

                                <label for="images" class="col-form-label labelimg">Choose images</label><br>
                                <span id="file-chosen">No file chosen.</span>

                                <!-- <input type="text" oninvalid="this.setCustomValidity('Please select the images.')" oninput="setCustomValidity('')" class="checkImg" value="0" name="0"> -->
                                <input type="text" class="checkImg" value="111" name="0">

                            </div>
                            <div class="col-md-9 imgShow p-input">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="short_desc" class="col-form-label">Short Description</label>
                                <span class="required"></span>
                                <span class="char-len">(<span id="short_desc_len">0</span>/200)</span>
                                <textarea rows="4" required name="short_desc" class="form-control p-input validate-input" id="short_desc" maxlength="200"></textarea>
                            </div>
                            <div class="col-md-7">
                                <label for="long_desc" class="col-form-label">Full Description</label>
                                <span class="char-len">(<span id="long_desc_len">0</span>/5000)</span>
                                <textarea rows="4" name="long_desc" class="form-control p-input" id="long_desc" maxlength="5000"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="unit_price" class="col-form-label">Unit Price</label>
                                <span class="required"></span>
                                <input name="unit_price" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="text" onkeypress="return  /^[0-9]*\.?[0-9]*$/i.test(event.key)" class="form-control p-input validate-input" id="unit_price" maxlength="10" placeholder="0.00" />
                                <span class="money-sign">Rs.</span>
                            </div>
                            <div class="col">
                                <label for="discount" class="col-form-label">Discount (%)</label>
                                <input type="text" name="discount" class="form-control p-input" id="discount" placeholder="0.00" maxlength="5" onkeypress="return  /^[0-9]*\.?[0-9]*$/i.test(event.key)">
                            </div>
                            <!-- <div class="col-md-4">
                                <label for="tax" class="col-form-label">Tax (%)</label>
                                <input type="text" name="tax" class="form-control p-input" id="tax" placeholder="0.00" maxlength="5" onkeypress="return  /^[0-9]*\.?[0-9]*$/i.test(event.key)">
                            </div> -->
                        </div>
                        <div class="row">
                            <div class=" {{Session::has('sessellerDelivery') == '1' ? 'col-md-8' : 'col' }}">
                                <label for="colors" class="col-form-label">Colors</label>
                                <input type="text" name="colors" class="form-control p-input" id="colors" maxlength="100" placeholder="Black, Red, White, Blue...">
                            </div>

                            @if(Session::has('sessellerDelivery') == '1')
                            <div class="col-md-4">
                                <div class="custom-control custom-switch cod-div">
                                    <input type="checkbox" class="custom-control-input" id="pCOD" checked name="pCOD" value="1">
                                    <label class="custom-control-label" for="pCOD">Cash On Delivery Available</label>
                                    <span class="required"></span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeBtn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnSubmit">Save</button>
                    <button type="submit" style="display: none;"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {

        $("#product_category").selectpicker();

        $('#pCOD').change(function() {
            if ($(this).is(':checked')) {
                $('#pCOD').val(1);

            } else {
                $('#pCOD').val(0);

            }
        });

        $("input[type='text']").on("click", function() {
            $(this).select();
        });

        $("#type").selectpicker();

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.list') }}",
            columns: [{
                    data: 'ids',
                    name: 'ids'
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
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'cod',
                    name: 'cod'
                },
                {
                    data: 'colors',
                    name: 'colors'
                },

                {
                    data: 'discount',
                    name: 'discount'
                },
                // {
                //     data: 'tax',
                //     name: 'tax'
                // },
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

        $('#product_category').selectpicker('val', $('#last_data').attr('data-last-cato'));
        $('#product_category').selectpicker('refresh');

        $('#type').selectpicker('val', $('#last_data').attr('data-last-type'));
        $('#type').selectpicker('refresh');


        //Sweet alert for remove record
        $(document).on('click', '.removeBtn', function() {
            var pid = $(this).attr('data-id');


            deleteAction(pid, "{{ route('product.destroy') }}", table)
        });

        var formChange = false;
        const actualBtn = document.getElementById('images');

        $(document).on('click', '.editBtn', function() {

            var pid = $(this).attr('data-id');
            if ($('#pCOD').is(':checked')) {
                $('#pCOD').trigger('click');
            }

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
                $('#name').val(data[0].name);
                $('#short_desc').text(data[0].short_desc);
                $('#long_desc').text(data[0].long_desc);
                $('#unit_price').val(data[0].unit_price);
                // $('#tax').val(data[0].tax);
                $('#discount').val(data[0].discount);

                $('#pCOD').removeAttr('checked');
                if (data[0].cod == '1') {
                    $('#pCOD').trigger('click');
                }

                $('#colors').val(data[0].colors);

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
                data.append('pCOD', $('#pCOD').val());


                var url = "{{ route('product.update') }}";

                $(".validate-input").each(function() {
                    if ($(this).val() == "") {
                        vanillaAlert(2, 'Please fill the required information.');
                        check = 1;
                        return false;

                    }
                });

                if ($('#file-chosen').text() == 'No file chosen.') {
                    vanillaAlert(2, 'Please select the images.');
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
                                // Swal.fire('', '', 'success');
                                vanillaAlert(0, 'Product details updated!');
                                $('#closeBtn').trigger('click');

                            } else if (data == 0) {
                                vanillaAlert(1, 'Failed to update.');
                                // Swal.fire('', '', 'info');
                            }
                        }
                    });

                    e.preventDefault();
                }
            } else {
                vanillaAlert(2, 'Please make any changes');
                return false;
            }
        });

        pageReload();
        sweetPull();
    });
</script>
<script src="{{ asset('js/sellerjs/products.js') }}" defer></script>



@endsection