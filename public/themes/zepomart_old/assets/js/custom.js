/*$('.hero-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
});*/

/*window.onscroll = function() {myFunction()};

var header = document.getElementById("header");
//var sticky = header.offsetTop;
var sticky = 20;
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}*/

/* Menu Hover
  ------------------------------------------------------------- */
  $('#primary-menu li.parent').on('mouseenter',function(){
    $(this).find(".sub-menu").fadeIn();
    $(this).addClass('active');
  });
  $('#primary-menu li.parent').on('mouseleave',function(){
    $(this).find(".sub-menu").fadeOut();
    $(this).removeClass('active');
  });  

  $('#primary-menu-2 li.parent ul.sub-menu li').on('click',function(e){    
      e.stopPropagation();
  });
  

 /* $('#primary-menu-2 li.parent').on('click',function(){  

      event.preventDefault();

      if($(this).hasClass('active')){

        $(this).find(".sub-menu").slideUp();
        $(this).removeClass('active');

      } else {

        $(this).find(".sub-menu").slideDown();
        $(this).addClass('active');
      }
    
  });*/



$(document).ready(function() {
  
    $('.selectpicker').selectpicker();

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
                    slidesToScroll: 3
                }
            }
        ]
    });