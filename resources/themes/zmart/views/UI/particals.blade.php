<style>
    .camera-icon {
        background-image: url("{{ asset('/vendor/webkul/ui/assets/images/Camera.svg') }}");
    }
</style>

<script type="text/x-template" id="cart-btn-template">
    <button
        type="button"
        id="mini-cart"
        @click="toggleMiniCart"
        :class="`btn btn-link disable-box-shadow ${itemCount == 0 ? 'cursor-not-allowed' : ''}`">

        <div class="mini-cart-content">
            <span class="addcart notranslate"><i class="material-icons-outlined text-down-3 notranslate">shopping_cart</i>
            <span class="badge" v-text="itemCount" v-if="itemCount != 0"></span></span>
            <!-- <span class="fs18 fw6 cart-text">{{ __('velocity::app.minicart.cart') }}</span> -->
        </div>
        <div class="down-arrow-container">
            <span class="rango-arrow-down"></span>
        </div>
    </button>
</script>

<script type="text/x-template" id="close-btn-template">
    <button type="button" class="close disable-box-shadow">
        <span class="white-text fs20" @click="togglePopup">×</span>
    </button>
</script>

<script type="text/x-template" id="quantity-changer-template">
    <div :class="`quantity control-group ${errors.has(controlName) ? 'has-error' : ''}`">
        <label class="required">{{ __('shop::app.products.quantity') }}</label>
        <button type="button" class="decrease" @click="decreaseQty()">-</button>

        <input
            :value="qty"
            class="control"
            :name="controlName"
            :v-validate="validations"
            data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;"
            readonly />

        <button type="button" class="increase" @click="increaseQty()">+</button>

        <span class="control-error" v-if="errors.has(controlName)">@{{ errors.first(controlName) }}</span>
    </div>
</script>

@include('velocity::UI.header')

<script type="text/x-template" id="logo-template">
    <a class=" navbar-brand col-md-2"
        :class="`left ${addClass}`"
        href="{{ route('shop.home.index') }}">

        @if ($logo = core()->getCurrentChannel()->logo_url)
            <img class="logo" src="{{ $logo }}" class="custom-logo" />
        @else
            <img class="logo custom-logo" src="{{ asset('themes/zmart/assets/images/logo-text.png') }}" />
        @endif
    </a>
</script>

