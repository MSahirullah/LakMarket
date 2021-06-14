@extends('admin.dashboard_layout')

@section('dahsboard_content')
<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>



<div class="content-wrapper">
            <div class="content-header">      
                <div class="container-fluid">
                    <h1 class="m-0">Customers</h1>
                </div>
            </div>
                

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">full name</th>
                                <th scope="col">email</th>
                                <th scope="col">phone number</th>
                                <th scope="col">blacklisted</th>
                                <th scope="col">edit</th>
                                <th scope="col">blacklist</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $row)
                            <tr>
                                <th scope="row">{{$row->id}}</th>
                                <td>{{$row->full_name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->mobile_no}}</td>
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

