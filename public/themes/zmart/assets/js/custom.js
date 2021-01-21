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
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: true,
                    slidesToShow: 1,
                    slidesToScroll: 3
                }
            }
        ]
    });  
   });


