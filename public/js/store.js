$(document).ready(function () {

  $('#sort-filter-select').selectpicker();

  $(document).on('mouseover', '.search-product', function () {
    $(".option-btn", this).show();
  })

  $(document).on('mouseout', '.search-product', function () {
    $(".option-btn", this).hide();
  })


  $('li').click(function () {
    $(this).addClass('active').siblings().removeClass('active');
  });

  $('#product-menu').hide();

  var view = 'list';

  $('.list-view-btn').on('click', function () {
    showListView();
    localStorage.setItem("pageViewStore", 'list');

  });

  $('.tile-view-btn').on('click', function () {

    if (!$('.tile-view-btn i').hasClass('view-button-selected')) {
      $('.search-tile-product-div').show();
      $('#product-menu').hide();
      $('.list-view-btn i').removeClass('view-button-selected');
      $('.tile-view-btn i').addClass('view-button-selected');
      localStorage.setItem("pageViewStore", 'tile');
      var pageView = localStorage.getItem("pageViewStore");
    }
  });

  $('#sort-filter-select').change(function () {
    $('#loading').show();

    var data = $('#sort-filter-select').val()

    deliveryStatus = checkDeliveryStatus("#paidDeliveryStore", "#cashOnDeliveryStore");

    var cato = $('#catoSelected').attr('sCato');
    var q = $('#storeSearchQ').val();

    var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
    var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

    if (isNaN(priceMin))
      priceMin = 0.0;
    if (isNaN(priceMax))
      priceMax = 1000000.0;

    $.post("/store/product/filter/",
      {
        storeId: $('#storeD').attr('sid'),
        sort: data,
        deliveryStatus: deliveryStatus,
        priceMin: priceMin,
        priceMax: priceMax,
        cato: cato,
        q: q,
        _token: post_token,
      },
      function (data) {
        $("#result-col .products").load(window.location.href + "#result-col .products");
        $("#result-col .products").remove();
        $("#result-col .products-menu").remove();
        $('#product-menu').hide();

        showResult(data['products']);
        var pageView = localStorage.getItem("pageViewStore");
        $('#loading').fadeOut("slow");
        if (pageView == 'list') {
          showListView();
        }
        localStorage.setItem("filtersInStore", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);
        localStorage.setItem("pageViewStore", pageView);
      });
  })

  $('.delivery-check input[type="checkbox"]').change(function () {
    filterPOST(550);
  });

  $('#rangeBtn2').click(function () {

    var price = 0.00;
    var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
    var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

    if (isNaN(priceMin))
      priceMin = 0.0;
    if (isNaN(priceMax))
      priceMax = 1000000.0;

    if (priceMin => 0 && priceMax > 0) {

      if ((!(priceMin >= 0 && priceMin <= 1000000)) || (!(priceMax >= 0 && priceMax <= 1000000))) {
        vanillaAlert(2, 'Price Range must be between Rs. 0.00 and Rs. 1000000.');
        return false;
      }
      if (priceMin > priceMax) {
        vanillaAlert(2, 'Please enter the price range correctly.');
        return false;
      }
      filterPOST(550)
    }
  })

  $('#clearFBtn').click(function () {
    $('#sort-filter-select').val('Best Match');
    $('#sort-filter-select').selectpicker('refresh');

    $('#paidDelivery').prop("checked", true)
    $('#cashOnDelivery').prop("checked", true)

    $('#priceMin').val('');
    $('#priceMax').val('');

    filterPOST(550)
  })

  if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    var filters = localStorage.getItem("filtersInStore");
    var pageView = localStorage.getItem("pageViewStore");
    filters = filters.split(',');

    $('#sort-filter-select').val(filters[1]);
    $('#sort-filter-select').selectpicker('refresh');

    if (filters[2] == '3') {
      $('#paidDelivery').prop("checked", true);
      $('#cashOnDelivery').prop("checked", true);
    }
    if (filters[2] == '0') {
      $('#paidDelivery').prop("checked", false);
      $('#cashOnDelivery').prop("checked", false);
    }
    else if (filters[2] == '1') {
      $('#paidDelivery').prop("checked", true);
      $('#cashOnDelivery').prop("checked", false);
    }
    else if (filters[2] == '2') {
      $('#paidDelivery').prop("checked", false);
      $('#cashOnDelivery').prop("checked", true);
    }

    $('#priceMin').val(filters[3]);
    $('#priceMax').val(filters[4]);

    filterPOST();
  }

  $('#searchSubmitBtnTemp').click(function (e) {
    e.preventDefault();
    if ($('#storeSearchQ').val() != '') {
      $('#storeSearchSubmitBtn').trigger('click');
    }
  });

});

function filterPOST(top = 0) {
  $('#loading').show();

  var cato = $('#catoSelected').attr('sCato');
  var q = $('#storeSearchQ').val();

  var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
  var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

  if (isNaN(priceMin))
    priceMin = 0.0;
  if (isNaN(priceMax))
    priceMax = 1000000.0;

  $.post("/store/product/filter/",
    {
      sort: $('#sort-filter-select').val(),
      storeId: $('#storeD').attr('sid'),
      deliveryStatus: checkDeliveryStatus("#paidDeliveryStore", "#cashOnDeliveryStore"),
      priceMin: priceMin,
      priceMax: priceMax,
      cato: cato,
      q: q,
      _token: post_token,
    },
    function (data) {
      $('#loading').fadeOut("slow");
      $("html, body").animate({ scrollTop: top }, 300);

      Result(data['products']);

      $('#product-menu').hide();

      var pageView = localStorage.getItem("pageViewStore");

      if (pageView == 'list') {
        showListView();
      }

      localStorage.setItem("filtersInStore", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus("#paidDeliveryStore", "#cashOnDeliveryStore"), $('#priceMin').val(), $('#priceMax').val()]);
      localStorage.setItem("pageViewStore", pageView);
    });
}

function showListView() {
  $('.search-tile-product-div').hide();
  $('#product-menu').show();
  $('.tile-view-btn i').removeClass('view-button-selected');
  $('.list-view-btn i').addClass('view-button-selected');
  view = 'list';
  localStorage.setItem("pageViewStore", view);
}






























//follow button 
$('#followBtn').click(function () {

  $.post("/follow/store",
    {
      store: $('#storeHome').attr('data-url'),
      _token: post_token,
    },
    function (data) {

      if (data != -1) {
        if (data < $('#followers').text()) {
          $('#followBtn').removeClass('followed');
          $('#followBtnTxt').text('Follow');
          vanillaAlert(0, 'You have unfollowed ' + $('#storeHome').text());
        }
        else {
          $('#followBtn').addClass('followed');
          $('#followBtnTxt').text('Followed');
          vanillaAlert(0, 'You have followed ' + $('#storeHome').text());
        }
        $('#followers').text(data);

      } else {
        vanillaAlert(1, 'Something went wrong. Please try again later');
      }
    });
});

function selectText(containerid) {
  if (document.selection) { // IE
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select();
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
  }
}