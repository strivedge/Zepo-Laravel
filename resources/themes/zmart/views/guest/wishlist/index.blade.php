@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.wishlist.page-title') }}
@endsection

@section('content-wrapper')
    @guest('customer')
        <wishlist-product></wishlist-product>
    @endguest

    @auth('customer')
        @push('scripts')
            <script>
                window.location = '{{ route('customer.wishlist.index') }}';
            </script>
        @endpush
    @endauth
@endsection

@push('scripts')
    <script type="text/x-template" id="wishlist-product-template">
        <section class="cart-details no-margin col-12 product-box">
            <div class="row">
                <h2 class="wishlist-title col-6">
                    {{ __('shop::app.customer.account.wishlist.title') }}
                </h2>

                <div class="wishlist-delete-btn col-6" v-if="products.length > 0">
                    <button
                        class="theme-btn light pull-right"
                        @click="removeProduct('all')">
                        {{ __('shop::app.customer.account.wishlist.deleteall') }}
                    </button>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.before') !!}

            <div class="row products-collection col-12 ml0">
                <shimmer-component v-if="!isProductListLoaded && !isMobile()"></shimmer-component>

                <template v-else-if="isProductListLoaded && products.length > 0">
                    <carousel-component
                        slides-per-page="6"
                        navigation-enabled="true"
                        pagination-enabled="hide"
                        id="wishlist-products-carousel"
                        locale-direction="{{ core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr' }}"
                        :slides-count="products.length"
                        :perPageCustom="[[480, 2], [768, 3]]">

                        <slide
                            :key="index"
                            :slot="`slide-${index}`"
                            v-for="(product, index) in products">
                            <product-card :product="product"></product-card>
                        </slide>
                    </carousel-component>
                </template>

                <span v-else-if="isProductListLoaded">{{ __('customer::app.wishlist.empty') }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.after') !!}
        </section>
    </script>

    <script>
        Vue.component('wishlist-product', {
            template: '#wishlist-product-template',

            data: function () {
                return {
                    'products': [],
                    'isProductListLoaded': false,
                }
            },

            watch: {
                '$root.headerItemsCount': function () {
                    this.getProducts();
                }
            },

            mounted: function () {
                this.getProducts();
            },

            methods: {
                'getProducts': function () {
                    let items = this.getStorageValue('wishlist_product');
                    items = items ? items.join('&') : '';

                    if (items != "") {
                        this.$http
                        .get(`${this.$root.baseUrl}/detailed-products`, {
                            params: { moveToCart: true, items }
                        })
                        .then(response => {
                            this.isProductListLoaded = true;
                            this.products = response.data.products;

                            console.log("products",this.products)
                        })
                        .catch(error => {
                            this.isProductListLoaded = true;
                            console.log(this.__('error.something_went_wrong'));
                        });
                    } else {
                        this.products = [];
                        this.isProductListLoaded = true;
                    }
                },

                'removeProduct': function (productId) {
                    let existingItems = this.getStorageValue('wishlist_product');

                    if (productId == "all") {
                        updatedItems = [];
                        this.$set(this, 'products', []);
                    } else {
                        updatedItems = existingItems.filter(item => item != productId);
                        this.$set(this, 'products', this.products.filter(product => product.slug != productId));
                    }

                    this.$root.headerItemsCount++;
                    this.setStorageValue('wishlist_product', updatedItems);

                    window.showAlert(`alert-success`, this.__('shop.general.alert.success'), `${this.__('customer.wishlist.remove-all-success')}`);
                }
            }
        });
    </script>
@endpush