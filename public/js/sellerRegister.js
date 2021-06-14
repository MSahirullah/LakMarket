
$(document).ready(function(){

    alertMSG = $('#regStatus').attr('dataMSG');
    alertID = $('#regStatus').attr('dataID');
    if(alertMSG){
        vanillaAlert(alertID, alertMSG);
    }

    $(".reg-button-2").click(function(){
        sendRegMail();
      });

    $('.button-3').click(function() {
        if($('#timer').text() == 0){
            sendRegMail();
        }
    });

    $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));
                
                if(prev.length) {
                    $(prev).select();
                }
            } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));
                
                if(next.length) {
                    $(next).select();
                } else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    $('.reg-button-3').click(function(){

        var digit_1 = $('#digit-1').val();
        var digit_2 = $('#digit-2').val();
        var digit_3 = $('#digit-3').val();
        var digit_4 = $('#digit-4').val();
        var digit_5 = $('#digit-5').val();
        var digit_6 = $('#digit-6').val();
        var email = $('#dataEmail').attr('data-email');

        if (digit_1 && digit_2 && digit_3 && digit_4 && digit_5 && digit_6){
            $.post($('#VerifyCodeSellerForm').attr('action'),
            {
                "_token": post_token,
                "digit_1" : digit_1,
                "digit_2" : digit_2,
                "digit_3" : digit_3,
                "digit_4" : digit_4,
                "digit_5" : digit_5,
                "digit_6" : digit_6,
                "email" : email,
            },
            function(data){
              vanillaAlert(data[0], data[1]);
              if(data[0] == 0){
                $('#personal').addClass('active');
                $('#accountTab').hide(500);
                $('#businessTab').show(500);
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }
            });
        }
    });

    alertMSG = $('#regStatus').attr('dataMSG');
    alertID = $('#regStatus').attr('dataID');
    if(alertMSG){
        vanillaAlert(alertID, alertMSG);
    }

    for(var i=60; i>=0; i--){
        $('#timer').val(i);
    }
    
    $('body:not(#corner-popup)').click(function(){
        $('#corner-popup').hide(); 
    });


    

    function autocomplete(inp, tmpParam ,arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /// RND Start

        inp.addEventListener("focusin", function(e) {

            if (tmpParam){
                arr = cities;
                var selectedDis = $("#reg-district").val();
                if (!selectedDis || !districts.includes(selectedDis)){
                    arr = [];
                    arr.push(" -- Please select district first -- ");
                    inp.val = null;
                }

            }

            $(`#${inp.id}-icon`).removeClass('fa-angle-down').addClass('fa-angle-up');
            $(`#${inp.id}`).addClass('data-focused');

            var a, b, i, val = this.value;
            currentFocus = -1;

            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", `autocomplete-items ${this.id}autocomplete-items`);

            this.parentNode.appendChild(a);

            for (i = 0; i < arr.length; i++) {
                if (arr[i] == " -- Please select district first -- "){
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                } else {
                    
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        b.addEventListener("click", function(e) {
                            var selectedDis = this.getElementsByTagName("input")[0].value;
                            inp.value = selectedDis;
                            if (!tmpParam){
                                getDistrictCities(selectedDis);
                            }
                            closeAllLists();
                        });
                    }
                }

                a.appendChild(b);
            }

        });
        
        inp.addEventListener('focusout',function(e) {
            
            var user_input_val = $(`#${inp.id}`).val();
            if (arr.includes(user_input_val)){
                inp.value = user_input_val
            }else {
                inp.value = null;
                if (!tmpParam){
                    $("#reg-hometown").val('');
                }
            }

            setTimeout(function(){
                closeAllLists();
            },150);

            setTimeout(function(){
                $(`#${inp.id}`).removeClass('data-focused');
            },500);

            $(`#${inp.id}-icon`).removeClass('fa-angle-up').addClass('fa-angle-down');

        });

        $(`#${inp.id}-icon`).unbind().click(function() {

            if (  $(`#${inp.id}`).hasClass('data-focused')){
                $(`#${inp.id}`).focusout();
            }else {
                $(`#${inp.id}`).focus();
            }
        });


        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            
            closeAllLists();
            
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", `autocomplete-items ${this.id}autocomplete-items`);
            this.parentNode.appendChild(a);

            if (!val) {
                for (i = 0; i < arr.length; i++) {

                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                        b.addEventListener("click", function(e) {
                            var selectedDis = this.getElementsByTagName("input")[0].value;
                            inp.value = selectedDis;
                            if (!tmpParam){
                                getDistrictCities(selectedDis);
                            }
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
                return false;
            }


            for (i = 0; i < arr.length; i++) {
                
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                    b.addEventListener("click", function(e) {
                        var selectedDis = this.getElementsByTagName("input")[0].value;
                        inp.value = selectedDis;
                        if (!tmpParam){
                            getDistrictCities(selectedDis);
                        }
                        closeAllLists();
                    });

                    a.appendChild(b);
                }
            }
        });

        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            
            var x = document.getElementsByClassName( `${inp.id}autocomplete-items`);

            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                }
            }
        }
    }

    var districts = []
    var districts_ids = []
    var cities = []

    cities.push(" -- Please select district first -- ")

    $.post('/register-district',{"_token": post_token},function(data){
        const iterator = data.values();

        for (const value of iterator) {
            districts_ids[value['name_en']] = value['id'];
            districts.push(value['name_en']);
        }
        
    });

    function getDistrictCities(dis_name){

        var dis_id = districts_ids[dis_name];
        cities = []

        $.post('/register-cities',{'dis_id': dis_id,"_token": post_token},function(data){
            const iterator = data.values();
            for (const value of iterator) {
                cities.push(value['name_en']);
            }

        });
    }

    autocomplete(document.getElementById("reg-district"),0, districts);
    autocomplete(document.getElementById("reg-hometown"),1, cities );


    $('#businessTab #sellerDeailsSubmit').click(function(){

        var validate = true;

        var full_name = $('#full-name').val();
        var business_name = $('#business-name').val();
        var selectCategory = $('#selectCategory').val();
        var bMobile = $('#bMobile').val();
        var bHotline = $('#bHotline').val();
        var address = $('#address').val();
        var reg_district = $('#reg-district').val();
        var reg_hometown = $('#reg-hometown').val();
        var location_lo = $('#storeLocation').attr('data-lo');
        var location_la = $('#storeLocation').attr('data-la');
        var cashOnDel = $('#cashOnDel').val();
        var email = $('#dataEmail').attr('data-email');

        if(full_name.length < 2 || address.length < 2){
            validate = false;
        }
        else if(business_name.length < 2){
            validate = false;
        }
        else if(bMobile.length < 10 ){
            validate = false;
        }
        else if(!(reg_district && reg_hometown)){
            validate = false;
        }


        if (validate){
            $.post($('#submitSellerDetails').attr('action'),
            {
                "_token": post_token,
                'full_name' :full_name,
                'business_name' :business_name,
                'selectCategory' :selectCategory,
                'bMobile' :bMobile,
                'bHotline' :bHotline,
                'address' :address,
                'reg_district' :reg_district,
                'reg_hometown' :reg_hometown,
                'location_la' :location_lo,
                'location_lo' :location_la,
                'cashOnDel': cashOnDel ,
                "email" : email,
            },
            function(data){
                vanillaAlert(data[0], data[1]);
              if(data[0] == 0){
                $('#confirm').addClass('active');
                $('#businessTab').hide(500);
                $('#confirmTab').show(500);
                $("html, body").animate({ scrollTop: 0 }, "slow");
              }
            });
        }else{

            $('#submitSellerDetails .sellerDeailsSubmitBtn').removeAttr('disabled');
            $('#submitSellerDetails .sellerDeailsSubmitBtn').click();
            $("html, body").animate({ scrollTop: 50 }, "slow");
            $('#submitSellerDetails .sellerDeailsSubmitBtn').attr('disabled', 'disabled');

        }
    })

});


