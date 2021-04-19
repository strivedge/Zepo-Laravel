@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

@php
    $images = $productImageHelper->getGalleryImages($product);
@endphp

{!! view_render_event('bagisto.shop.products.view.gallery.before', ['product' => $product]) !!}


    <div class="product-image-group">
        <div class="col-md-12 col-lg-3 mobile-thumb-gallery"><!-- row  col-3-->
            <product-gallery></product-gallery>
        </div>
        <div class="col-md-12 col-lg-9"><!-- row col-9 -->
        
            <magnify-image src="{{ $images[0]['large_image_url'] }}">
            </magnify-image>
            <div class="mobile-lightbox-gallery">
                <div class="column">
                    @if ($product->getTypeInstance()->haveSpecialPrice())
                        <div class="sticker new">
                            <span class="save">{{ __('shop::app.products.save') }}</span><span class="percentage">{{$product->getTypeInstance()->getOfferPercentage()}}%</span>
                        </div>
                    @endif
                    <img src="http://localhost/zepomart/public/cache/original/product/108/p1zVWnUEznNIgLbhCUfvUSHsMr1AGfgwmJqby8Rk.png" onclick="openModal();currentSlide(1)" class="hover-shadow">
                </div>
                

                <div id="myModal" class="modal">
                    
                    <div class="modal-content">
                        <span class="close cursor" onclick="closeModal()">&times;</span>
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
            </div>
            @if ($product->getTypeInstance()->haveSpecialPrice())
            <div class="sticker new desktop-sticker">
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