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
  localStorage.setItem("pageView", view);

});

$('.tile-view-btn').on('click', function () {

  if (!$('.tile-view-btn i').hasClass('view-button-selected')) {
    $('.search-tile-product-div').show();
    $('#product-menu').hide();
    $('.list-view-btn i').removeClass('view-button-selected');
    $('.tile-view-btn i').addClass('view-button-selected');
    view = 'tile';
    localStorage.setItem("pageView", view);
    var pageView = localStorage.getItem("pageView");

  }
});

$('#sort-filter-select').change(function () {
  $('#loading').show();

  $('#temp1').attr('name')
  var data = $('#sort-filter-select').val()

  deliveryStatus = checkDeliveryStatus();

  $.post("/search/filter/sort-by",
    {
      sort: data,
      q: $('#searchP').attr('data-q'),
      deliveryStatus: deliveryStatus,
      category: $('#select-search-cato').val(),
      priceMin: $('#priceMin').val(),
      priceMax: $('#priceMax').val(),
      _token: post_token,
    },
    function (data) {
      $(".result-col .products").load(window.location.href + ".result-col .products");
      $(".result-col .products").remove();
      $(".result-col .products-menu").load(window.location.href + ".result-col .products-menu");
      $(".result-col .products-menu").remove();
      $('#product-menu').hide();
      showResult(data['products']);
      var pageView = localStorage.getItem("pageView");
      $('#loading').fadeOut("slow");
      if (pageView == 'list') {
        showListView();
      }
      localStorage.setItem("filters", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);
      localStorage.setItem("pageView", pageView);
    });
})


$('.delivery-check input[type="checkbox"]').change(function () {
  filterPOST(view)
});

$('#rangeBtn').click(function () {
  var price = 0.00;
  var priceMin = parseFloat($('#priceMin').val()).toFixed(2);
  var priceMax = parseFloat($('#priceMax').val()).toFixed(2);

  if (priceMin > 0 && priceMax > 0) {
    if ((!(priceMin >= 0 && priceMin <= 1000000)) || (!(priceMax >= 0 && priceMax <= 1000000))) {
      vanillaAlert(2, 'Price Range must be between Rs. 0.00 and Rs. 1000000.');
      return false;
    }
    if (priceMin > priceMax) {
      vanillaAlert(2, 'Please enter the price range correctly.');
      return false;
    }

    filterPOST(view)
  }
})

$('#clearFBtn').click(function () {
  $('#sort-filter-select').val('Best Match');
  $('#sort-filter-select').selectpicker('refresh');

  $('#paidDelivery').prop("checked", true)
  $('#cashOnDelivery').prop("checked", true)

  $('#priceMin').val('');
  $('#priceMax').val('');

  filterPOST(view)
})

if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
  var filters = localStorage.getItem("filters");
  var pageView = localStorage.getItem("pageView");
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

  filterPOST(pageView);
}

});


function filterPOST(view = 'tile') {
  $('#loading').show();
  $.post("/search/filter/",
    {
      sort: $('#sort-filter-select').val(),
      deliveryStatus: checkDeliveryStatus(),
      q: $('#searchP').attr('data-q'),
      category: $('#select-search-cato').val(),
      priceMin: $('#priceMin').val(),
      priceMax: $('#priceMax').val(),
      _token: post_token,
    },
    function (data) {
      $('#loading').fadeOut("slow");
      $("html, body").animate({ scrollTop: 0 }, 300);

      // $(".result-col .resultSummery").load(window.location.href + ".result-col .resultSummery");
      $(".result-col .resultSummery").remove();
      resultSummery(data['storeCount'], data['productCount'], data['q']);

      Result(data['productCount'], data['q'], data['stores'], data['products'], data['categories'], data['storeCount']);
      $('#product-menu').hide();

      if (view == 'list') {
        showListView();
      }

      localStorage.setItem("filters", [$('#select-search-cato').val(), $('#sort-filter-select').val(), checkDeliveryStatus(), $('#priceMin').val(), $('#priceMax').val()]);
      localStorage.setItem("pageView", view);
    });
}

function showListView() {
  $('.search-tile-product-div').hide();
  $('#product-menu').show();
  $('.tile-view-btn i').removeClass('view-button-selected');
  $('.list-view-btn i').addClass('view-button-selected');
  view = 'list';
  localStorage.setItem("pageView", view);
}



