$(document).ready(function () {
      $('li').click(function () {
            $(this).addClass('active').siblings().removeClass('active');
      });

      if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            var SCfilters = localStorage.getItem("SCfilters");
            var SC = localStorage.getItem("SC");


            if (SCfilters == '3') {
                  $('#paidDelivery').prop("checked", true);
                  $('#cashOnDelivery').prop("checked", true);
            }
            if (SCfilters == '0') {
                  $('#paidDelivery').prop("checked", false);
                  $('#cashOnDelivery').prop("checked", false);
            }
            else if (SCfilters == '1') {
                  $('#paidDelivery').prop("checked", true);
                  $('#cashOnDelivery').prop("checked", false);
            }
            else if (SCfilters == '2') {
                  $('#paidDelivery').prop("checked", false);
                  $('#cashOnDelivery').prop("checked", true);
            }

            filterPOST(SC);
      }

});


function filterPOST(q) {
      $('#loading').show();
      $.post("/category/filter/",
            {
                  deliveryStatus: checkDeliveryStatus(),
                  q: q,
                  _token: post_token,
            },
            function (data) {
                  $('#loading').fadeOut("slow");
                  $("html, body").animate({ scrollTop: 0 }, 300);

                  resultSummery(data['storesCount'], data['q']);
                  resultData(data['storesCount'], data['q'], data['categories'], data['stores']);

                  localStorage.setItem("SCfilters", checkDeliveryStatus());
            }
      );
}


