@extends('seller.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>

<link href="{{ URL::asset('css/sellercss/categories.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/sellercss/products.css') }}" rel="stylesheet">

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid content-wrapper-title">
            <h1 class="m-0">Manage Categories</h1>
        </div>
    </div>

    <div class="addNewBtn">
        <button data-toggle="modal" data-button="Save" data-title="Add New Category Details" data-target=".bd-AddEdit-modal-lg" class="btn btn-success createBtn" target="modalAddEdit"><i class="fas fa-plus"></i>Add New Category</button>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col md-12">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Action</t>
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
            <form action="{{route('categories.add')}}" method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="cid" id="cid">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Category Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">
                        <div class="row">
                            <div class="col">
                                <label for="name" class="col-form-label">Category Name</label>
                                <span class="required"></span>
                                <input type="text" required name="name" class="form-control p-input validate-input" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="image" class="col-form-label">Image</label>
                                <br>

                                <input type="file" id="image" hidden accept="image/*" name="image" />

                                <label for="image" class="col-form-label labelimg">Choose an image</label><br>
                                <span id="file-chosen">No file chosen</span>


                            </div>
                            <div class="col-md-9">
                                <div class="imgShow"></div>
                                <p class="note">Note : Category image size should be 1000px(width) and 500px(height)</p>
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
    $(document).ready(function() {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.list') }}",
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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        //Sweet alert for remove record
        $(document).on('click', '.removeBtn', function() {
            var cid = $(this).attr('data-id');

            deleteAction(cid, "{{ route('categories.destroy') }}", table)
        });

        var formChange = false;
        const actualBtn = document.getElementById('image');

        $(document).on('click', '.editBtn', function() {
            var cid = $(this).attr('data-id');
            $('#cid').val(cid);

            $.post("{{ route('categories.details') }}", {
                rowid: cid,
                _token: "{{ csrf_token() }}"

            }, function(data) {

                $('#name').val(data[0].name);

                $('.imgShow').html('');
                $("#file-chosen").html('No file chosen');

                if (data[0].image) {

                    $("#file-chosen").html('1 image chosen.');

                    var img = $("<img />");
                    img.attr("class", "uploaded-image");
                    img.attr("src", "/" + data[0].image);
                    $('.imgShow').append(img);
                    $("#file-chosen").attr('data-uploded', 1);

                }
            });

            $('#detailsForm').on('keyup change paste', 'input, select', function() {
                formChange = true;
            });
            actualBtn.addEventListener('change', function() {
                formChange = true;
            });
        });

        pageReload();
        sweetPull();

        $(document).on('click', '#Update', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var check = 0

            if (formChange) {
                // var cid = $('.editBtn').attr('data-id');
                var data = new FormData(this.form);
                var url = "{{ route('categories.update') }}";

                if ($('.validate-input').val() == "") {
                    alert('Please fill the required information.');
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
                                Swal.fire('Category details updated!', '', 'success');
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


    });
</script>
<script src="{{ asset('js/sellerjs/categories.js') }}" defer></script>

@endsection