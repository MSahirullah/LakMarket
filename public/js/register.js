
$(document).ready(function(){

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

        $(`.${inp.id}-icon`).removeClass('fa-angle-down').addClass('fa-angle-up');
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

        $(`.${inp.id}-icon`).removeClass('fa-angle-up').addClass('fa-angle-down');

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


$('.button-reg-1').click(function() {

    var password1 = $('#password').val();
    var password2 = $('#confirm-password').val();

    if (password1 != password2) {

        $('#confirm-password').attr('type', 'text');
        $('#confirm-password').val('');
        $('#confirm-password').attr('type', 'password');
    }
    else{
        
    }
    $('#form-submit').trigger("click");
});


$(".toggle-password").click(function() {

    var input = $($(this).attr("toggle"));
    if ($(input).val()){
        $(this).toggleClass("fa-eye fa-eye-slash");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    }
});

});

function loginCall(){
    window.location.href='/login';
}