@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

@php
    $images = $productImageHelper->getGalleryImages($product);
@endphp

{!! view_render_event('bagisto.shop.products.view.gallery.before', ['product' => $product]) !!}

<style type="text/css">
.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>

    <div class="product-image-group">
        <div class="col-3"><!-- row  -->
            <product-gallery></product-gallery>
        </div>
        <div class="col-9"><!-- row  -->
        
            <magnify-image src="{{ $images[0]['large_image_url'] }}" v-if="!isMobile()" style="display: none;">
            </magnify-image>

            <div class="column">
                <img src="http://localhost/zepomart/public/cache/original/product/108/p1zVWnUEznNIgLbhCUfvUSHsMr1AGfgwmJqby8Rk.png" onclick="openModal();currentSlide(1)" class="hover-shadow">
            </div>
            

            <div id="myModal" class="modal">
                <span class="close cursor" onclick="closeModal()">&times;</span>
                <div class="modal-content">

                    <div class="mySlides">
                      
                      <img src="http://localhost/zepomart/public/cache/original/product/108/p1zVWnUEznNIgLbhCUfvUSHsMr1AGfgwmJqby8Rk.png">
                    </div>

                    <div class="mySlides">
                      
                      <img src="http://localhost/zepomart/public/cache/original/product/108/TVRWDgMRlzwKZBRa3yZSIZZEkysfGYigIxdkUFGf.png">
                    </div>

                     <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                </div>
            </div>
            @if ($product->getTypeInstance()->haveSpecialPrice())
            <div class="sticker new">
                <span class="save">{{ __('shop::app.products.save') }}</span><span class="percentage">{{$product->getTypeInstance()->getOfferPercentage()}}%</span>
            </div>
            @endif
            <img
                v-else
                class="vc-small-product-image"
                src="{{ $images[0]['large_image_url'] }}" />
        </div>

        

    </div>

{!! view_render_event('bagisto.shop.products.view.gallery.after', ['product' => $product]) !!}

<script type="text/x-template" id="product-gallery-template">
    <ul class="thumb-list col-12ltr" type="none">
        <li class="arrow left" @click="scroll('prev')" v-if="thumbs.length > 4">
            <i class="rango-arrow-left fs24"></i>
        </li>

        <carousel-component
            slides-per-page="4"
            :id="galleryCarouselId"
            pagination-enabled="hide"
            navigation-enabled="hide"
            add-class="product-gallery"
            :slides-count="thumbs.length">

            <slide :slot="`slide-${index}`" v-for="(thumb, index) in thumbs">
                <li
                    @click="changeImage({
                        largeImageUrl: thumb.large_image_url,
                        originalImageUrl: thumb.original_image_url,
                    })"
                    :class="`thumb-frame ${index + 1 == 4 ? '' : 'mr5'} ${thumb.large_image_url == currentLargeImageUrl ? 'active' : ''}`"
                    >

                    <div
                        class="bg-image"
                        :style="`background-image: url(${thumb.small_image_url})`">
                    </div>
                </li>
            </slide>
        </carousel-component>

        <li class="arrow right" @click="scroll('next')" v-if="thumbs.length > 4">
            <i class="rango-arrow-right fs24"></i>
        </li>
    </ul>
</script>

@push('scripts')
    <script type="text/javascript">
        (() => {
            var galleryImages = @json($images);

            Vue.component('product-gallery', {
                template: '#product-gallery-template',
                data: function() {
                    return {
                        images: galleryImages,
                        thumbs: [],
                        galleryCarouselId: 'product-gallery-carousel',
                        currentLargeImageUrl: '',
                        currentOriginalImageUrl: '',
                        counter: {
                            up: 0,
                            down: 0,
                        }
                    }
                },

                watch: {
                    'images': function(newVal, oldVal) {
                        if (this.images[0]) {
                            this.changeImage({
                                largeImageUrl: this.images[0]['large_image_url'],
                                originalImageUrl: this.images[0]['original_image_url'],
                            })
                        }

                        this.prepareThumbs()
                    }
                },

                created: function() {
                    this.changeImage({
                        largeImageUrl: this.images[0]['large_image_url'],
                        originalImageUrl: this.images[0]['original_image_url'],
                    });

                    eventBus.$on('configurable-variant-update-images-event', this.updateImages);

                    this.prepareThumbs()
                },

                methods: {
                    updateImages: function (galleryImages) {
                        this.images = galleryImages;
                    },

                    prepareThumbs: function() {
                        this.thumbs = [];

                        this.images.forEach(image => {
                            this.thumbs.push(image);
                        });
                    },

                    changeImage: function({largeImageUrl, originalImageUrl}) {
                        this.currentLargeImageUrl = largeImageUrl;

                        this.currentOriginalImageUrl = originalImageUrl;

                        this.$root.$emit('changeMagnifiedImage', {
                            smallImageUrl: this.currentOriginalImageUrl
                        });

                        let productImage = $('.vc-small-product-image');
                        if (productImage && productImage[0]) {
                            productImage = productImage[0];

                            productImage.src = this.currentOriginalImageUrl;
                        }
                    },

                    scroll: function (navigateTo) {
                        let navigation = $(`#${this.galleryCarouselId} .VueCarousel-navigation .VueCarousel-navigation-${navigateTo}`);

                        if (navigation && (navigation = navigation[0])) {
                            navigation.click();
                        }
                    },
                }
            });
        })()
    </script>

    <script>
        $(document).ready(() => {

            /* waiting for the window to appear */
            let waitForEl = function(selector, callback) {
                if (jQuery(selector).length) {
                    callback();
                } else {
                    setTimeout(function() {waitForEl(selector, callback);}, 100);
                }
            };

            /* positioning when .zoomWindow div available */
            waitForEl('.zoomWindow', function() {
                if ($('body').hasClass("rtl")) {
                    let widthOfImage = $('.zoomContainer').width();
                    $('.zoomWindow').css('right', `${widthOfImage}px`);
                }
            });
        });
    </script>
@endpush