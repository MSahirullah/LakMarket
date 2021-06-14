@extends('admin.dashboard_layout')

@section('dahsboard_content')
<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>



<div class="content-wrapper">
            <div class="content-header">      
                <div class="container-fluid">
                    <h1 class="m-0">Sellers</h1>
                </div>
            </div>
                

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Full name</th>
                                <th scope="col">store name</th>
                                <th scope="col">business email</th>
                                <th scope="col">hotline</th>
                                <th scope="col">business mobile</th>
                                <th scope="col">delivering districts</th>
                                <th scope="col">blacklisted</th>
                                <th scope="col">edit</th>
                                <th scope="col">blacklist</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sellers as $row)
                            <tr>
                                <th scope="row">{{$row->id}}</th>
                                <td>{{$row->full_name}}</td>
                                <td>{{$row->store_name}}</td>
                                <td>{{$row->business_email}}</td>
                                <td>{{$row->hotline}}</td>
                                <td>{{$row->business_mobile}}</td>
                                <td>{{$row->delivering_districts}}</td>
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

