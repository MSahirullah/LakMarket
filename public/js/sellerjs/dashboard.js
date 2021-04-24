$(document).ready(function(){

  sellerName = $('#seller-name').attr('data-name');
  $('.online-seller-name').html(sellerName);

  sellerImage = $('#seller-name').attr('data-image');
  $('#user-profile-photo').attr('src', sellerImage);

  $('#sideBarToggle').click(function(){

    var sidebar_status = 0;

    if($(this).attr('data-toggle-status') == "0"){
      sidebar_status = 1;
    }

    $.post("/seller/dashboard/change-sidebar-status",
    {
    status : sidebar_status,
    _token: post_token
    },
    function(){
    });

  });

});

function ocMiniSideMenu() {
    
    $("#sideMenu").toggleClass("menu-collapse");
    if ($("#sideMenu").hasClass("menu-collapse")) {
      
      $("body").addClass("menu-collapse-width-status");   

      setTimeout(function () {
        $("body").addClass("menu-collapse-state");   
      }, 250);

    } else {
      $("body").removeClass("menu-collapse-width-status");   
      
      setTimeout(function () {
        $("body").removeClass("menu-collapse-state");   
      }, 150);
      
    }
  }
