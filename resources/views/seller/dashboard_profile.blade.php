@extends('seller.dashboard_layout')

@section('dahsboard_content')
<link href="{{ URL::asset('css/sellercss/profile.css') }}" rel="stylesheet">
<span id="actionStatus" {{ Session::has('alert') ? 'data-status' : '' }} data-status-alert='{{ Session::get('alert') }}' data-status-message='{{ Session::get('message') }}'></span>


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
                                <th>Birthday</th>
                                <td id="seller_birthday">{{$sellerData->birthday}}</td>
                            </tr>
                            <tr>
                                <th>Delivering Districts</th>
                                <td id="seller_birthday">{{$sellerData->delivering_districts}}
                                    <i class="fas fa-edit dd-edit"></i>
                                </td>
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
                                <td>{{$sellerData->business_mobile}}</td>
                            </tr>
                            <tr>
                                <th>Hotline</th>
                                <td>
                                    {{$sellerData->hotline}}
                                    <i class="fas fa-edit hotline-edit"></i>
                                </td>
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
                                <th>Address</th>
                                <td>{{$sellerData->address}}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td id="store_location">
                                    <div id="map"></div>
                                </td>
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



<!-- Button trigger modal -->
<button type="button" id="edit_profile_details" data-toggle="modal" data-target="#editProfileDetails" style="display: none;">
</button>

<!-- Modal -->
<div class="modal fade" id="editProfileDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" enctype="multipart/form-data" method="post" id="sellerDetailForm">
                @csrf
                <div class="modal-body">
                    <div class="row delivery-districts-row">
                        <div class="col">
                            <label for="delivery_districts" class="col-form-label">Category</label>
                            <span class="required"></span>
                            <select name="delivery_districts[]" class="form-control btn-input" data-live-search="true" id="delivery_districts" multiple>
                                <option class="all-island" selected>All Island</option>
                                @foreach($districtsData as $district)
                                <option class="{{$district->name_en}}">{{$district->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row hotline-row">
                        <div class="col">
                            <label for="hotline" class="col-form-label">Hotline</label>
                            <input name="hotline" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" class="form-control p-input" id="hotline" pattern="{0-9}{1}[0-8]{1}[0-9]{7}" style="padding-left: 40px;" maxlength="9">
                            <span class="mob-contry-code">+94</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary button-1" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary button-2" id="_submit-temp">Update</button>
                    <button type="submit" style="display:none;" id="_submit"></button>
            </form>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $("#delivery_districts").selectpicker();

        pageReload();

        sweetPull();

        $('.hotline-edit').on('click', function() {

            var hotline = "<?php echo $sellerData->hotline; ?>"
            $('#hotline').val(hotline.slice(3, ));

            $('.delivery-districts-row').hide();
            $('.hotline-row').show();
            $('.modal-title').text('Edit Hotline');
            $('#edit_profile_details').trigger('click');
        });

        $('.dd-edit').on('click', function() {

            var district = "<?php echo $sellerData->delivering_districts; ?>"

            district = district.split(", ");

            $('#delivery_districts').selectpicker('val', district);
            $('#delivery_districts').selectpicker('refresh');

            $('.hotline-row').hide();
            $('.delivery-districts-row').show();
            $('.modal-title').text('Edit Delivering Districts');
            $('#edit_profile_details').trigger('click')
            $('#_submit-temp').addClass('district-submit')
        });
    });

    $('#_submit-temp').on('click', function(e) {

        e.preventDefault();

        if ($(this).hasClass('district-submit')) {

            var district = $('#delivery_districts').val();
            var sdd = "<?php echo $sellerData->delivering_districts; ?>";

            $('#hotline').removeAttr('required');

            if (district != sdd) {
                $('#sellerDetailForm').attr('action', 'profile/change-delivery-districts');
                $('#_submit').trigger('click');
            } else {
                alert("Please make any changes.");
                $('select').val('');
            }

        } else {

            $('#sellerDetailForm').attr('action', 'profile/change-hotline');
            var hotline = '+94' + $('#hotline').val();
            var ht = "<?php echo $sellerData->hotline; ?>";
            $('#hotline').attr('required', 'required');

            if (hotline) {
                if (hotline.length <= 9) {
                    $('#hotline').val('');
                } else if (hotline == ht) {
                    alert("Please make any changes.");
                    $('#hotline').val('');
                }
                $('#_submit').trigger('click');
            }
        }
    });

    $('select').on('change', function() {

        var check = 0;

        if ($('#bs-select-1-0').hasClass('selected')) {

            $('#delivery_districts').selectpicker('val', 'All Island');
            $('#delivery_districts').selectpicker('refresh');
        }

        $("#delivery_districts option").each(function() {
            if ($(this).is(':selected') && $('#bs-select-1-0').hasClass('selected')) {
                check++;
            }
        })


        $("#delivery_districts option").each(function() {

            var id = $('option').attr('class');

            if ($(this).is(':selected') && !$('#bs-select-1-0').hasClass('selected')) {
                check++;
            }
        });


        if (check == 25) {
            $('#delivery_districts').selectpicker('val', 'All Island');
            $('#delivery_districts').selectpicker('refresh');
        }
    });

    var marker = false;

    function initMap() {
        var lo = "<?php echo $sellerData->longitude; ?>";
        var la = "<?php echo $sellerData->latitude; ?>";

        var centerOfMap = new google.maps.LatLng(lo, la);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: centerOfMap,
            zoom: 12
        });

        var _marker = new google.maps.Marker({
            position: centerOfMap,
            map: map,
            title: ''
        });

        _marker.setMap(map);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQxriVKFmURanWzX7-k-WG1gdN30drD4&callback=initMap&libraries=&v=weekly" async></script>
<script src="{{ asset('js/sellerjs/profile.js') }}" defer></script>

@endsection