<script type="text/x-template" id="searchbar-template">
    <div class="col-md-10 right searchbar">
        <div class="navbar--search col-md-9 no-padding input-group">
            <form
                method="GET"
                role="search"
                id="search-form"
                action="{{ route('velocity.search.index') }}">

                <div
                    class="btn-toolbar full-width"
                    role="toolbar">

                    <div class="btn-group full-width">
                        <!-- <div class="selectdiv">
                           <select class="form-control fs13 styled-select" name="category" @change="focusInput($event)">
                                <option value="">
                                    {{ __('velocity::app.header.all-categories') }}
                                </option>

                                <template v-for="(category, index) in $root.sharedRootCategories">
                                    <option
                                        :key="index"
                                        selected="selected"
                                        :value="category.id"
                                        v-if="(category.id == searchedQuery.category)">
                                        @{{ category.name }}
                                    </option>

                                    <option :key="index" :value="category.id" v-else>
                                        @{{ category.name }}
                                    </option>
                                </template>
                            </select>

                            <div class="select-icon-container">
                                <span class="select-icon rango-arrow-down"></span>
                            </div>
                        </div> -->

                        <div class="full-width">

                           <search-products></search-products>


                             <!-- <input
                                required
                                name="term"
                                type="search"
                                class="form-control"
                                placeholder="{{ __('velocity::app.header.search-text') }}"
                                :value="searchedQuery.term ? searchedQuery.term.split('+').join(' ') : ''" /> -->

                            <image-search-component></image-search-component>

                            <button class="btn" type="submit" id="header-search-icon">
                                <i class="fs16 fw6 rango-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="navbar--addcart--wishlist col-md-3">
            {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
                @include('shop::checkout.cart.mini-cart')
            {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}

            @php
                $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
            @endphp

            {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}
                @if ($showCompare)
                    <a
                        class="compare-btn unset"
                        @auth('customer')
                            href="{{ route('velocity.customer.product.compare') }}"
                        @endauth

                        @guest('customer')
                            href="{{ route('velocity.product.compare') }}"
                        @endguest
                        >

                       <span class="compare notranslate"> <i class="material-icons">compare_arrows</i>
                            <span class="badge-container" v-if="compareCount > 0">
                                <span class="badge" v-text="compareCount"></span>
                            </span>
                        </span>
                       <!--  <span>{{ __('velocity::app.customer.compare.text') }}</span> -->
                    </a>
                @endif
            {!! view_render_event('bagisto.shop.layout.header.compare.after') !!}

            {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}
                <a class="wishlist-btn unset" :href="`${isCustomer ? '{{ route('customer.wishlist.index') }}' : '{{ route('velocity.product.guest-wishlist') }}'}`">
                    <span class="wishlist notranslate"><i class="material-icons">favorite_border</i>
                    <span class="badge-container" v-if="wishlistCount > 0">
                        <span class="badge" v-text="wishlistCount"></span>
                    </span>
                </span>
                    <!-- <span>{{ __('shop::app.layouts.wishlist') }}</span> -->
                </a>
            {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}
        </div>
    </div>
</script>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>

<script type="text/x-template" id="image-search-component-template">
    <div class="d-inline-block">
        <label class="image-search-container" for="image-search-container">
            <!-- <i class="icon camera-icon"></i> -->

            <input
                type="file"
                class="d-none"
                ref="image_search_input"
                id="image-search-container"
                v-on:change="uploadImage()" />

            <img
                class="d-none"
                id="uploaded-image-url"
                :src="uploadedImageUrl" />
        </label>
    </div>
</script>


   <script type="text/x-template" id="search-products-template">
        <div>

            <div class="control-group" v-for='(key) in linkedProducts'>

                <input type="text" id="prod-search-box" required name="term" class="control"  placeholder="{{ __('admin::app.catalog.products.product-search-hint') }}" v-on:keyup="search(key)" value="" autocomplete="off">

                <div class="linked-product-search-result" id="prod-suggestion">
                    <ul>
                        <li class='pli' v-for='(product, index) in products[key]' v-if='products[key].length' @click="addProduct(product, key)">
                            <div class="col-md-2 product-img">
                                <img :alt="product.name" :src="product.image" :onerror="`this.src='${baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`">
                            </div>
                            <div class="col-md-8 product-name">
                                <a :href="`${$root.baseUrl}/${product.url_key}`">
                                    @{{ product.name }}
                                </a>
                            </div>
                            <div class="col-md-2 prices" v-html="product.priceHTML">
                            </div>
                        </li>

                        <li class='pli1 searching text-center' v-if='! products[key].length && search_term[key].length && ! is_searching[key]'>
                            {{ __('admin::app.catalog.products.no-result-found') }}
                        </li>

                        <li class='searching' v-if="is_searching[key] && search_term[key].length">
                            {{ __('admin::app.catalog.products.searching') }}
                        </li>
                    </ul>
                </div>

                <!-- <input type="hidden" name="up_sell[]" v-for='(product, index) in addedProducts.up_sells' v-if="(key == 'up_sells') && addedProducts.up_sells.length" :value="product.id"/>

                
                <span class="filter-tag linked-product-filter-tag" v-if="addedProducts[key].length">
                    <span class="wrapper linked-product-wrapper " v-for='(product, index) in addedProducts[key]'>
                        <span class="do-not-cross-linked-product-arrow">
                            @{{ product.name }}
                        </span>
                        <span class="icon cross-icon" @click="removeProduct(product, key)"></span>
                    </span>
                </span> -->
            </div>

        </div>
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            console.log('sss ')
               $('#prod-suggestion').hide();
               $("html,body").click(function(e) {
                $("#prod-suggestion").hide();
            });
        });
        
    </script>



