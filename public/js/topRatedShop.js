$(document).ready(function () {
    $('li').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

});


function filterPOST() {
    $('#loading').show();
    $.post("/top-rated-shops/filter/",
        {
            deliveryStatus: checkDeliveryStatus(),
            _token: post_token,
        },
        function (data) {
            $('#loading').fadeOut("slow");
            $("html, body").animate({ scrollTop: 0 }, 300);

            resultSummery(data['storesCount'], data['q']);
            resultData(data['storesCount'], data['title'], data['stores']);
        }
    );
}


