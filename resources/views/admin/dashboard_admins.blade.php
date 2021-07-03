@extends('admin.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>
<link href="{{ URL::asset('css/admincss/admin.css') }}" rel="stylesheet">


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manage Admins</h1>
        </div>
    </div>

    <div class="addNewBtn">
        <button data-toggle="modal" data-button="Save" data-title="Add New Product Details" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit"><i class="fas fa-plus addNewBtn"></i>Add New Admins</button>

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
            <form action="{{route('admin.add')}}" method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="pid" id="pid">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">

                        <div class="row">
                            <div class="col">
                                <label for="first_name" class="col-form-label">First name</label>
                                <span class="required"></span>
                                <input type="text" required name="first_name" class="form-control p-input validate-input" id="first_name">
                            </div>
                            <div class="col">
                                <label for="last_name" class="col-form-label">Last name</label>
                                <span class="required"></span>
                                <input type="text" required name="last_name" class="form-control p-input validate-input" id="last_name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email" class="col-form-label">email</label>
                                <span class="required"></span>
                                <input type="email" required name="email" class="form-control p-input validate-input" id="email">
                            </div>
                            <div class="col">
                                <label for="phone_number" class="col-form-label">phone number</label>
                                <span class="required"></span>
                                <input type="number" required name="phone_number" class="form-control p-input validate-input" id="phone_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="date_of_birth" class="col-form-label">date_of_birth</label>
                                <span class="required"></span>
                                <input type="date" required name="date_of_birth" class="form-control p-input validate-input" id="date_of_birth">
                            </div>
                            <div class="col">
                                <label for="password" class="col-form-label">password</label>
                                <span class="required"></span>
                                <input type="password" required name="password" class="form-control p-input validate-input" id="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="address" class="col-form-label">address</label>
                                <textarea rows="4" name="address" class="form-control p-input" id="address"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="role" class="col-form-label">role</label>
                                <input type="text" name="role" class="form-control p-input" id="role">
                            </div> 
                            <div class="col">
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

            deleteAction(pid, "{{ route('admin.destroy') }}", table)
        });

        /* var formChange = false;
        const actualBtn = document.getElementById('images'); */

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