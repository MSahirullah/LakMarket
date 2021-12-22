@extends('admin.dashboard_layout')

@section('dahsboard_content')
<link href="{{ URL::asset('css/admincss/profile.css') }}" rel="stylesheet">
<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>


<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Admin Profile</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="profile-title">
                    <span>Basic Details</span>
                </div>
            </div>
            <div class="row profile-content">
                <div class="col-sm-3">
                    <div class="pro-pic circle">
                        <img class="profile-pic" src="{{$AdminData->profile_photo}}">
                        <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>
                            <form action="profile/change-profile-image" enctype="multipart/form-data" method="post" id="profile_form">
                                @csrf
                                <input name="profile_photo" class="file-upload profile_img" type="file" accept="image/*" id="profile_photo" />

                                @error('profile_photo')
                                    <span id="pPStatus" data-status-message='{{ $message }}'></span>
                                @enderror

                                <button type="submit" style="display: none;" id="profile_submit"></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="pro-store-det">
                        <table class="basic-details-table">
                            <tr>
                                <th>Full Name</th>
                                <td id="admin_name">{{$AdminData->full_name}}</td>
                            </tr>
                            <tr>
                                <th>Birthday</th>
                                <td id="admin_birthday">{{$AdminData->date_of_birth}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="profile-title">
                    <span>Contact Details</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="pro-con-det">
                        <table class="basic-contact-table">
                            <tr>
                                <th>Personal Email</th>
                                <td id="personal_email">{{$AdminData->email}}</td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td>{{$AdminData->phone_number}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$AdminData->address}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>



<!-- Button trigger modal -->
<button type="button" id="edit_profile_details" data-toggle="modal" data-target="#editProfileDetails" style="display: none;">
</button>




<script type="text/javascript">
    $(document).ready(function() {


    });

    var msg = $('#pPStatus').attr('data-status-message');

    if(msg){
        alert(msg);

    }




</script>

/* @endsection */

@section('scripts')
<script src="{{ asset('js/adminjs/profile.js') }}" defer></script>
@endsection
