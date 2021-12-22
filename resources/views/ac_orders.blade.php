@extends('layouts.app')


@section('css')
<link href="{{ URL::asset('css/myaccount.css') }}" rel="stylesheet">
@endsection

@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection

@section('content')


<div class="site-wrapper pt-16 deals">

    <div class="container c-p">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected">My Account</a>
    </div>

    <div class="site-container container bg-w">
        <div class="row account-content">
            <div class="col-md-2 cp-tb-75 title-div pr-0 pl-0">
                {{View::make('myaccount_header')}}
            </div>
            <div class=" col-md-10 cp-tb-75">
                <div class="big-title-div">
                    Orders
                </div>
                <div class="inner-hr"></div>
                <div class="sorter d-flex">
                    <div class="p-3 topic">Awaiting payment (0)</div>
                    <div class="p-3 topic">Awaiting shipment (0)</div>
                    <div class="p-3 topic">Awaiting delivery (0)</div>
                </div>
                <div class="inner-hr"></div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var type = '<?php echo $type ?>';

        $(".title-div").find(".subtitle-link").each(function() {
            if ($(this).attr('data-type') == type) {
                var parent = $(this).parent().parent();
                $(parent).append('<div class="selected-subtitle"></div>');
                $(parent).addClass('selected-subtitle-c');
            }
        });
    });
</script>

<script src="{{ asset('js/myaccount.js') }}" defer></script>
@endsection