var marker = false;

function initMap() {

    lo = $('#storeLocation').attr('data-lo');
    la = $('#storeLocation').attr('data-la');
    
    var centerOfMap = new google.maps.LatLng(lo, la);
    var map = new google.maps.Map(document.getElementById('storeLocation'), {
        center: centerOfMap,
        zoom: 12,
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
        position: new google.maps.LatLng( $('#storeLocation').attr('data-lo'), $('#storeLocation').attr('data-la')),
        map: map,
        draggable:true,
        title: ''
    });

    google.maps.event.addListener(_marker, 'dragend', function(marker) {
        var latLng = marker.latLng;
        $('#storeLocation').attr('data-lo', latLng.lat());
        $('#storeLocation').attr('data-la', latLng.lng());
     }); 
         
    _marker.setMap(map);

    google.maps.event.trigger(map, 'resize');
}



function sendRegMail(){
    var email = $('#sellerEmail').val();
    var email = $('#sellerEmail').val();

    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var value = re.test(String(email).toLowerCase());

    if(value){
        $.post($('#verifySellerForm').attr('action'),
        {
          "email" : email,
          "_token": post_token,
        },
        function(data){
          vanillaAlert(data[0], data[1]);
          if (data[0] == 0){
            
            var email = $('#sellerEmail').val();
              $('#dataEmail').attr('data-email', email);
              $('#sellerRegSub').hide();
              $('.button-3').attr('disabled', 'disabled');
              $('.timer').show();
              $('#timer').text(60);
              $('#sellerRegResend').show();
              var x = 1; 
              for(var i = 59; i>=0; i--){
                  x = x + 1;
                  delay(i, x);
              }
          
              function delay(i, x) {
                  setTimeout(() => {
                      $('#timer').text(i);
                  }, 1000 * x);
              }

              setTimeout(() => {
                $('.button-3').removeAttr('disabled');
                $('.timer').hide();
        
            }, 62000);

            $('#verifyCode').removeAttr('style');

            $("html, body").animate({ scrollTop: 280 }, "slow");
          }
        });
    }
    else{
        $('#verifySellerForm .seller-submit').removeAttr('disabled')
        $('#verifySellerForm .seller-submit').click();
        $('#verifySellerForm .seller-submit').attr('disabled', 'disabled');
    }
}

$('.map-span').click(function(){
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            $('#storeLocation').attr('data-la', position.coords.longitude);
            $('#storeLocation').attr('data-lo', position.coords.latitude);

            initMap();
        });
    } else {
        vanillaAlert(1, "Sorry, your browser does not support HTML5 geolocation.");
    }
})


