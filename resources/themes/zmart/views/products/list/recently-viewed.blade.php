@inject ('velocityHelper', 'Webkul\Velocity\Helpers\Helper')
@inject ('productRatingHelper', 'Webkul\Product\Helpers\Review')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

@php
    $direction = core()->getCurrentLocale()->direction;
@endphp

<recently-viewed
    add-class="{{ isset($addClass) ? $addClass . " $direction": '' }}"
    quantity="{{ isset($quantity) ? $quantity : null }}"
    add-class-wrapper="{{ isset($addClassWrapper) ? $addClassWrapper : '' }}">
</recently-viewed>

<!-- <section class="recently-viewed product-box">
                    <div class="container">
                        <div class="section-title"><h2>You Recently Viewed</h2></div>
                        <ul class="row">
                            <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                           <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                            <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                            <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                            <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                             <li class="">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section> -->

@push('scripts')
    <script type="text/x-template" id="recently-viewed-template">
        <section class="recently-viewed product-box">
                    <div class="container">
                        <div class="section-title"><h2>{{ __('velocity::app.products.recently-viewed') }}</h2></div>
                        <ul class="row">
                            <li class="" :key="Math.random()"  v-for="(product, index) in recentlyViewed">
                                <div class="content-wrap">
                                    <div class="product-code">@{{ product.sku }}</div>
                                    <!-- <a :href="`${baseUrl}/${product.urlKey}`" class="unset"> -->
                                        <div class="img">
                                            <div class="discount badge badge-secondary"  v-if="product.special_price"><span class="save">SAVE</span><span class="percentage">@{{ product.percentage }}%</span></div>
                                            <!-- <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}"> -->
                                            <img :src="`${product.image}`" :onerror="`this.src='${product.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`">
                                        </div>
                                    <!-- </a> -->
                                    <div class="content">
                                        <div class="product-rating">
                                            <star-ratings v-if="product.rating > 0"
                                                push-class="display-inbl"
                                                :ratings="product.rating">
                                            </star-ratings>
                                        </div>
                                        
                                        <div class="star" v-if="product.rating == 0">
                                            <img src="{{ asset('/themes/zmart/assets/images/star-gray.png') }}">
                                        </div>
                                        
                                        <div class="title">
                                            <a :href="`${baseUrl}/${product.urlKey}`" class="unset no-padding">@{{ product.name }}</a>
                                        </div>
                                            <div class="price">
                                               <div v-html="product.priceHTML" >
                                                </div>
                                                <!-- <span class="amount">$74.68</span>
                                                <span class="amount-price">$80.35</span> -->
                                                <span class="including-tax">(Including tax)</span>
                                            </div>
                                     
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <span
                            class="fs16"
                            v-if="!recentlyViewed ||(recentlyViewed && Object.keys(recentlyViewed).length == 0)"
                            v-text="'{{ __('velocity::app.products.not-available') }}'">
                        </span>
                    </div>
                </section>
    </script>
    <script type="text/x-template" id="recently-viewed-template">
        <div :class="`${addClass} recently-viewed`">
            <div class="row remove-padding-margin">
                <div class="col-12 no-padding">
                    <h2 class="fs20 fw6 mb15">{{ __('velocity::app.products.recently-viewed') }}</h2>
                </div>
            </div>

            <div :class="`recetly-viewed-products-wrapper ${addClassWrapper}`">
                <div
                    :key="Math.random()"
                    class="row small-card-container"
                    v-for="(product, index) in recentlyViewed">

                    <div> @{{product}}</div>

                    <div class="col-4 product-image-container mr15">
                        <a :href="`${baseUrl}/${product.urlKey}`" class="unset">
                            <div class="product-image" :style="`background-image: url(${product.image})`"></div>
                        </a>
                    </div>

                    <div class="col-8 no-padding card-body align-vertical-top" v-if="product.urlKey">
                        <a :href="`${baseUrl}/${product.urlKey}`" class="unset no-padding">
                            <div class="product-name">
                                <span class="fs16 text-nowrap">@{{ product.name }}</span>
                            </div>

                            <div
                                v-html="product.priceHTML"
                                class="fs18 card-current-price fw6">
                            </div>

                            <star-ratings v-if="product.rating > 0"
                                push-class="display-inbl"
                                :ratings="product.rating">
                            </star-ratings>
                        </a>
                    </div>
                </div>

                <span
                    class="fs16"
                    v-if="!recentlyViewed ||(recentlyViewed && Object.keys(recentlyViewed).length == 0)"
                    v-text="'{{ __('velocity::app.products.not-available') }}'">
                </span>
            </div>
        </div>
    </script>

    <script type="text/javascript">
        (() => {
            Vue.component('recently-viewed', {
                template: '#recently-viewed-template',
                props: ['quantity', 'addClass', 'addClassWrapper'],

                data: function () {
                    return {
                        recentlyViewed: (() => {
                            let storedRecentlyViewed = window.localStorage.recentlyViewed;
                            //console.log("storedRecentlyViewed",storedRecentlyViewed)
                            if (storedRecentlyViewed) {
                                var slugs = JSON.parse(storedRecentlyViewed);
                                var updatedSlugs = {};

                                slugs = slugs.reverse();

                                slugs.forEach(slug => {
                                    updatedSlugs[slug] = {};
                                });

                                return updatedSlugs;
                            }
                        })(),
                    }
                },

                created: function () {
                    for (slug in this.recentlyViewed) {
                        if (slug) {
                            this.$http(`${this.baseUrl}/product-details/${slug}`)
                            .then(response => {
                                if (response.data.status) {
                                    this.$set(this.recentlyViewed, response.data.details.urlKey, response.data.details);
                                } else {
                                    delete this.recentlyViewed[response.data.slug];
                                    this.$set(this, 'recentlyViewed', this.recentlyViewed);

                                    this.$forceUpdate();
                                }
                            })
                            .catch(error => {})
                        }
                    }
                },
            })
        })()
    </script>
@endpush
