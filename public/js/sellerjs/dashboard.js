$(document).ready(function () {

  alertMSG = $('#status').attr('dataMSG');
  alertID = $('#status').attr('dataID');
  if (alertMSG) {
    vanillaAlert(alertID, alertMSG);
  }

  sellerName = $('#seller-name').attr('data-name');
  $('.online-seller-name').html(sellerName);

  sellerImage = $('#seller-name').attr('data-image');

  $('#user-profile-photo').attr('src', '/img/seller-temp.png');
  if (sellerImage == '/') {
    $('#user-profile-photo').attr('src', '/img/seller-temp.png');
  } else {
    $('#user-profile-photo').attr('src', sellerImage);
  }

  $('#sideBarToggle').click(function () {

    var sidebar_status = 0;

    if ($(this).attr('data-toggle-status') == "0") {
      sidebar_status = 1;
    }

    $.post("/seller/dashboard/change-sidebar-status",
      {
        status: sidebar_status,
        _token: post_token
      },
      function () {
      });

  });

  $('#changeThePassword .btn-submit').click(function () {

    var cP = $('#changeThePassword #current-password').val();
    var nP = $('#changeThePassword #new-password').val();
    var nCP = $('#changeThePassword #confirm-password').val();

    const pattern = /(?=.*[a-z])(?=.*[A-Z]).{8,}/;

    if (cP && pattern.test(nP)) {
      if (nP == nCP) {

        $('.mismatch-msg').attr('style', 'display:none;');

        $.post("/seller/dashboard/profile/change-password",
          {
            cP: cP,
            nP: nP,
            _token: post_token
          },
          function (data) {
            vanillaAlert(data[0], data[1]);
            if (data[0] == 0) {
              $('#changeThePassword .close').click();
            }
          });

      } else {

        $('#changeThePassword #confirm-password').val('');
        $('.mismatch-msg').removeAttr('style');
        $('.mismatch-msg').text("Passwords must be match.");
      }

    } else {
      $('#form-submit').trigger("click");
    }

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
document.getElementById('btnFullscreen').addEventListener('click', function () {

  if (value == 0) {

    $('#fullScreenIcon').removeClass('fas fa-expand-arrows-alt');
    $('#fullScreenIcon').addClass('fas fa-compress-arrows-alt');
    value = 1;
  }
  else {

    $('#fullScreenIcon').removeClass('fas fa-compress-arrows-alt');
    $('#fullScreenIcon').addClass('fas fa-expand-arrows-alt');
    value = 0;
  }

  toggleFullscreen();
});

$(".toggle-password").click(function () {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

