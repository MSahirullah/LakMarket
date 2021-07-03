$(document).ready(function(){
    $('.search-tile-product-div-hr .search-product').mouseover(function(){
    $(".option-btn", this).show();
    });

    $('.search-tile-product-div-hr .search-product').mouseout(function(){
    $(".option-btn", this).hide();
    });

    $('.search-tile-product-div .search-product').mouseover(function(){
        $(".option-btn", this).show();
    });

    $('.search-tile-product-div .search-product').mouseout(function(){
    $(".option-btn", this).hide();
    });

  
      $('.list-view-btn').on('click', function(){
        $('.search-tile-product-div').hide();
        $('.search-tile-product-div-hr').show();
        $('.tile-view-btn i').removeClass('view-button-selected');
        $('.list-view-btn i').addClass('view-button-selected');
      });
  
      $('.tile-view-btn').on('click', function(){
        
        if(!$('.tile-view-btn i').hasClass('view-button-selected')){
          
  
          $('.search-tile-product-div').show();
          $('.search-tile-product-div-hr').hide();
          $('.list-view-btn i').removeClass('view-button-selected');
          $('.tile-view-btn i').addClass('view-button-selected');
  
        }
      });
});