jQuery(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
  jQuery("select").select2();
  });

jQuery(document).ready(function () {
  jQuery(".slider_3").not(".slick-initialized").slick({
    dots: true,
    arrows: true,
    autoplay: true,
    swipeToSlide: true,
    infinite: false,
    autoplaySpeed: 5000,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [
        {
          breakpoint: 1240,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 900,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 630,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
});
 


//инициализируем галерею ДО запуска слайдера
var gallery = $('.slide a');
//при клике на ссылку в слайде запускаем галерею
$('.slide a').on('click', function(e) {
  e.preventDefault();
  //узнаём индекс слайда без учёта клонов
  var totalSlides = +$(this).parents('.slider').slick("getSlick").slideCount,
      dataIndex = +$(this).parents('.slide').data('slick-index'),
      trueIndex;
  switch(true){
    case (dataIndex<0):
      trueIndex = totalSlides+dataIndex; break;
    case (dataIndex>=totalSlides):
      trueIndex = dataIndex%totalSlides; break;
    default: 
      trueIndex = dataIndex;
  }  
  //вызывается элемент галереи, соответствующий индексу слайда
  $.fancybox.open(gallery,{}, trueIndex);
  return false;
});

$('.slider').slick({
  slidesToShow: 1,
  arrows: true,
  dots: true,
  customPaging: function() {
    return ''
  }
});
});


jQuery(document).ready(function(){

    // кабинет продавца
    jQuery('.item_data_order_open').click(function(e){
      if (jQuery(this).hasClass('open')) {
          jQuery(this).removeClass('open');
      }
      else {
      jQuery(this).addClass('open');
      }
      e.preventDefault();
    });

    // Все локации
    jQuery('.more_location').click(function(e){
      if (jQuery('.all_location').hasClass('open')) {
          jQuery('.all_location').removeClass('open');
      }
      else {
      jQuery('.all_location').addClass('open');
      }
      e.preventDefault();
    });

    // моб меню 
    jQuery('.menu_toggle').click(function(e){
      if (jQuery('body').hasClass('menu_toggled')) {
          jQuery('body').removeClass('menu_toggled');
      }
      else {
      jQuery('body').addClass('menu_toggled');
      }
      e.preventDefault();
    });

    jQuery('body').mouseup( function(e){ 
      var div = jQuery(".menu-target");
      if ( !div.is(e.target)
        && div.has(e.target).length === 0 ) {
          jQuery('body').removeClass('menu_toggled');
      }
    });

    // моб меню 
    jQuery('.aside_toggle').click(function(e){
      if (jQuery('body').hasClass('aside_toggled')) {
          jQuery('body').removeClass('aside_toggled');
      }
      else {
      jQuery('body').addClass('aside_toggled');
      }
      e.preventDefault();
    });


});
// на верх 
jQuery(document).ready(function() {
  var btn = $('.to-top');  
  $(window).scroll(function() {     
    if ($(window).scrollTop() > 300) {
       btn.addClass('show');
     } else {
       btn.removeClass('show');
     }
   });
   btn.on('click', function(e) {
     e.preventDefault();
     $('html, body').animate({scrollTop:0}, '300');
   });
});