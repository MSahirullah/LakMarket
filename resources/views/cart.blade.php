@extends('layouts.app')

@section('css')
<link href="{{ URL::asset('/css/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="site-wrapper pt-16">
    <!-- //Breadcrumb -->
    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">My Cart</a>
    </div>
    <div class="site-container container bg-w mt-22">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active" id="orderSummery"><span>Order Summery</span></li>
            <li id="deliveryInfo"><span>Delivery Information</span></li>
            <li id="paymentOption"><span>Payment Option</span></li>
            <li id="finish"><span>Finish</span></li>
        </ul>
        <hr>

        

    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/categories.js') }}" defer></script>
@endsection