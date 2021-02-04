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

@push('scripts')
    <script type="text/x-template" id="recently-viewed-template">
        <section class="recently-viewed product-box">
                    <div class="container">
                        <div class="section-title"><h2>{{ __('velocity::app.products.recently-viewed') }}</h2></div>
                        <ul class="row">
                            <li class="" :key="Math.random()"  v-for="(product, index) in recentlyViewed">
                                <div class="content-wrap">
                                    <div class="product-code">@{{ product.sku }}</div>
                                    <div class="img">
                                        <a :href="`${baseUrl}/${product.urlKey}`" class="unset">
                                            
                                                <div class="discount badge badge-secondary"  v-if="product.special_price"><span class="save">SAVE</span><span class="percentage">@{{ product.percentage }}%</span></div>
                                                <!-- <img src="{{ asset('/themes/zmart/assets/images/venus-v4400-n95-face-mask.png') }}"> -->
                                                <img :src="`${product.image}`" :onerror="`this.src='${product.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`">
                                            
                                        </a> 
                                    </div>
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


                                   <!-- <div class="cart-wish-wrap no-padding ml0">
                                        <div class="mx-0 no-padding">
                                            <div class="add-to-cart-btn pl0">
                                                <form
                                                    method="POST" :action="`${baseUrl}/checkout/cart/add/${product.product_id}`"
                                                    >
                                                    
                                                    <input type="hidden" name="_token" :value="`${product.csrf_token}`">
                                                    <input type="hidden" name="product_id" :value="`${product.product_id}`">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button
                                                        type="submit"
                                                        
                                                        class="btn btn-add-to-cart">
                                                        <span class="fs14 fw6 text-uppercase text-up-4">
                                                            {{__('shop::app.products.add-to-cart')}}
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div> -->
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

    <script type="text/javascript">
        (() => {
            Vue.component('recently-viewed', {
                template: '#recently-viewed-template',
                props: ['quantity', 'addClass', 'addClassWrapper'],

                data: function () {
                    return {
                        recentlyViewed: (() => {
                            let storedRecentlyViewed = window.localStorage.recentlyViewed;
                            console.log("storedRecentlyViewed",storedRecentlyViewed)
                            if (storedRecentlyViewed) {
                                var slugs = JSON.parse(storedRecentlyViewed);
                                console.log("slugs",slugs)
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
