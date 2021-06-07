

function configOwl(item_2, item_3, time_1, time_2) {
    return({
          loop: true,
          margin: 10,
          nav: false,
          autoplayTimeout: time_1,
          autoplay: true,
          autoplaySpeed:time_2,
          responsiveClass: true,
          autoplayHoverPause:true,
          responsive: {
          0: {
              items: 1,
          
          },
          600: {
              items: item_2,
          },
          900: {
              items: item_3,
          }}
          });
}

function acceptOnlyNumber(){
    $(this).keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
        }
        });
};

function vanillaAlert(inp, msg, time = 6000){

    var title = ['Success!','Error!','Warning!','Information!'];
    var type = ['success', 'error', 'warning','info'];
    var icon = ['success.png', 'error.png', 'warning.png', 'info.png']
    var path = '/img/alert-logo/';

    VanillaToasts.create({
        title: title[inp],
        text: msg,
        type: type[inp], 
        icon: path + icon[inp], 
        timeout: time
        // callback: function() { ... } // executed when toast is clicked / optional parameter
      });
}


