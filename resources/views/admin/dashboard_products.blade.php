@extends('admin.dashboard_layout')

@section('dahsboard_content')
<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>


<div class="content-wrapper">
            <div class="content-header">      
                <div class="container-fluid">
                    <h1 class="m-0">Products</h1>
                </div>
            </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">code</th>
                                <th scope="col">seller_id</th>
                                <th scope="col">product_catrgory_id</th>
                                <th scope="col">name</th>
                                <th scope="col">unit_price</th>
                                <th scope="col">tax</th>
                                <th scope="col">discount</th>
                                <th scope="col">blacklisted</th>
                                <th scope="col">edit</th>
                                <th scope="col">blacklist</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $row)
                            <tr>
                                <th scope="row">{{$row->code}}</th>
                                <td>{{$row->seller_id}}</td>
                                <td>{{$row->product_catrgory_id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->unit_price}}</td>
                                <td>{{$row->tax}}</td>
                                <td>{{$row->discount}}</td>
                                <td>{{$row->blacklisted}}</td>
                                <td><a href='#' class="btn btn-success">edit</td>
                                <td><a href='#' class="btn btn-danger">blacklist</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</div>
@endsection

