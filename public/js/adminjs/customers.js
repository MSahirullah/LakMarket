$(document).ready(function () {

    selectTitle('#sidebarMenuCustomers');
      $('#name').keyup(function (e) {
          var lng = $(this).val().length;
          document.getElementById("name_len").innerHTML = lng;
      })
      $('#short_desc').keyup(function (e) {
          var lng = $(this).val().length;
          document.getElementById("short_desc_len").innerHTML = lng;
      })
      $('#long_desc').keyup(function (e) {
          var lng = $(this).val().length;
          document.getElementById("long_desc_len").innerHTML = lng;
      })

       $(".createBtn").click(function () {
          $("#detailsForm .modal-body input, #detailsForm .modal-body full_name").val('');
          $('#Full_name, #phone_number, #address').val('');
          $('#email,#DOB,#ad-password').removeAttr('disabled');
          $('#modalLabel').text($(this).attr('data-title'));
          $('.btnSubmit').text($(this).attr('data-button'));
          $('.btnSubmit').attr('id', $(this).attr('data-button'));
          $('.linkedin-col').hide();
          $('.password-col').show();
         });

        $('#createBtn1, .pass-generate').click(function(){
          $('#ad-password').val(randomPass()); 
        });

});


function randomPass(){
    var lowercase = "abcdefghijklmnopqrstuvwxyz".split("");
    var uppercase = "ABCDEFGHIJKLMNOPWRSTUVWXYZ".split("");
    var numbers = "0123456789".split("");
    var symbols = "!@#$%^&*".split("");

    var low = true;
    var up = true;
    var num = true;
    var sym = true;
    var length = 10;


  var dictionary = [].concat(
    low ? lowercase : [],
    up ? uppercase : [],
    num ? numbers : [],
    sym ? symbols : []
  );
 
  var pw = "";
  for (var i = 0; i < length; i++) {
    pw += dictionary[Math.floor(Math.random() * dictionary.length)];
  }

return pw;

}