<script>

    
     
    Vue.component('search-products', {

        template: '#search-products-template',

        data: function() {
            return {
                products: {
                    'up_sells': []
                },

                search_term: {
                    'up_sells': ''
                },

                addedProducts: {
                    'up_sells': []
                },

                is_searching: {
                    'up_sells': false
                },

                //productId: '',

                linkedProducts: ['up_sells'],

                upSellingProducts: {},
            }
        },

        created: function () {
            if (this.upSellingProducts.length >= 1) {
                console.log("upSellingProducts length")
                for (var index in this.upSellingProducts) {
                    this.addedProducts.up_sells.push(this.upSellingProducts[index]);
                }
            }
        },

        methods: {
            addProduct: function (product, key) {
                console.log("upSellingProducts addProduct method")
                //console.log(product)
                //console.log("product:",product.name)
                 //$('#prod-search-box').css('overflow-x', 'scroll');
                 $('#prod-search-box').val(product.name);
                // console.log("val:",$('#prod-search-box').val())
                //console.log('test')
                //$('#prod-suggestion').empty();
                $('#prod-suggestion').hide();
                //this.addedProducts[key].push(product);
                //console.log("this.products",this.products)
                //console.log("this.products key",this.products[key])
                this.search_term[key] = '';
                this.products[key] = [];

                 console.log("After this.products",this.products[key])
               
            },

            removeProduct: function (product, key) {
                console.log("upSellingProducts removeProduct method")
                for (var index in this.addedProducts[key]) {
                    if (this.addedProducts[key][index].id == product.id ) {
                        this.addedProducts[key].splice(index, 1);
                    }
                }
            },

            search: function (key) {
                $('#prod-suggestion').show();
                //console.log("upSellingProducts search method")
                this_this = this;

                this.search_term[key] = $('#prod-search-box').val();

                //console.log('this search_term key ',this.search_term[key])


                this.is_searching[key] = true;

                if (this.search_term[key].length >= 1) {
                    this.$http.get ("{{ route('products.productlinksearch') }}", {params: {query: this.search_term[key]}})
                        .then (function(response) {

                           // console.log("upSellingProducts response")
                            //console.log(response)

                            for (var index in response.data) {
                                if (response.data[index].id == this_this.productId) {
                                    response.data.splice(index, 1);
                                }
                            }

                            if (this_this.addedProducts[key].length) {
                                for (var product in this_this.addedProducts[key]) {
                                    for (var productId in response.data) {
                                        if (response.data[productId].id == this_this.addedProducts[key][product].id) {
                                            response.data.splice(productId, 1);
                                        }
                                    }
                                }
                            }

                            this_this.products[key] = response.data;

                            this_this.is_searching[key] = false;
                        })

                        .catch (function (error) {
                            this_this.is_searching[key] = false;
                        })
                } else {
                    this_this.products[key] = [];
                    this_this.is_searching[key] = false;
                }
            }
        }
    });

</script>

