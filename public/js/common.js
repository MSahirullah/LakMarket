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