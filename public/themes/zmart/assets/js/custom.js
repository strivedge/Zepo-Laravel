/* Menu Hover
  ------------------------------------------------------------- */
  $(document).ready(function(){   
      $('#primary-menu li.parent').on('mouseenter',function(){
        $(this).find(".sub-menu").fadeIn();
        $(this).addClass('active');
      });
      $('#primary-menu li.parent').on('mouseleave',function(){
        $(this).find(".sub-menu").fadeOut();
        $(this).removeClass('active');
      });

      /*$(".hamburger-wrapper").click(function() {
        $( "#top" ).insertAfter( ".menu-primary-menu-container ul#primary-menu" );
      });*/
      
  $('.our-customer-content').slick({
      infinite: false,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        dots: false,
        autoplay : true,
        autoplaySpeed:5000,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });  
  $('.addtocart').slick({
    infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: true,
        dots: false,
        autoplay : true,
        autoplaySpeed:5000,
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
  $('.linked-products-content').slick({
      infinite: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay : true,
        autoplaySpeed:5000,
        responsive: [
            {
                breakpoint: 1610,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });  
  
 });



$(document).ready(function () {

    //productImageSlider();
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

   $('.product-imgs').slick('refresh');
    
  ('#myCarousel').carousel({
    interval: 2000
  });

  });
});

function productImageSlider() {

    console.log('image slider function call');
    $('.product-imgs').slick({
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay : false,
        autoplaySpeed:5000,
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.linked-products-content').slick({
      infinite: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay : true,
        autoplaySpeed:5000,
        responsive: [
            {
                breakpoint: 1610,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });  
}


$( window ).on("load", function() {
    productImageSlider();
});