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

/*  $('.search-btn').on('click', function(){
    if($('.navbar--search').css('display') == 'block'){
      $('.navbar--search').slideUp("fast");
    } else{
      $('.navbar--search').slideDown("fast");
    }
  });*/
  
 });



$(document).ready(function () {

    //productImageSlider();
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

   $('.product-imgs').slick('refresh');
    

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


// Open the Modal
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

// Close the Modal
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}



$( window ).on("load", function() {
        productImageSlider();
});
