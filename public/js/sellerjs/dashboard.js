function ocMiniSideMenu() {
    $("#sideMenu").toggleClass("menu-collapse");
    if ($("#sideMenu").hasClass("menu-collapse")) {
      $("#sideMenu").attr("style", "width:4.6rem;");
      
      setTimeout(function () {
        
        $(".menu-collapse .nav-link p, .brand-text, .online-seller-name, .online-status, .online-status-seller").hide();
        $("#sideMenu .nav-link").attr("style", "width:56px;");
      }, 300);

      $("#bodyContent .main-header, #bodyContent .content-wrapper, #bodyContent .main-footer").attr("style", "margin-left:4.6rem;");

    } else {

      $("#sideMenu .nav-link").attr("style", "width:234px;");
      $("#sideMenu").attr("style", "width:250px;");

      $("#bodyContent .main-header, #bodyContent .content-wrapper, #bodyContent .main-footer").attr("style", "margin-left:250px;");
      
      setTimeout(function () {
        
        $(".nav-link p, .brand-text, .online-seller-name, .online-status, .online-status-seller").show();
        
      }, 150);

      
    }
  }

