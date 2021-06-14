$(document).ready(function(){

  sellerName = $('#seller-name').attr('data-name');
  $('.online-seller-name').html(sellerName);

  sellerImage = $('#seller-name').attr('data-image');
  if (sellerImage == '/'){
    $('#user-profile-photo').attr('src', '/img/seller-temp.png');
  }else{
    $('#user-profile-photo').attr('src', sellerImage);
  }

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
  function toggleFullscreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
      !document.webkitFullscreenElement && !document.msFullscreenElement) {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
      } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    }
  }
  value = 0;
  document.getElementById('btnFullscreen').addEventListener('click', function() {

    if (value == 0){
      
      $('#fullScreenIcon').removeClass('fas fa-expand-arrows-alt');
      $('#fullScreenIcon').addClass('fas fa-compress-arrows-alt');
      value = 1;
    }
    else{

      $('#fullScreenIcon').removeClass('fas fa-compress-arrows-alt');
      $('#fullScreenIcon').addClass('fas fa-expand-arrows-alt');
      value = 0;
    }

    toggleFullscreen();
  });