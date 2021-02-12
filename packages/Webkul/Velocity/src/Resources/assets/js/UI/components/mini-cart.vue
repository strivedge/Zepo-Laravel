<template>
    <div :class="`dropdown ${cartItems.length > 0 ? '' : 'disable-active'}`">
        <cart-btn :item-count="cartItems.length"></cart-btn>

        <div
            id="cart-modal-content"
            v-if="cartItems.length > 0"
            class="modal-content sensitive-modal cart-modal-content hide">

            <!--Body-->
            <div class="mini-cart-container">
                <div class="row small-card-container" :key="index" v-for="(item, index) in cartItems">
                    <div class="col-3 product-image-container mr15">
                        
                           
                       

                        <a class="unset" :href="`${$root.baseUrl}/${item.url_key}`" @click="removeProduct(item.id)">
                             <span class="rango-close"></span>
                            <div
                                class="product-image"
                                :style="`background-image: url(${item.images.medium_image_url});`">
                            </div>
                        </a>
                    </div>
                    <div class="col-9 no-padding card-body align-vertical-top">
                        <div class="no-padding">
                            <div class="text-nowrap productname" v-html="item.name"></div>

                            <div class="card-current-price">
                                <div class="display-inbl">
                                    <label>{{ __('checkout.qty') }}</label>
                                    <input type="text" disabled :value="item.quantity" class="ml5" />
                                </div>
                                <span class="card-total-price">
                                    {{ item.base_total }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer">
                <h2 class="col-6 text-left no-padding">
                    {{ subtotalText }}
                </h2>

                <h2 class="col-6 text-right no-padding total-price">{{ cartInformation.base_sub_total }}</h2>
            </div>

            <div class="modal-footer">
                <a class="col text-left fs16 link-color remove-decoration" :href="viewCart">{{ cartText }}</a>

                <div class="col text-right no-padding">
                    <a :href="checkoutUrl">
                        <button
                            type="button"
                            class="theme-btn fs16 fw6">
                            {{ checkoutText }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
console.log("Mini cart")
    export default {
        props: [
            'cartText',
            'viewCart',
            'checkoutUrl',
            'checkoutText',
            'subtotalText',
        ],

        data: function () {
            return {
                cartItems: [],
                cartInformation: [],
            }
        },

        mounted: function () {
            this.getMiniCartDetails();
        },

        watch: {
            '$root.miniCartKey': function () {
                this.getMiniCartDetails();
            }
        },

        methods: {
            getMiniCartDetails: function () {
                this.$http.get(`${this.$root.baseUrl}/mini-cart`)
                .then(response => {
                    if (response.data.status) {
                        this.cartItems = response.data.mini_cart.cart_items;
                        this.cartInformation = response.data.mini_cart.cart_details;
                    }
                })
                .catch(exception => {
                    console.log(this.__('error.something_went_wrong'));
                });
            },

            removeProduct: function (productId) {
                this.$http.delete(`${this.$root.baseUrl}/cart/remove/${productId}`)
                .then(response => {
                    this.cartItems = this.cartItems.filter(item => item.id != productId);

                    window.showAlert(`alert-${response.data.status}`, response.data.label, response.data.message);
                })
                .catch(exception => {
                    console.log(this.__('error.something_went_wrong'));
                });
            }
        }
    }
</script>
