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
        <button data-button="Save" data-title="Add New Category Details" class="btn btn-success createBtn"><i class="fas fa-plus"></i>Add New Category</button>
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

<div class="modal fade bd-AddEdit-modal" tabindex="-1" role="dialog" aria-labelledby="btnAddEdit" aria-hidden="true" id="modalAddEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('categories.add')}}" method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="cid" id="cid">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Category Details</h5>
                    <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAddEdit">
                        <div class="row">
                            <div class="col">
                                <label for="categoryName" class="col-form-label">Category Name</label>
                                <span class="required"></span>
                                <select name="categoryName[]" required class="form-control p-input btn-input validate-input" data-live-search="true" id="categoryName" multiple data-size="8">
                                    @if(!empty(json_decode($categories, true)))
                                    @foreach($categories as $category)
                                    <option>{{$category->name}}</option>
                                    @endforeach
                                    @else
                                    <option disabled>No more categories</option>
                                    @endif
                                </select>

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

        $('#closeModal, #closeBtn').click(function() {
            $("#modalAddEdit").modal('hide');
        })

        $("#categoryName").selectpicker();

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
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });


        $('.createBtn').click(function() {
            $('#ModalLabel').text($(this).attr('data-title'));
            $('.btnSubmit').attr('id', '');
            $('#categoryName').selectpicker('refresh');
            $('.bd-AddEdit-modal').modal('show');
        });


        var selectedValue;
        //Sweet alert for remove record
        $(document).on('click', '.removeBtn', function() {
            var cid = $(this).attr('data-id');
            deleteAction(cid, "{{ route('categories.destroy') }}", table)
        });

        pageReload();
        sweetPull();


    });
</script>
<script src="{{ asset('js/sellerjs/categories.js') }}" defer></script>

@endsection