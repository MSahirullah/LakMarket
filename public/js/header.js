
$(document).ready(function () {


    checkCartStatus();

    // $.post("/customer-product-categories", {
    //     "_token": post_token,
    //     "location": $('#CityInputTxt').val()
    // },
    //     function (data) {
    //         $.each(data, function (index, value) {
    //             $('#select-search-cato').append('<option value="' + value.id + '">' + value.name + '</option>');

    //         });
    //         $('#select-search-cato').selectpicker('refresh');
    //     });

    if ($('#searchCato').attr('data-cato')) {
        $('#select-search-cato').val($('#searchCato').attr('data-cato'));
        $('#select-search-cato').selectpicker('refresh');
    }

    $('#searchP').focusout(function () {
        setTimeout(() => {
            $('#searchPautocomplete-list').hide();
        }, 100);
    });


    $('.search-input').focus(function () {
        if ($('.select-cato').hasClass('show')) {
            $('.select-cato button').trigger('click');
        }
    })

    // $('#searchP').change(function () {
    //     setTimeout(() => {
    //         $('#searchSubmitBtn').trigger('click');
    //     }, 100);
    // });

    $('.search-btn').click(function () {

        if (!$('#searchP').val() == '') {
            setTimeout(() => {
                $('#searchSubmitBtn').trigger('click');
            }, 100);
        }

    });



    $(document).on('click', '.selected-search', function () {
        setTimeout(() => {
            $('#searchSubmitBtn').trigger('click');
        }, 100);
    })

    $('#searchP').keyup(function (e) {
        if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            setTimeout(() => {
                $('#searchSubmitBtn').trigger('click');
            }, 100);
        }

    })

    alertMSG = $('#status').attr('dataMSG');
    alertID = $('#status').attr('dataID');
    if (alertMSG) {
        vanillaAlert(alertID, alertMSG);
    }

    $('.btn-locate').click(function () {

        var pro = $('#provinceS').val();
        var dis = $('#districtS').val();
        var cit = $('#cityS').val();
        var data = []
        var statusVal = -1;

        //Select the product for all provinces
        if (!(pro) || pro == 'All Provinces') {
            statusVal = 0;
            data.push('allP');
        }

        //Select the product for specific province and all district
        else if (pro != 'All Provinces' && (!(dis) || dis == 'All Districts')) {
            statusVal = 1;
            data.push(pro, 'allD');
        }

        //Select the product for specific province and specific district and all cities
        else if (pro != 'All Provinces' && (dis && dis != 'All Districts') && (!(cit) || cit == 'All Cities')) {
            statusVal = 2;
            data.push(pro, dis, 'allC');
        }

        //Select the product for specific province and specific district and all cities
        else if (pro != 'All Provinces' && (dis && dis != 'All Districts') && (cit && cit != 'All Cities')) {
            statusVal = 3;
            data.push(pro, dis, cit);
        }

        var jsondata = JSON.stringify(data);

        $.post("/customer-location-change", {
            "_token": post_token,
            'data': jsondata
        },
            function (data) {

                if (data) {
                    location.reload(true);
                }
                else {
                    vanillaAlert(1, 'Something went wrong. Please try again later.');
                }
            });
    });

    //         



    // if ($('#locationData').attr('data-pro') != '0') {
    //     $('#provinceS').val($('#locationData').attr('data-pro'));
    //     autocomplete(document.getElementById("provinceS"), 0, provinces);

    // }
    // if ($('#locationData').attr('data-dis') != '0') {
    //     $('#districtS').val($('#locationData').attr('data-dis'));
    //     autocomplete(document.getElementById("provinceS"), 0, provinces);
    //     autocomplete(document.getElementById("districtS"), 1, districts);
    // }
    // if ($('#locationData').attr('data-cit') != '0') {
    //     $('#cityS').val($('#locationData').attr('data-cit'));
    //     autocomplete(document.getElementById("provinceS"), 0, provinces);
    //     autocomplete(document.getElementById("districtS"), 1, districts);
    //     autocomplete(document.getElementById("cityS"), 2, cities);
    // }


    $(window).scroll(function () {
        if ($(window).scrollTop() >= 36) {
            $('#fixed-header').addClass('fixed-header');
            $('.site-container').css('margin-top', '140px');
            $('#loading').addClass('loader-top');

        }
        else {
            $('#fixed-header').removeClass('fixed-header');
            $('.site-container').css('margin-top', '0px');
            $('#loading').removeClass('loader-top');
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

    // $('#select-search-cato').change(function () {
    //     cato = $(this).val();
    //     getSearchProducts(' ', cato);
    // });

    $('#select-search-cato').on('show.bs.select', function () {
        $('.location-select-div .row').hide();
        $('#searchPautocomplete-list').hide();
        $('.location-select-div').css({ "visibility": "hidden", "opacity": "0" });
        $('#city-angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
    });

    $('#CityInputTxt').focus(function () {
        $('.location-select-div .row').show();
        if ($('.select-cato').hasClass('show')) {
            $('.select-cato button').trigger('click');
        }
        $('.location-select-div').css({ "visibility": "visible", "opacity": "1" });
        $('#city-angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
    })

    $("body").click(function () {

        $('.location-select-div .row').hide();
        $('.location-select-div').css({ "visibility": "hidden", "opacity": "0" });
        $('#city-angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
    })

    $('#CityInputTxt, .location-select-div').on('click', function (event) {
        event.stopPropagation();
    });


    $('.btn-close').click(function () {
        $('.location-select-div .row').hide();
        $('.location-select-div').css({ "visibility": "hidden", "opacity": "0" });
        $('#city-angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
    });

    $('.location-select-div .btn-home').click(function () {
        $.post("/customer-location-reset", {
            "_token": post_token,
        },
            function (data) {
                if (data) {
                    location.reload(true);
                }
                else {
                    vanillaAlert(1, 'Something went wrong. Please try again later.');
                }
            });
    })
    autocompleteLocation(document.getElementById("provinceS"), 0, provinces);
    autocompleteLocation(document.getElementById("districtS"), 1, districts);
    autocompleteLocation(document.getElementById("cityS"), 2, cities);

    autocompleteSearch(document.getElementById("searchP"));


});


function autocompleteLocation(inp, tmpParam, arr) {
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



function autocompleteSearch(inp) {

    var currentFocus;
    var executed = false;
    if (!executed) {
        executed = true;
        arr = getSearchProducts($('#searchP').val(), 'All Categories');
    }

    inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        var cato = $('#select-search-cato').val();

        closeAllLists();

        if (!val) { return false; }

        currentFocus = -1;

        data = getSearchProducts(val, cato);
        arr = data[0];
        arrId = data[1];

        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        this.parentNode.appendChild(a);

        for (i = 0; i < arr.length; i++) {

            // if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            b = document.createElement("DIV");
            b.innerHTML = arr[i];
            b.classList.add('selected-search');

            b.innerHTML += "<input type='hidden' class='searchAutocomplete-ID' data-id='" + arrId[i] + "' value='" + arr[i] + "'>";

            b.addEventListener("click", function (e) {
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
            });
            a.appendChild(b);
        }
    });

    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) { //down
            currentFocus++;
            addActive(x);

        } else if (e.keyCode == 38) { //up
            currentFocus--;
            addActive(x);

        } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    // document.addEventListener("click", function (e) {
    //     closeAllLists(e.target);
    // });
}

var proNames = []
var proId = []

function getSearchProducts(value, category) {
    var val = '';
    if (value) {
        val = value;
    }


    $.ajax({
        'async': false,
        'type': "GET",
        'url': "/customer-search-products",
        "contentType": "application/json",
        'data': { "term": val, 'category': category },

        'success': function (data) {

            const iterator = data.values();
            proNames = [];
            proId = [];
            for (var value of iterator) {
                if (!proNames.includes(value['name'])) {

                    proNames.push(value['name']);
                    proId.push(value['id']);
                }
            }
        }
    });
    // $.get("/customer-search-products", {
    //     "term": val,
    //     'category': category
    // },
    //     function (data) {

    //         const iterator = data.values();
    //         for (var value of iterator) {

    //             if (!proNames.includes(value['name'])) {

    //                 proNames.push(value['name']);
    //                 proId.push(value['id']);
    //             }
    //         }
    //     });
    return [proNames, proId];
}
