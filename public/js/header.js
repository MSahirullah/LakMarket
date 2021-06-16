$(document).ready(function () {

    alertMSG = $('#status').attr('dataMSG');
    alertID = $('#status').attr('dataID');
    if (alertMSG) {
        vanillaAlert(alertID, alertMSG);
    }

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 36) {
            $('#fixed-header').addClass('fixed-header');
            $('.site-container').css('margin-top', '140px');
        }
        else {
            $('#fixed-header').removeClass('fixed-header');
            $('.site-container').css('margin-top', '0px');
        }
    });

    $('.cato-link').mouseover(function () {
        $('.cato-link .fa-chevron-down').hide();
        $('.cato-link .fa-chevron-up').show();
        $('.cato-list').show();
    });

    $('.cato-link').mouseout(function () {

        $('.cato-link .fa-chevron-up').hide();
        $('.cato-link .fa-chevron-down').show();
        $('.cato-list').hide();

    });

    $('.cato-list').mouseout(function () {
        $('.cato-list').hide();
    });

    $(".location-select-div .sign-input").focusout(function () {
        if ($('#provinceS').val() == '') {
            $('#districtS').val(null);
            $('#cityS').val(null);
        }

        if ($('#districtS').val() == '') {
            $('#cityS').val(null);
        }

    });

    var open;
    $('#CityInputTxt').focus(function () {
        $('.location-select-div .row').show();
        $('.location-select-div').css({ "visibility": "visible", "opacity": "1" });
        open = 1;
    })

    $("body").click(function () {

        $('.location-select-div .row').hide();
        $('.location-select-div').css({ "visibility": "hidden", "opacity": "0" });
    })

    $('#CityInputTxt, .location-select-div').on('click', function (event) {
        event.stopPropagation();
    });


    $('.btn-close').click(function () {
        $('.location-select-div .row').hide();
        $('.location-select-div').css({ "visibility": "hidden", "opacity": "0" });
    });


});


function autocomplete(inp, tmpParam, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;


    inp.addEventListener("focusin", function (e) {

        if (tmpParam == 1) {
            arr = districts;
            var selectedPro = $("#provinceS").val();
            if (!selectedPro || !provinces.includes(selectedPro)) {
                arr = [];
                arr.push(" -Select province first- ");
                inp.val = null;
                $('#cityS').val(null);
                
            }


        }
        if (tmpParam == 2) {
            arr = cities;
            var selectedDis = $("#districtS").val();
            if (!selectedDis || !districts.includes(selectedDis)) {
                arr = [];
                arr.push(" -Select district first- ");
                inp.val = null;
            
            }
        }

        $(`.${inp.id}-icon`).removeClass('fa-angle-down').addClass('fa-angle-up');
        $(`#${inp.id}`).addClass('data-focused');

        var a, b, i, val = this.value;
        currentFocus = -1;

        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", `autocomplete-items ${this.id}autocomplete-items`);

        this.parentNode.appendChild(a);

        for (i = 0; i < arr.length; i++) {
            if (arr[i] == " -Select province first- ") {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

            } else if (arr[i] == " -Select district first- ") {
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
                    b.addEventListener("click", function (e) {
                        var selectedVal = this.getElementsByTagName("input")[0].value;
                        inp.value = selectedVal;

                        if (!tmpParam && !tmpParam == 1) {
                            getProvinceDistricts(selectedVal);
                        }
                        else if (tmpParam > 0) {
                            getDistrictCities(selectedVal);
                        }
                        closeAllLists();
                    });
                }

            }
            a.appendChild(b);
        }

    });

    inp.addEventListener('focusout', function (e) {

        var user_input_val = $(`#${inp.id}`).val();
        if (arr.includes(user_input_val)) {
            inp.value = user_input_val
        } else {
            inp.value = null;
            if (!tmpParam && !tmpParam == 1) {
                $("#districtS").val('');
            }
            else if (!tmpParam && !tmpParam == 2) {
                $("#cityS").val('');
            }
        }

        setTimeout(function () {
            closeAllLists();
        }, 150);

        setTimeout(function () {
            $(`#${inp.id}`).removeClass('data-focused');
        }, 500);

        $(`.${inp.id}-icon`).removeClass('fa-angle-up').addClass('fa-angle-down');

    });

    $(`.${inp.id}-icon`).unbind().click(function () {

        if ($(`#${inp.id}`).hasClass('data-focused')) {
            $(`#${inp.id}`).focusout();
        } else {
            $(`#${inp.id}`).focus();
        }
    });

    inp.addEventListener("input", function (e) {
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

                    b.addEventListener("click", function (e) {
                        var selectedVal = this.getElementsByTagName("input")[0].value;
                        inp.value = selectedVal;
                        if (!tmpParam && !tmpParam == 1) {
                            getProvinceDistricts(selectedVal);
                        }
                        else if (tmpParam > 0) {
                            getDistrictCities(selectedVal);
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

                b.addEventListener("click", function (e) {
                    var selectedVal = this.getElementsByTagName("input")[0].value;
                    inp.value = selectedVal;
                    if (!tmpParam && !tmpParam == 1) {
                        getProvinceDistricts(selectedVal);
                    }
                    else if (tmpParam > 0) {
                        getDistrictCities(selectedVal);
                    }
                    closeAllLists();
                });

                a.appendChild(b);
            }
        }
    });

    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
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

        var x = document.getElementsByClassName(`${inp.id}autocomplete-items`);

        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
}

var provinces = []
var province_ids = []
var districts = []
var districts_ids = []
var cities = []

cities.push(" -Select district first- ")
districts.push(" -Select province first- ")

$.post('/register-provinces', { "_token": post_token }, function (data) {
    const iterator = data.values();
    provinces.push("All Provinces");
    for (const value of iterator) {
        province_ids[value['name_en']] = value['id'];
        provinces.push(value['name_en']);
    }

});


function getProvinceDistricts(pro_name) {

    var pro_id = province_ids[pro_name];
    districts = []
    districts_ids = []

    $.post('/register-district-bid', { 'pro_id': pro_id, "_token": post_token }, function (data) {
        const iterator = data.values();
        districts.push("All Districts");
        for (const value of iterator) {
            districts_ids[value['name_en']] = value['id'];
            districts.push(value['name_en']);
        }

    });
}

function getDistrictCities(dis_name) {

    var dis_id = districts_ids[dis_name];
    cities = []

    $.post('/register-cities', { 'dis_id': dis_id, "_token": post_token }, function (data) {
        const iterator = data.values();
        cities.push("All Cities");
        for (const value of iterator) {
            cities.push(value['name_en']);
        }

    });
}

autocomplete(document.getElementById("provinceS"), 0, provinces);
autocomplete(document.getElementById("districtS"), 1, districts);
autocomplete(document.getElementById("cityS"), 2, cities);
//