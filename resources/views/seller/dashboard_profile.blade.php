@extends('seller.dashboard_layout')

@section('dahsboard_content')

<span id="seller-name" data-name='{{Session::get('sellerName')}}' data-image='{{Session::get('sellerImage')}}'></span>

<span>{{Session::get('addNewStatus')}}</span>

@endsection