<script type="text/javascript">
    (() => {
        Vue.component('cart-btn', {
            template: '#cart-btn-template',

            props: ['itemCount'],

            methods: {
                toggleMiniCart: function () {
                    let modal = $('#cart-modal-content')[0];
                    if (modal)
                        modal.classList.toggle('hide');

                    let accountModal = $('.account-modal')[0];
                    if (accountModal)
                        accountModal.classList.add('hide');

                    event.stopPropagation();
                }
            }
        });

        Vue.component('close-btn', {
            template: '#close-btn-template',

            methods: {
                togglePopup: function () {
                    $('#cart-modal-content').hide();
                }
            }
        });

        Vue.component('quantity-changer', {
            template: '#quantity-changer-template',
            inject: ['$validator'],
            props: {
                controlName: {
                    type: String,
                    default: 'quantity'
                },

                quantity: {
                    type: [Number, String],
                    default: 1
                },

                minQuantity: {
                    type: [Number, String],
                    default: 1
                },

                validations: {
                    type: String,
                    default: 'required|numeric|min_value:1'
                }
            },

            data: function() {
                return {
                    qty: this.quantity
                }
            },

            watch: {
                quantity: function (val) {
                    this.qty = val;

                    this.$emit('onQtyUpdated', this.qty)
                }
            },

            methods: {
                decreaseQty: function() {
                    if (this.qty > this.minQuantity)
                        this.qty = parseInt(this.qty) - 1;

                    this.$emit('onQtyUpdated', this.qty)
                },

                increaseQty: function() {
                    this.qty = parseInt(this.qty) + 1;

                    this.$emit('onQtyUpdated', this.qty)
                }
            }
        });

        Vue.component('logo-component', {
            template: '#logo-template',
            props: ['addClass'],
        });

        Vue.component('searchbar-component', {
            template: '#searchbar-template',
            data: function () {
                return {
                    compareCount: 0,
                    wishlistCount: 0,
                    searchedQuery: [],
                    isCustomer: '{{ auth()->guard('customer')->user() ? "true" : "false" }}' == "true",
                }
            },

            watch: {
                '$root.headerItemsCount': function () {
                    this.updateHeaderItemsCount();
                }
            },

            created: function () {
                let searchedItem = window.location.search.replace("?", "");
                searchedItem = searchedItem.split('&');

                let updatedSearchedCollection = {};

                searchedItem.forEach(item => {
                    let splitedItem = item.split('=');
                    updatedSearchedCollection[splitedItem[0]] = decodeURI(splitedItem[1]);
                });

                if (updatedSearchedCollection['image-search'] == 1) {
                    updatedSearchedCollection.term = '';
                }

                this.searchedQuery = updatedSearchedCollection;

                this.updateHeaderItemsCount();
            },

            methods: {
                'focusInput': function (event) {
                    $(event.target.parentElement.parentElement).find('input').focus();
                },

                'updateHeaderItemsCount': function () {
                    if (! this.isCustomer) {
                        let comparedItems = this.getStorageValue('compared_product');
                        let wishlistedItems = this.getStorageValue('wishlist_product');

                        if (wishlistedItems) {
                            this.wishlistCount = wishlistedItems.length;
                        }

                        if (comparedItems) {
                            this.compareCount = comparedItems.length;
                        }
                    } else {
                        this.$http.get(`${this.$root.baseUrl}/items-count`)
                            .then(response => {
                                this.compareCount = response.data.compareProductsCount;
                                this.wishlistCount = response.data.wishlistedProductsCount;
                            })
                            .catch(exception => {
                                console.log(this.__('error.something_went_wrong'));
                            });
                    }
                }
            }
        });

        Vue.component('image-search-component', {
            template: '#image-search-component-template',
            data: function() {
                return {
                    uploadedImageUrl: ''
                }
            },

            methods: {
                uploadImage: function() {
                    var imageInput = this.$refs.image_search_input;

                    if (imageInput.files && imageInput.files[0]) {
                        if (imageInput.files[0].type.includes('image/')) {
                            this.$root.showLoader();

                            var formData = new FormData();

                            formData.append('image', imageInput.files[0]);

                            axios.post(
                                "{{ route('shop.image.search.upload') }}",
                                formData,
                                {
                                    headers: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                            ).then(response => {
                                var net;
                                var self = this;
                                this.uploadedImageUrl = response.data;


                                async function app() {
                                    var analysedResult = [];

                                    var queryString = '';

                                    net = await mobilenet.load();

                                    const imgElement = document.getElementById('uploaded-image-url');

                                    try {
                                        const result = await net.classify(imgElement);

                                        result.forEach(function(value) {
                                            queryString = value.className.split(',');

                                            if (queryString.length > 1) {
                                                analysedResult = analysedResult.concat(queryString)
                                            } else {
                                                analysedResult.push(queryString[0])
                                            }
                                        });
                                    } catch (error) {
                                        self.$root.hideLoader();

                                        window.showAlert(
                                            `alert-danger`,
                                            this.__('shop.general.alert.error'),
                                            "{{ __('shop::app.common.error') }}"
                                        );
                                    }

                                    localStorage.searchedImageUrl = self.uploadedImageUrl;

                                    queryString = localStorage.searched_terms = analysedResult.join('_');

                                    self.$root.hideLoader();

                                    window.location.href = "{{ route('shop.search.index') }}" + '?term=' + queryString + '&image-search=1';
                                }

                                app();
                            }).catch(() => {
                                this.$root.hideLoader();

                                window.showAlert(
                                    `alert-danger`,
                                    this.__('shop.general.alert.error'),
                                    "{{ __('shop::app.common.error') }}"
                                );
                            });
                        } else {
                            imageInput.value = '';

                            alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                        }
                    }
                }
            }
        });
    })()
</script>