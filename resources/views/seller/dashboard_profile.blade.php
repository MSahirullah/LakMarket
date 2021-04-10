@extends('seller.dashboard_layout')

@section('dahsboard_content')
<link href="{{ URL::asset('css/sellercss/profile.css') }}" rel="stylesheet">
<span id="updateStatus" {{ Session::has('updateStatus') ? 'data-updateStatus' : '' }} data-updateStatus-value='{{ Session::get('updateStatus') }}'>
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Seller Profile</h1>
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
                            <img class="profile-pic" src="{{$sellerData->profile_photo}}">
                            <div class="p-image">
                                <i class="fa fa-camera upload-button"></i>
                                <form action="profile/change-profile-image" enctype="multipart/form-data" method="post" id="profile_form">
                                    @csrf
                                    <input name="profile_photo" class="file-upload profile_img" type="file" accept="image/*" id="profile_photo" />
                                    <button type="submit" style="display: none;" id="profile_submit"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="pro-store-det">
                            <table class="basic-details-table">
                                <tr>
                                    <th>Store Name</th>
                                    <td id="store_name">{{$sellerData->store_name}}</td>
                                </tr>
                                <tr>
                                    <th>Owner Name</th>
                                    <td id="store_owner">{{$sellerData->full_name}}</td>
                                </tr>
                                <tr>
                                    <th>Shop Category</th>
                                    <td id="store_category">{{$sellerData->shop_category_name}}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td id="store_city">{{$sellerData->city}}</td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td id="store_district">{{$sellerData->district}}</td>
                                </tr>
                                <tr>
                                    <th>Store Image</th>
                                    <td id="store_image">
                                        <img class="store-image" src="{{$sellerData->store_image}}">
                                        <i class="far fa-image change_store_img"></i>
                                        <form action="profile/change-store-image" enctype="multipart/form-data" method="post" id="store_form">
                                            @csrf
                                            <input name="store_image" id="stpre_image" class="store-img-input" type="file" accept="image/*" id="store_image" />
                                            <p>Note : Store image size should be 1000px(width) and 500px(height)</p>
                                            <button type="submit" style="display: none;" id="store_submit"></button>
                                        </form>
                                    </td>
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
                                    <th>Business Email</th>
                                    <td id="business_email">{{$sellerData->business_email}}</td>
                                </tr>
                                <tr>
                                    <th>Business Mobile</th>
                                    <td id="store_owner_val">{{$sellerData->business_mobile}}</td>
                                </tr>
                                <tr>
                                    <th>Hotline</th>
                                    <td id="store_category">{{$sellerData->hotline}}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td id="store_district">{{$sellerData->address}}</td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td id="store_city">tets</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="more-desc">
                        <span>Note: If you need to change any other details, please contact the administrator.</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        //Sweet alert for profile picture update record
        $(document).ready(function() {

            $.ajax({
                url: "/seller/dashboard/profile/clear-session",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                method: 'post',
                success: function() {
                }
            });

            function sweetalert(type, msg) {
                Swal.fire({
                    icon: type,
                    title: msg,
                    showConfirmButton: true,
                    timer: 3000
                })
            }

            var sweetPull = (function() {
                var notificationStatus = $('#updateStatus').attr('data-updateStatus');

                if (typeof notificationStatus === 'undefined') {
                    return false;

                } else {
                    var status = $('#updateStatus').attr('data-updateStatus-value');
                    var types = ['success', 'warning'];

                    if (status == '1') {
                        type = types[0];
                        message = 'Profile picture updated!';

                    } else if (status == '11') {
                        type = types[0];
                        message = 'Store image updated!';
                    } else {
                        type = types[1];
                        message = 'Something went wrong. Please try again later!';
                    }
                }
                sweetalert(type, message);
            })
            sweetPull();
        })
    </script>

    <script src="{{ asset('js/sellerjs/profile.js') }}" defer></script>
    @endsection