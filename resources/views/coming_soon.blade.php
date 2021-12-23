@extends('layouts.app')

@section('title')
Lak Market : 1st Online Shopping Master Market In Sri Lanka | Buy Online | Buy Genuine | Buy NearBy |
@endsection

@section('css')
<style>
    .img-div {
        background-image: url('/img/coming-soon.png');
        background-repeat: no-repeat;
        background-size: 32rem;
        margin-top: 4rem;
    }

    .cs-text {
        font-family: 'Ubuntu', sans-serif;
        padding: 8rem 1rem 10rem 3rem;
    }

    .cs-text-1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .cs-text-2 {
        font-size: 2rem;
        font-weight: 500;
    }

    .cs-text-3 {
        font-size: 2.9rem;
        font-weight: 700;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
@endsection

@section('content')

<div class="site-wrapper pt-16 ">
    <div class="container site-container">
        <div class="row">
            <div class="col-md-6">
                <div class="cs-text">
                    <span class="cs-text-1">
                        Sorry!
                    </span><br>
                    <span class="cs-text-2">
                        This Page is
                    </span><br>
                    <span class="cs-text-3">
                        Under Construction.
                    </span><br>
                </div>
            </div>

            <div class="col-md-6 img-div"></div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script>
    $(document).ready(function() {
        var status = '<?php echo $status ?>';
        var msg = '<?php echo $msg ?>';

        if (status != '-') {
            vanillaAlert(status, msg);
        }
    });
</script>

@endsection