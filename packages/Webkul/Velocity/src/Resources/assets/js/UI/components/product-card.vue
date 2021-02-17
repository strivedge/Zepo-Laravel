<template>
    <div class="col-12 lg-card-container list-card product-card row" v-if="list">
        <div class="content-wrap">    

            <div class="product-image">
                
                <a :title="product.name" :href="`${baseUrl}/${product.slug}`">
                    <div class="product-code">{{ product.sku}}</div>
                    <div class="sticker new"  v-if="product.special_price">
                        <span class="save">SAVE</span>
                        <span class="percentage">{{ product.percentage }}%</span>
                    </div>
                    <img
                        :src="product.image || product.product_image"
                        :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />

                    <div class="quick-view-in-list">
                        <product-quick-view-btn :quick-view-details="product" v-if="!isMobile()"></product-quick-view-btn>
                    </div>
                </a>
            </div>
        </div>
        <div class="product-information">
            <div>
                <div class="product-name">
                    <a :href="`${baseUrl}/${product.slug}`" :title="product.name" class="unset">
                        <span class="fs16">{{ product.name }}</span>
                    </a>
                </div>

                <div class="product-price" v-html="product.priceHTML"></div>

                <div class="product-rating" v-if="product.totalReviews && product.totalReviews > 0">
                    <star-ratings :ratings="product.avgRating"></star-ratings>
                    <span>{{ __('products.reviews-count', {'totalReviews': product.totalReviews}) }}</span>
                </div>

                <div class="product-rating" v-else>
                    <img :src="`${product.star_icon}`">
                </div>

                <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
            </div>
        </div>
    </div>

    <div class="list-li" v-else>
        <div class="content-wrap">
            <div class="product-code">{{ product.sku}}</div>
            <div class="sticker new"  v-if="product.special_price">
                <span class="save">SAVE</span>
                <span class="percentage">@{{ product.percentage }}%</span>
            </div>
            <div class="img">
                <a :href="`${baseUrl}/${product.slug}`" :title="product.name" class="product-image-container">
                    <img
                        loading="lazy"
                        :alt="product.name"
                        :src="product.image || product.product_image"
                        :data-src="product.image || product.product_image"
                        class="card-img-top lzy_img"
                        :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />
                        <!-- :src="`${$root.baseUrl}/vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png`" /> -->

                    
                </a>
            </div>

            <div class="content">
                <div class="star">
                    <div
                        class="product-rating"
                        v-if="product.totalReviews && product.totalReviews > 0">

                        <star-ratings :ratings="product.avgRating"></star-ratings>
                        <a class="align-top active-hover" :href="`${$root.baseUrl}/reviews/${product.slug}`">
                            {{ __('products.reviews-count', {'totalReviews': product.totalReviews}) }}
                        </a>
                    </div>
                    <div class="product-rating" v-else>
                     <img src="http://localhost/htmldemo/public/themes/zmart/assets/images/star-gray.png">
                    </div>
                </div>
                <div class="title">
                    <a
                        class="unset"
                        :title="product.name"
                        :href="`${baseUrl}/${product.slug}`">

                        {{ product.name | truncate }}
                    </a>
                </div>

                <div class="price" v-html="product.priceHTML"></div>

                

                
                <div class="cart-wish-wrap">
                    <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script type="text/javascript">
    export default {
        props: [
            'list',
            'product',
        ],

        data: function () {
            return {
                'addToCart': 0,
                'addToCartHtml': '',
            }
        },

        methods: {
            'isMobile': function () {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
</script>