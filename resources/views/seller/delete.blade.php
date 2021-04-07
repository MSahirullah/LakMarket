@extends('seller.dashboard_layout')

@section('dahsboard_content')

@if(Session::has('message'))
<p class="alert alert-danger">{{ session()->get('message') }}</p>
@endif

@endsection