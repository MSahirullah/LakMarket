<div class="site-wrapper">
    <!-- //Breadcrumb -->
    <div class="container c-p mb-0">
        <a href="#">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="#">Lak Market Shops</a>
        <i class="fas fa-chevron-right"></i>
        <a class="selected" href="#">Jayanthi Bookshop</a>

    </div>
    <div class="site-container container pl-0 pr-0 c-c-s-2">
        <div class="store-header-location">
            <div id="map"></div>
        </div>
        <div class="store-details-div">
            <div class="row store-details">
                <div class="col-md-c-1 store-logo">
                    <img src="https://picsum.photos/200" alt="store-logo">
                </div>
                <div class="col-md-7">
                    <div class="store-name">
                        <h2>Jayanthi bookshop</h2>
                    </div>
                    <div class="by-now-btn">
                        <button><i class="fas fa-user-plus" style="padding-right:5px;"></i>Follow</button>
                    </div>
                    <div class="store-follow">
                        <div class="followers"><i class="far fa-star"></i> <span>4000</span> followers</div>
                        <div><i class="fas fa-medal"></i> <span>95.5</span>% (<span>7854</span>) Positive Ratings.</div>
                    </div>
                    <div class="store-desc">
                        <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
                    </div>
                    <div class="col-md-10 store-search pr-0 pl-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search in Shop">
                            <div class=" input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search" style="padding-right: 5px;"></i>Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-c-4 store-contact">
                    <div class="store-since">Seller since January 2021</div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-phone-square-alt icon"></i>
                        </div>

                        <div class="col-sm pl-0 pr-0 contact-details">
                            <div class="item">+94 77 21 55 122</div>
                            <div class="item">+94 77 21 55 122</div>
                        </div>
                    </div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-map-marker-alt icon"></i>
                        </div>
                        <div class=" col-sm pl-0 pr-0 contact-details">
                            <div class="item">B/12, Owaththa, Hingula.</div>
                            <div class="location">
                                <a href="#"><i class="fas fa-location-arrow location-icon"> </i> Get Direction</a>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line"></div>
                    <div class="row contact mr-0 ml-0 mb-15">
                        <div class="col-sm-2 pl-0">
                            <i class="fas fa-envelope icon"></i>
                        </div>
                        <div class="col-sm pl-0 pr-0 contact-details">
                            <div class="item">testtestetstetstetstest@mwbook.com</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var marker = false;

        function initMap() {
            var lo = "7.8731";
            var la = "80.7718";

            var centerOfMap = new google.maps.LatLng(lo, la);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: centerOfMap,
                zoom: 15,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER,
                },
                scaleControl: true,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP,
                },
                fullscreenControl: true,
            });

            var _marker = new google.maps.Marker({
                position: centerOfMap,
                map: map,
                title: ''
            });

            _marker.setMap(map);
        }
    </script>