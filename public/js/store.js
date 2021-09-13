$(document).ready(function () {
  $('.search-tile-product-div-hr .search-product').mouseover(function () {
    $(".option-btn", this).show();
  });

  $('.search-tile-product-div-hr .search-product').mouseout(function () {
    $(".option-btn", this).hide();
  });

  $('.search-tile-product-div .search-product').mouseover(function () {
    $(".option-btn", this).show();
  });

  $('.search-tile-product-div .search-product').mouseout(function () {
    $(".option-btn", this).hide();
  });


  $('.list-view-btn').on('click', function () {
    $('.search-tile-product-div').hide();
    $('.search-tile-product-div-hr').show();
    $('.tile-view-btn i').removeClass('view-button-selected');
    $('.list-view-btn i').addClass('view-button-selected');
  });

  $('.tile-view-btn').on('click', function () {

    if (!$('.tile-view-btn i').hasClass('view-button-selected')) {


      $('.search-tile-product-div').show();
      $('.search-tile-product-div-hr').hide();
      $('.list-view-btn i').removeClass('view-button-selected');
      $('.tile-view-btn i').addClass('view-button-selected');

    }
  });

  $('#followBtn').click(function () {

    $.post("/follow/store",
      {
        store: $('#storeHome').attr('data-url'),
        _token: post_token,
      },
      function (data) {
        // console.log(data > $('#followers').text());
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
  })

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