@extends('seller.dashboard_layout')

@section('dahsboard_content')

<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>

<link href="{{ URL::asset('css/sellercss/stock.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/sellercss/products.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/loader.css') }}" rel="stylesheet">

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid content-wrapper-title">
            <h1 class="m-0">Manage Stocks</h1>
        </div>
    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="row title">
                <div class="col md-6 col-title">
                    <button class="title-summery" id="title-summery">
                        Stock Summery
                    </button>
                </div>
                <div class="col md-6">
                    <button class="title-all" id="title-all">
                        All Stock Details
                    </button>
                </div>
            </div>
            <div class="addNewBtn">
                <button data-toggle="modal" data-target=".bd-Add-modal" class="btn btn-success createBtn" target="modalAdd"><i class="fas fa-plus"></i>Add New Stock</button>
            </div>
            <div class="row" id="summery-stock">
                <div class="col md-12">
                    <table class="table table-bordered data-table-summery">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Last Added Date</th>
                                <th>Product Name</th>
                                <th>Color</th>
                                <th>Total Added Stock</th>
                                <th>Total Stock Usage</th>
                                <th>Available Stock</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row" id="all-stock">
                <div class="col md-12">
                    <table class="table table-bordered data-table-all">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Added Date</th>
                                <th>Product Name</th>
                                <th>Color</th>
                                <th>Added Stock</th>
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


<div class="modal fade bd-Add-modal" tabindex="-1" role="dialog" aria-labelledby="btnAdd" aria-hidden="true" id="modalAdd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('stock.add')}}" method="POST" enctype="multipart/form-data" id="detailsForm">
                @csrf
                <input type="hidden" name="sid" id="sid">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 modelAdd">

                        <div class="row">
                            <div class="col">
                                <label for="product" class="col-form-label">Product</label>
                                <span class="required"></span>
                                <select name="product" class="form-control btn-input" data-live-search="true" id="product" data-size="6">
                                    @foreach($stockdetails as $stock)
                                    <option>{{$stock->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" style="display: none;" id="colors_div">
                            <div class="col">
                                <label for="colors" class="col-form-label">Product Colors</label>
                                <span class="required"></span>
                                <select name="colors" class="form-control btn-input" id="colors" data-size="4">

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="stock" class="col-form-label">Stock</label>
                                <span class="required"></span>
                                <input name="stock" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="stock" maxlength="15" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeBtn" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary btnSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {


        $("#product").selectpicker();
        $("#colors").selectpicker();

        $('#product').selectpicker('val', '');
        $('#product').selectpicker('refresh');

        $('#product').change(function() {

            $.post("{{ route('stock.data') }}", {
                pName: $('#product').val(),
                _token: post_token
            }, function(data) {
                $('#colors_div').attr('style', 'display:none;');
                if (data != 0) {

                    data = data.replace(/\s/g, '').split(',');

                    $('#colors_div').removeAttr('style');
                    $('#colors').empty();
                    $.each(data, function(key, value) {
                        $('#colors').append('<option>' + value + '</option>');
                        console.log(value);
                    });
                    $("#colors").selectpicker('refresh');
                }

            });
        });

        $(document).on('click', '.removeBtn', function() {
            var sid = $(this).attr('data-id');

            deleteAction(sid, "{{ route('stock.destroy') }}", allTable)
        });

        function changeStatus(btn) {
            var sid = $(btn).attr('data-id');

            $.post("{{ route('stock.change') }}", {
                rowid: sid,
                _token: post_token
            }, function(dd) {
                if (dd == 1) {
                    if (allTable) {
                        allTable.ajax.reload();
                    } else if (summeryTable) {
                        summeryTable.ajax.reload();
                    }
                }
            });
        }

        $(document).on('click', '.stock-status', function() {
            changeStatus(this);
        });

        $(document).on('click', '.stock-status-oos', function() {
            changeStatus(this);
        });

        var summeryTable;
        $(document).on('click', '#title-summery', function() {

            $('#all-stock').hide()
            $('#summery-stock').show()

            $('#title-all').removeClass('selected-title');
            $('#title-summery').addClass('selected-title');

            $("#title-summery").attr('disabled', 'disabled');
            $("#title-all").removeAttr('disabled');

            if (!$.fn.dataTable.isDataTable('.data-table-summery')) {

                summeryTable = $('.data-table-summery').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": "{{ route('stock.list') }}" + '?type=' + 'summery-stock',
                    columns: [{
                            data: 'ids',
                            name: 'ids'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'product_name',
                            name: 'product_name'
                        },
                        {
                            data: 'product_color',
                            name: 'product_color'
                        },
                        {
                            data: 'added_stock',
                            name: 'added_stock'
                        },
                        {
                            data: 'stock_usage',
                            name: 'stock_usage'
                        },
                        {
                            data: 'available_stock',
                            name: 'available_stock',
                        },
                        {
                            data: 'outof_stock',
                            name: 'outof_stock'
                        }
                    ]
                });

            } else {

                summeryTable.ajax.reload();
            }
        });

        $("#title-summery").click();


        pageReload();
        sweetPull();

        var allTable;

        $(document).on('click', '#title-all', function() {

            $('#summery-stock').hide();
            $('#all-stock').show();

            $('#title-summery').removeClass("selected-title");
            $('#title-all').addClass("selected-title");

            $("#title-all").attr('disabled', 'disabled');
            $("#title-summery").removeAttr('disabled');

            if (!$.fn.dataTable.isDataTable('.data-table-all')) {

                allTable = $('.data-table-all').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": "{{ route('stock.list') }}" + '?type=' + 'all-stock',
                    columns: [{
                            data: 'ids',
                            name: 'ids'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'product_name',
                            name: 'product_name'
                        },
                        {
                            data: 'product_color',
                            name: 'product_color'
                        },
                        {
                            data: 'added_stock',
                            name: 'added_stock'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            } else {

                allTable.ajax.reload();
            }
        });

    });
</script>
<script script src="{{ asset('js/sellerjs/stock.js') }}" defer>
</script>
@endsection